<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro de Comunidades & UBCH</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/style.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="<?= BASE_URL ?>/bootstrap/css/bootstrap.min.css?v=<?php echo time(); ?>">
  <link rel="icon" href="<?= BASE_URL ?>/img/logo-ico.ico" type="image/x-icon">
</head>
<body class="bg-light">
  <div class="container pt-5">
    <div class="row justify-content-center">
      <div class="col-md-6 col-lg-5">
        <div class="card border shadow-sm rounded-3">
          <div class="card-body px-4 py-4">
            <form action="<?= BASE_URL ?>/ingresar" method="POST" autocomplete="off">
              <div class="text-center mb-4">
                <img src="<?= BASE_URL ?>/img/logo.png" alt="Logo" class="mb-2" style="max-height: 100px; width: auto;">
                <h5 class="fw-semibold text-dark mb-0">Acceso al sistema</h5>
              </div>

              <div class="mb-3">
                <label for="ci" class="form-label small text-muted">Cédula de Identidad</label>
                <input type="text" id="ci" name="ci" placeholder="Ej: 12345678" required
                       oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                       class="form-control form-control-sm">
              </div>

              <div class="mb-3">
                <label for="clave" class="form-label small text-muted">Contraseña</label>
                <input type="password" id="clave" name="clave" placeholder="Ingrese su contraseña" required
                       class="form-control form-control-sm">
              </div>

              <div class="d-grid">
                <button type="submit" class="btn btn-dark btn-sm">Ingresar</button>
              </div>
            </form>

            <div class="text-center mt-3">
              <a href="<?= BASE_URL ?>/registro" class="text-decoration-none small text-muted">¿No tienes cuenta? Registrarse</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>



  <script src="<?= BASE_URL ?>/public/js/msj.js"></script>
  <script src="<?= BASE_URL ?>/public/js/sesionReload.js"></script>
  <script>
    const BASE_PATH = "<?php echo BASE_PATH; ?>";
    <?php if (isset($msj)): ?> mostrarMensaje("<?= htmlspecialchars($msj) ?>", "info", 6500);
    <?php endif; ?>
  </script>
</html>
