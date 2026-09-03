<?php
$pageTitle = 'Consultar Estado de Trámite';
require VIEW_PATH . 'layouts/header.php';

$estadoLabel = ['pendiente' => 'Pendiente', 'aprobado' => 'Aprobado', 'rechazado' => 'Rechazado'];
$estadoDesc  = [
    'pendiente' => 'Su expediente fue recibido y está siendo revisado por el área administrativa.',
    'aprobado'  => 'Su expediente fue evaluado y el administrador otorgó el visto bueno.',
    'rechazado' => 'Su expediente fue evaluado y no procede según el siguiente motivo.',
];
?>

<main class="main-wrap">

  <!-- Widget de búsqueda -->
  <div class="consulta-hero">
    <div class="consulta-icon">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="11" cy="11" r="8"/>
        <line x1="21" y1="21" x2="16.65" y2="16.65"/>
      </svg>
    </div>
    <h1 class="consulta-title">Consultar Estado de Expediente</h1>
    <p class="consulta-sub">Ingrese su código de expediente para conocer el estado de su trámite.</p>

    <form method="GET" action="<?= BASE_URL ?>consulta" class="consulta-form" id="consultaForm">
      <div class="consulta-input-wrap">
        <span class="consulta-prefix">Código</span>
        <input
          type="text"
          name="codigo"
          id="codigo"
          class="consulta-input"
          placeholder="Ej: MP-2026-0042"
          value="<?= htmlspecialchars($codigo) ?>"
          autocomplete="off"
          maxlength="20"
          autofocus
        >
        <button type="submit" class="btn btn-primary">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          Consultar
        </button>
      </div>
      <p class="consulta-hint">El código tiene el formato <strong>MP-YYYY-NNNN</strong> y fue entregado al enviar su trámite.</p>
    </form>
  </div>

  <!-- Error: no encontrado -->
  <?php if ($error): ?>
  <div class="alert alert-error" role="alert">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
    <span><?= $error /* ya sanitizado en controller */ ?></span>
  </div>
  <?php endif; ?>

  <!-- Resultado -->
  <?php if ($expediente): ?>

  <!-- Tarjeta de estado principal -->
  <div class="estado-card estado-<?= $expediente['estado'] ?>">
    <div class="estado-left">
      <div class="estado-badge-icon">
        <?php if ($expediente['estado'] === 'aprobado'): ?>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        <?php elseif ($expediente['estado'] === 'rechazado'): ?>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
        <?php else: ?>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        <?php endif; ?>
      </div>
      <div>
        <p class="estado-codigo-label">Código de Expediente</p>
        <p class="estado-codigo"><?= htmlspecialchars($expediente['codigo']) ?></p>
      </div>
    </div>
    <div class="estado-right">
      <span class="badge badge-<?= $expediente['estado'] ?> badge-lg"><?= $estadoLabel[$expediente['estado']] ?></span>
    </div>
  </div>

  <!-- Descripción del estado -->
  <div class="alert alert-<?= $expediente['estado'] === 'aprobado' ? 'success' : ($expediente['estado'] === 'rechazado' ? 'error' : 'warning') ?>">
    <?php if ($expediente['estado'] === 'aprobado'): ?>
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
    <?php elseif ($expediente['estado'] === 'rechazado'): ?>
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
    <?php else: ?>
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
    <?php endif; ?>
    <span><?= $estadoDesc[$expediente['estado']] ?></span>
  </div>

  <!-- Detalle del expediente -->
  <div class="card">
    <div class="card-header">
      <div class="card-header-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
      </div>
      <h2 class="card-title">Detalle del Trámite</h2>
    </div>
    <div class="card-body">
      <div class="detail-grid">
        <div class="detail-item">
          <span class="detail-key">Solicitante</span>
          <span class="detail-val"><?= htmlspecialchars($expediente['apellidos'] . ', ' . $expediente['nombres']) ?></span>
        </div>
        <div class="detail-item">
          <span class="detail-key">DNI</span>
          <span class="detail-val td-mono"><?= htmlspecialchars($expediente['dni']) ?></span>
        </div>
        <div class="detail-item detail-full">
          <span class="detail-key">Asunto / Trámite</span>
          <span class="detail-val"><?= htmlspecialchars($expediente['asunto']) ?></span>
        </div>
        <div class="detail-item">
          <span class="detail-key">Fecha de presentación</span>
          <span class="detail-val"><?= date('d/m/Y H:i', strtotime($expediente['created_at'])) ?></span>
        </div>
        <div class="detail-item">
          <span class="detail-key">Última actualización</span>
          <span class="detail-val"><?= $expediente['updated_at'] ? date('d/m/Y H:i', strtotime($expediente['updated_at'])) : '—' ?></span>
        </div>
      </div>

      <!-- Comentario del admin (solo si fue procesado) -->
      <?php if ($expediente['comentario'] && $expediente['estado'] !== 'pendiente'): ?>
      <div class="divider"></div>
      <p class="section-label">
        <?= $expediente['estado'] === 'aprobado' ? 'Visto Bueno — Comentario del Administrador' : 'Motivo del Rechazo' ?>
      </p>
      <div class="comentario-box comentario-<?= $expediente['estado'] ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
          <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/>
        </svg>
        <p><?= htmlspecialchars($expediente['comentario']) ?></p>
      </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- Timeline -->
  <div class="card">
    <div class="card-header">
      <div class="card-header-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
      </div>
      <h2 class="card-title">Seguimiento del Expediente</h2>
    </div>
    <div class="card-body">
      <ul class="timeline">
        <li class="tl-item">
          <div class="tl-dot tl-blue">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
          </div>
          <div class="tl-body">
            <span class="tl-date"><?= date('d/m/Y H:i', strtotime($expediente['created_at'])) ?></span>
            <p class="tl-text"><strong>Expediente presentado</strong> &mdash; Recibido en Mesa de Partes y registrado en el sistema.</p>
          </div>
        </li>

        <?php if ($expediente['estado'] === 'pendiente'): ?>
        <li class="tl-item">
          <div class="tl-dot tl-amber">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
          </div>
          <div class="tl-body">
            <span class="tl-date">En progreso</span>
            <p class="tl-text"><strong>En revisión</strong> &mdash; El área administrativa está evaluando su solicitud. El plazo es de 3 a 5 días hábiles.</p>
          </div>
        </li>

        <?php elseif ($expediente['estado'] === 'aprobado'): ?>
        <li class="tl-item">
          <div class="tl-dot tl-green">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
          </div>
          <div class="tl-body">
            <span class="tl-date"><?= date('d/m/Y H:i', strtotime($expediente['updated_at'])) ?></span>
            <p class="tl-text"><strong>Visto bueno otorgado</strong> &mdash; Su trámite fue aprobado satisfactoriamente.</p>
          </div>
        </li>

        <?php elseif ($expediente['estado'] === 'rechazado'): ?>
        <li class="tl-item">
          <div class="tl-dot tl-red">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
          </div>
          <div class="tl-body">
            <span class="tl-date"><?= date('d/m/Y H:i', strtotime($expediente['updated_at'])) ?></span>
            <p class="tl-text"><strong>Expediente rechazado</strong> &mdash; Revise el motivo indicado y comuníquese con Mesa de Partes.</p>
          </div>
        </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>

  <div style="text-align:center;margin-bottom:2rem;">
    <a href="<?= BASE_URL ?>" class="btn btn-outline" style="margin-right:.6rem;">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
      Ir al inicio
    </a>
    <a href="<?= BASE_URL ?>consulta" class="btn btn-ghost">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
      Nueva consulta
    </a>
  </div>

  <?php endif; ?>

  <!-- Estado vacío: sin búsqueda aún -->
  <?php if (!$expediente && !$error && $codigo === ''): ?>
  <div class="card" style="margin-bottom:2rem;">
    <div class="card-body">
      <div class="empty-state" style="padding:2rem;">
        <div class="empty-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.3"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
        </div>
        <h3>Ingrese su código</h3>
        <p>Escriba el código de expediente que recibió al presentar su trámite y haga clic en <strong>Consultar</strong>.</p>
      </div>
    </div>
  </div>
  <?php endif; ?>

</main>

<?php require VIEW_PATH . 'layouts/footer.php'; ?>

<script>
// Formatear automáticamente en mayúsculas y guiones
document.getElementById('codigo').addEventListener('input', function () {
  const pos = this.selectionStart;
  this.value = this.value.toUpperCase().replace(/[^A-Z0-9\-]/g, '');
  this.setSelectionRange(pos, pos);
});
</script>
