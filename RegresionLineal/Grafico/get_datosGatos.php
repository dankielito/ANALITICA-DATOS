<?php
$anio = $_POST['anio'] ?? 2021;
$db = new mysqli("localhost", "root", "", "dwh_analitica_animales");

$sql = "SELECT h.nombre_mes, h.total_mensual 
        FROM hechos_abandono_gatos h 
        JOIN dim_tiempo t ON h.fk_tiempo = t.id_tiempo 
        WHERE t.anio = ? ORDER BY t.mes ASC";

$stmt = $db->prepare($sql);
$stmt->bind_param("i", $anio);
$stmt->execute();
$res = $stmt->get_result();
$labels = []; $valores = [];
while ($row = $res->fetch_assoc()) {
    $labels[] = $row['nombre_mes'];
    $valores[] = (int)$row['total_mensual'];
}
echo json_encode(['labels' => $labels, 'valores' => $valores]);
?>