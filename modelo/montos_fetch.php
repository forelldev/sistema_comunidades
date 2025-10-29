<?php
header('Content-Type: application/json');
require 'conexiondb.php';

$pdo = DB::conectar();

$tipo = $_POST['tipo'] ?? '';
$valor = $_POST['valor'] ?? '';

if (!$tipo || !$valor) {
    echo json_encode(['total' => 0, 'datos' => [], 'filas' => 0]);
    exit;
}

if ($tipo === 'Comunidad') {
    $stmt = $pdo->prepare("
        SELECT sci.*, sc.*, sca.*, scf.*
        FROM solicitud_comunidad_info AS sci
        LEFT JOIN solicitud_comunidad AS sc ON sci.id_doc = sc.id_doc
        LEFT JOIN solicitud_comunidad_archivo AS sca ON sci.id_doc = sca.id_doc
        LEFT JOIN solicitud_comunidad_fecha AS scf ON sci.id_doc = scf.id_doc
        WHERE sci.comunidad = ?
    ");
    $stmt->execute([$valor]);
} else {
    $stmt = $pdo->prepare("
        SELECT sci.*, sc.*, sca.*, scf.*
        FROM solicitud_comunidad_info AS sci
        LEFT JOIN solicitud_comunidad AS sc ON sci.id_doc = sc.id_doc
        LEFT JOIN solicitud_comunidad_archivo AS sca ON sci.id_doc = sca.id_doc
        LEFT JOIN solicitud_comunidad_fecha AS scf ON sci.id_doc = scf.id_doc
        JOIN comunidades com ON sci.comunidad = com.comunidad
        JOIN ubch ub ON com.id_ubch = ub.id
        WHERE com.id_ubch = ? OR sci.comunidad = ub.comunidad
    ");
    $stmt->execute([$valor]);
}

$datos = $stmt->fetchAll(PDO::FETCH_ASSOC);
$total = array_sum(array_column($datos, 'monto'));
$filas = count($datos);

echo json_encode([
    'total' => $total,
    'datos' => $datos,
    'filas' => $filas
]);
