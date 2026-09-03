<?php
$pageTitle = 'Expediente Enviado';
require VIEW_PATH . 'layouts/header.php';
?>

<main class="main-wrap">
  <div class="success-wrap">

    <div class="success-icon-wrap">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
        <path d="M22 11.08V12a10 10 0 11-5.93-9.14"/>
        <polyline points="22 4 12 14.01 9 11.01"/>
      </svg>
    </div>

    <h1 class="success-title">Expediente Enviado Exitosamente</h1>
    <p class="success-sub">Su trámite ha sido recibido por Mesa de Partes. Conserve su código de seguimiento:</p>

    <div class="codigo-card">
      <p class="codigo-label">Código de Expediente</p>
      <p class="codigo-val"><?= htmlspecialchars($codigo) ?></p>
    </div>

    <div class="card" style="margin-bottom:1.5rem;">
      <div class="card-body">
        <ul class="info-checklist">
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Anote o fotografíe su código para consultar el estado de su trámite.</span>
          </li>
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>El plazo de atención es de <strong>3 a 5 días hábiles</strong>.</span>
          </li>
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Si proporcionó su correo, será notificado al resolverse su trámite.</span>
          </li>
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Para consultas, acuda a Mesa de Partes portando su código.</span>
          </li>
        </ul>
      </div>
    </div>

    <a href="<?= BASE_URL ?>" class="btn btn-primary">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
      Realizar otro trámite
    </a>

  </div>
</main>

<?php require VIEW_PATH . 'layouts/footer.php'; ?>
