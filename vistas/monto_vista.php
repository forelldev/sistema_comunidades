<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Montos</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="<?= BASE_URL ?>/bootstrap/css/bootstrap.min.css?v=<?php echo time(); ?>">
    <link rel="icon" href="<?= BASE_URL ?>/img/logo-ico.ico" type="image/x-icon">
    
</head>
<body class="bg-light">
  <div class="container pt-4">
    <!-- Enlace al menú principal -->
    <div class="text-start mb-3">
      <a href="<?= BASE_URL ?>/main" class="btn btn-outline-secondary btn-sm fw-normal">
        Volver al menú principal
      </a>
    </div>

    <!-- Formulario -->
    <div class="row justify-content-center">
      <div class="col-md-7 col-lg-6">
        <div class="card border shadow-sm rounded-3">
          <div class="card-body px-4 py-4">
            <div class="text-center mb-3">
              <img src="<?= BASE_URL ?>/img/logo.png" alt="Logo" class="mb-2" style="max-height: 100px; width: auto;">
            </div>
            <h4 class="text-center fw-semibold text-dark mb-4">Selección de Monto</h4>

            <!-- Tipo -->
            <div class="mb-3">
              <label for="tipo" class="form-label small text-muted">Seleccionar monto por</label>
              <select name="tipo" id="tipo" class="form-select form-select-sm" onchange="mostrarSelect()" required>
                <option value="">Seleccione</option>
                <option value="UBCH">UBCH</option>
                <option value="Comunidad">Comunidad</option>
              </select>
            </div>

            <!-- Comunidad -->
            <div class="mb-3" id="comunidadDiv" style="display:none;">
              <label for="comunidad" class="form-label small text-muted">Seleccione la Comunidad</label>
              <select name="comunidad" id="comunidad" class="form-select form-select-sm">
                <option value="">Seleccione</option>
                <?php foreach ($comunidades as $com): ?>
                  <option 
                    value="<?= htmlspecialchars($com['comunidad']) ?>" 
                    data-jefe="<?= htmlspecialchars($com['jefe'] ?? '') ?>">
                    <?= htmlspecialchars($com['comunidad']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <!-- UBCH -->
            <div class="mb-3" id="ubchDiv" style="display:none;">
              <label for="ubch" class="form-label small text-muted">Seleccione UBCH</label>
              <select name="ubch" id="ubch" class="form-select form-select-sm">
                <option value="">Seleccione</option>
                <?php foreach ($ubchs as $ubch): ?>
                  <option 
                    value="<?= htmlspecialchars($ubch['id']) ?>" 
                    data-jefe="<?= htmlspecialchars($ubch['jefe'] ?? '') ?>">
                    <?= htmlspecialchars($ubch['comunidad']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <!-- Monto total -->
            <div class="mb-3">
              <label for="monto_total" class="form-label small text-muted">Monto total</label>
              <input type="text" readonly id="monto_total" placeholder="Total" class="form-control form-control-sm">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <h1 id="total" class="text-center text-secundary fw-bold mt-3"></h1>
  <div id="tarjetas_solicitudes" class="row g-3 justify-content-center mt-3"></div>
</body>


<script>
    const BASE_PATH = "<?php echo BASE_PATH; ?>";
    const BASE_B = "<?=BASE_URL?>";
</script>
<script src="<?=BASE_URL?>/public/js/monto.js"></script>
<script src="<?= BASE_URL ?>/public/js/comunidades.js"></script>
<script src="<?= BASE_URL ?>/public/js/sesionReload.js"></script>
<script src="<?= BASE_URL ?>/public/js/validarSesion.js"></script>
</html>