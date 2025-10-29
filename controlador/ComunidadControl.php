<?php 
require_once 'modelo/ComunidadModelo.php';
    class ComunidadControl{
        public static function registrar_documento(){
            $resultado = ComunidadModelo::traer_comunidades();
            if($resultado['exito']){
                $comunidades = $resultado['comunidades'];
                $ubchs = $resultado['ubchs'];
            }
            else{
                $msj = 'Ocurrio un error ';
            }
            
            require_once 'vistas/documento_formulario.php';
        }

        public static function registro_documento() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $_POST['carta'] = $_FILES['carta'];
                $_POST['comunidad'] = $_POST['tipo'] === 'Comunidad' ? ($_POST['comunidad_comunidad'] ?? '') : ($_POST['comunidad_ubch'] ?? '');
                $resultado = ComunidadModelo::registrar_documento($_POST);
                
                if ($resultado['exito']) {
                    header("Location: " . BASE_URL . "/felicidades");
                } else {
                    $msj = $resultado['mensaje'];
                    require_once 'vistas/documento_formulario.php';
                }
            } else {
                $msj = 'Ocurrió un error en el envío del formulario';
                require_once 'vistas/documento_formulario.php';
            }
        }


        public static function felicidades(){
            require_once 'vistas/felicidades.php';
        }

        public static function lista(){
            $resultado = ComunidadModelo::mostrar_documentos();

        if ($resultado['exito']) {
            $documentos = $resultado['datos'];
            require_once 'vistas/lista.php';
        } else {
            $msj = $resultado['mensaje'];
            require_once 'vistas/lista.php';
        }
        }

    public static function editar() {
        if(isset($_GET['id'])){
        $resultado = ComunidadModelo::traer_comunidades();
        if($resultado['exito']){
                $comunidades = $resultado['comunidades'];
                $ubchs = $resultado['ubchs'];
            }
            else{
                $msj = 'Ocurrio un error ';
            }
        $documento = ComunidadModelo::obtenerPorId($_GET['id']);
        $datos = ComunidadModelo::obtenerDatosSelect();
        }
        else{
            $msj = 'No llegó get';
        }
        require_once 'vistas/documento_editar.php';
    }

    public static function actualizar() {
        $resultado = ComunidadModelo::actualizarDocumento($_POST);
        $msj = $resultado['mensaje'];
        header("Location: " . BASE_URL . "/lista?msj=" . urlencode($msj));
        exit;
    }

    public static function monto_vista(){
        $resultado = ComunidadModelo::traer_comunidades();
            if($resultado['exito']){
                $comunidades = $resultado['comunidades'];
                $ubchs = $resultado['ubchs'];
            }
            else{
                $msj = 'Ocurrio un error ';
            }
        require_once 'vistas/monto_vista.php';
    }

    public static function buscar_documentos(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $busqueda = $_POST['busqueda'];
            $resultado = ComunidadModelo::busqueda($busqueda);
            if($resultado['exito']){
                $msj = 'Busqueda realizada con éxito!';
                $documentos = $resultado['datos'];
            }
        }
        else{
            $msj = 'Ocurrió un error (POST)';
        }
        require_once 'vistas/lista.php';
    }
}
?>