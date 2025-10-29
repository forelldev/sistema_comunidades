<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro de Usuario</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/style.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="<?= BASE_URL ?>/bootstrap/css/bootstrap.min.css?v=<?php echo time(); ?>">
  <link rel="icon" href="<?= BASE_URL ?>/img/logo-ico.ico" type="image/x-icon">
</head>
<body class="bg-light">
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-6 col-lg-5">
        <div class="card border shadow-sm rounded-3">
          <div class="card-body px-4 py-3">
            <div class="text-center mb-3">
              <img src="<?= BASE_URL ?>/img/logo.png" alt="Logo" class="mb-2" style="max-height: 100px; width: auto;">
              <h5 class="fw-semibold text-dark mb-0">Registro de Usuario</h5>
            </div>

            <form action="<?= BASE_URL ?>/registrar_usuario" method="POST" autocomplete="off">
              <!-- Credenciales -->
              <fieldset class="mb-4">
                <legend class="fs-6 fw-semibold text-muted mb-3">Credenciales</legend>

                <div class="mb-3">
                  <label for="ci" class="form-label small text-muted">Cédula</label>
                  <input type="text" name="ci" id="ci" required class="form-control form-control-sm">
                </div>

                <div class="mb-3">
                  <label for="clave" class="form-label small text-muted">Contraseña</label>
                  <input type="password" name="clave" id="clave" required class="form-control form-control-sm">
                </div>

                <div class="mb-3">
                  <label for="id_rol" class="form-label small text-muted">Rol</label>
                  <select name="id_rol" id="id_rol" required class="form-select form-select-sm">
                    <option value="">Seleccione un rol</option>
                    <option value="1">Jefe de UBCH</option>
                    <option value="2">Jefe de Comunidad</option>
                  </select>
                </div>
              </fieldset>

              <!-- Información Personal -->
              <fieldset class="mb-4">
                <legend class="fs-6 fw-semibold text-muted mb-3">Información Personal</legend>

                <div class="mb-3">
                  <label for="nombre" class="form-label small text-muted">Nombre</label>
                  <input type="text" name="nombre" id="nombre" required class="form-control form-control-sm">
                </div>

                <div class="mb-3">
                  <label for="apellido" class="form-label small text-muted">Apellido</label>
                  <input type="text" name="apellido" id="apellido" required class="form-control form-control-sm">
                </div>

                <div class="mb-3">
                  <label for="telefono" class="form-label small text-muted">Teléfono</label>
                  <input type="text" name="telefono" id="telefono" class="form-control form-control-sm">
                </div>
              </fieldset>

              <div class="d-grid">
                <button type="submit" class="btn btn-dark btn-sm">Registrar Usuario</button>
              </div>

              <div class="text-center mt-3">
                <a href="<?= BASE_URL ?>/" class="text-decoration-none small text-muted">← Volver</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>


  <script src="<?= BASE_URL ?>/public/js/msj.js"></script>
  <script>
    const BASE_PATH = "<?php echo BASE_PATH; ?>";
    <?php if (isset($msj)): ?> mostrarMensaje("<?= htmlspecialchars($msj) ?>", "info", 6500);
    <?php endif; ?>
  </script>

</html>
