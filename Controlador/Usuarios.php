<?php
class Usuarios {
    private $conn;
    private $table_name = "users";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para buscar usuario por nombre de usuario o email
    public function buscarUsuario($usuario, $email) {
 
        $query = "SELECT * FROM " . $this->table_name . " WHERE username = ? OR user_email = ? LIMIT 0,1";

        // Preparar la consulta
        $stmt = $this->conn->prepare($query);

        // Verificar si la preparación de la consulta fue exitosa
        if (!$stmt) {
            die('Error en la preparacion de la consulta: ' . $this->conn->error);
        }

        // Bind de parámetros
        $stmt->bind_param("ss", $usuario, $email);

        // Ejecutar la consulta
        $stmt->execute();
        $result = $stmt->get_result();

        // Si se encuentra el usuario
        if ($result->num_rows > 0) {
            // Obtener la fila asociativa
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }
}
?>