<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rellenar Formulario</title>
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
      <div class="col-md-6 col-lg-5">
        <div class="card border shadow-sm rounded-3">
          <div class="card-body px-4 py-3">
            <div class="text-center mb-2">
              <img src="<?= BASE_URL ?>/img/logo.png" alt="Logo" class="mb-2" style="max-height: 80px; width: auto;">
            </div>
            <h5 class="text-center fw-semibold text-dark mb-3">Registro de Documento Comunitario</h5>

            <form action="<?= BASE_URL ?>/registro_documento" method="POST" autocomplete="off" enctype="multipart/form-data">
              <!-- Tipo -->
              <div class="mb-2">
                <label for="tipo" class="form-label small text-muted">Especifique</label>
                <select name="tipo" id="tipo" onchange="mostrarSelect()" class="form-select form-select-sm" required>
                  <option value="">Seleccione</option>
                  <option value="UBCH">UBCH</option>
                  <option value="Comunidad">Comunidad</option>
                </select>
              </div>

              <!-- Comunidad -->
              <div id="comunidadDiv" class="mb-2" style="display:none;">
                <label for="comunidad" class="form-label small text-muted">Comunidad</label>
                <select id="comunidad" name="comunidad_comunidad" class="form-select form-select-sm" onchange="mostrarJefe('comunidad')" required>
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
              <div id="ubchDiv" class="mb-2" style="display:none;">
                <label for="ubch" class="form-label small text-muted">UBCH</label>
                <select name="comunidad_ubch" id="ubch" class="form-select form-select-sm" onchange="mostrarJefe('ubch')" required>
                  <option value="">Seleccione</option>
                  <?php foreach ($ubchs as $ubch): ?>
                    <option 
                      value="<?= htmlspecialchars($ubch['comunidad']) ?>" 
                      data-jefe="<?= htmlspecialchars($ubch['jefe'] ?? '') ?>">
                      <?= htmlspecialchars($ubch['comunidad']) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>

              <!-- Jefe -->
              <div id="jefeDiv" class="mb-2" style="display:none;">
                <label class="form-label small text-muted">Jefe</label>
                <input type="text" id="jefe" class="form-control form-control-sm" readonly>
              </div>

              <!-- Descripción -->
              <div class="mb-2">
                <label for="descripcion" class="form-label small text-muted">Descripción del documento</label>
                <input type="text" name="descripcion" id="descripcion" required class="form-control form-control-sm" placeholder="Descripción del documento">
              </div>

              <!-- Monto -->
              <div class="mb-2">
                <label for="monto" class="form-label small text-muted">Monto Aproximado (Dólares)</label>
                <input type="text" name="monto" id="monto" required class="form-control form-control-sm" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Ej: 150">
              </div>

              <!-- Carta -->
              <div class="mb-2">
                <label for="carta" class="form-label small text-muted">Adjuntar Carta</label>
                <input type="file" name="carta" id="carta" required class="form-control form-control-sm">
              </div>

              <!-- Botón -->
              <div class="d-grid mt-3">
                <button type="submit" class="btn btn-dark btn-sm">Registrar Documento</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>



<script>
function mostrarJefe(tipo) {
  const select = document.getElementById(tipo);
  const selectedOption = select.options[select.selectedIndex];
  const jefe = selectedOption?.getAttribute('data-jefe') || '';
  const jefeDiv = document.getElementById('jefeDiv');
  const jefeInput = document.getElementById('jefe');

  if (jefe.trim() !== '') {
    jefeInput.value = jefe;
    jefeDiv.style.display = 'block';
  } else {
    jefeInput.value = '';
    jefeDiv.style.display = 'none';
  }
}
</script>
  <script src="<?= BASE_URL ?>/public/js/msj.js"></script>
  <script src="<?= BASE_URL ?>/public/js/comunidades.js"></script>
  <script>
    const BASE_PATH = "<?php echo BASE_PATH; ?>";
    <?php if (isset($msj)): ?> mostrarMensaje("<?= htmlspecialchars($msj) ?>", "info", 6500);
    <?php endif; ?>
  </script>
<script src="<?= BASE_URL ?>/public/js/sesionReload.js"></script>
<script src="<?= BASE_URL ?>/public/js/validarSesion.js"></script>
</body>
</html>
