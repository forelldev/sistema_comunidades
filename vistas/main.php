<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Alcaldía de Peña</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/style.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="<?= BASE_URL ?>/bootstrap/css/bootstrap.min.css?v=<?php echo time(); ?>">
  <link rel="icon" href="<?= BASE_URL ?>/img/logo-ico.ico" type="image/x-icon">
</head>
<body class="bg-light">
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-7 col-lg-6">
        <div class="card border shadow-sm rounded-3">
          <div class="text-center pt-4 px-4">
            <img src="<?= BASE_URL ?>/img/logo.png" alt="Logo" class="mb-3" style="max-height: 110px; width: auto;">
          </div>
          <div class="card-body px-5 py-4 text-center">
            <h4 class="fw-semibold text-dark mb-4">Bienvenido</h4>

            <div class="d-grid gap-3 mb-4">
              <a href="<?= BASE_URL ?>/registrar_documento" class="btn btn-outline-warning btn-md fw-normal text-dark rounded-pill shadow-sm">
                Registrar Caso
              </a>
              <a href="<?= BASE_URL ?>/monto_vista" class="btn btn-outline-success btn-md fw-normal rounded-pill shadow-sm">
                Ver Montos
              </a>
              <a href="<?= BASE_URL ?>/lista" class="btn btn-outline-primary btn-md fw-normal rounded-pill shadow-sm">
                Ver Documentos
              </a>
            </div>

            <div class="d-grid">
              <a href="<?= BASE_URL ?>/cerrar_sesion" class="btn btn-outline-danger btn-md fw-normal rounded-pill shadow-sm">
                Cerrar Sesión
              </a>
            </div>
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
<script src="<?= BASE_URL ?>/public/js/sesionReload.js"></script>
<script src="<?= BASE_URL ?>/public/js/validarSesion.js"></script>
</html>
