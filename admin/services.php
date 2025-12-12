<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit;
}
require_once __DIR__ . '/../config.php';

$messages = [];
$errors = [];

// Handle Services CRUD
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    try {
        if ($action === 'save_service') {
            $id = $_POST['id'] ?? null;
            $data = [
                'name' => $_POST['name'],
                'agency' => $_POST['agency'],
                'fee' => $_POST['fee'],
                'processing_time' => $_POST['processing_time'],
                'documents' => $_POST['documents'],
                'eligibility' => $_POST['eligibility'],
                'process_steps' => $_POST['process_steps'],
                'locations' => $_POST['locations'],
                'contacts' => $_POST['contacts'],
                'notes' => $_POST['notes'],
                'last_verified' => $_POST['last_verified'],
                'region' => $_POST['region'],
            ];
            if ($id) {
                $sql = "UPDATE services SET name=:name, agency=:agency, fee=:fee, processing_time=:processing_time, documents=:documents, eligibility=:eligibility, process_steps=:process_steps, locations=:locations, contacts=:contacts, notes=:notes, last_verified=:last_verified, region=:region WHERE id=:id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute($data + ['id' => $id]);
                $messages[] = "Service updated.";
            } else {
                $sql = "INSERT INTO services (name, agency, fee, processing_time, documents, eligibility, process_steps, locations, contacts, notes, last_verified, region) VALUES (:name,:agency,:fee,:processing_time,:documents,:eligibility,:process_steps,:locations,:contacts,:notes,:last_verified,:region)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute($data);
                $messages[] = "Service created.";
            }
        }
        if ($action === 'delete_service') {
            $stmt = $pdo->prepare("DELETE FROM services WHERE id=:id");
            $stmt->execute(['id' => $_POST['id']]);
            $messages[] = "Service removed.";
        }
        if ($action === 'save_rep') {
            $id = $_POST['id'] ?? null;
            $data = [
                'name' => $_POST['name'],
                'role' => $_POST['role'],
                'district' => $_POST['district'],
                'constituency' => $_POST['constituency'],
                'phone' => $_POST['phone'],
                'email' => $_POST['email'],
            ];
            if ($id) {
                $sql = "UPDATE representatives SET name=:name, role=:role, district=:district, constituency=:constituency, phone=:phone, email=:email WHERE id=:id";
                $pdo->prepare($sql)->execute($data + ['id' => $id]);
                $messages[] = "Representative updated.";
            } else {
                $sql = "INSERT INTO representatives (name, role, district, constituency, phone, email) VALUES (:name,:role,:district,:constituency,:phone,:email)";
                $pdo->prepare($sql)->execute($data);
                $messages[] = "Representative created.";
            }
        }
        if ($action === 'delete_rep') {
            $pdo->prepare("DELETE FROM representatives WHERE id=:id")->execute(['id' => $_POST['id']]);
            $messages[] = "Representative removed.";
        }
        if ($action === 'save_agency') {
            $id = $_POST['id'] ?? null;
            $data = [
                'name' => $_POST['name'],
                'contact' => $_POST['contact'],
                'email' => $_POST['email'],
                'website' => $_POST['website'],
                'region' => $_POST['region'],
                'description' => $_POST['description'],
            ];
            if ($id) {
                $pdo->prepare("UPDATE agencies SET name=:name, contact=:contact, email=:email, website=:website, region=:region, description=:description WHERE id=:id")->execute($data + ['id' => $id]);
                $messages[] = "Agency updated.";
            } else {
                $pdo->prepare("INSERT INTO agencies (name, contact, email, website, region, description) VALUES (:name,:contact,:email,:website,:region,:description)")->execute($data);
                $messages[] = "Agency created.";
            }
        }
        if ($action === 'delete_agency') {
            $pdo->prepare("DELETE FROM agencies WHERE id=:id")->execute(['id' => $_POST['id']]);
            $messages[] = "Agency removed.";
        }
        header("Location: services.php?success=1");
        exit;
    } catch (Exception $e) {
        $errors[] = $e->getMessage();
    }
}

$editService = null;
if (!empty($_GET['edit_service'])) {
    $stmt = $pdo->prepare("SELECT * FROM services WHERE id=:id");
    $stmt->execute(['id' => $_GET['edit_service']]);
    $editService = $stmt->fetch();
}
$editRep = null;
if (!empty($_GET['edit_rep'])) {
    $stmt = $pdo->prepare("SELECT * FROM representatives WHERE id=:id");
    $stmt->execute(['id' => $_GET['edit_rep']]);
    $editRep = $stmt->fetch();
}
$editAgency = null;
if (!empty($_GET['edit_agency'])) {
    $stmt = $pdo->prepare("SELECT * FROM agencies WHERE id=:id");
    $stmt->execute(['id' => $_GET['edit_agency']]);
    $editAgency = $stmt->fetch();
}

$services = $pdo->query("SELECT * FROM services ORDER BY last_verified DESC")->fetchAll();
$representatives = $pdo->query("SELECT * FROM representatives ORDER BY district, name")->fetchAll();
$agencies = [];
try {
    $agencies = $pdo->query("SELECT * FROM agencies ORDER BY name")->fetchAll();
} catch (Exception $e) {
    // optional table; ignore if missing
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin | SaloneHub</title>
  <link rel="stylesheet" href="../assets/css/style.css">
  <style>
    body { font-family: 'Inter', system-ui, sans-serif; }
    body.page-body {
      background: var(--bg-gradient);
      color: var(--text);
    }
    .admin-shell {
      max-width: 1200px;
      margin: 0 auto;
      padding: 32px 18px 40px;
    }
    .admin-card {
      background: var(--glass);
      border: 1px solid var(--glass-border);
      border-radius: 18px;
      padding: 20px;
      box-shadow: 0 18px 40px rgba(0,0,0,0.25);
      backdrop-filter: blur(18px);
    }
    .admin-card h2, .admin-card h3 { margin: 0; }
    .admin-input {
      width: 100%;
      padding: 12px 14px;
      border-radius: 12px;
      border: 1px solid var(--glass-border);
      background: rgba(255,255,255,0.06);
      color: var(--text);
      margin-bottom: 14px;
    }
    .admin-input:last-child {
      margin-bottom: 0;
    }
    form .grid {
      margin-bottom: 14px;
    }
    form .grid .admin-input {
      margin-bottom: 0;
    }
    .admin-table {
      width: 100%;
      border-collapse: collapse;
      color: var(--text);
    }
    .admin-table th,
    .admin-table td {
      padding: 10px 8px;
      border-top: 1px solid var(--glass-border);
      text-align: left;
      font-size: 0.95rem;
    }
    .admin-pill-link { color: var(--accent); font-weight: 600; text-decoration: none; }
    .admin-btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      padding: 12px 14px;
      border-radius: 12px;
      border: 1px solid var(--glass-border);
      background: linear-gradient(135deg, var(--accent), #fbbf24);
      color: #0f172a;
      font-weight: 700;
      cursor: pointer;
    }
    .admin-badge { padding: 6px 10px; border-radius: 10px; background: rgba(255,255,255,0.08); color: var(--muted); font-size: 0.85rem; }
    a { color: var(--accent); }
    .text-muted { color: var(--muted); }
  </style>
  <script>
    function confirmLogout() {
      return confirm('Are you sure you want to logout?');
    }
  </script>
</head>
<body class="page-body">
  <div class="admin-shell">
    <div class="flex items-center justify-between mb-6">
      <div>
        <p class="text-sm text-muted">SaloneHub Admin</p>
        <h1 class="text-2xl" style="margin:4px 0;">Control Center</h1>
      </div>
      <div class="flex items-center gap-3">
        <a href="logout.php" class="card-actions" style="text-decoration:none;" onclick="return confirmLogout();"><span class="pill">Logout</span></a>
        <a href="../index.php" class="admin-pill-link">View site →</a>
      </div>
    </div>

    <?php if (!empty($_GET['success'])): ?>
      <div class="admin-card" style="border-color: rgba(16,185,129,0.5); color:#A7F3D0; background: rgba(16,185,129,0.12); margin-bottom:16px;">Changes saved.</div>
    <?php endif; ?>
    <?php foreach ($errors as $err): ?>
      <div class="admin-card" style="border-color: rgba(248,113,113,0.5); color:#fecaca; background: rgba(248,113,113,0.12); margin-bottom:16px;"><?php echo htmlspecialchars($err); ?></div>
    <?php endforeach; ?>

    <div class="grid md:grid-cols-2 gap-6">
      <div class="admin-card">
        <div class="flex items-center justify-between mb-3">
          <h2 class="font-semibold">Service <?php echo $editService ? 'Edit' : 'Create'; ?></h2>
          <?php if ($editService): ?>
            <a class="text-sm admin-pill-link" href="services.php">Reset</a>
          <?php endif; ?>
        </div>
        <form method="POST">
          <input type="hidden" name="action" value="save_service">
          <input type="hidden" name="id" value="<?php echo htmlspecialchars($editService['id'] ?? ''); ?>">
          <input required name="name" placeholder="Service Name" class="admin-input" value="<?php echo htmlspecialchars($editService['name'] ?? ''); ?>">
          <input required name="agency" placeholder="Agency" class="admin-input" value="<?php echo htmlspecialchars($editService['agency'] ?? ''); ?>">
          <div class="grid grid-cols-2 gap-3" style="margin-bottom:14px;">
            <input required name="fee" placeholder="Fee (NLe)" class="admin-input" value="<?php echo htmlspecialchars($editService['fee'] ?? ''); ?>">
            <input required name="processing_time" placeholder="Processing time" class="admin-input" value="<?php echo htmlspecialchars($editService['processing_time'] ?? ''); ?>">
          </div>
          <input name="region" placeholder="Region (Freetown/Bo/Kenema/Makeni)" class="admin-input" value="<?php echo htmlspecialchars($editService['region'] ?? ''); ?>">
          <textarea name="documents" placeholder="Documents (comma separated)" class="admin-input"><?php echo htmlspecialchars($editService['documents'] ?? ''); ?></textarea>
          <textarea name="eligibility" placeholder="Eligibility" class="admin-input"><?php echo htmlspecialchars($editService['eligibility'] ?? ''); ?></textarea>
          <textarea name="process_steps" placeholder="Process steps" class="admin-input"><?php echo htmlspecialchars($editService['process_steps'] ?? ''); ?></textarea>
          <textarea name="locations" placeholder="Locations (comma separated)" class="admin-input"><?php echo htmlspecialchars($editService['locations'] ?? ''); ?></textarea>
          <textarea name="contacts" placeholder="Contacts" class="admin-input"><?php echo htmlspecialchars($editService['contacts'] ?? ''); ?></textarea>
          <textarea name="notes" placeholder="Notes / corruption warnings" class="admin-input"><?php echo htmlspecialchars($editService['notes'] ?? ''); ?></textarea>
          <div class="flex items-center gap-3" style="margin-bottom:14px;">
            <label class="text-sm text-muted">Last Verified</label>
            <input type="date" name="last_verified" class="admin-input" style="margin-bottom:0;" value="<?php echo htmlspecialchars($editService['last_verified'] ?? ''); ?>">
          </div>
          <button class="admin-btn" style="width:100%; margin-top:8px;">Save Service</button>
        </form>
      </div>

      <div class="admin-card">
        <div class="flex items-center justify-between mb-3">
          <h2 class="font-semibold">Representative <?php echo $editRep ? 'Edit' : 'Create'; ?></h2>
          <?php if ($editRep): ?><a class="text-sm admin-pill-link" href="services.php">Reset</a><?php endif; ?>
        </div>
        <form method="POST">
          <input type="hidden" name="action" value="save_rep">
          <input type="hidden" name="id" value="<?php echo htmlspecialchars($editRep['id'] ?? ''); ?>">
          <input required name="name" placeholder="Full name" class="admin-input" value="<?php echo htmlspecialchars($editRep['name'] ?? ''); ?>">
          <input required name="role" placeholder="Role" class="admin-input" value="<?php echo htmlspecialchars($editRep['role'] ?? ''); ?>">
          <div class="grid grid-cols-2 gap-3" style="margin-bottom:14px;">
            <input name="district" placeholder="District" class="admin-input" value="<?php echo htmlspecialchars($editRep['district'] ?? ''); ?>">
            <input name="constituency" placeholder="Constituency" class="admin-input" value="<?php echo htmlspecialchars($editRep['constituency'] ?? ''); ?>">
          </div>
          <div class="grid grid-cols-2 gap-3" style="margin-bottom:14px;">
            <input name="phone" placeholder="Phone" class="admin-input" value="<?php echo htmlspecialchars($editRep['phone'] ?? ''); ?>">
            <input name="email" type="email" placeholder="Email" class="admin-input" value="<?php echo htmlspecialchars($editRep['email'] ?? ''); ?>">
          </div>
          <button class="admin-btn" style="width:100%; margin-top:8px; background: linear-gradient(135deg, var(--primary), #0f172a); color: var(--text); border-color: var(--glass-border);">Save Representative</button>
        </form>
      </div>
    </div>

    <div class="grid md:grid-cols-3 gap-6 mt-8">
      <div class="md:col-span-2 admin-card">
        <h3 class="font-semibold mb-3">Services</h3>
        <div class="overflow-x-auto">
          <table class="admin-table">
            <thead>
              <tr class="text-muted">
                <th class="py-2">Name</th>
                <th class="py-2">Agency</th>
                <th class="py-2">Region</th>
                <th class="py-2">Verified</th>
                <th class="py-2">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($services as $svc): ?>
                <tr>
                  <td class="py-2"><?php echo htmlspecialchars($svc['name']); ?></td>
                  <td class="py-2"><?php echo htmlspecialchars($svc['agency']); ?></td>
                  <td class="py-2"><?php echo htmlspecialchars($svc['region']); ?></td>
                  <td class="py-2"><?php echo htmlspecialchars($svc['last_verified']); ?></td>
                  <td class="py-2 flex items-center gap-2">
                    <a class="admin-pill-link text-xs" href="?edit_service=<?php echo $svc['id']; ?>">Edit</a>
                    <form method="POST" onsubmit="return confirm('Delete service?');">
                      <input type="hidden" name="action" value="delete_service">
                      <input type="hidden" name="id" value="<?php echo $svc['id']; ?>">
                      <button class="text-xs" style="color:#fca5a5;">Delete</button>
                    </form>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>

      <div class="admin-card">
        <h3 class="font-semibold mb-3">Agencies</h3>
        <form method="POST" style="margin-bottom:20px;">
          <input type="hidden" name="action" value="save_agency">
          <input type="hidden" name="id" value="<?php echo htmlspecialchars($editAgency['id'] ?? ''); ?>">
          <input required name="name" placeholder="Agency Name" class="admin-input" value="<?php echo htmlspecialchars($editAgency['name'] ?? ''); ?>">
          <input name="contact" placeholder="Contact Person" class="admin-input" value="<?php echo htmlspecialchars($editAgency['contact'] ?? ''); ?>">
          <input name="email" type="email" placeholder="Email" class="admin-input" value="<?php echo htmlspecialchars($editAgency['email'] ?? ''); ?>">
          <input name="website" placeholder="Website" class="admin-input" value="<?php echo htmlspecialchars($editAgency['website'] ?? ''); ?>">
          <input name="region" placeholder="Region" class="admin-input" value="<?php echo htmlspecialchars($editAgency['region'] ?? ''); ?>">
          <textarea name="description" placeholder="Description" class="admin-input"><?php echo htmlspecialchars($editAgency['description'] ?? ''); ?></textarea>
          <button class="admin-btn" style="width:100%; margin-top:8px;">Save Agency</button>
        </form>
        <div class="space-y-3 max-h-64 overflow-y-auto">
          <?php foreach ($agencies as $agency): ?>
            <div class="admin-card" style="padding:12px;">
              <div class="font-semibold"><?php echo htmlspecialchars($agency['name']); ?></div>
              <p class="text-muted"><?php echo htmlspecialchars($agency['region']); ?></p>
              <div class="flex items-center gap-2 mt-2">
                <a class="admin-pill-link text-xs" href="?edit_agency=<?php echo $agency['id']; ?>">Edit</a>
                <form method="POST" onsubmit="return confirm('Delete agency?');">
                  <input type="hidden" name="action" value="delete_agency">
                  <input type="hidden" name="id" value="<?php echo $agency['id']; ?>">
                  <button class="text-xs" style="color:#fca5a5;">Delete</button>
                </form>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

    <div class="admin-card" style="margin-top:32px;">
      <h3 class="font-semibold mb-3">Representatives</h3>
      <div class="overflow-x-auto">
        <table class="admin-table">
          <thead>
            <tr class="text-muted">
              <th class="py-2">Name</th>
              <th class="py-2">Role</th>
              <th class="py-2">District</th>
              <th class="py-2">Contact</th>
              <th class="py-2">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($representatives as $rep): ?>
              <tr>
                <td class="py-2"><?php echo htmlspecialchars($rep['name']); ?></td>
                <td class="py-2"><?php echo htmlspecialchars($rep['role']); ?></td>
                <td class="py-2"><?php echo htmlspecialchars($rep['district']); ?></td>
                <td class="py-2"><?php echo htmlspecialchars($rep['phone']); ?></td>
                <td class="py-2 flex items-center gap-2">
                  <a class="admin-pill-link text-xs" href="?edit_rep=<?php echo $rep['id']; ?>">Edit</a>
                  <form method="POST" onsubmit="return confirm('Delete representative?');">
                    <input type="hidden" name="action" value="delete_rep">
                    <input type="hidden" name="id" value="<?php echo $rep['id']; ?>">
                    <button class="text-xs" style="color:#fca5a5;">Delete</button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>

