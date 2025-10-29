<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lista de Documentos</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/style.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="<?= BASE_URL ?>/bootstrap/css/bootstrap.min.css?v=<?php echo time(); ?>">
  <link rel="icon" href="<?= BASE_URL ?>/img/logo-ico.ico" type="image/x-icon">
</head>
<body class="bg-light">
  <div class="container pt-4">

    <!-- Botones superiores -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 px-2 px-md-0">
  <div class="text-center text-md-start mb-3 mb-md-0">
    <h4 class="fw-bold text-primary mb-1">Búsqueda de Casos</h4>
    <p class="text-muted mb-0 small">Despacho del Alcalde</p>
  </div>
  <div class="d-flex flex-wrap gap-2">
    <a href="<?= BASE_URL ?>/registrar_documento" class="btn btn-outline-primary rounded-pill px-4 py-2 fw-semibold shadow-sm">
      <i class="bi bi-file-earmark-plus me-2"></i> Registrar Caso
    </a>
    <a href="<?= BASE_URL ?>/main" class="btn btn-light border rounded-pill px-4 py-2 fw-semibold shadow-sm">
      <i class="bi bi-arrow-left-circle me-2"></i> Menú Principal
    </a>
  </div>
</div>


    <!-- Formulario de Búsqueda Rápida -->
<div class="card border-0 shadow-sm mb-4">
  <div class="card-body px-3 px-md-4 py-4">
    <form method="POST" action="<?= BASE_URL ?>/buscar_documentos" autocomplete="off">
      <div class="row g-3 align-items-center">
        <div class="col-12 col-md-8">
          <label for="busqueda" class="form-label fw-semibold text-muted mb-1">Buscar Caso</label>
          <input type="text" id="busqueda" name="busqueda" class="form-control rounded-pill"
            placeholder="Ej. ID, descripción, comunidad, creador..."
            aria-label="Buscar documento" required
            value="<?= isset($_POST['busqueda']) ? htmlspecialchars($_POST['busqueda']) : '' ?>">
        </div>
        <div class="col-12 col-md-4 text-md-end">
          <label class="d-none d-md-block">&nbsp;</label>
          <button class="btn btn-primary rounded-pill px-4 w-100 fw-semibold" type="submit">
            <i class="bi bi-search me-2"></i> Buscar
          </button>
        </div>
      </div>
    </form>
  </div>
</div>



    <?php if (!empty($documentos)): ?>
      <?php $total = $documentos[0]['total'] ?? count($documentos); ?>

      <h5 class="text-center fw-semibold text-dark mb-3">Documentos Comunitarios</h5>
      <p class="text-center fw-semibold text-dark mb-2">Un total de: <?= $total ?> documentos registrados</p>

      <div class="row g-3 justify-content-center">
        <?php foreach ($documentos as $doc): ?>
          <?php $fecha = new DateTime($doc['fecha']); ?>
          <div class="col-md-6 col-lg-5 d-flex">
            <div class="card shadow-sm border rounded-3 h-100 w-100 mx-auto fondo-logo">
              <div class="card-body d-flex flex-column justify-content-between contenido-superior">
                <div>
                  <div class="text-center mb-4">
                    <img src="<?= BASE_URL ?>/img/logo.png" alt="Logo" class="mb-2" style="max-height: 100px; width: auto;">
                  </div>
                  <h6 class="fw-semibold text-primary mb-2">Caso #<?= htmlspecialchars($doc['id_doc']) ?> - <?= htmlspecialchars($doc['descripcion']) ?></h6>
                  <p class="mb-1"><strong>Creador:</strong> <?= htmlspecialchars($doc['creador']) ?></p>
                  <p class="mb-1"><strong>Tipo:</strong> <?= htmlspecialchars($doc['tipo']) ?></p>
                  <p class="mb-1">
                    <p class="mb-1"><strong>Estado:</strong> <?= htmlspecialchars($doc['estado']) ?></p>
                  <p class="mb-1">
                    <strong><?= $doc['tipo'] === 'UBCH' ? 'UBCH:' : 'Comunidad:' ?></strong>
                    <?= htmlspecialchars($doc['comunidad']) ?>
                  </p>
                  <p class="mb-1"><strong>Jefe:</strong> <?= htmlspecialchars($doc['jefe_comunidad'] ?? $doc['jefe_ubch']) ?> - <?= htmlspecialchars($doc['telefono_comunidad'] ?? $doc['telefono_ubch'])?></p>
                  <p class="mb-1">
                    <strong>Monto:</strong>
                    <?= ($doc['monto'] == 0) ? 'Sin Monto Aproximado' : number_format($doc['monto'], 0, '', '.') . ' $' ?>
                  </p>
                  <p class="mb-1"><strong>Fecha:</strong> <?= $fecha->format('d/m/Y') ?></p>
                  <p class="mb-3"><strong>Hora:</strong> <?= $fecha->format('g:i A') ?></p>
                </div>
                <div class="d-flex justify-content-between">
                  <!-- Botón Editar -->
                <!-- Botón Editar -->
<a href="<?= BASE_URL ?>/editar?id=<?= $doc['id_doc'] ?>"
   class="btn btn-outline-info btn-xs rounded-pill px-3 py-1 d-inline-flex align-items-center gap-1 shadow-sm fw-normal text-nowrap">
  <i class="bi bi-pencil-square small"></i>
  <span class="small">Editar</span>
</a>

<!-- Botón Descargar PDF -->
<button id="descargar_pdf"
        data-url="<?= BASE_URL . '/cartas/' . rawurlencode(basename($doc['ubicacion'])) ?>"
        class="btn btn-primary btn-xs rounded-pill px-3 py-1 d-inline-flex align-items-center gap-1 shadow-sm fw-normal text-nowrap">
  <i class="bi bi-file-earmark-pdf small"></i>
  <span class="small">Descargar PDF</span>
</button>

<!-- Botón Ver Carta -->
<a href="<?= BASE_URL . '/cartas/' . rawurlencode(basename($doc['ubicacion'])) ?>" target="_blank"
   class="btn btn-outline-secondary btn-xs rounded-pill px-3 py-1 d-inline-flex align-items-center gap-1 shadow-sm fw-normal text-nowrap">
  <i class="bi bi-eye small"></i>
  <span class="small">Ver Carta</span>
</a>

                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <p class="text-center text-muted fs-6">No hay documentos registrados.</p>
    <?php endif; ?>
  </div>
</body>

  <script src="<?=BASE_URL?>/libs/jspdf.umd.min.js"></script>
  <script src="<?=BASE_URL?>/public/js/descargar_pdf.js"></script>
  <script src="<?= BASE_URL ?>/public/js/msj.js"></script>
  <script>
    const BASE_PATH = "<?php echo BASE_PATH; ?>";
    <?php if (isset($msj)): ?> mostrarMensaje("<?= htmlspecialchars($msj) ?>", "info", 1500);
    <?php endif; ?>
    <?php if (isset($_GET['msj'])): ?> mostrarMensaje("<?= htmlspecialchars($_GET['msj']) ?>", "info", 6500);
    <?php endif; ?>
  </script>
  <script src="<?= BASE_URL ?>/public/js/sesionReload.js"></script>
<script src="<?= BASE_URL ?>/public/js/validarSesion.js"></script>
</html>