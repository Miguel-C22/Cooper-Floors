<?php
//php -S localhost:9081

$emailOutPut = "";

ini_set("SMTP", "http://159.203.161.98/");
ini_set("sendmail_from", "miguel.ganoza@yahoo.com");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["formType"])){
        $formType = $_POST["formType"];
    }
    else {
        $formType = "";
    }
    
    //CoopersFloors@outlook.com
    $to = "miguel.ganoza209@gmail.com";
    $subject = '';

    $msg = "";

    if ($formType === "estimation") {
        $selectedChoice = isset($_POST["EstimateOrConsultation"]) ? $_POST["EstimateOrConsultation"] : "";
        $subject = "Estimation Request";
        
        // Include the "Choice" field only if "Estimate" is selected
        if ($selectedChoice === "Estimate") {
            $msg .= "<div style='display: block; margin-bottom: 10px;'><h4 style='display: inline;'>Choice:</h4><p style='display: inline; margin: 0;'> Estimate</p></div>";
        }
        if ($selectedChoice === "Consultation") {
            $msg .= "<div style='display: block; margin-bottom: 10px;'><h4 style='display: inline;'>Choice:</h4><p style='display: inline; margin: 0;'> Consultation</p></div>";
        }
    } else {
        $subject = "Contact Request";
    }

    $msg .= "<div style='display: block; margin-bottom: 10px;'><h4 style='display: inline;'>From:</h4><p style='display: inline;'> " . $_POST["FirstName"] . " " . $_POST["LastName"] . "</p></div>";
    $msg .= "<div style='display: block; margin-bottom: 10px;'><h4 style='display: inline;'>Email:</h4><p style='display: inline;'> " . $_POST["Email"] . "</p></div>";
    $msg .= "<div style='display: block; margin-bottom: 10px;'><h4 style='display: inline;'>Phone Number:</h4><p style='display: inline;'> " . (isset($_POST["PhoneNumber"]) ? $_POST["PhoneNumber"] : "") . "</p></div>";

    // Include the Message field
    $msg .= "<div style='display: block; margin-bottom: 10px;'><h4 style='display: inline;'>Message:</h4><p style='display: inline; margin: 0;'> " . $_POST["Message"] . "</p></div>";

    $headers = "From: ". $_POST["Email"] . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

    if (mail($to, $subject, $msg, $headers)) {
       $emailOutPut = "Email sent successfully!";
    } else {
        $emailOutPut = "Failed to send email.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="form.css">
    <title>Home</title>
</head>
<body>

    <nav>
        <button class="hamburgerBtn" id="hamburgerBtn">|||</button>
        <a class="headerLogo" href="index.php"><img class="headerLogo" src="Images/CooperFloorsLogo.PNG" alt=""></a>
        <div class="navLinks" id="navLinks">
            <button class="closeHamburgerBtn" id="closeHamburgerBtn">X</button>
            <a href="index.php">Home</a>
            <hr>
            <a href="about.html">About</a>
            <hr>
            <p id="productBtn" class="productBtn">Products 
                <img src="Images/dropDownArrow.png" alt="" width="10" height="8">
            </p>
            <hr class="btnHr">
                <div class="dropDownLinks" id="dropDownLinks">
                    <a href="carpet.html">Carpet</a>
                    <hr>
                    <a href="luxuryVinyl.html">Luxury Vinyl</a>
                    <hr>
                    <a href="laminate.html">Laminate</a>
                    <hr>
                </div>
            <a id="contactLink" class="contact" href="contact.html">Contact</a>
            <hr>
            <a href="tel: 763-786-9616" class="HamburgerphoneNumber" id="HamburgerphoneNumber">Phone: 763-786-9616</a>
        </div>
        <a href="tel: 763-786-9616" class="phoneNumber" id="phoneNumber">Phone: 763-786-9616</a>
    </nav>
       
    <?php
        // Check if the emailOutPut is set and not empty
        if (isset($emailOutPut) && !empty($emailOutPut)) {
            echo '<div id="emailOutPut" class="emailOutPut">' . $emailOutPut . '<button id="closeEmailOutput" class="closeEmailOutput">close</button></div>';

        } else {
            // If emailOutPut is empty or not set, do not display the container
            echo $emailOutPut;
        }
    ?>
        
    <header>
        <img src="Images/homeHeader.png" alt="">
        <div class="headerText">
            <p>We offer free estimates <br>
                 and design consultation</p>
            <a href="freeEstimate.html"><button> Click Here</button></a>
        </div>
    </header>

    <main>
         <div class="commercialServices">
            <p>We provide residential and commercial services</p>
            <a href="residential&Commercial.html"><button>Learn More</button></a>
         </div>

         <section class="flooringOptions flooringOption">
            <div class="carpet hidden flooringOption">
                <h2>Carpet</h2>
                <a href="carpet.html"><button>Explore Carpet</button></a>
            </div>
            <div class="luxuryVinyl hidden flooringOption">
                <h2>Luxury Vinyl</h2>
                <a href="luxuryVinyl.html"><button>Explore Luxury Vinyl </button></a>
            </div>

            <div class="laminate hidden flooringOption">
                <h2>Laminate</h2>
                <a href="laminate.html"><button>Explore Laminate </button></a>
            </div>
         </section>

         <div class="customer-review-container">
            <button class="backward" id="backward">&larr;</button>
            <section class="customerReviews" id="customerReviews"></section>
            <button class="forward" id="forward">&rarr;</button>
         </div>
         

         <section>
            <h2 class="homePageContactUsH2">Contact US</h2>
            <div class="homeContactForm">
            <form action="index.php" method="POST">
                <input type="hidden" name="_subject" value="New Email">
                <div class="name">
                    <div class="label">
                        <label for="fname">First name*</label>
                        <input type="text" name="FirstName" required>
                    </div>
                    <div class="label">
                        <label for="fname">Last name*</label>
                        <input type="text" name="LastName" required>
                    </div>
                    
                </div>
                <div class="contactInfo">
                    <div class="label">
                        <label for="fname">Email*</label>
                        <input type="email" name="Email" required>
                    </div>
                    <div class="label">
                        <label for="fname">Phone number*</label>
                        <input type="tel" name="PhoneNumber" id="phoneNumberInput" required>
                    </div>
                
                </div>
                <div class="message">
                    <div class="label">
                        <label for="fname">Message*</label>
                        <textarea class="userInput" name="Message" placeholder="How can we help you!"></textarea>
                    </div>
                </div>
                <input class="sumbit" type="submit" value="Send">
            </form>
            <iframe class="iframHomePage" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2810.4336203472362!2d-93.33038312379983!3d45.21879547107101!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x52b33d0730a78345%3A0xd2a1f9d17d483ff5!2s13640%20Crosstown%20Blvd%20NW%2C%20Andover%2C%20MN%2055304!5e0!3m2!1sen!2sus!4v1692465345032!5m2!1sen!2sus" width="600" height="550" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        </section>
        <section class="aboutUsSection">
            <div class="aboutUsContainer">
            <img class="aboutUsImage hidden" src="Images/AboutUs.jpeg" alt="">
            <div class="aboutUsContent hidden">
                <h1>We are the Cooper's</h1>
                <p>Gary and Jan, originally from a South Dakota farm town,
                    married and moved to Minnesota in 1962. 
                    Gary began his career as a floor installer, 
                    later transitioning to carpet buying and selling.
                    The couple's business, initially run from home,
                    expanded through various locations. Despite economic 
                    challenges, they've maintained their business for 23 
                    years. Alongside their entrepreneurial success, 
                    they're active in their church and enjoy time with 
                    their four daughters, 16 grandchildren, 
                    and 9 great-grandchildren, leading a fulfilling 
                    and vibrant life.  
                </p>
                <a href="about.html"><button>More About US</button></a>
            </div> 
        </div>
        </section>
    </main>

    
    <footer>
        <div class="footerLogo">
            <img src="Images/CooperFloorsLogoWhite.PNG" alt="">
        </div>
        <div class="footerContainer">
            <div class="siteMap">
               <h2>SiteMap</h2>
               <div class="siteMapLinks">
                <a href="index.php">Home</a>
                <a href="about.html">About</a>
                <a href="contact.html">Contact</a>
                <a href="freeEstimate.html">Free Estimate</a>
                <a href="residential&Commercial.html">Residential & Commercial</a>
                <a href="carpet.html">Carpet</a>
                <a href="laminate.html">Laminate</a>
                <a href="luxuryVinyl.html">Luxury Vinyl</a>
               </div>
            </div>
            <div class="contactAdress">
                <h2>Andover, MN</h2>
                <a href="tel:763-786-9616" id="phoneNumber">PHONE: 763-786-9616</a>
                <address>ADDRESS: 13640 Crosstown Blvd NW</address>
                <a href="mailto:">EMAIL: CooperFloors@outlook.com</a>
            </div>
            <div class="hours">
                <h2>Hours</h2>
                <p>Monday-Friday <br><span>10:00AM - 5:00pm</span></p>
                <p>Saturday <br><span>10:00 AM - 3:00PM</span></p>
                <p>Sunday <br><span>Closed</span></p>
            </div>
        </div>
        <div class="copySocial">
            &copy; Cooper Floors 
            <!-- <a class="fa fa-facebook-square" aria-hidden="true"></a> -->
        </div>
    </footer>

    <script src="index.js" type="module"></script>
</body>
</html>