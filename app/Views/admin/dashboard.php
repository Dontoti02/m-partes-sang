<?php
$pageTitle = 'Panel de Expedientes';
require VIEW_PATH . 'layouts/header.php';

$estadoLabel = [
    'pendiente' => 'Pendiente',
    'aprobado'  => 'Aprobado',
    'rechazado' => 'Rechazado',
];
?>

<main class="main-wrap wide">

  <div class="page-topbar">
    <div>
      <h1 class="page-title">Expedientes Recibidos</h1>
      <p class="page-sub">Bienvenido, <strong><?= htmlspecialchars($_SESSION['admin_nombre']) ?></strong>
        &mdash; <?= date('d/m/Y H:i') ?></p>
    </div>
  </div>

  <!-- Flash messages -->
  <?php if (!empty($_SESSION['flash_ok'])): ?>
  <div class="alert alert-success" role="alert" style="margin-bottom:1rem;">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
    <span><?= htmlspecialchars($_SESSION['flash_ok']) ?></span>
  </div>
  <?php unset($_SESSION['flash_ok']); endif; ?>
  <?php if (!empty($_SESSION['flash_err'])): ?>
  <div class="alert alert-error" role="alert" style="margin-bottom:1rem;">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
    <span><?= htmlspecialchars($_SESSION['flash_err']) ?></span>
  </div>
  <?php unset($_SESSION['flash_err']); endif; ?>

  <!-- Estadísticas -->
  <div class="stats-grid">
    <div class="stat-card">
      <div class="stat-icon stat-icon-blue">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/></svg>
      </div>
      <div>
        <div class="stat-val"><?= $stats['total'] ?></div>
        <div class="stat-lbl">Total</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-icon stat-icon-amber">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
      </div>
      <div>
        <div class="stat-val stat-amber"><?= $stats['pendiente'] ?></div>
        <div class="stat-lbl">Pendientes</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-icon stat-icon-green">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
      </div>
      <div>
        <div class="stat-val stat-green"><?= $stats['aprobado'] ?></div>
        <div class="stat-lbl">Aprobados</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-icon stat-icon-red">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
      </div>
      <div>
        <div class="stat-val stat-red"><?= $stats['rechazado'] ?></div>
        <div class="stat-lbl">Rechazados</div>
      </div>
    </div>
  </div>

  <!-- Filtros y búsqueda -->
  <div class="card">
    <div class="card-body" style="padding:1rem 1.4rem;">
      <div class="toolbar">
        <form method="GET" class="search-form">
          <input type="hidden" name="filtro" value="<?= htmlspecialchars($filtro) ?>">
          <div class="search-input-wrap">
            <span class="search-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            </span>
            <input type="text" name="q" class="form-control search-input"
                   placeholder="Buscar por código, nombre o DNI..."
                   value="<?= htmlspecialchars($busqueda) ?>">
          </div>
          <button type="submit" class="btn btn-primary btn-sm">Buscar</button>
          <?php if ($busqueda): ?>
          <a href="<?= BASE_URL ?>admin?filtro=<?= urlencode($filtro) ?>" class="btn btn-ghost btn-sm">Limpiar</a>
          <?php endif; ?>
        </form>

        <div class="filter-pills">
          <?php
          $filters = [
            ''          => 'Todos',
            'pendiente' => 'Pendientes',
            'aprobado'  => 'Aprobados',
            'rechazado' => 'Rechazados',
          ];
          foreach ($filters as $val => $label):
            $active = $filtro === $val ? 'active' : '';
            $q      = $busqueda ? '&q=' . urlencode($busqueda) : '';
          ?>
          <a href="<?= BASE_URL ?>admin?filtro=<?= urlencode($val) . $q ?>"
             class="pill pill-<?= $val ?: 'all' ?> <?= $active ?>"><?= $label ?></a>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>

  <!-- Tabla -->
  <div class="card">
    <div class="card-header">
      <div class="card-header-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
      </div>
      <h2 class="card-title">
        Lista de Expedientes
        <?php if ($busqueda): ?>
          &mdash; resultados para &ldquo;<?= htmlspecialchars($busqueda) ?>&rdquo;
        <?php endif; ?>
      </h2>
    </div>
    <div class="card-body" style="padding:0;">

      <?php if (empty($expedientes)): ?>
      <div class="empty-state">
        <div class="empty-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.3"><path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/></svg>
        </div>
        <h3>Sin expedientes</h3>
        <p>No hay expedientes<?= $filtro ? " con estado &laquo;{$estadoLabel[$filtro]}&raquo;" : '' ?>.</p>
      </div>

      <?php else: ?>

      <!-- Barra de acciones masivas -->
      <div class="bulk-bar" id="bulkBar" style="display:none;">
        <span class="bulk-count" id="bulkCount">0 seleccionados</span>
        <form method="POST" action="<?= BASE_URL ?>admin/delete-masivo" id="bulkForm" style="display:inline;">
          <button type="submit" class="btn btn-danger btn-sm" id="bulkDeleteBtn" onclick="return confirm('¿Eliminar los expedientes seleccionados? Esta acción no se puede deshacer.');">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
            Eliminar seleccionados
          </button>
        </form>
      </div>

      <div class="table-wrap">
        <table>
          <thead>
            <tr>
              <th style="width:40px;">
                <input type="checkbox" id="checkAll" title="Seleccionar todos">
              </th>
              <th>Código</th>
              <th>Solicitante</th>
              <th>DNI</th>
              <th>Asunto</th>
              <th>Fecha recepción</th>
              <th>Estado</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($expedientes as $exp): ?>
            <tr>
              <td>
                <input type="checkbox" class="row-check" value="<?= $exp['id'] ?>" data-id="<?= $exp['id'] ?>">
              </td>
              <td><code class="code-chip"><?= htmlspecialchars($exp['codigo']) ?></code></td>
              <td><?= htmlspecialchars($exp['apellidos'] . ', ' . $exp['nombres']) ?></td>
              <td class="td-mono"><?= htmlspecialchars($exp['dni']) ?></td>
              <td class="td-truncate"><?= htmlspecialchars($exp['asunto']) ?></td>
              <td class="td-date"><?= date('d/m/Y H:i', strtotime($exp['created_at'])) ?></td>
              <td><span class="badge badge-<?= $exp['estado'] ?>"><?= $estadoLabel[$exp['estado']] ?></span></td>
              <td>
                <div style="display:flex;gap:.35rem;align-items:center;">
                  <a href="<?= BASE_URL ?>admin/ver?id=<?= $exp['id'] ?>" class="btn btn-outline btn-sm" title="Ver detalle">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px;"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                  </a>
                  <form method="POST" action="<?= BASE_URL ?>admin/delete" style="display:inline;" onsubmit="return confirm('¿Eliminar este expediente? Esta acción no se puede deshacer.');">
                    <input type="hidden" name="id" value="<?= $exp['id'] ?>">
                    <button type="submit" class="btn btn-danger btn-sm" title="Eliminar" style="padding:.3rem .5rem;">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px;"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <div class="table-footer">
        Mostrando <strong><?= count($expedientes) ?></strong> expediente(s)
      </div>
      <?php endif; ?>

    </div>
  </div>

</main>

<?php require VIEW_PATH . 'layouts/footer.php'; ?>

<script>
(function(){
  var checkAll   = document.getElementById('checkAll');
  var rowChecks  = document.querySelectorAll('.row-check');
  var bulkBar    = document.getElementById('bulkBar');
  var bulkCount  = document.getElementById('bulkCount');
  var bulkForm   = document.getElementById('bulkForm');

  if (!checkAll) return;

  function updateBulkBar(){
    var selected = document.querySelectorAll('.row-check:checked');
    var n = selected.length;
    if (n > 0){
      bulkBar.style.display = 'flex';
      bulkCount.textContent = n + ' seleccionado' + (n > 1 ? 's' : '');
      // Add hidden inputs to form
      bulkForm.querySelectorAll('input[name="ids[]"]').forEach(function(el){ el.remove(); });
      selected.forEach(function(cb){
        var inp = document.createElement('input');
        inp.type = 'hidden';
        inp.name = 'ids[]';
        inp.value = cb.value;
        bulkForm.appendChild(inp);
      });
    } else {
      bulkBar.style.display = 'none';
    }
  }

  checkAll.addEventListener('change', function(){
    rowChecks.forEach(function(cb){ cb.checked = checkAll.checked; });
    updateBulkBar();
  });

  rowChecks.forEach(function(cb){
    cb.addEventListener('change', function(){
      var allChecked = Array.from(rowChecks).every(function(c){ return c.checked; });
      checkAll.checked = allChecked;
      updateBulkBar();
    });
  });
})();
</script>
