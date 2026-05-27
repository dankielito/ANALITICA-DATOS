<?php
require_once 'conexion_arq.php';

class PreparadorDatos {
    private $conn;

    public function __construct() {
        $database = new ConexionArq();
        $this->conn = $database->getConnection();
    }

    public function obtenerDatosEntrenamiento($tamano = 'todos') {
        $query = "SELECT tiempo_refugio_dias as X, adoptado as Y FROM perfil_animal WHERE tiempo_refugio_dias IS NOT NULL AND adoptado IS NOT NULL";
        
        if ($tamano !== 'todos') {
            $query .= " AND tamano = :tamano";
        }
        $query .= " LIMIT 800"; // Límite seguro para procesar en tiempo real

        $stmt = $this->conn->prepare($query);
        if ($tamano !== 'todos') {
            $stmt->bindParam(':tamano', $tamano);
        }
        $stmt->execute();

        $X = []; $Y = []; $max_x = 0;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $valX = (float)$row['X'];
            $X[] = $valX;
            $Y[] = (int)$row['Y'];
            if ($valX > $max_x) $max_x = $valX;
        }

        // Normalización Min-Max (Es vital para que el Descenso de Gradiente funcione)
        $X_norm = [];
        foreach ($X as $val) {
            $X_norm[] = ($max_x > 0) ? $val / $max_x : 0;
        }

        return [
            'raw_X' => $X,
            'norm_X' => $X_norm,
            'Y' => $Y,
            'max_x' => $max_x
        ];
    }
}
?>