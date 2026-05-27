<?php
class ConexionETL {
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    
    private $db_operacional = "analitca_animales_bd";
    private $db_dwh = "dwh_analitica_animales";
    
    public $connOp = null;
    public $connDwh = null;

    public function __construct() {
        // Conexión a Base de Datos Operacional
        try {
            $this->connOp = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_operacional, $this->username, $this->password);
            $this->connOp->exec("set names utf8");
            $this->connOp->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            $this->connOp = null;
        }

        // Conexión al Data Warehouse
        try {
            $this->connDwh = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_dwh, $this->username, $this->password);
            $this->connDwh->exec("set names utf8");
            $this->connDwh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            $this->connDwh = null;
        }
    }
}
?>