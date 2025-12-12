<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/header.php';

try {
    // MySQL-compatible ordering (NULLS LAST equivalent)
    $stmt = $pdo->query("SELECT * FROM services ORDER BY last_verified IS NULL, last_verified DESC");
    $services = $stmt->fetchAll();
} catch (Exception $e) {
    $services = [];
    error_log("Services query error: " . $e->getMessage());
}
?>

<section class="section">
  <div class="section-header">
    <p>Directory</p>
    <h1>Government Services</h1>
    <p style="color:var(--muted);">Search verified fees, documents, and contacts. Updated with corruption warnings.</p>
  </div>
  <div class="card-actions" style="margin-bottom:14px;">
    <a href="admin/" class="cta-button" style="padding:12px 16px;">Admin</a>
  </div>
  <div class="filter-bar">
    <input id="service-search" type="text" placeholder="Search service or keyword" aria-label="Search services">
    <select id="filter-agency">
      <option value="">Agency</option>
      <?php
        $agencies = array_unique(array_map(fn($s) => $s['agency'], $services));
        foreach ($agencies as $agency):
      ?>
        <option value="<?php echo htmlspecialchars($agency); ?>"><?php echo htmlspecialchars($agency); ?></option>
      <?php endforeach; ?>
    </select>
    <select id="filter-region">
      <option value="">Region</option>
      <option value="Freetown">Freetown</option>
      <option value="Bo">Bo</option>
      <option value="Kenema">Kenema</option>
      <option value="Makeni">Makeni</option>
    </select>
  </div>

  <div class="service-grid" style="padding-top:1.5rem;">
    <?php if (empty($services)): ?>
      <article class="service-card">
        <h3>No services yet</h3>
        <p style="color:var(--muted);">Add your first service in the admin dashboard.</p>
        <div class="card-actions">
          <a href="admin/">Go to Admin →</a>
        </div>
      </article>
    <?php endif; ?>

    <?php foreach ($services as $service): ?>
      <?php
        $documents = array_filter(array_map('trim', explode(',', $service['documents'] ?? '')));
        $locations = array_filter(array_map('trim', explode(',', $service['locations'] ?? '')));
        $safe = fn($v) => htmlspecialchars($v ?? '', ENT_QUOTES);
        $details = "
          <div class='space-y-2'>
            <p class=\"text-sm text-slate-500\">SERVICE</p>
            <h3 class='text-2xl font-display text-tealdeep dark:text-gold'>{$safe($service['name'])}</h3>
            <p class='text-sm text-slate-400'>Agency: {$safe($service['agency'])} | Verified: {$safe($service['last_verified'])}</p>
            <div class='grid sm:grid-cols-2 gap-3'>
              <div class=\"p-3 rounded-xl bg-slate-50 dark:bg-white/5\"><p class=\"font-semibold\">Fee</p><p>{$safe($service['fee'])}</p></div>
              <div class=\"p-3 rounded-xl bg-slate-50 dark:bg-white/5\"><p class=\"font-semibold\">Processing</p><p>{$safe($service['processing_time'])}</p></div>
            </div>
            <div><p class='font-semibold'>Documents</p><ul class='list-disc list-inside text-sm text-slate-600 dark:text-slate-200'>".
              implode('', array_map(fn($d) => "<li>".$safe($d)."</li>", $documents))
            ."</ul></div>
            <div><p class='font-semibold'>Locations</p><p>".implode(' • ', array_map($safe, $locations))."</p></div>
            <div><p class='font-semibold'>Contacts</p><p>{$safe($service['contacts'])}</p></div>
            <div class='text-amber-600 dark:text-amber-300 font-semibold'>⚠️ Notes: {$safe($service['notes'])}</div>
          </div>
        ";
      ?>
      <article
        class="service-card"
        data-service-card
        data-agency="<?php echo htmlspecialchars($service['agency']); ?>"
        data-region="<?php echo htmlspecialchars($service['region']); ?>"
        data-search="<?php echo strtolower(htmlspecialchars($service['name'] . ' ' . $service['agency'] . ' ' . ($service['region'] ?? ''))); ?>"
      >
        <div class="pill">Service</div>
        <h3><?php echo htmlspecialchars($service['name']); ?></h3>
        <p style="color:var(--muted);">Agency: <?php echo htmlspecialchars($service['agency']); ?> · Region: <?php echo htmlspecialchars($service['region']); ?></p>
        <div class="service-meta">
          <div class="meta-pill">Fee: <?php echo htmlspecialchars($service['fee']); ?></div>
          <div class="meta-pill">Time: <?php echo htmlspecialchars($service['processing_time']); ?></div>
        </div>
        <div class="card-actions">
          <button
            data-service="<?php echo htmlspecialchars($details, ENT_QUOTES); ?>"
            style="background: linear-gradient(135deg, var(--accent), #fbbf24); color:#0f172a; border: none;"
          >View details →</button>
        </div>
      </article>
    <?php endforeach; ?>
  </div>
</section>

<div id="service-modal" class="modal-overlay hidden">
  <div class="modal-body">
    <button id="close-modal" class="modal-close" aria-label="Close modal">✕</button>
    <div id="modal-content" class="modal-content-inner"></div>
  </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
