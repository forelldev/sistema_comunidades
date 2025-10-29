<?php 
require_once 'conexiondb.php';
    class ComunidadModelo{
     public static function registrar_documento($data) {
        try {
            // Rellenar campos vacíos con 'Sin Registrar'
            $camposEsperados = ['ci', 'estado', 'tipo', 'descripcion', 'comunidad'];
            foreach ($camposEsperados as $campo) {
                if (!isset($data[$campo]) || trim($data[$campo]) === '') {
                    $data[$campo] = 'Sin Registrar';
                }
            }

            // Verificar sesión
            if (empty($_SESSION['ci'])) {
                return [
                    'exito' => false,
                    'mensaje' => 'No se puede identificar al creador. Sesión no iniciada.'
                ];
            }

            $db = DB::conectar();

            // Buscar nombre y apellido del creador
            $sqlCreador = "SELECT nombre, apellido FROM usuarios_info WHERE ci = :ci";
            $stmtCreador = $db->prepare($sqlCreador);
            $stmtCreador->bindParam(':ci', $_SESSION['ci']);
            $stmtCreador->execute();
            $datosCreador = $stmtCreador->fetch(PDO::FETCH_ASSOC);

            if (!$datosCreador) {
                return [
                    'exito' => false,
                    'mensaje' => 'No se encontró información del creador.'
                ];
            }

            $creador = $datosCreador['nombre'] . ' ' . $datosCreador['apellido'];

            $db->beginTransaction();

            // Insertar en solicitud_comunidad
            $sqlDoc = "INSERT INTO solicitud_comunidad (ci, estado, tipo) VALUES (:ci, :estado, :tipo)";
            $stmtDoc = $db->prepare($sqlDoc);
            $stmtDoc->bindParam(':ci', $data['ci']);
            $stmtDoc->bindParam(':estado', $data['estado']);
            $stmtDoc->bindParam(':tipo', $data['tipo']);
            $stmtDoc->execute();
            $id_doc = $db->lastInsertId();

            date_default_timezone_set('America/Caracas');

            // Insertar en solicitud_comunidad_fecha
            $sqlFecha = "INSERT INTO solicitud_comunidad_fecha (id_doc, fecha) VALUES (:id_doc, :fecha)";
            $stmtFecha = $db->prepare($sqlFecha);
            $fecha = date('Y-m-d H:i:s');
            $stmtFecha->bindParam(':id_doc', $id_doc);
            $stmtFecha->bindParam(':fecha', $fecha);
            $stmtFecha->execute();

            // Insertar en solicitud_comunidad_info
            $sqlInfo = "INSERT INTO solicitud_comunidad_info (id_doc, descripcion, creador, comunidad, monto) 
                        VALUES (:id_doc, :descripcion, :creador, :comunidad, :monto)";
            $stmtInfo = $db->prepare($sqlInfo);
            $stmtInfo->bindParam(':id_doc', $id_doc);
            $stmtInfo->bindParam(':descripcion', $data['descripcion']);
            $stmtInfo->bindParam(':creador', $creador);
            $stmtInfo->bindParam(':comunidad', $data['comunidad']);
            $stmtInfo->bindParam(':monto', $data['monto']);
            $stmtInfo->execute();

            // Procesar archivo adjunto
            if (isset($_FILES['carta']) && $_FILES['carta']['error'] === UPLOAD_ERR_OK) {
                $nombreArchivo = basename($_FILES['carta']['name']);
                $rutaDestino = 'cartas/' . time() . '_' . $nombreArchivo;

                if (!move_uploaded_file($_FILES['carta']['tmp_name'], $rutaDestino)) {
                    $db->rollBack();
                    return [
                        'exito' => false,
                        'mensaje' => 'Error al guardar el archivo.'
                    ];
                }

                // Insertar en solicitud_comunidad_archivo
                $sqlArchivo = "INSERT INTO solicitud_comunidad_archivo (id_doc, ubicacion) VALUES (:id_doc, :ubicacion)";
                $stmtArchivo = $db->prepare($sqlArchivo);
                $stmtArchivo->bindParam(':id_doc', $id_doc);
                $stmtArchivo->bindParam(':ubicacion', $rutaDestino);
                $stmtArchivo->execute();
            }

            $db->commit();

            return [
                'exito' => true,
                'mensaje' => 'Documento registrado correctamente.'
            ];
        } catch (PDOException $e) {
            $db->rollBack();
            error_log("Error al registrar documento: " . $e->getMessage());
            return [
                'exito' => false,
                'mensaje' => 'Error al registrar el documento.'
            ];
        }
    }



     public static function mostrar_documentos() {
        try {
            $db = DB::conectar();

            $sql = "SELECT 
            sc.*,
            sci.*,
            scf.*,
            sca.*,
            c.jefe AS jefe_comunidad,
            c.telefono AS telefono_comunidad,
            u.jefe AS jefe_ubch,
            u.telefono AS telefono_ubch,
            COUNT(*) OVER() AS total
        FROM solicitud_comunidad sc
        LEFT JOIN solicitud_comunidad_info sci ON sc.id_doc = sci.id_doc
        LEFT JOIN solicitud_comunidad_fecha scf ON sc.id_doc = scf.id_doc
        LEFT JOIN solicitud_comunidad_archivo sca ON sc.id_doc = sca.id_doc
        LEFT JOIN comunidades c ON sci.comunidad = c.comunidad
        LEFT JOIN ubch u ON sci.comunidad = u.comunidad
        ORDER BY scf.fecha DESC;";

            $stmt = $db->prepare($sql);
            $stmt->execute();
            $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return [
                'exito' => true,
                'datos' => $datos
            ];
        } catch (PDOException $e) {
            error_log("Error al obtener solicitudes: " . $e->getMessage());
            return [
                'exito' => false,
                'mensaje' => 'Error al consultar las solicitudes.'
            ];
        }

}

    public static function traer_comunidades(){
        try {
            $db = DB::conectar();

            // Comunidades
            $stmtCom = $db->prepare("SELECT * FROM comunidades");
            $stmtCom->execute();
            $comunidades = $stmtCom->fetchAll(PDO::FETCH_ASSOC);

            // UBCHs
            $stmtUbch = $db->prepare("SELECT * FROM ubch");
            $stmtUbch->execute();
            $ubchs = $stmtUbch->fetchAll(PDO::FETCH_ASSOC);

            return [
                'exito' => true,
                'comunidades' => $comunidades,
                'ubchs' => $ubchs
            ];
        } catch (PDOException $e) {
            error_log("Error al obtener datos de select: " . $e->getMessage());
            return [
                'exito' => false,
                'comunidades' => [],
                'ubchs' => []
            ];
        }
    }

  public static function obtenerPorId($id) {
    $db = DB::conectar();
    $sql = "SELECT * 
            FROM solicitud_comunidad d
            JOIN solicitud_comunidad_fecha f ON d.id_doc = f.id_doc
            JOIN solicitud_comunidad_info i ON d.id_doc = i.id_doc
            WHERE d.id_doc = :id";
    
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


  public static function obtenerDatosSelect() {
    $db = DB::conectar();
    $comunidades = $db->query("SELECT comunidad FROM comunidades ORDER BY comunidad ASC")->fetchAll(PDO::FETCH_ASSOC);
    $ubchs = $db->query("SELECT comunidad FROM ubch ORDER BY comunidad ASC")->fetchAll(PDO::FETCH_ASSOC);
    return ['comunidades' => $comunidades, 'ubchs' => $ubchs];
  }

  public static function actualizarDocumento($data) {
    try {
      $db = DB::conectar();
      $db->beginTransaction();

      $sql1 = "UPDATE solicitud_comunidad SET ci = :ci, estado = :estado, tipo = :tipo WHERE id_doc = :id_doc";
      $stmt1 = $db->prepare($sql1);
      $stmt1->execute([
        ':ci' => $data['ci'],
        ':estado' => $data['estado'],
        ':tipo' => $data['tipo'],
        ':id_doc' => $data['id_doc']
      ]);

      $sql2 = "UPDATE solicitud_comunidad_info SET descripcion = :descripcion,comunidad = :comunidad
               WHERE id_doc = :id_doc";
      $stmt2 = $db->prepare($sql2);
      $stmt2->execute([
        ':descripcion' => $data['descripcion'],
        ':comunidad' => $data['comunidad'],
        ':id_doc' => $data['id_doc']
      ]);

      $db->commit();
      return ['exito' => true, 'mensaje' => 'Documento actualizado correctamente.'];
    } catch (PDOException $e) {
      $db->rollBack();
      error_log("Error al actualizar documento: " . $e->getMessage());
      return ['exito' => false, 'mensaje' => 'Error al actualizar el documento.'];
    }
  }

public static function busqueda($busqueda) {
    try {
        $pdo = DB::conectar();

        $sql = "
            SELECT 
                sc.*, 
                sci.*, 
                scf.*,
                sca.*,
                c.jefe AS jefe_comunidad,
                u.jefe AS jefe_ubch
            FROM solicitud_comunidad sc
            LEFT JOIN solicitud_comunidad_info sci ON sc.id_doc = sci.id_doc
            LEFT JOIN solicitud_comunidad_fecha scf ON sc.id_doc = scf.id_doc
            LEFT JOIN solicitud_comunidad_archivo sca ON sc.id_doc = sca.id_doc
            LEFT JOIN comunidades c ON sci.comunidad = c.comunidad
            LEFT JOIN ubch u ON sci.comunidad = u.comunidad
            WHERE 
                sc.id_doc LIKE :busqueda OR
                sc.ci LIKE :busqueda OR
                sc.estado LIKE :busqueda OR
                sc.tipo LIKE :busqueda OR
                sc.nombre LIKE :busqueda OR
                sc.apellido LIKE :busqueda OR
                scf.fecha LIKE :busqueda OR
                sci.id_doc LIKE :busqueda OR
                sci.descripcion LIKE :busqueda OR
                sci.creador LIKE :busqueda OR
                sci.comunidad LIKE :busqueda OR
                sci.monto LIKE :busqueda OR
                c.jefe LIKE :busqueda OR
                u.jefe LIKE :busqueda
            ORDER BY scf.fecha DESC
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([':busqueda' => '%' . $busqueda . '%']);
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($resultados && count($resultados) > 0) {
            $totalFilas = count($resultados);
            $totalMonto = array_sum(array_column($resultados, 'monto'));

            return [
                'exito' => true,
                'mensaje' => 'Resultados encontrados.',
                'datos' => $resultados,
                'filas' => $totalFilas,
                'total' => $totalMonto
            ];
        } else {
            return [
                'exito' => false,
                'mensaje' => 'No se encontraron resultados para la búsqueda.',
                'datos' => [],
                'filas' => 0,
                'total' => 0
            ];
        }
    } catch (PDOException $e) {
        error_log("Error en búsqueda de documentos: " . $e->getMessage());
        return [
            'exito' => false,
            'mensaje' => 'Ocurrió un error al realizar la búsqueda.',
            'datos' => [],
            'filas' => 0,
            'total' => 0
        ];
    }
}





}

?>