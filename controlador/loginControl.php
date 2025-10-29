<?php 
require_once 'modelo/loginModel.php';
require_once 'modelo/conexiondb.php';
class LoginControl {
        public static function index (){
            if (isset($_SESSION['ci'])) {
                header('Location: '.BASE_URL.'/main');
                exit;
            }
            require_once 'vistas/login.php';
        }

        public static function ingresar() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $ci = $_POST['ci'] ?? null;
                $clave = $_POST['clave'] ?? null;
                // Delegar al modelo
                $resultado = LoginModel::verificarCredenciales($ci, $clave);
                if ($resultado['exito']) {
                    header('Location: '.BASE_URL.'/main');
                } else {
                    $msj = $resultado['mensaje'];
                    require_once 'vistas/login.php';
                }
            } else {
                // Si no es POST, redirigir al login
                header('Location: ' . BASE_URL . '/login');
                exit;
            }
        }

        public static function main(){
            if (!isset($_SESSION['ci'])) {
                header('Location: '.BASE_URL.'/');
                exit;
            }
            require_once 'vistas/main.php';
        }

        public static function registro (){
            require_once 'vistas/registro.php';
        }

        public static function registrar_usuario() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Capturar datos del formulario
                $ci = $_POST['ci'] ?? null;
                $clave = $_POST['clave'] ?? null;
                $id_rol = $_POST['id_rol'] ?? null;

                $nombre = $_POST['nombre'] ?? null;
                $apellido = $_POST['apellido'] ?? null;
                $telefono = $_POST['telefono'] ?? null;

                // Validar campos obligatorios
                if (!$ci || !$clave || !$id_rol || !$nombre || !$apellido) {
                    $msj = "Faltan campos obligatorios.";
                    require_once 'vistas/registro.php';
                    return;
                }

                // Llamar al modelo
                $resultado = LoginModel::registrar($ci, $clave, $id_rol, $nombre, $apellido, $telefono);

                if ($resultado['exito']) {
                    $msj = 'Registrado con éxito!';
                    require_once 'vistas/login.php';
                } else {
                    $msj = $resultado['mensaje'];
                    require_once 'vistas/registro.php';
                }
            } else {
                // Si no es POST, redirigir al formulario
                header('Location: ' . BASE_URL . '/registro');
                exit;
            }
        }

        public function validarSesionAjax() {
            header('Content-Type: application/json');
            if (isset($_SESSION['ci'])) {
                $activa = LoginModel::sesionValidar($_SESSION['ci']);

                if ($activa) {
                    echo json_encode(['sesionActiva' => true]);
                } else {
                    // ⚠️ Sesión marcada como inactiva en la base de datos
                    session_unset();      // Elimina variables de sesión
                    session_destroy();    // Destruye la sesión
                    setcookie(session_name(), '', time() - 3600, '/'); // Elimina cookie
                    echo json_encode(['sesionActiva' => false]);
                }
            } else {
                // No hay sesión en PHP
                session_destroy();
                echo json_encode(['sesionActiva' => false]);
            }
        }

        public static function cerrar_sesion() {
            if (isset($_SESSION['ci'])) {
                $ci = $_SESSION['ci'];

                try {
                    $db = DB::conectar();
                    $sql = "UPDATE usuarios SET sesion = 0 WHERE ci = :ci";
                    $stmt = $db->prepare($sql);
                    $stmt->bindParam(':ci', $ci);
                    $stmt->execute();
                } catch (PDOException $e) {
                    error_log("Error al cerrar sesión: " . $e->getMessage());
                }
            }

            session_unset();
            session_destroy();

            header("Location: " . BASE_URL . "/");
            exit;
        }


        
    }
?>