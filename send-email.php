<?php
declare(strict_types=1);
ob_start(); // buffer any stray warnings so they never corrupt the JSON response

// ── Configuration ────────────────────────────────────────────────────────────
// MAIL_FROM must match the sending domain you have verified in Resend.
// Example: 'Cooper Floors Website <website@coopersfloors.com>'
// Update this value once your Resend domain is verified.
define('MAIL_FROM',   'Cooper Floors Website <website@contact.coopersfloors.com>');
define('MAIL_TO',     'coopersfloors@outlook.com');
define('RATE_LIMIT',  3);   // max submissions per IP
define('RATE_WINDOW', 60);  // within this many seconds

// ── Response helpers ─────────────────────────────────────────────────────────
header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');

function jsonError(int $code, string $msg): void {
    ob_clean();
    http_response_code($code);
    echo json_encode(['error' => $msg]);
    exit;
}

// ── 1. Method guard ──────────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonError(405, 'Method not allowed.');
}

// ── 2. Load API key ──────────────────────────────────────────────────────────
// config.local.php is gitignored and calls putenv() with your Resend key.
// On production, set the RESEND_API_KEY server environment variable instead.
@include_once __DIR__ . '/config.local.php';
$apiKey = getenv('RESEND_API_KEY');
if (!$apiKey) {
    jsonError(500, 'Server configuration error. Please call us at 763-786-9616.');
}

// ── 3. Parse JSON body ───────────────────────────────────────────────────────
$raw   = (string)file_get_contents('php://input');
$input = json_decode($raw, true);
if (!is_array($input)) {
    jsonError(400, 'Invalid request.');
}

// ── 4. Honeypot ──────────────────────────────────────────────────────────────
// Return 200 silently so bots think they succeeded.
if (!empty($input['website'])) {
    ob_clean();
    echo json_encode(['ok' => true]);
    exit;
}

// ── 5. Rate limiting (file-based, no dependencies) ───────────────────────────
$ip       = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$rateFile = sys_get_temp_dir() . '/cf_rl_' . md5($ip);
$now      = time();
$window   = [];

if (file_exists($rateFile)) {
    $stored = json_decode((string)file_get_contents($rateFile), true);
    if (is_array($stored)) {
        $window = array_values(array_filter($stored, function ($t) use ($now) {
            return is_int($t) && ($now - $t) < RATE_WINDOW;
        }));
    }
}

if (count($window) >= RATE_LIMIT) {
    jsonError(429, 'Too many requests. Please wait a moment and try again.');
}

$window[] = $now;
@file_put_contents($rateFile, json_encode($window), LOCK_EX);

// ── 6. Sanitize helper ───────────────────────────────────────────────────────
function san($v): string {
    return htmlspecialchars(strip_tags(trim((string)($v ?? ''))), ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

// ── 7. Common fields ─────────────────────────────────────────────────────────
$formType  = san($input['formType'] ?? '');
$firstName = san($input['FirstName'] ?? '');
$lastName  = san($input['LastName']  ?? '');
$rawEmail  = trim((string)($input['Email'] ?? ''));
$email     = filter_var($rawEmail, FILTER_VALIDATE_EMAIL);
$phone     = san($input['Phone'] ?? $input['PhoneNumber'] ?? '');

if (!$firstName || !$lastName) {
    jsonError(400, 'First and last name are required.');
}
if (!$email) {
    jsonError(400, 'A valid email address is required.');
}

// ── 8. Per-type validation ───────────────────────────────────────────────────
$extraFields   = [];
$subjectLine   = "New Estimate Request \u{2014} Cooper's Floors";

if ($formType === 'contact') {
    $subjectLine = "New Website Message \u{2014} Cooper's Floors";
    $message     = san($input['Message'] ?? '');
    if (!$message) {
        jsonError(400, 'A message is required.');
    }
    $extraFields = ['Message' => $message];

} elseif ($formType === 'estimate') {
    $flooringType      = san($input['FlooringType']      ?? '');
    $projectType       = san($input['ProjectType']       ?? '');
    $projectSize       = san($input['ProjectSize']       ?? '');
    $timeline          = san($input['Timeline']          ?? '');
    $zipCode           = san($input['ZipCode']           ?? '');
    $additionalDetails = san($input['AdditionalDetails'] ?? '');

    if (!$flooringType || !$projectType) {
        jsonError(400, 'Please select a flooring type and project type.');
    }
    if (!$phone) {
        jsonError(400, 'Phone number is required for estimate requests.');
    }
    if (!preg_match('/^\d{5}$/', $zipCode)) {
        jsonError(400, 'A valid 5-digit ZIP code is required.');
    }

    $extraFields = [
        'Flooring Type'      => $flooringType,
        'Project Type'       => $projectType,
        'Project Size'       => $projectSize ?: '—',
        'Timeline'           => $timeline    ?: '—',
        'ZIP Code'           => $zipCode,
        'Additional Details' => $additionalDetails ?: '—',
    ];

} elseif ($formType === 'legacy-estimate') {
    $typeChoice = san($input['EstimateOrConsultation'] ?? 'Estimate');
    $message    = san($input['Message'] ?? '');
    if (!$phone) {
        jsonError(400, 'Phone number is required.');
    }
    $extraFields = [
        'Request Type' => $typeChoice,
        'Message'      => $message ?: '—',
    ];

} else {
    jsonError(400, 'Invalid form submission.');
}

// ── 9. Build email content ───────────────────────────────────────────────────
$allFields = array_merge(
    [
        'First Name' => $firstName,
        'Last Name'  => $lastName,
        'Email'      => (string)$email,
        'Phone'      => $phone ?: '—',
    ],
    $extraFields
);

$rowsHtml = '';
$rowsText = '';
foreach ($allFields as $label => $value) {
    $esc       = htmlspecialchars($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $labelEsc  = htmlspecialchars($label, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $rowsHtml .= "
      <tr>
        <td style=\"padding:10px 16px;background:#f9f7f4;font-size:13px;color:#555;font-weight:600;white-space:nowrap;border-bottom:1px solid #eee;width:160px\">$labelEsc</td>
        <td style=\"padding:10px 16px;font-size:14px;color:#222;border-bottom:1px solid #eee\">$esc</td>
      </tr>";
    $rowsText .= "$label: $value\n";
}

$subjectEsc = htmlspecialchars($subjectLine, ENT_QUOTES | ENT_HTML5, 'UTF-8');

$htmlBody = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"></head>
<body style="margin:0;padding:0;background:#f0ede8;font-family:Arial,Helvetica,sans-serif">
  <table width="100%" cellpadding="0" cellspacing="0" style="background:#f0ede8">
    <tr><td style="padding:32px 20px">
      <table width="580" align="center" cellpadding="0" cellspacing="0"
             style="max-width:580px;background:#ffffff;border-radius:8px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,.08)">
        <tr>
          <td style="background:#62805e;padding:24px 32px">
            <div style="color:#ffffff;font-size:20px;font-weight:700;letter-spacing:.02em">Cooper's Floors</div>
            <div style="color:rgba(255,255,255,.75);font-size:13px;margin-top:5px">$subjectEsc</div>
          </td>
        </tr>
        <tr>
          <td style="padding:28px 32px 8px">
            <p style="margin:0 0 20px;font-size:15px;color:#333">You have a new submission from your website contact form.</p>
            <table width="100%" cellpadding="0" cellspacing="0"
                   style="border:1px solid #eee;border-radius:6px;overflow:hidden">
              $rowsHtml
            </table>
          </td>
        </tr>
        <tr>
          <td style="padding:20px 32px 28px">
            <p style="margin:0;font-size:13px;color:#999">Hit <strong>Reply</strong> to respond directly to the customer.</p>
          </td>
        </tr>
        <tr>
          <td style="background:#f9f7f4;padding:16px 32px;border-top:1px solid #e8e4de">
            <p style="margin:0;font-size:12px;color:#bbb">Sent from the Cooper's Floors website contact form.</p>
          </td>
        </tr>
      </table>
    </td></tr>
  </table>
</body>
</html>
HTML;

$textBody = "$subjectLine\n\n$rowsText\n--\nSent from the Cooper's Floors website contact form.";

// ── 10. Customer confirmation content ────────────────────────────────────────
$confirmHtml = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"></head>
<body style="margin:0;padding:0;background:#f0ede8;font-family:Arial,Helvetica,sans-serif">
  <table width="100%" cellpadding="0" cellspacing="0" style="background:#f0ede8">
    <tr><td style="padding:32px 20px">
      <table width="580" align="center" cellpadding="0" cellspacing="0"
             style="max-width:580px;background:#ffffff;border-radius:8px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,.08)">
        <tr>
          <td style="background:#62805e;padding:24px 32px">
            <div style="color:#ffffff;font-size:20px;font-weight:700;letter-spacing:.02em">Cooper's Floors</div>
            <div style="color:rgba(255,255,255,.75);font-size:13px;margin-top:5px">Thanks for reaching out</div>
          </td>
        </tr>
        <tr>
          <td style="padding:32px">
            <p style="margin:0 0 16px;font-size:16px;color:#333">Hi $firstName,</p>
            <p style="margin:0 0 16px;font-size:15px;color:#444;line-height:1.6">
              Thanks for reaching out to Cooper's Floors. We've received your request and
              someone from our team will get back to you shortly.
            </p>
            <p style="margin:0 0 28px;font-size:15px;color:#444;line-height:1.6">
              In the meantime, feel free to give us a call if you have any urgent questions.
            </p>
            <table cellpadding="0" cellspacing="0"
                   style="border:1px solid #e8e4de;border-radius:6px;overflow:hidden;width:100%;max-width:320px">
              <tr>
                <td style="padding:16px 20px;background:#f9f7f4">
                  <div style="font-size:13px;font-weight:700;color:#795B40;margin-bottom:10px;letter-spacing:.06em">COOPER'S FLOORS</div>
                  <div style="font-size:13px;color:#555;line-height:2">
                    &#128222;&nbsp;<a href="tel:7637869616" style="color:#62805e;text-decoration:none">763-786-9616</a><br>
                    &#9993;&nbsp;<a href="mailto:CoopersFloors@outlook.com" style="color:#62805e;text-decoration:none">CoopersFloors@outlook.com</a><br>
                    &#128205;&nbsp;13640 Crosstown Blvd NW, Andover, MN 55304<br>
                    &#128336;&nbsp;Mon–Fri 10AM–5PM &nbsp;·&nbsp; Sat 10AM–3PM
                  </div>
                </td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td style="background:#f9f7f4;padding:16px 32px;border-top:1px solid #e8e4de">
            <p style="margin:0;font-size:12px;color:#bbb">
              You're receiving this because you submitted a request on coopersfloors.com.
            </p>
          </td>
        </tr>
      </table>
    </td></tr>
  </table>
</body>
</html>
HTML;

$confirmText = "Hi $firstName,\n\nThanks for reaching out to Cooper's Floors. We've received your request and someone from our team will get back to you shortly.\n\nCooper's Floors\nPhone: 763-786-9616\nEmail: CoopersFloors@outlook.com\nAddress: 13640 Crosstown Blvd NW, Andover, MN 55304\nHours: Mon-Fri 10AM-5PM, Sat 10AM-3PM\n\n--\nYou're receiving this because you submitted a request on coopersfloors.com.";

// ── 11. Resend API helper ─────────────────────────────────────────────────────
function sendResend(string $key, array $payload): bool {
    $options = [
        'http' => [
            'method'        => 'POST',
            'header'        => [
                'Authorization: Bearer ' . $key,
                'Content-Type: application/json',
            ],
            'content'       => json_encode($payload),
            'timeout'       => 15,
            'ignore_errors' => true,
        ],
    ];
    $context = stream_context_create($options);
    $body = @file_get_contents(
        'https://api.resend.com/emails',
        false,
        $context
    );
    $status = 0;
    if (isset($http_response_header[0]) &&
        preg_match('/\s(\d{3})\s/', $http_response_header[0], $matches)) {
        $status = (int)$matches[1];
    }
    error_log("Resend API [$status]: " . ($body ?: 'No response'));
    return $status >= 200 && $status < 300;
}

// ── 12. Send business notification ───────────────────────────────────────────
$sent = sendResend($apiKey, [
    'from'     => MAIL_FROM,
    'to'       => [MAIL_TO],
    'reply_to' => (string)$email,
    'subject'  => $subjectLine,
    'html'     => $htmlBody,
    'text'     => $textBody,
]);

if (!$sent) {
    jsonError(500, "We couldn't send your message. Please try again or call us at 763-786-9616.");
}

// ── 13. Send customer confirmation (best-effort) ──────────────────────────────
sendResend($apiKey, [
    'from'    => MAIL_FROM,
    'to'      => [(string)$email],
    'subject' => "We received your request | Cooper's Floors",
    'html'    => $confirmHtml,
    'text'    => $confirmText,
]);

ob_clean();
echo json_encode(['ok' => true]);
