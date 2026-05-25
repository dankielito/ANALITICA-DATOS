<?php
$anios_futuros = isset($_POST['anios']) ? $_POST['anios'] : [];
$especie = $_POST['especie'] ?? 'ambos';
$db = new mysqli("localhost", "root", "", "dwh_analitica_animales");

if ($especie == 'gatos') {
    $query = "SELECT t.anio, SUM(h.total_mensual) as total FROM hechos_abandono_gatos h JOIN dim_tiempo t ON h.fk_tiempo = t.id_tiempo GROUP BY t.anio ORDER BY t.anio";
} elseif ($especie == 'perros') {
    $query = "SELECT t.anio, SUM(h.total_mensual) as total FROM hechos_abandono_perros h JOIN dim_tiempo t ON h.fk_tiempo = t.id_tiempo GROUP BY t.anio ORDER BY t.anio";
} else {
    $query = "SELECT t.anio, (SUM(hp.total_mensual) + SUM(hg.total_mensual)) as total 
              FROM dim_tiempo t 
              LEFT JOIN hechos_abandono_perros hp ON t.id_tiempo = hp.fk_tiempo 
              LEFT JOIN hechos_abandono_gatos hg ON t.id_tiempo = hg.fk_tiempo 
              GROUP BY t.anio ORDER BY t.anio";
}

$res = $db->query($query);
$x = []; $y = [];
while ($row = $res->fetch_assoc()) {
    $x[] = (int)$row['anio'];
    $y[] = (int)$row['total'];
}

$n = count($x);
if ($n < 2) { echo json_encode(['error' => 'Datos insuficientes.']); exit; }

$sum_x = array_sum($x); $sum_y = array_sum($y);
$sum_xy = 0; $sum_xx = 0;
for ($i = 0; $i < $n; $i++) {
    $sum_xy += ($x[$i] * $y[$i]);
    $sum_xx += ($x[$i] * $x[$i]);
}

$m = ($n * $sum_xy - $sum_x * $sum_y) / ($n * $sum_xx - ($sum_x * $sum_x));
$b = ($sum_y - $m * $sum_x) / $n;

$labels = []; $valores = [];
$meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
sort($anios_futuros);

foreach ($anios_futuros as $anio_target) {
    $pred_anual = ($m * $anio_target) + $b;
    $pred_mensual = $pred_anual / 12;
    foreach ($meses as $mes) {
        $labels[] = "$mes $anio_target";
        $valores[] = round($pred_mensual);
    }
}
echo json_encode(['labels' => $labels, 'valores' => $valores, 'descripcion' => "Modelo proyectado: " . ($m > 0 ? "Tendencia al alza" : "Tendencia a la baja")]);
?>