<?php
class ClsUbigeo {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function obtenerDPyD($codUbigeo) {
        $query = "CALL obtenerDPyD(:codUbigeo)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':codUbigeo', $codUbigeo);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerDepartamentos() {
        // Solo se puede obtener los departamentos directamente desde la base de datos
        $query = "SELECT cod_ubigeo, descripcion FROM ubigeo WHERE LENGTH(cod_ubigeo) = 2"; // Suponiendo que los departamentos tienen 2 dígitos
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerProvincias($codDepartamento) {
        $query = "SELECT cod_ubigeo, descripcion FROM ubigeo WHERE cod_ubigeo_sup = :codDepartamento";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':codDepartamento', $codDepartamento);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerDistritos($codProvincia) {
        $query = "SELECT cod_ubigeo, descripcion FROM ubigeo WHERE cod_ubigeo_sup = :codProvincia";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':codProvincia', $codProvincia);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
