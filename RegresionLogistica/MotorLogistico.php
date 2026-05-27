<?php
class MotorLogistico {
    private $weights = 0.0;
    private $bias = 0.0;
    private $learningRate;
    private $iterations;

    public function __construct($learningRate = 0.5, $iterations = 5000) {
        $this->learningRate = $learningRate;
        $this->iterations = $iterations;
    }

    private function sigmoid($z) {
        // Evita desbordamientos en números muy grandes o pequeños
        if ($z < -15) return 0.00001;
        if ($z > 15) return 0.99999;
        return 1 / (1 + exp(-$z));
    }

    public function fit($X, $y) {
        $n_samples = count($X);
        if ($n_samples == 0) return;
        
        for ($i = 0; $i < $this->iterations; $i++) {
            $dw = 0; $db = 0;
            
            for ($j = 0; $j < $n_samples; $j++) {
                $linear_model = ($this->weights * $X[$j]) + $this->bias;
                $y_predicted = $this->sigmoid($linear_model);
                
                // Cálculo de gradientes
                $dw += (1 / $n_samples) * 2 * $X[$j] * ($y_predicted - $y[$j]);
                $db += (1 / $n_samples) * 2 * ($y_predicted - $y[$j]);
            }
            
            // Actualización de pesos
            $this->weights -= $this->learningRate * $dw;
            $this->bias -= $this->learningRate * $db;
        }
    }

    public function predict_proba($x_val) {
        $linear_model = ($this->weights * $x_val) + $this->bias;
        return $this->sigmoid($linear_model);
    }
}
?>