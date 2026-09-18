<?php
$pageTitle = 'FUT Virtual';
$pageDesc  = 'Formulario Único de Trámite (FUT) Virtual 100% en línea del ' . APP_INST;
require VIEW_PATH . 'layouts/header.php';
?>

<!-- ── Hero Institucional ─────────────────────────────────── -->
<div class="hero">
  <div class="hero-inner">
    <div class="hero-icon">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
        <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
        <polyline points="14 2 14 8 20 8"/>
        <line x1="16" y1="13" x2="8" y2="13"/>
        <line x1="16" y1="17" x2="8" y2="17"/>
        <polyline points="10 9 9 9 8 9"/>
      </svg>
    </div>
    <div>
      <div style="font-size:0.85rem;text-transform:uppercase;letter-spacing:1px;font-weight:600;opacity:0.9;margin-bottom:0.25rem;">
        R.M. N.º 821-88-ED &bull; Trámite 100% Digital
      </div>
      <h1 class="hero-title">Formulario Único de Trámite (FUT) Virtual</h1>
      <p class="hero-sub">Llene su formulario directamente en línea sin necesidad de imprimir ni descargar documentos Word.</p>
    </div>
  </div>

  <!-- Pasos -->
  <ol class="steps-bar">
    <li class="step-item">
      <span class="step-num">1</span>
      <span>Indique su trámite</span>
    </li>
    <li class="step-sep">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
    </li>
    <li class="step-item">
      <span class="step-num">2</span>
      <span>Llene sus datos</span>
    </li>
    <li class="step-sep">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
    </li>
    <li class="step-item">
      <span class="step-num">3</span>
      <span>Fundamente su pedido</span>
    </li>
    <li class="step-sep">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
    </li>
    <li class="step-item">
      <span class="step-num">4</span>
      <span>Sustento (Opcional)</span>
    </li>
    <li class="step-sep">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
    </li>
    <li class="step-item">
      <span class="step-num">5</span>
      <span>Envío y constancia</span>
    </li>
  </ol>
</div>

<!-- ── Contenido Principal ─────────────────────────────────── -->
<main class="main-wrap">

  <?php if ($error): ?>
  <div class="alert alert-error" role="alert">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
    <span><?= htmlspecialchars($error) ?></span>
  </div>
  <?php endif; ?>

  <!-- Consulta rápida de estado -->
  <div class="quick-consulta" style="margin-bottom:1.5rem;">
    <div class="qc-left">
      <div class="qc-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="11" cy="11" r="8"/>
          <line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
      </div>
      <div>
        <p class="qc-title">¿Ya presentó un trámite anteriormente?</p>
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

  <!-- Formulario FUT Virtual -->
  <form method="POST" enctype="multipart/form-data" id="futForm" novalidate>

    <!-- Encabezado Institucional del FUT -->
    <div style="background:#14532d;color:#ffffff;padding:1rem 1.5rem;border-radius:10px 10px 0 0;display:flex;align-items:center;gap:1rem;margin-bottom:-1px;">
      <div style="background:rgba(255,255,255,0.15);padding:0.6rem;border-radius:8px;">
        <svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
        </svg>
      </div>
      <div>
        <div style="font-size:0.75rem;text-transform:uppercase;letter-spacing:1px;opacity:0.85;">Dirigido a:</div>
        <div style="font-size:1.05rem;font-weight:700;">SEÑOR DIRECTOR DEL IESTP SANGARARÁ – ACOMAYO</div>
      </div>
    </div>

    <!-- 1. Petitorio -->
    <div class="card" style="border-top-left-radius:0;border-top-right-radius:0;">
      <div class="card-header">
        <div class="card-header-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
            <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
          </svg>
        </div>
        <h2 class="card-title">1. Petitorio (¿Qué solicita?)</h2>
      </div>
      <div class="card-body">
        <div class="form-group">
          <label class="form-label" for="asunto">SOLICITA: <span class="required">*</span></label>
          <input type="text" id="asunto" name="asunto" class="form-control"
                 placeholder="Ej: Solicitud de Certificado de Estudios, Constancia de Egresado, Rectificación de Matrícula, etc."
                 value="<?= htmlspecialchars($old['asunto'] ?? '') ?>"
                 required maxlength="255">
          <span style="font-size:0.8rem;color:#6b7280;margin-top:0.25rem;display:block;">
            Indique de manera clara y puntual el trámite que requiere ante la institución.
          </span>
        </div>
      </div>
    </div>

    <!-- 2. Datos del Solicitante -->
    <div class="card">
      <div class="card-header">
        <div class="card-header-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/>
            <circle cx="12" cy="7" r="4"/>
          </svg>
        </div>
        <h2 class="card-title">2. Datos del Usuario / Solicitante</h2>
      </div>
      <div class="card-body">
        <div class="form-grid">
          
          <div class="form-group">
            <label class="form-label" for="apellidos">Apellidos Completos <span class="required">*</span></label>
            <input type="text" id="apellidos" name="apellidos" class="form-control"
                   placeholder="Ej: Pérez Quispe"
                   value="<?= htmlspecialchars($old['apellidos'] ?? '') ?>"
                   required maxlength="120" autocomplete="family-name">
          </div>

          <div class="form-group">
            <label class="form-label" for="nombres">Nombres Completos <span class="required">*</span></label>
            <input type="text" id="nombres" name="nombres" class="form-control"
                   placeholder="Ej: Juan Carlos"
                   value="<?= htmlspecialchars($old['nombres'] ?? '') ?>"
                   required maxlength="120" autocomplete="given-name">
          </div>

          <div class="form-group">
            <label class="form-label" for="dni">N.&ordm; DNI <span class="required">*</span></label>
            <input type="text" id="dni" name="dni" class="form-control"
                   placeholder="12345678"
                   value="<?= htmlspecialchars($old['dni'] ?? '') ?>"
                   required maxlength="8" pattern="\d{8}" inputmode="numeric">
          </div>

          <div class="form-group">
            <label class="form-label" for="cargo">Condición / Cargo</label>
            <select id="cargo" name="cargo" class="form-control">
              <option value="Estudiante" <?= ($old['cargo'] ?? '') === 'Estudiante' ? 'selected' : '' ?>>Estudiante</option>
              <option value="Egresado" <?= ($old['cargo'] ?? '') === 'Egresado' ? 'selected' : '' ?>>Egresado</option>
              <option value="Docente" <?= ($old['cargo'] ?? '') === 'Docente' ? 'selected' : '' ?>>Docente</option>
              <option value="Personal Administrativo" <?= ($old['cargo'] ?? '') === 'Personal Administrativo' ? 'selected' : '' ?>>Personal Administrativo</option>
              <option value="Público en General" <?= ($old['cargo'] ?? '') === 'Público en General' ? 'selected' : '' ?>>Público en General / Otro</option>
            </select>
          </div>

          <div class="form-group">
            <label class="form-label" for="codigo_modular">Código Modular / Estudiante</label>
            <input type="text" id="codigo_modular" name="codigo_modular" class="form-control"
                   placeholder="Ej: 10245896 (opcional)"
                   value="<?= htmlspecialchars($old['codigo_modular'] ?? '') ?>"
                   maxlength="50">
          </div>

          <div class="form-group">
            <label class="form-label" for="telefono">Teléfono / Celular <span class="required">*</span></label>
            <input type="tel" id="telefono" name="telefono" class="form-control"
                   placeholder="987 654 321"
                   value="<?= htmlspecialchars($old['telefono'] ?? '') ?>"
                   required maxlength="15" autocomplete="tel">
          </div>

          <div class="form-group form-full">
            <label class="form-label" for="direccion">Domicilio / Dirección Actual</label>
            <input type="text" id="direccion" name="direccion" class="form-control"
                   placeholder="Comunidad, Calle, Av. o Jr. y N.°"
                   value="<?= htmlspecialchars($old['direccion'] ?? '') ?>"
                   maxlength="255">
          </div>

          <div class="form-group">
            <label class="form-label" for="distrito">Distrito</label>
            <input type="text" id="distrito" name="distrito" class="form-control"
                   placeholder="Ej: Sangarará"
                   value="<?= htmlspecialchars($old['distrito'] ?? '') ?>"
                   maxlength="100">
          </div>

          <div class="form-group">
            <label class="form-label" for="provincia">Provincia</label>
            <input type="text" id="provincia" name="provincia" class="form-control"
                   placeholder="Ej: Acomayo"
                   value="<?= htmlspecialchars($old['provincia'] ?? '') ?>"
                   maxlength="100">
          </div>

          <div class="form-group">
            <label class="form-label" for="region">Región / Departamento</label>
            <input type="text" id="region" name="region" class="form-control"
                   placeholder="Ej: Cusco"
                   value="<?= htmlspecialchars($old['region'] ?? '') ?>"
                   maxlength="100">
          </div>

          <div class="form-group form-full">
            <label class="form-label" for="email">Correo Electrónico <span class="required">*</span></label>
            <input type="email" id="email" name="email" class="form-control"
                   placeholder="correo@ejemplo.com"
                   value="<?= htmlspecialchars($old['email'] ?? '') ?>"
                   required maxlength="120" autocomplete="email">
            <span style="font-size:0.8rem;color:#166534;margin-top:0.25rem;display:block;">
              A este correo se le enviará su constancia oficial con su código de expediente.
            </span>
          </div>

        </div>
      </div>
    </div>

    <!-- 3. Fundamento de lo Solicitado -->
    <div class="card">
      <div class="card-header">
        <div class="card-header-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
            <polyline points="14 2 14 8 20 8"/>
            <line x1="16" y1="13" x2="8" y2="13"/>
            <line x1="16" y1="17" x2="8" y2="17"/>
            <polyline points="10 9 9 9 8 9"/>
          </svg>
        </div>
        <h2 class="card-title">3. Fundamento de lo Solicitado <span class="required">*</span></h2>
      </div>
      <div class="card-body">
        <div class="form-group">
          <label class="form-label" for="fundamento">Exposición de Motivos: <span class="required">*</span></label>
          <textarea id="fundamento" name="fundamento" class="form-control" rows="5"
                    placeholder="Explique detalladamente las razones, hechos y fundamentos que justifican su solicitud..."
                    required maxlength="3000"><?= htmlspecialchars($old['fundamento'] ?? '') ?></textarea>
        </div>
      </div>
    </div>

    <!-- 4. Documentos que Adjunta / Sustento (Opcional) -->
    <div class="card">
      <div class="card-header">
        <div class="card-header-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21.44 11.05l-9.19 9.19a6 6 0 01-8.49-8.49l9.19-9.19a4 4 0 015.66 5.66l-9.2 9.19a2 2 0 01-2.83-2.83l8.49-8.48"/>
          </svg>
        </div>
        <h2 class="card-title">4. Documentos que Adjunta (Sustento &mdash; Opcional)</h2>
      </div>
      <div class="card-body">
        
        <div class="form-group">
          <label class="form-label" for="documentos_sustento">Detalle de Documentos que Anexa (Opcional):</label>
          <textarea id="documentos_sustento" name="documentos_sustento" class="form-control" rows="2"
                    placeholder="Ej: 1. Copia de DNI, 2. Comprobante de pago, 3. Certificado anterior... (opcional)"
                    maxlength="1000"><?= htmlspecialchars($old['documentos_sustento'] ?? '') ?></textarea>
        </div>

        <div class="form-group" style="margin-top:1.25rem;">
          <label class="form-label">Subir Archivo Digital de Respaldo / Sustento (Opcional):</label>
          <div class="upload-area" id="uploadArea">
            <input type="file" name="archivo" id="archivo" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
            <div class="upload-inner">
              <div class="upload-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1"/>
                  <polyline points="16 12 12 8 8 12"/>
                  <line x1="12" y1="8" x2="12" y2="20"/>
                </svg>
              </div>
              <p class="upload-label">Haga clic o arrastre su archivo de sustento aquí (opcional)</p>
              <p class="upload-hint">PDF, DOC, DOCX o imágenes JPG/PNG &mdash; máximo 10 MB</p>
              <p class="upload-name" id="uploadName"></p>
            </div>
          </div>
        </div>

        <div class="alert alert-info" style="margin-top:1rem;margin-bottom:0;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
          <span>Si su trámite no requiere archivos de respaldo, puede dejar este campo vacío y enviar el formulario directamente.</span>
        </div>

      </div>
    </div>

    <!-- 5. Declaración Jurada y Firma Virtual -->
    <div class="card" style="background:#f0fdf4;border-color:#bbf7d0;">
      <div class="card-body" style="padding:1.5rem;">
        <label style="display:flex;align-items:flex-start;gap:0.75rem;cursor:pointer;font-size:0.95rem;color:#166534;line-height:1.5;">
          <input type="checkbox" id="declaracion_jurada" required style="margin-top:0.25rem;width:18px;height:18px;accent-color:#14532d;">
          <span>
            <strong>Declaración Jurada y Firma Virtual:</strong> Declaro bajo juramento que los datos consignados en este Formulario Único de Trámite (FUT) Virtual son verídicos y fidedignos, asumiendo la responsabilidad legal correspondiente.
          </span>
        </label>
      </div>
    </div>

    <!-- Envío -->
    <div class="submit-section">
      <button type="submit" class="btn btn-primary btn-lg" id="submitBtn" style="background:#14532d;font-size:1.05rem;padding:1rem 2rem;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <line x1="22" y1="2" x2="11" y2="13"/>
          <polygon points="22 2 15 22 11 13 2 9 22 2"/>
        </svg>
        Enviar Formulario Único de Trámite (FUT) Virtual
      </button>
      <p class="submit-note">
        Al presionar Enviar, su trámite se despacha de inmediato a la institución y recibirá su <strong>código de expediente</strong> en pantalla y en su correo.
      </p>
    </div>

  </form>
</main>

<?php require VIEW_PATH . 'layouts/footer.php'; ?>

<script>
// Archivo seleccionado
document.getElementById('archivo').addEventListener('change', function () {
  const name = this.files[0]?.name ?? '';
  const el   = document.getElementById('uploadName');
  if (name) {
    el.textContent = 'Archivo seleccionado: ' + name;
    el.style.display = 'block';
  }
});

// Drag & drop
const area = document.getElementById('uploadArea');
if (area) {
  ['dragover','dragenter'].forEach(e => area.addEventListener(e, ev => { ev.preventDefault(); area.classList.add('drag-over'); }));
  ['dragleave','dragend'].forEach(e => area.addEventListener(e, () => area.classList.remove('drag-over')));
  area.addEventListener('drop', ev => {
    ev.preventDefault();
    area.classList.remove('drag-over');
    const input = document.getElementById('archivo');
    if (ev.dataTransfer.files[0]) {
      const dt = new DataTransfer();
      dt.items.add(ev.dataTransfer.files[0]);
      input.files = dt.files;
      document.getElementById('uploadName').textContent = 'Archivo seleccionado: ' + ev.dataTransfer.files[0].name;
      document.getElementById('uploadName').style.display = 'block';
    }
  });
}

// Prevenir doble envío
document.getElementById('futForm').addEventListener('submit', function (e) {
  const check = document.getElementById('declaracion_jurada');
  if (check && !check.checked) {
    e.preventDefault();
    alert('Por favor acepte la Declaración Jurada para poder firmar y enviar su FUT virtual.');
    check.focus();
    return false;
  }

  const btn = document.getElementById('submitBtn');
  btn.disabled  = true;
  btn.innerHTML = '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10" opacity=".25"/><path d="M12 2a10 10 0 0110 10" stroke-linecap="round"/></svg> Enviando FUT Virtual...';
  btn.style.opacity = '.7';
});
</script>
