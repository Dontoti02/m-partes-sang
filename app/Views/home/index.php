<?php
$pageTitle = 'Presentar Trámite';
$pageDesc  = 'Presente su Formulario Único de Trámite (FUT) en línea al ' . APP_INST;
require VIEW_PATH . 'layouts/header.php';
?>

<!-- ── Hero ──────────────────────────────────────────────── -->
<div class="hero">
  <div class="hero-inner">
    <div class="hero-icon">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
        <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
      </svg>
    </div>
    <div>
      <h1 class="hero-title">Mesa de Partes Virtual</h1>
      <p class="hero-sub">Presente su Formulario Único de Trámite de forma rápida y segura desde cualquier lugar.</p>
    </div>
  </div>

  <!-- Pasos -->
  <ol class="steps-bar">
    <li class="step-item">
      <span class="step-num">1</span>
      <span>Descargue el FUT</span>
    </li>
    <li class="step-sep">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
    </li>
    <li class="step-item">
      <span class="step-num">2</span>
      <span>Llene y firme</span>
    </li>
    <li class="step-sep">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
    </li>
    <li class="step-item">
      <span class="step-num">3</span>
      <span>Complete el formulario</span>
    </li>
    <li class="step-sep">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
    </li>
    <li class="step-item">
      <span class="step-num">4</span>
      <span>Adjunte (opcional) y envíe</span>
    </li>
    <li class="step-sep">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
    </li>
    <li class="step-item">
      <span class="step-num">5</span>
      <span>Espere respuesta</span>
    </li>
  </ol>
</div>

<!-- ── Contenido ──────────────────────────────────────────── -->
<main class="main-wrap">

  <?php if ($error): ?>
  <div class="alert alert-error" role="alert">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
    <span><?= htmlspecialchars($error) ?></span>
  </div>
  <?php endif; ?>

  <!-- Descarga FUT -->
  <div class="download-box">
    <div class="dl-left">
      <div class="dl-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
          <polyline points="14 2 14 8 20 8"/>
          <line x1="12" y1="18" x2="12" y2="12"/>
          <polyline points="9 15 12 18 15 15"/>
        </svg>
      </div>
      <div>
        <h2 class="dl-title">Formulario Único de Trámite &mdash; FUT (Opcional)</h2>
        <p class="dl-desc">Descargue el formulario si requiere adjuntarlo formalmente, o envíe directamente su trámite llenando sus datos abajo.</p>
      </div>
    </div>
    <a href="<?= BASE_URL ?>assets/FUT IESTP SANGARARA.docx" download class="btn btn-accent">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/>
        <polyline points="7 10 12 15 17 10"/>
        <line x1="12" y1="15" x2="12" y2="3"/>
      </svg>
      Descargar FUT (.docx)
    </a>
  </div>

  <!-- Consulta rápida de estado -->
  <div class="quick-consulta">
    <div class="qc-left">
      <div class="qc-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="11" cy="11" r="8"/>
          <line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
      </div>
      <div>
        <p class="qc-title">¿Ya tiene un trámite en curso?</p>
        <p class="qc-sub">Consulte el estado ingresando su código de expediente.</p>
      </div>
    </div>
    <form method="GET" action="<?= BASE_URL ?>consulta" class="qc-form">
      <input type="text" name="codigo" class="form-control qc-input"
             placeholder="MP-2026-XXXX"
             maxlength="20" autocomplete="off"
             style="text-transform:uppercase;letter-spacing:.08em;font-family:monospace;">
      <button type="submit" class="btn btn-primary btn-sm">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        Ver estado
      </button>
    </form>
  </div>


  <!-- Formulario -->
  <form method="POST" enctype="multipart/form-data" id="futForm" novalidate>

    <!-- Datos personales -->
    <div class="card">
      <div class="card-header">
        <div class="card-header-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/>
            <circle cx="12" cy="7" r="4"/>
          </svg>
        </div>
        <h2 class="card-title">Datos Personales del Solicitante</h2>
      </div>
      <div class="card-body">
        <div class="form-grid">
          <div class="form-group">
            <label class="form-label" for="nombres">Nombres <span class="required">*</span></label>
            <input type="text" id="nombres" name="nombres" class="form-control"
                   placeholder="Ingrese sus nombres completos"
                   value="<?= htmlspecialchars($old['nombres'] ?? '') ?>"
                   required maxlength="120" autocomplete="given-name">
          </div>
          <div class="form-group">
            <label class="form-label" for="apellidos">Apellidos <span class="required">*</span></label>
            <input type="text" id="apellidos" name="apellidos" class="form-control"
                   placeholder="Ingrese sus apellidos completos"
                   value="<?= htmlspecialchars($old['apellidos'] ?? '') ?>"
                   required maxlength="120" autocomplete="family-name">
          </div>
          <div class="form-group">
            <label class="form-label" for="dni">N.&ordm; DNI <span class="required">*</span></label>
            <input type="text" id="dni" name="dni" class="form-control"
                   placeholder="12345678"
                   value="<?= htmlspecialchars($old['dni'] ?? '') ?>"
                   required maxlength="8" pattern="\d{8}" inputmode="numeric">
          </div>
          <div class="form-group">
            <label class="form-label" for="telefono">Teléfono / Celular</label>
            <input type="tel" id="telefono" name="telefono" class="form-control"
                   placeholder="987 654 321"
                   value="<?= htmlspecialchars($old['telefono'] ?? '') ?>"
                   maxlength="15" autocomplete="tel">
          </div>
          <div class="form-group form-full">
            <label class="form-label" for="email">Correo Electrónico</label>
            <input type="email" id="email" name="email" class="form-control"
                   placeholder="correo@ejemplo.com"
                   value="<?= htmlspecialchars($old['email'] ?? '') ?>"
                   maxlength="120" autocomplete="email">
          </div>
        </div>
      </div>
    </div>

    <!-- Datos del trámite -->
    <div class="card">
      <div class="card-header">
        <div class="card-header-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
            <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
          </svg>
        </div>
        <h2 class="card-title">Datos del Trámite</h2>
      </div>
      <div class="card-body">
        <div class="form-group">
          <label class="form-label" for="asunto">Asunto / Tipo de Trámite <span class="required">*</span></label>
          <input type="text" id="asunto" name="asunto" class="form-control"
                 placeholder="Ej: Solicitud de constancia de estudios, certificado de notas..."
                 value="<?= htmlspecialchars($old['asunto'] ?? '') ?>"
                 required maxlength="255">
        </div>
        <div class="form-group">
          <label class="form-label" for="descripcion">Descripción / Observaciones</label>
          <textarea id="descripcion" name="descripcion" class="form-control"
                    placeholder="Detalle adicional de su solicitud (opcional)..."
                    maxlength="2000"><?= htmlspecialchars($old['descripcion'] ?? '') ?></textarea>
        </div>
      </div>
    </div>

    <!-- Adjuntar FUT -->
    <div class="card">
      <div class="card-header">
        <div class="card-header-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21.44 11.05l-9.19 9.19a6 6 0 01-8.49-8.49l9.19-9.19a4 4 0 015.66 5.66l-9.2 9.19a2 2 0 01-2.83-2.83l8.49-8.48"/>
          </svg>
        </div>
        <h2 class="card-title">Adjuntar FUT u otro documento <span style="font-size:.85rem;font-weight:normal;color:#6b7280;">(Opcional)</span></h2>
      </div>
      <div class="card-body">
        <div class="upload-area" id="uploadArea">
          <input type="file" name="archivo" id="archivo" accept=".pdf,.doc,.docx">
          <div class="upload-inner">
            <div class="upload-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1"/>
                <polyline points="16 12 12 8 8 12"/>
                <line x1="12" y1="8" x2="12" y2="20"/>
              </svg>
            </div>
            <p class="upload-label">Haga clic o arrastre su archivo aquí (opcional)</p>
            <p class="upload-hint">PDF, DOC o DOCX &mdash; máximo 10 MB</p>
            <p class="upload-name" id="uploadName"></p>
          </div>
        </div>
        <div class="alert alert-info" style="margin-top:.9rem;margin-bottom:0;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
          <span>Si cuenta con el FUT u otro archivo de sustento puede adjuntarlo aquí. Si no lo tiene, puede enviar su trámite directamente.</span>
        </div>
      </div>
    </div>

    <!-- Submit -->
    <div class="submit-section">
      <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <line x1="22" y1="2" x2="11" y2="13"/>
          <polygon points="22 2 15 22 11 13 2 9 22 2"/>
        </svg>
        Enviar Expediente a Mesa de Partes
      </button>
      <p class="submit-note">
        Al enviar recibirá un <strong>código de seguimiento</strong> para consultar el estado de su trámite.
      </p>
    </div>

  </form>
</main>

<?php require VIEW_PATH . 'layouts/footer.php'; ?>

<script>
// Nombre del archivo seleccionado
document.getElementById('archivo').addEventListener('change', function () {
  const name = this.files[0]?.name ?? '';
  const el   = document.getElementById('uploadName');
  if (name) { el.textContent = 'Archivo seleccionado: ' + name; el.style.display = 'block'; }
});

// Drag & drop visual
const area = document.getElementById('uploadArea');
['dragover','dragenter'].forEach(e => area.addEventListener(e, ev => { ev.preventDefault(); area.classList.add('drag-over'); }));
['dragleave','dragend'].forEach(e => area.addEventListener(e, () => area.classList.remove('drag-over')));
area.addEventListener('drop', ev => {
  ev.preventDefault();
  area.classList.remove('drag-over');
  const input = document.getElementById('archivo');
  if (ev.dataTransfer.files[0]) {
    // Crear DataTransfer para asignar al input
    const dt = new DataTransfer();
    dt.items.add(ev.dataTransfer.files[0]);
    input.files = dt.files;
    document.getElementById('uploadName').textContent = 'Archivo seleccionado: ' + ev.dataTransfer.files[0].name;
    document.getElementById('uploadName').style.display = 'block';
  }
});

// Prevenir doble envío
document.getElementById('futForm').addEventListener('submit', function () {
  const btn = document.getElementById('submitBtn');
  btn.disabled  = true;
  btn.innerHTML = '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10" opacity=".25"/><path d="M12 2a10 10 0 0110 10" stroke-linecap="round"/></svg> Enviando...';
  btn.style.opacity = '.7';
});
</script>
