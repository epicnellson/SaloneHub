<?php
$pageTitle = 'Find Your Representatives | SaloneHub';
$pageDescription = 'Connect with Sierra Leone government representatives. Find MPs, local council members, and elected officials by district. Get contact information to reach your representatives directly.';
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/header.php';

try {
    $stmt = $pdo->query("SELECT * FROM representatives ORDER BY district, name");
    $representatives = $stmt->fetchAll();
} catch (Exception $e) {
    $representatives = [];
}

$districts = array_unique(array_map(fn($r) => $r['district'], $representatives));
sort($districts);
?>

<section class="section">
  <div class="section-header">
    <p>Representatives</p>
    <h1>Find your MP or Local Council</h1>
    <p style="color:var(--muted);">Filter by district and contact them directly.</p>
  </div>
  <div class="filter-bar" style="margin-bottom:14px;">
    <select id="district-filter">
      <option value="">All Districts</option>
      <?php foreach ($districts as $district): ?>
        <option value="<?php echo htmlspecialchars($district); ?>"><?php echo htmlspecialchars($district); ?></option>
      <?php endforeach; ?>
    </select>
    <div class="card-actions">
      <a href="admin/" class="cta-button" style="padding:12px 16px;">Admin</a>
    </div>
  </div>

  <div class="service-grid" style="padding-top:0;">
    <?php if (empty($representatives)): ?>
      <article class="service-card">
        <h3>No representatives yet</h3>
        <p style="color:var(--muted);">Add representatives in the admin dashboard.</p>
        <div class="card-actions"><a href="admin/">Go to Admin →</a></div>
      </article>
    <?php endif; ?>

    <?php foreach ($representatives as $rep): ?>
      <article
        class="service-card rep-card"
        data-rep-card
        data-district="<?php echo htmlspecialchars($rep['district']); ?>"
      >
        <div class="pill">District: <?php echo htmlspecialchars($rep['district']); ?></div>
        <h3><?php echo htmlspecialchars($rep['name']); ?></h3>
        <p style="color:var(--muted);"><?php echo htmlspecialchars($rep['role']); ?> · <?php echo htmlspecialchars($rep['constituency']); ?></p>
        <div class="rep-meta">
          <a class="meta-pill" href="tel:<?php echo htmlspecialchars($rep['phone']); ?>">📞 <?php echo htmlspecialchars($rep['phone']); ?></a>
          <a class="meta-pill" href="mailto:<?php echo htmlspecialchars($rep['email']); ?>">✉️ Email</a>
        </div>
        <div class="card-actions">
          <a href="mailto:<?php echo htmlspecialchars($rep['email']); ?>">Contact your Representative →</a>
        </div>
      </article>
    <?php endforeach; ?>
  </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
