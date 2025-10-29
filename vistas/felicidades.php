<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Documento Registrado</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/style.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="<?= BASE_URL ?>/bootstrap/css/bootstrap.min.css?v=<?php echo time(); ?>">
  <link rel="icon" href="<?= BASE_URL ?>/img/logo-ico.ico" type="image/x-icon">
</head>
<body class="bg-light">
  <div class="container pt-4">
    <div class="row justify-content-center">
      <div class="col-md-6 col-lg-5">
        <div class="card border shadow-sm rounded-3 text-center">
          <div class="card-body px-4 py-4">
            <h5 class="fw-semibold text-dark mb-4">Documento registrado con éxito</h5>

            <div class="d-grid gap-2">
              <a href="<?= BASE_URL ?>/main" class="btn btn-outline-secondary btn-sm rounded-pill fw-normal">
                Volver al menú principal
              </a>
              <a href="<?= BASE_URL ?>/registrar_documento" class="btn btn-warning btn-sm rounded-pill fw-normal text-dark">
                Registrar otro documento
              </a>
              <a href="<?= BASE_URL ?>/lista" class="btn btn-success btn-sm rounded-pill fw-normal">
                Ver documentos registrados
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
</body>
</html>
