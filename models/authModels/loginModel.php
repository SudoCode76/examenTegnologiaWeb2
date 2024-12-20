<?php
require_once __DIR__ . '/../../config/conexion.php';

class LoginModel {
    private $conn;

    public function __construct(){
        global $conexion;
        $this->conn = $conexion;
    }

    public function login($usuario, $password){
        $sql = " SELECT * FROM USUARIO JOIN PERFIL ON USUARIO.id_perfil = PERFIL.id_perfil WHERE USUARIO.USUARIO = ? AND USUARIO.password =?";


        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $usuario, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        return $user;
    }
}
?>
