<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Documento</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/style.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="<?= BASE_URL ?>/bootstrap/css/bootstrap.min.css?v=<?php echo time(); ?>">
  <link rel="icon" href="<?= BASE_URL ?>/img/logo-ico.ico" type="image/x-icon">
</head>
<body class="bg-light">
  <div class="container pt-4">
    <!-- Enlaces superiores -->
    <div class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-3 mb-3">
      <a href="<?= BASE_URL ?>/main" class="btn btn-outline-secondary btn-sm fw-normal w-100 w-md-auto">
        Volver al menú principal
      </a>
      <a href="<?= BASE_URL ?>/lista" class="btn btn-outline-secondary btn-sm fw-normal w-100 w-md-auto">
        ← Volver
      </a>
    </div>

    <!-- Formulario -->
    <div class="row justify-content-center">
      <div class="col-md-6 col-lg-5">
        <div class="card border shadow-sm rounded-3">
          <div class="card-body px-4 py-3">
            <h5 class="text-center fw-semibold text-dark mb-3">Editar Documento Comunitario</h5>

            <form action="<?= BASE_URL ?>/actualizar" method="POST" autocomplete="off">
              <input type="hidden" name="id_doc" value="<?= $documento['id_doc'] ?>">

              <!-- Estado -->
              <div class="mb-2">
                <label for="estado" class="form-label small text-muted">Estado de la solicitud</label>
                <select name="estado" id="estado" class="form-select form-select-sm" required>
                  <option value="">Seleccione</option>
                  <option value="Sin Registrar" <?= $documento['estado'] === 'Sin Registrar' ? 'selected' : '' ?>>Sin Registrar</option>
                  <option value="Informado al alcalde" <?= $documento['estado'] === 'Informado al alcalde' ? 'selected' : '' ?>>Informado al alcalde</option>
                  <option value="Aprobado" <?= $documento['estado'] === 'Aprobado' ? 'selected' : '' ?>>Aprobado</option>
                  <option value="Negado" <?= $documento['estado'] === 'Negado' ? 'selected' : '' ?>>Negado</option>
                  <option value="Diferido" <?= $documento['estado'] === 'Diferido' ? 'selected' : '' ?>>Diferido</option>
                </select>
              </div>

              <!-- Tipo -->
              <div class="mb-2">
                <label for="tipo" class="form-label small text-muted">Tipo de documento</label>
                <select name="tipo" id="tipo" onchange="mostrarSelect()" class="form-select form-select-sm">
                  <option value="">Seleccione</option>
                  <option value="UBCH" <?= $documento['tipo'] === 'UBCH' ? 'selected' : '' ?>>UBCH</option>
                  <option value="Comunidad" <?= $documento['tipo'] === 'Comunidad' ? 'selected' : '' ?>>Comunidad</option>
                </select>
              </div>

              <!-- Comunidad -->
              <div id="comunidadDiv" class="mb-2 tipo-comunidad" style="display:none;">
                <label for="comunidad" class="form-label small text-muted">Comunidad</label>
                <select name="comunidad" id="comunidad" class="form-select form-select-sm">
                  <option value="">Seleccione</option>
                  <?php foreach ($comunidades as $com): ?>
                    <option value="<?= htmlspecialchars($com['comunidad']) ?>"
                      <?= $documento['tipo'] === 'Comunidad' && $documento['comunidad'] === $com['comunidad'] ? 'selected' : '' ?>>
                      <?= htmlspecialchars($com['comunidad']) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>

              <!-- UBCH -->
              <div id="ubchDiv" class="mb-2 tipo-ubch" style="display:none;">
                <label for="ubch" class="form-label small text-muted">UBCH</label>
                <select name="ubch" id="ubch" class="form-select form-select-sm">
                  <option value="">Seleccione</option>
                  <?php foreach ($ubchs as $ubch): ?>
                    <option value="<?= htmlspecialchars($ubch['comunidad']) ?>"
                      <?= $documento['tipo'] === 'UBCH' && $documento['comunidad'] === $ubch['comunidad'] ? 'selected' : '' ?>>
                      <?= htmlspecialchars($ubch['comunidad']) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>

              <!-- Descripción -->
              <div class="mb-2">
                <label for="descripcion" class="form-label small text-muted">Descripción del documento</label>
                <input type="text" name="descripcion" id="descripcion" required
                       class="form-control form-control-sm"
                       value="<?= htmlspecialchars($documento['descripcion']) ?>">
              </div>

              <!-- Monto -->
              <div class="mb-2">
                <label for="monto" class="form-label small text-muted">Monto Aproximado</label>
                <input type="text" name="monto" id="monto" required
                       class="form-control form-control-sm"
                       oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                       value="<?= htmlspecialchars($documento['monto']) ?>">
              </div>

              <!-- Botón -->
              <div class="d-grid mt-3">
                <button type="submit" class="btn btn-dark btn-sm">Actualizar Documento</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>


  <script src="<?= BASE_URL ?>/public/js/msj.js"></script>
  <script src="<?= BASE_URL ?>/public/js/comunidades.js"></script>
  <script>
    const BASE_PATH = "<?php echo BASE_PATH; ?>";
    <?php if (isset($msj)): ?> mostrarMensaje("<?= htmlspecialchars($msj) ?>", "info", 6500); <?php endif; ?>
    mostrarSelect(); // Ejecutar al cargar para mostrar el campo correcto
  </script>
<script src="<?= BASE_URL ?>/public/js/sesionReload.js"></script>
<script src="<?= BASE_URL ?>/public/js/validarSesion.js"></script>

</html>
