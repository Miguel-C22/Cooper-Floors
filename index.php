<?php
//php -S localhost:9081
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="styles.css?<?php echo filemtime('styles.css') ?>">
  <link rel="icon" type="image/png" href="Images/black-logo.png">
  <link rel="apple-touch-icon" href="Images/black-logo.png">
  <meta property="og:title" content="Cooper's Floors — Quality Flooring &amp; Installation">
  <meta property="og:description" content="Professional flooring installation in the Twin Cities. Carpet, luxury vinyl, and laminate.">
  <meta property="og:image" content="Images/open-graph-image.png">
  <meta property="og:type" content="website">
  <title>Cooper's Floors — Quality Flooring &amp; Installation</title>
</head>
<body>

<nav id="site-nav">
  <div class="nav-inner">
    <a class="nav-logo" href="index.php"><img src="Images/cooper-floors-black-logo.png" alt="Cooper's Floors" class="nav-logo-img"></a>
    <div class="nav-desktop-links">
      <a href="index.php" class="nav-link active">Home</a>
      <a href="about.html" class="nav-link">About</a>
      <button id="productBtn" class="nav-link">Flooring <svg id="chevIcon" class="nav-chev" width="11" height="7" viewBox="0 0 11 7" fill="none" aria-hidden="true"><path d="M1 1L5.5 6L10 1" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
      <a href="contact.html" class="nav-link" id="contactLink">Contact</a>
    </div>
    <div class="nav-desktop-actions">
      <a href="contact.html" class="nav-cta-btn">Get a Free Estimate →</a>
      <a href="tel:7637869616" class="nav-phone-link"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="flex:none"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12.7a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg> 763-786-9616</a>
    </div>
    <div class="nav-mobile-actions">
      <a href="tel:7637869616" class="nav-mobile-phone-btn" aria-label="Call us"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12.7a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg></a>
      <button id="hamburgerBtn" class="nav-hamburger-btn">☰</button>
    </div>
  </div>
  <div id="dropDownLinks" class="nav-mega">
    <div id="megaOverlay" class="nav-mega-overlay"></div>
    <div class="nav-mega-inner">
      <div class="nav-mega-intro">
        <div class="nav-mega-label">FLOORING PRODUCTS</div>
        <div class="nav-mega-title">Quality floors for every space.</div>
        <div class="nav-mega-desc">Explore our flooring options and find the perfect fit for your home or business.</div>
        
      </div>
      <div class="nav-mega-cards">
        <a href="carpet.html" class="nav-mega-card">
          <div class="nav-mega-card-img" style="background-image:url(Images/coopers-floors-website-images/05-carpet-bedroom.png)"></div>
          <div class="nav-mega-card-body"><div><div class="nav-mega-card-title">Carpet</div><div class="nav-mega-card-desc">Comfort meets durability.</div></div><div class="nav-mega-card-arrow">→</div></div>
        </a>
        <a href="luxuryVinyl.html" class="nav-mega-card">
          <div class="nav-mega-card-img" style="background-image:url(Images/coopers-floors-website-images/04-kitchen.png)"></div>
          <div class="nav-mega-card-body"><div><div class="nav-mega-card-title">Luxury Vinyl</div><div class="nav-mega-card-desc">Stylish. Waterproof. Versatile.</div></div><div class="nav-mega-card-arrow">→</div></div>
        </a>
        <a href="laminate.html" class="nav-mega-card">
          <div class="nav-mega-card-img" style="background-image:url(Images/coopers-floors-website-images/09-dining-room.png)"></div>
          <div class="nav-mega-card-body"><div><div class="nav-mega-card-title">Laminate</div><div class="nav-mega-card-desc">Beautiful looks. Everyday tough.</div></div><div class="nav-mega-card-arrow">→</div></div>
        </a>
      </div>
    </div>
  </div>
</nav>

<div id="mobileDrawer" class="mobile-drawer">
  <div id="drawerOverlay" class="mobile-drawer-overlay"></div>
  <aside class="mobile-drawer-inner">
    <div class="mobile-drawer-header">
      <a href="index.php" class="nav-logo"><img src="Images/cooper-floors-black-logo.png" alt="Cooper's Floors" class="nav-logo-img"></a>
      <button id="closeDrawerBtn" class="mobile-drawer-close">✕</button>
    </div>
    <a href="index.php" class="mobile-nav-link">Home</a>
    <a href="about.html" class="mobile-nav-link">About</a>
    <div class="mobile-flooring-acc">
      <button id="mobileAccBtn" class="mobile-acc-header">Flooring <svg id="mobileAccChev" class="nav-chev" width="11" height="7" viewBox="0 0 11 7" fill="none" aria-hidden="true"><path d="M1 1L5.5 6L10 1" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
      <div id="mobileAccContent" class="mobile-acc-content">
        <a href="carpet.html" class="mobile-acc-link"><span class="mobile-acc-img" style="background-image:url(Images/coopers-floors-website-images/05-carpet-bedroom.png)"></span>Carpet</a>
        <a href="luxuryVinyl.html" class="mobile-acc-link"><span class="mobile-acc-img" style="background-image:url(Images/coopers-floors-website-images/04-kitchen.png)"></span>Luxury Vinyl</a>
        <a href="laminate.html" class="mobile-acc-link"><span class="mobile-acc-img" style="background-image:url(Images/coopers-floors-website-images/09-dining-room.png)"></span>Laminate</a>
      </div>
    </div>
    <a href="contact.html" class="mobile-nav-link">Contact</a>
    <a href="tel:7637869616" class="mobile-phone-link"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12.7a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg> 763-786-9616</a>
    <a href="contact.html" class="mobile-cta-btn">Get a Free Estimate →</a>
  </aside>
</div>

<main>

  <!-- Hero -->
  <section class="page-hero hero-home" style="background-image:linear-gradient(90deg,#795B40cc 0%,#795B4066 55%,#795B4022 100%),url(Images/coopers-floors-website-images/01-hero-living-room.png)">
    <div class="hero-headline">Beautiful Floors for Every Space</div>
    <div class="hero-sub">Quality flooring. Expert installation. A home you'll love.</div>
    <div class="hero-btns">
      <a href="#flooring-products" class="btn-dark">Explore Our Products →</a>
      <a href="contact.html" class="btn-outline-white">Get a Free Estimate</a>
    </div>
    <svg class="wave-divider wave-bottom" viewBox="0 0 1440 80" preserveAspectRatio="none"><path d="M0 44 C260 0 520 84 760 44 S1200 4 1440 44 L1440 80 L0 80Z" fill="#FCFAF6"/></svg>
  </section>

  <!-- Pillars -->
  <div class="pillars-bar">
    <div class="pillar"><div class="pillar-icon">⌂</div><div>Residential &amp; Commercial</div></div>
    <div class="pillar"><div class="pillar-icon">◇</div><div>High-Quality Products</div></div>
    <div class="pillar"><div class="pillar-icon">❖</div><div>Expert Installation</div></div>
    <div class="pillar"><div class="pillar-icon">▤</div><div>Free Estimates &amp; Consultations</div></div>
  </div>

  <!-- About split -->
  <div class="split-section bg-cream section-edge">
    <div class="split-text">
      <div class="section-eyebrow">FLOORING SOLUTIONS</div>
      <div class="section-heading-lg">For Life's<br>Next Chapter</div>
      <p class="section-body">At Cooper's Floors, we provide top-quality flooring and expert installation for homes and businesses across the area. From carpet to luxury vinyl and laminate, we're here to help you find the perfect fit for your space and style.</p>
      <a href="about.html" class="btn-dark">Learn More About Us →</a>
    </div>
    <div class="split-img" style="background-image:url(Images/coopers-floors-website-images/04-kitchen.png)">
      <svg class="wave-vert-left" viewBox="0 0 60 100" preserveAspectRatio="none"><path d="M0 0 L30 0 C52 22 8 42 30 62 S48 86 30 100 L0 100Z" fill="#F7F3EB"/></svg>
    </div>
  </div>

  <!-- Products grid -->
  <section id="flooring-products" class="section-pad bg-cream">
    <div style="display:flex;justify-content:space-between;align-items:baseline;margin-bottom:clamp(22px,3vw,40px)">
      <div class="section-heading">Our Flooring Products</div>
    </div>
    <div class="products-grid">
      <a href="carpet.html" class="product-card">
        <div class="product-card-img" style="background-image:url(Images/coopers-floors-website-images/05-carpet-bedroom.png)"></div>
        <div class="product-card-body"><div><div class="product-card-title">Carpet</div><div class="product-card-desc">Comfort meets durability.</div></div><div class="product-card-arrow">→</div></div>
      </a>
      <a href="luxuryVinyl.html" class="product-card">
        <div class="product-card-img" style="background-image:url(Images/coopers-floors-website-images/04-kitchen.png)"></div>
        <div class="product-card-body"><div><div class="product-card-title">Luxury Vinyl</div><div class="product-card-desc">Stylish. Waterproof. Versatile.</div></div><div class="product-card-arrow">→</div></div>
      </a>
      <a href="laminate.html" class="product-card">
        <div class="product-card-img" style="background-image:url(Images/coopers-floors-website-images/09-dining-room.png)"></div>
        <div class="product-card-body"><div><div class="product-card-title">Laminate</div><div class="product-card-desc">Beautiful looks. Everyday tough.</div></div><div class="product-card-arrow">→</div></div>
      </a>
    </div>
  </section>

  <!-- CTA banner -->
  <section class="cta-banner" style="background:linear-gradient(90deg,#0E3528f2,#0E3528d0),url(Images/coopers-floors-website-images/10-flooring-samples.png) center/cover">
    <div>
      <div class="cta-banner-title">Let's Bring Your Vision to Life.</div>
      <div class="cta-banner-sub">Whether you're updating your home or outfitting a commercial space, our team is here to help.</div>
    </div>
    <a href="contact.html" class="btn-light">Get a Free Estimate →</a>
  </section>

  <!-- Testimonials -->
  <section class="testimonials-section">
    <div class="testi-header">
      <div class="testi-eyebrow">TESTIMONIALS</div>
      <div class="testimonials-heading"> Real experiences from homeowners and businesses across the Twin Cities.</div>
    </div>
    <div class="testi-carousel-wrap">
      <button class="testi-nav-btn" id="backward">&#8249;</button>
      <div class="testi-track-outer">
        <div class="testi-track" id="testiTrack"></div>
      </div>
      <button class="testi-nav-btn" id="forward">&#8250;</button>
    </div>
    <div class="testi-dots" id="testiDots"></div>
  </section>

</main>

<div id="reviewModal" class="review-modal" role="dialog" aria-modal="true" aria-label="Full review">
  <div class="review-modal-backdrop"></div>
  <div class="review-modal-box">
    <button class="review-modal-close" aria-label="Close">✕</button>
    <div class="review-modal-quote">"</div>
    <p class="review-modal-text"></p>
    <hr class="review-modal-divider">
    <div class="review-modal-name"></div>
    <div class="review-modal-stars">★★★★★</div>
  </div>
</div>

<footer>
  <div class="footer-inner">
    <div class="footer-brand">
      <div class="footer-brand-logo"><img src="Images/cooper-floors-logo-white.png" alt="Cooper's Floors" class="footer-logo-img"></div>
      <p class="footer-tagline">Quality flooring and installation for homes and businesses across the twin cities area.</p>

    </div>
    <div><span class="footer-col-title">Quick Links</span><div class="footer-col"><a href="index.php">Home</a><a href="about.html">About</a><a href="contact.html">Contact</a></div></div>
    <div><span class="footer-col-title">Our Products</span><div class="footer-col"><a href="carpet.html">Carpet</a><a href="luxuryVinyl.html">Luxury Vinyl</a><a href="laminate.html">Laminate</a></div></div>
    <div class="footer-contact-col"><span class="footer-col-title">Contact</span><a href="tel:7637869616"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="flex:none"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12.7a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg> 763-786-9616</a><a href="mailto:CoopersFloors@outlook.com"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="flex:none"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg> CoopersFloors@outlook.com</a><span>⌖ 13640 Crosstown Blvd NW<br>&nbsp;&nbsp;&nbsp;Andover, MN 55304</span></div>
  </div>
  <div class="footer-bottom">
    <span>© <?php echo date('Y'); ?> Cooper's Floors. All rights reserved.</span>

  </div>
</footer>

<script src="index.js?<?php echo filemtime('index.js') ?>" type="module"></script>
</body>
</html>
