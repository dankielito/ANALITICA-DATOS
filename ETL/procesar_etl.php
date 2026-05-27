<?php
header('Content-Type: application/json');
require_once 'conexion_etl.php';

$input = json_decode(file_get_contents('php://input'), true);

if (!$input || empty($input['tablas'])) {
    echo json_encode(["error" => "No se seleccionaron tablas o indicadores para procesar."]);
    exit;
}

$tablasSeleccionadas = $input['tablas'];
$database = new ConexionETL();
$resultadoFinal = [];

// FASE DE EXTRACCIÓN Y TRANSFORMACIÓN MIGRADA
try {
    // ---- BASE DE DATOS: OPERACIONAL ----
    if (in_array('estadisticas_anuales', $tablasSeleccionadas) && $database->connOp) {
        // Transformación: Hacemos un JOIN automático con estados para extraer el nombre real en vez del ID binario
        $query = "SELECT s.anio as 'Año', e.nombre_estado as 'Estado', s.poblacion_calle as 'Población en Calle', 
                         s.poblacion_hogar as 'Población en Hogar', s.costo_salud_publica as 'Costo Salud Pública ($)', 
                         s.tasa_esterilizacion as 'Tasa Esterilización (%)'
                  FROM estadisticas_anuales s 
                  LEFT JOIN estados e ON s.id_estado = e.id_estado LIMIT 500";
        $stmt = $database->connOp->prepare($query);
        $stmt->execute();
        $resultadoFinal['Estadísticas Anuales'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    if (in_array('perfil_animal', $tablasSeleccionadas) && $database->connOp) {
        // Transformación: Formateamos la salida binaria de 'adoptado' a texto comprensible
        $query = "SELECT p.id_animal as 'ID Animal', e.nombre_estado as 'Estado', p.edad_meses as 'Edad (Meses)', 
                         p.tamano as 'Tamaño', p.salud_estado as 'Estado de Salud', p.tiempo_refugio_dias as 'Días en Refugio',
                         IF(p.adoptado = 1, 'Adoptado', 'En Refugio') as 'Estatus de Adopción'
                  FROM perfil_animal p
                  LEFT JOIN estados e ON p.id_estado = e.id_estado LIMIT 500";
        $stmt = $database->connOp->prepare($query);
        $stmt->execute();
        $resultadoFinal['Perfil Animal'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ---- BASE DE DATOS: DATA WAREHOUSE ----
    if (in_array('hechos_abandono_estatal', $tablasSeleccionadas) && $database->connDwh) {
        $query = "SELECT id_hecho as 'ID Registro DWH', fk_tiempo as 'Periodo', fk_estado as 'Cód Estado', 
                         total_perros as 'Total Perros', total_gatos as 'Total Gatos', nombre_mes as 'Mes del Hecho' 
                  FROM hechos_abandono_estatal LIMIT 500";
        $stmt = $database->connDwh->prepare($query);
        $stmt->execute();
        $resultadoFinal['Abandono Estatal (DWH)'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    if (in_array('hechos_abandono_gatos', $tablasSeleccionadas) && $database->connDwh) {
        $query = "SELECT id_hecho as 'ID Registro DWH', fk_tiempo as 'Periodo', total_mensual as 'Total Gatos Mensual', nombre_mes as 'Mes' 
                  FROM hechos_abandono_gatos LIMIT 500";
        $stmt = $database->connDwh->prepare($query);
        $stmt->execute();
        $resultadoFinal['Abandono Gatos (DWH)'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    if (in_array('hechos_abandono_perros', $tablasSeleccionadas) && $database->connDwh) {
        $query = "SELECT id_hecho as 'ID Registro DWH', fk_tiempo as 'Periodo', total_mensual as 'Total Perros Mensual', nombre_mes as 'Mes' 
                  FROM hechos_abandono_perros LIMIT 500";
        $stmt = $database->connDwh->prepare($query);
        $stmt->execute();
        $resultadoFinal['Abandono Perros (DWH)'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Verificar si se logró extraer algo
    if (empty($resultadoFinal)) {
        echo json_encode(["error" => "No se pudieron recuperar datos. Verifica que las tablas contengan registros o que las conexiones sean correctas."]);
    } else {
        echo json_encode(["success" => true, "data" => $resultadoFinal]);
    }

} catch (PDOException $e) {
    echo json_encode(["error" => "Fallo en el Pipeline ETL durante la extracción: " . $e->getMessage()]);
}
?>