<?php
$pageTitle = 'Expediente ' . htmlspecialchars($expediente['codigo']);
require VIEW_PATH . 'layouts/header.php';

$estadoLabel = ['pendiente'=>'Pendiente','aprobado'=>'Aprobado','rechazado'=>'Rechazado'];
?>

<main class="main-wrap">

  <!-- Breadcrumb -->
  <nav class="breadcrumb" aria-label="Ruta">
    <a href="<?= BASE_URL ?>admin">Expedientes</a>
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
    <span><?= htmlspecialchars($expediente['codigo']) ?></span>
  </nav>

  <?php if ($msg): ?>
  <div class="alert <?= stripos($msg,'visto') !== false ? 'alert-success' : 'alert-error' ?>" role="alert">
    <?php if (stripos($msg,'visto') !== false): ?>
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
    <?php else: ?>
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
    <?php endif; ?>
    <span><?= htmlspecialchars($msg) ?></span>
  </div>
  <?php endif; ?>

  <?php if ($error): ?>
  <div class="alert alert-error" role="alert">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
    <span><?= htmlspecialchars($error) ?></span>
  </div>
  <?php endif; ?>

  <!-- Cabecera del expediente -->
  <div class="card">
    <div class="card-header" style="justify-content:space-between;flex-wrap:wrap;gap:.5rem;">
      <div style="display:flex;align-items:center;gap:.7rem;">
        <div class="card-header-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/></svg>
        </div>
        <h2 class="card-title">Expediente <code><?= htmlspecialchars($expediente['codigo']) ?></code></h2>
      </div>
      <span class="badge badge-<?= $expediente['estado'] ?> badge-lg"><?= $estadoLabel[$expediente['estado']] ?></span>
    </div>

    <div class="card-body">

      <!-- Datos personales -->
      <p class="section-label">Datos del Solicitante</p>
      <div class="detail-grid">
        <div class="detail-item">
          <span class="detail-key">Nombres</span>
          <span class="detail-val"><?= htmlspecialchars($expediente['nombres']) ?></span>
        </div>
        <div class="detail-item">
          <span class="detail-key">Apellidos</span>
          <span class="detail-val"><?= htmlspecialchars($expediente['apellidos']) ?></span>
        </div>
        <div class="detail-item">
          <span class="detail-key">DNI</span>
          <span class="detail-val td-mono"><?= htmlspecialchars($expediente['dni']) ?></span>
        </div>
        <div class="detail-item">
          <span class="detail-key">Teléfono</span>
          <span class="detail-val"><?= htmlspecialchars($expediente['telefono'] ?: '—') ?></span>
        </div>
        <div class="detail-item">
          <span class="detail-key">Correo electrónico</span>
          <span class="detail-val">
            <?= $expediente['email']
                ? '<a href="mailto:' . htmlspecialchars($expediente['email']) . '">' . htmlspecialchars($expediente['email']) . '</a>'
                : '—' ?>
          </span>
        </div>
        <div class="detail-item">
          <span class="detail-key">Fecha de recepción</span>
          <span class="detail-val"><?= date('d/m/Y H:i:s', strtotime($expediente['created_at'])) ?></span>
        </div>
      </div>

      <div class="divider"></div>

      <!-- Datos trámite -->
      <p class="section-label">Datos del Trámite</p>
      <div class="detail-grid">
        <div class="detail-item detail-full">
          <span class="detail-key">Asunto</span>
          <span class="detail-val"><?= htmlspecialchars($expediente['asunto']) ?></span>
        </div>
        <?php if ($expediente['descripcion']): ?>
        <div class="detail-item detail-full">
          <span class="detail-key">Descripción</span>
          <span class="detail-val" style="white-space:pre-wrap;"><?= htmlspecialchars($expediente['descripcion']) ?></span>
        </div>
        <?php endif; ?>
      </div>

      <div class="divider"></div>

      <!-- Documento adjunto -->
      <p class="section-label">Documento FUT Adjunto</p>
      <a href="<?= BASE_URL ?>uploads/<?= rawurlencode($expediente['archivo']) ?>" target="_blank" class="btn btn-outline" style="margin-bottom:.5rem;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
          <polyline points="14 2 14 8 20 8"/>
          <line x1="12" y1="18" x2="12" y2="12"/>
          <polyline points="9 15 12 18 15 15"/>
        </svg>
        Ver / Descargar FUT adjunto
      </a>
      <p class="file-meta">Archivo: <code><?= htmlspecialchars($expediente['archivo']) ?></code></p>

      <div class="divider"></div>

      <!-- Timeline -->
      <p class="section-label">Historial del Expediente</p>
      <ul class="timeline">
        <li class="tl-item">
          <div class="tl-dot tl-blue">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
          </div>
          <div class="tl-body">
            <span class="tl-date"><?= date('d/m/Y H:i', strtotime($expediente['created_at'])) ?></span>
            <p class="tl-text">Expediente recibido en Mesa de Partes.</p>
          </div>
        </li>

        <?php if ($expediente['estado'] === 'pendiente'): ?>
        <li class="tl-item">
          <div class="tl-dot tl-amber">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
          </div>
          <div class="tl-body">
            <span class="tl-date">Ahora</span>
            <p class="tl-text">En espera de revisión administrativa.</p>
          </div>
        </li>

        <?php elseif ($expediente['estado'] === 'aprobado'): ?>
        <li class="tl-item">
          <div class="tl-dot tl-green">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
          </div>
          <div class="tl-body">
            <span class="tl-date"><?= $expediente['updated_at'] ? date('d/m/Y H:i', strtotime($expediente['updated_at'])) : '' ?></span>
            <p class="tl-text">Visto bueno otorgado.</p>
          </div>
        </li>

        <?php elseif ($expediente['estado'] === 'rechazado'): ?>
        <li class="tl-item">
          <div class="tl-dot tl-red">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
          </div>
          <div class="tl-body">
            <span class="tl-date"><?= $expediente['updated_at'] ? date('d/m/Y H:i', strtotime($expediente['updated_at'])) : '' ?></span>
            <p class="tl-text">Expediente rechazado.</p>
          </div>
        </li>
        <?php endif; ?>
      </ul>

    </div>
  </div>

  <!-- Banner resultado si ya fue procesado -->
  <?php if ($expediente['estado'] === 'aprobado' && $expediente['comentario']): ?>
  <div class="result-banner result-green">
    <div class="rb-icon">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
    </div>
    <div>
      <strong>Visto Bueno &mdash; Comentario del Administrador</strong>
      <p><?= htmlspecialchars($expediente['comentario']) ?></p>
    </div>
  </div>
  <?php elseif ($expediente['estado'] === 'rechazado' && $expediente['comentario']): ?>
  <div class="result-banner result-red">
    <div class="rb-icon">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
    </div>
    <div>
      <strong>Expediente Rechazado &mdash; Motivo</strong>
      <p><?= htmlspecialchars($expediente['comentario']) ?></p>
    </div>
  </div>
  <?php endif; ?>

  <!-- Panel de acción -->
  <div class="card">
    <div class="card-header">
      <div class="card-header-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
      </div>
      <h2 class="card-title">Resolución Administrativa</h2>
    </div>
    <div class="card-body">

      <form method="POST" id="resolucionForm">
        <div class="form-group">
          <label class="form-label" for="comentario">
            Comentario / Visto Bueno
            <span style="font-weight:400;color:var(--gray-500);text-transform:none;letter-spacing:0;">
              (obligatorio para rechazar)
            </span>
          </label>
          <textarea id="comentario" name="comentario" class="form-control" rows="4"
                    placeholder="Ingrese el visto bueno, observaciones o motivo de rechazo..."><?= htmlspecialchars($expediente['comentario'] ?? '') ?></textarea>
        </div>

        <div class="action-buttons">
          <button type="submit" name="accion" value="aprobado" class="btn btn-success"
                  onclick="return confirm('Confirma otorgar el VISTO BUENO a este expediente?')">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            Otorgar Visto Bueno
          </button>
          <button type="submit" name="accion" value="rechazado" class="btn btn-danger"
                  onclick="return confirm('Confirma RECHAZAR este expediente?')">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            Rechazar Expediente
          </button>
          <a href="<?= BASE_URL ?>admin" class="btn btn-ghost">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
            Volver
          </a>
        </div>

        <?php if ($expediente['estado'] !== 'pendiente'): ?>
        <div class="alert alert-info" style="margin-top:1rem;margin-bottom:0;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
          <span>Este expediente ya fue procesado. Puede actualizar la decisión si es necesario.</span>
        </div>
        <?php endif; ?>
      </form>

    </div>
  </div>

</main>

<?php require VIEW_PATH . 'layouts/footer.php'; ?>
