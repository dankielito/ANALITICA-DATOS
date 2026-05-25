<?php
$anio = $_POST['anio'] ?? 2021;
$estado = $_POST['estado'] ?? 9; 
$db = new mysqli("localhost", "root", "", "dwh_analitica_animales");

$sql = "SELECT h.nombre_mes, (h.total_perros + h.total_gatos) as total 
        FROM hechos_abandono_estatal h 
        JOIN dim_tiempo t ON h.fk_tiempo = t.id_tiempo 
        WHERE t.anio = ? AND h.fk_estado = ? ORDER BY t.mes ASC";

$stmt = $db->prepare($sql);
$stmt->bind_param("ii", $anio, $estado);
$stmt->execute();
$res = $stmt->get_result();
$labels = []; $valores = [];
while ($row = $res->fetch_assoc()) {
    $labels[] = $row['nombre_mes'];
    $valores[] = (int)$row['total'];
}
echo json_encode(['labels' => $labels, 'valores' => $valores]);
?>