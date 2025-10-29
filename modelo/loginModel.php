<?php 
require_once 'conexiondb.php';
class LoginModel{
    public static function verificarCredenciales($ci, $clave) {
        try {
            $conexion = DB::conectar();

            // Buscar al usuario por su CI
            $sql = "SELECT clave, id_rol, sesion FROM usuarios WHERE ci = :ci";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':ci', $ci, PDO::PARAM_STR);
            $stmt->execute();

            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario) {
                // Verificar si ya tiene una sesión activa
                if ($usuario['sesion'] == 1) {
                    $sqlSesion = "UPDATE usuarios SET sesion = 0 WHERE ci = :ci";
                    $stmtSesion = $conexion->prepare($sqlSesion);
                    $stmtSesion->bindParam(':ci', $ci, PDO::PARAM_STR);
                    $stmtSesion->execute();
                    return [
                        'exito' => false,
                        'mensaje' => 'Ya existe una sesión activa para este usuario (Se han cerrado todas las sesiones).'
                    ];
                }

                // Verificar la contraseña
                if (password_verify($clave, $usuario['clave'])) {
                    // Actualizar campo sesion a 1
                    $sqlSesion = "UPDATE usuarios SET sesion = 1 WHERE ci = :ci";
                    $stmtSesion = $conexion->prepare($sqlSesion);
                    $stmtSesion->bindParam(':ci', $ci, PDO::PARAM_STR);
                    $stmtSesion->execute();

                    // Obtener el nombre del rol
                    $sqlRol = "SELECT nombre_rol FROM roles WHERE id = :id_rol";
                    $stmtRol = $conexion->prepare($sqlRol);
                    $stmtRol->bindParam(':id_rol', $usuario['id_rol'], PDO::PARAM_INT);
                    $stmtRol->execute();

                    $rol = $stmtRol->fetch(PDO::FETCH_ASSOC);

                    // Guardar en sesión
                    $_SESSION['ci'] = $ci;
                    $_SESSION['id_rol'] = $usuario['id_rol'];
                    $_SESSION['nombre_rol'] = $rol['nombre_rol'] ?? 'Sin rol';

                    return [
                        'exito' => true,
                        'mensaje' => 'Acceso concedido.'
                    ];
                } else {
                    return [
                        'exito' => false,
                        'mensaje' => 'Contraseña incorrecta.'
                    ];
                }
            } else {
                return [
                    'exito' => false,
                    'mensaje' => 'Usuario no encontrado.'
                ];
            }
        } catch (PDOException $e) {
            error_log("Error en login: " . $e->getMessage());
            return [
                'exito' => false,
                'mensaje' => 'Error en la base de datos.'
            ];
        }
    }


    public static function registrar($ci, $clave, $id_rol, $nombre, $apellido, $telefono) {
        try {
            $db = DB::conectar();
            $db->beginTransaction();
            $sqlCheck = "SELECT ci FROM usuarios WHERE ci = :ci";
            $stmtCheck = $db->prepare($sqlCheck);
            $stmtCheck->bindParam(':ci', $ci);
            $stmtCheck->execute();

            if ($stmtCheck->fetch()) {
                return [
                    'exito' => false,
                    'mensaje' => 'El usuario ya está registrado.'
                ];
            }
            // Hashear la contraseña
            $clave_segura = password_hash($clave, PASSWORD_DEFAULT);

            // Insertar en tabla usuarios
            $sqlUsuario = "INSERT INTO usuarios (ci, clave, sesion, id_rol) 
                           VALUES (:ci, :clave, 0, :id_rol)";
            $stmtUsuario = $db->prepare($sqlUsuario);
            $stmtUsuario->bindParam(':ci', $ci);
            $stmtUsuario->bindParam(':clave', $clave_segura);
            $stmtUsuario->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
            $stmtUsuario->execute();

            // Insertar en tabla usuarios_info
            $sqlInfo = "INSERT INTO usuarios_info (ci, nombre, apellido, telefono) 
                        VALUES (:ci, :nombre, :apellido, :telefono)";
            $stmtInfo = $db->prepare($sqlInfo);
            $stmtInfo->bindParam(':ci', $ci);
            $stmtInfo->bindParam(':nombre', $nombre);
            $stmtInfo->bindParam(':apellido', $apellido);
            $stmtInfo->bindParam(':telefono', $telefono);
            $stmtInfo->execute();

            $db->commit();

            return [
                'exito' => true,
                'mensaje' => 'Usuario registrado correctamente.'
            ];
        } catch (PDOException $e) {
            $db->rollBack();
            error_log("Error al registrar usuario: " . $e->getMessage());
            return [
                'exito' => false,
                'mensaje' => 'Error al registrar usuario.'
            ];
        }
    }

    public static function sesionValidar($ci) {
        $conexion = DB::conectar();
        $consulta = "SELECT sesion FROM usuarios WHERE ci = :ci";
        $cons = $conexion->prepare($consulta);
        $cons->bindParam(':ci', $ci);
        $cons->execute();
        $estado = $cons->fetchColumn();
        // Retornar true si la sesión está activa (1), false si es 0 o null
        return (int)$estado === 1;
    }

}



?>