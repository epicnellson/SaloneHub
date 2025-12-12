<?php require_once __DIR__ . '/includes/header.php'; ?>

<section class="hero">
  <div class="hero-content">
    <h1>Find Government Services<br><span style="color:var(--accent);">in 3 Clicks</span></h1>
    <p>Passport · Driver's License · NIN · Business Registration</p>
    <div class="hero-actions">
      <input type="text" id="hero-search" placeholder="Search services..." class="glass-input" autocomplete="off">
      <a href="services.php" class="cta-button" id="browse-btn">Browse Services →</a>
    </div>
    <div class="card-actions" style="margin-top:14px;">
      <span class="pill">✅ Verified data</span>
      <span class="pill">⚡ Lightning navigation</span>
    </div>
  </div>
</section>

<section class="section">
  <div class="section-header">
    <p>Featured</p>
    <h2>Priority Government Services</h2>
  </div>
  <div class="service-grid">
    <?php
      $featured = [
        ['Voter Registration','ECSL','NLe 0','2 days','Freetown','Register safely without middlemen.'],
        ['National ID (NIN)','NCRA','NLe 120','5 days','Bo','Bring birth certificate or affidavit.'],
        ['Business Registration','CAC','NLe 450','7 days','Freetown','Single window processing.'],
        ['Passport Renewal','Immigration','NLe 850','10 days','Freetown + Regions','Avoid unofficial fees.']
      ];
      foreach ($featured as $svc):
    ?>
    <article class="service-card">
      <div class="pill">Fast Track</div>
      <h3><?php echo htmlspecialchars($svc[0]); ?></h3>
      <p style="color:var(--muted); margin: 6px 0 10px;"><?php echo htmlspecialchars($svc[5]); ?></p>
      <div class="service-meta">
        <div class="meta-pill">Agency: <?php echo htmlspecialchars($svc[1]); ?></div>
        <div class="meta-pill">Fee: <?php echo htmlspecialchars($svc[2]); ?></div>
        <div class="meta-pill">Time: <?php echo htmlspecialchars($svc[3]); ?></div>
        <div class="meta-pill">Region: <?php echo htmlspecialchars($svc[4]); ?></div>
      </div>
      <div class="card-actions">
        <a href="services.php">View details</a>
      </div>
    </article>
    <?php endforeach; ?>
  </div>
</section>

<section class="section">
  <div class="section-header">
    <p>Live Updates</p>
    <h2>Get requirements in 3 seconds</h2>
  </div>
  <div class="service-card" style="background: rgba(255,255,255,0.06);">
    <p style="color:var(--muted); margin-bottom:12px;">Search verified services, see fees, documents, timelines, and contacts without dealing with middlemen.</p>
    <div class="card-actions" style="margin-bottom:10px;">
      <span class="pill">Offline ready</span>
      <span class="pill">Glassmorphism</span>
      <span class="pill">Keyboard friendly</span>
    </div>
    <div class="service-meta">
      <div class="meta-pill">Services: 10+</div>
      <div class="meta-pill">Contacts: 50+</div>
      <div class="meta-pill">Live: Updates</div>
      <div class="meta-pill">Reach: Nationwide</div>
    </div>
    <div class="card-actions">
      <a href="representatives.php">Find representatives</a>
      <a href="services.php">Explore services</a>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
