<?php
session_start();
if (isset($_SESSION['admin'])) {
    header('Location: services.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    if ($username === 'admin' && $password === 'salonehub2025') {
        $_SESSION['admin'] = true;
        header('Location:services.php');
        exit;
    } else {
        $error = 'Invalid credentials';
    }
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
    body.page-body { background: var(--bg-gradient); color: var(--text); }
    .auth-card {
      width: 100%;
      max-width: 480px;
      margin: 0 auto;
      background: var(--glass);
      border: 1px solid var(--glass-border);
      border-radius: 20px;
      padding: 28px;
      box-shadow: 0 18px 40px rgba(0,0,0,0.28);
      backdrop-filter: blur(18px);
    }
    .auth-input {
      width: 100%;
      padding: 12px 14px;
      border-radius: 12px;
      border: 1px solid var(--glass-border);
      background: rgba(255,255,255,0.08);
      color: var(--text);
      margin-bottom: 18px;
    }
    .auth-label { font-size: 0.9rem; color: var(--muted); display: block; margin-bottom: 8px; }
    form > div {
      margin-bottom: 4px;
    }
    .auth-btn {
      width: 100%;
      padding: 12px 14px;
      border-radius: 12px;
      border: 1px solid var(--glass-border);
      background: linear-gradient(135deg, var(--accent), #fbbf24);
      color: #0f172a;
      font-weight: 700;
      cursor: pointer;
    }
    .error-box {
      margin-bottom: 16px;
      padding: 12px 14px;
      border-radius: 12px;
      border: 1px solid rgba(248,113,113,0.5);
      background: rgba(248,113,113,0.12);
      color: #fecaca;
      font-size: 0.95rem;
    }
  </style>
</head>
<body class="page-body flex items-center justify-center px-4" style="min-height:100vh;">
  <div class="auth-card">
    <div class="flex items-center gap-3 mb-5">
      <div class="w-10 h-10 rounded-2xl" style="background: linear-gradient(135deg, var(--accent), var(--primary)); display:flex; align-items:center; justify-content:center; color:white; font-weight:700;">SH</div>
      <div>
        <p class="text-sm" style="letter-spacing:0.18em; text-transform:uppercase; color: var(--accent); margin:0;">SaloneHub</p>
        <p class="text-xs text-muted" style="margin:2px 0 0;">Admin Access</p>
      </div>
    </div>
    <?php if ($error): ?>
      <div class="error-box"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <form method="POST">
      <div>
        <label class="auth-label">Username</label>
        <input required name="username" class="auth-input" placeholder="admin">
      </div>
      <div>
        <label class="auth-label">Password</label>
        <input required name="password" type="password" class="auth-input" placeholder="salonehub2025">
      </div>
      <button class="auth-btn" style="margin-top:8px;">Sign in</button>
    </form>
    <p class="text-xs text-muted mt-4">Password protected • InfinityFree ready</p>
  </div>
</body>
</html>

