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
    <title>SaloneHub | Civic Services Portal</title>
    <meta name="description" content="Find Sierra Leone government services, requirements, and representatives instantly on SaloneHub." />
    <meta property="og:title" content="SaloneHub | Sierra Leone Government Services" />
    <meta property="og:description" content="Discover verified services, fees, documents, and contacts across Sierra Leone." />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://salonehub.demo" />
    <meta property="og:image" content="assets/images/og-card.png" />
    <link rel="manifest" href="manifest.json">
    <meta name="theme-color" content="#1E3A8A" />
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

