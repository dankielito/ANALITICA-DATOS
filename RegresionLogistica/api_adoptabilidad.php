<?php
header('Content-Type: application/json');
require_once 'PreparadorDatos.php';
require_once 'MotorLogistico.php';

$tamano = isset($_POST['tamano']) ? $_POST['tamano'] : 'todos';

$prep = new PreparadorDatos();
$datos = $prep->obtenerDatosEntrenamiento($tamano);

if (count($datos['raw_X']) < 5) {
    echo json_encode(["error" => "No hay suficientes datos registrados en la base de datos para generar un modelo estadístico confiable."]);
    exit;
}

// Entrenamos el modelo con los datos normalizados
$modelo = new MotorLogistico(0.5, 3000); 
$modelo->fit($datos['norm_X'], $datos['Y']);

// 1. Datos para los puntos reales (Gráfico de dispersión)
$scatterData = [];
for ($i = 0; $i < count($datos['raw_X']); $i++) {
    $scatterData[] = [
        "x" => $datos['raw_X'][$i],
        "y" => $datos['Y'][$i]
    ];
}

// 2. Datos para dibujar la Curva Logística (La línea "S")
$lineData = [];
$pasos = 60; // Puntos para que la curva sea suave
$max_dias = $datos['max_x'];
$incremento = $max_dias / $pasos;

for ($d = 0; $d <= $max_dias; $d += $incremento) {
    $x_norm = ($max_dias > 0) ? $d / $max_dias : 0;
    $probabilidad = $modelo->predict_proba($x_norm);
    $lineData[] = [
        "x" => round($d, 1),
        "y" => round($probabilidad, 4)
    ];
}

echo json_encode([
    "scatter" => $scatterData,
    "curve" => $lineData,
    "max_dias" => $max_dias
]);
?>