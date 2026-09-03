<?php
// No usar el layout global; esta página tiene diseño propio (pantalla de login)
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Acceso Administrativo &mdash; <?= APP_INST ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
<link rel="stylesheet" href="<?= BASE_URL ?>public/css/style.css?v=3">
</head>
<body class="body-login">

<div class="login-wrap">

  <div class="login-card">
    <!-- Logo / institución -->
    <div class="login-header">
      <div class="login-icon">
        <img src="<?= BASE_URL ?>assets/logo.jpeg" alt="<?= APP_INST ?>" class="login-logo">
      </div>
      <h1 class="login-title">Panel Administrativo</h1>
      <p class="login-sub"><?= APP_INST ?> &mdash; <?= APP_NAME ?></p>
    </div>

    <?php if ($error): ?>
    <div class="alert alert-error" role="alert">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
      <span><?= htmlspecialchars($error) ?></span>
    </div>
    <?php endif; ?>

    <form method="POST" autocomplete="on">
      <div class="form-group">
        <label class="form-label" for="usuario">Usuario</label>
        <div class="input-icon-wrap">
          <span class="input-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
          </span>
          <input type="text" id="usuario" name="usuario" class="form-control has-icon"
                 placeholder="Ingrese su usuario" autocomplete="username" required
                 value="<?= htmlspecialchars($_POST['usuario'] ?? '') ?>">
        </div>
      </div>

      <div class="form-group">
        <label class="form-label" for="password">Contraseña</label>
        <div class="input-icon-wrap">
          <span class="input-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
          </span>
          <input type="password" id="password" name="password" class="form-control has-icon"
                 placeholder="••••••••" autocomplete="current-password" required>
        </div>
      </div>

      <button type="submit" class="btn btn-primary btn-block" style="margin-top:.4rem;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
        Ingresar al Panel
      </button>
    </form>

    <div class="login-footer-link">
      <a href="<?= BASE_URL ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
        Volver al inicio
      </a>
    </div>
  </div>

  <p class="login-copy"><?= APP_INST ?> &copy; <?= date('Y') ?></p>
</div>

</body>
</html>
