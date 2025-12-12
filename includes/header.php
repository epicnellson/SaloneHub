<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $pageTitle ?? 'SaloneHub | Sierra Leone Government Services Portal'; ?></title>
    <meta name="description" content="<?php echo $pageDescription ?? 'Find Sierra Leone government services, requirements, and representatives instantly. Access verified information on fees, documents, processing times, and contact details for all civic services.'; ?>" />
    <meta name="keywords" content="Sierra Leone, government services, civic portal, voter registration, national ID, business registration, passport, driver license, representatives, MPs, local council" />
    <meta name="author" content="SaloneHub" />
    <meta name="robots" content="index, follow" />
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website" />
    <meta property="og:url" content="<?php echo 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" />
    <meta property="og:title" content="<?php echo $pageTitle ?? 'SaloneHub | Sierra Leone Government Services Portal'; ?>" />
    <meta property="og:description" content="<?php echo $pageDescription ?? 'Find Sierra Leone government services, requirements, and representatives instantly. Access verified information on fees, documents, processing times, and contact details.'; ?>" />
    <meta property="og:image" content="<?php echo 'https://' . $_SERVER['HTTP_HOST']; ?>/assets/images/og-card.png" />
    <meta property="og:site_name" content="SaloneHub" />
    <meta property="og:locale" content="en_US" />
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:url" content="<?php echo 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" />
    <meta property="twitter:title" content="<?php echo $pageTitle ?? 'SaloneHub | Sierra Leone Government Services Portal'; ?>" />
    <meta property="twitter:description" content="<?php echo $pageDescription ?? 'Find Sierra Leone government services, requirements, and representatives instantly.'; ?>" />
    <meta property="twitter:image" content="<?php echo 'https://' . $_SERVER['HTTP_HOST']; ?>/assets/images/og-card.png" />
    
    <!-- PWA -->
    <link rel="manifest" href="manifest.json">
    <meta name="theme-color" content="#0F4C5C" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta name="apple-mobile-web-app-title" content="SaloneHub" />
    
    <!-- Schema.org structured data -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "GovernmentOrganization",
      "name": "SaloneHub",
      "description": "Sierra Leone Government Services Portal",
      "url": "<?php echo 'https://' . $_SERVER['HTTP_HOST']; ?>",
      "logo": "<?php echo 'https://' . $_SERVER['HTTP_HOST']; ?>/assets/images/icon-512.png",
      "sameAs": [],
      "address": {
        "@type": "PostalAddress",
        "addressCountry": "SL",
        "addressLocality": "Freetown"
      },
      "areaServed": {
        "@type": "Country",
        "name": "Sierra Leone"
      }
    }
    </script>
    <link rel="apple-touch-icon" href="assets/images/icon-192.png" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="page-body" data-theme="dark">
  <div id="page" class="page-shell">
    <header class="glass-nav sticky-top">
      <div class="nav-container">
        <a href="index.php" class="logo">
          <h2>🗺️ SaloneHub</h2>
          <span>Civic Services Portal</span>
        </a>
        <button class="menu-toggle" id="menu-toggle" aria-label="Toggle menu">☰</button>
        <div class="nav-links" id="nav-links">
          <a href="index.php">Home</a>
          <a href="services.php">Services</a>
          <a href="representatives.php">Representatives</a>
        </div>
        <div class="nav-right">
          <button id="search-toggle" aria-label="Toggle search">🔍</button>
          <button id="theme-toggle" aria-label="Toggle dark mode"><span id="theme-icon">🌙</span></button>
        </div>
      </div>
      <div class="mobile-menu" id="mobile-menu">
        <a href="index.php">Home</a>
        <a href="services.php">Services</a>
        <a href="representatives.php">Representatives</a>
      </div>
    </header>
    <main class="site-main">

