<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($pageTitle ?? APP_NAME) ?> &mdash; <?= APP_INST ?></title>
<meta name="description" content="<?= htmlspecialchars($pageDesc ?? 'Sistema de Mesa de Partes Virtual del ' . APP_INST) ?>">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
<link rel="stylesheet" href="<?= BASE_URL ?>public/css/style.css?v=3">
</head>
<body>

<header class="site-header">
  <div class="header-inner">
    <div class="header-brand">
      <!-- Logo institucional -->
      <div class="brand-icon-wrap">
        <img src="<?= BASE_URL ?>assets/logo.jpeg" alt="<?= APP_INST ?>" class="brand-logo">
      </div>
      <div class="brand-text">
        <span class="brand-name"><?= APP_INST ?></span>
        <span class="brand-sub"><?= APP_NAME ?></span>
      </div>
    </div>

    <nav class="header-nav">
      <?php if (!empty($_SESSION['admin_id'])): ?>
        <a href="<?= BASE_URL ?>admin" class="nav-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin') && !str_contains($_SERVER['REQUEST_URI'], 'login') ? 'active' : '' ?>">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
          Panel
        </a>
        <a href="<?= BASE_URL ?>admin/logout" class="nav-link">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
          Salir
        </a>
        <a href="<?= BASE_URL ?>" class="nav-link">Presentar FUT</a>
        <a href="<?= BASE_URL ?>consulta" class="nav-link">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          Consultar Estado
        </a>
      <?php endif; ?>
    </nav>
  </div>
</header>
