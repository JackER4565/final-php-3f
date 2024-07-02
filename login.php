<?php
session_start();

require_once 'Modelo/Database.php'; // Ajusta la ruta seg�n tu estructura
require_once 'Controlador/Usuarios.php'; // Ajusta la ruta seg�n tu estructura

$database = new Database();
$db = $database->getConnection();

$usuario = new Usuarios($db); // Ajusta el nombre de la clase y la instancia seg�n tu estructura

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario_input = $_POST['usuario'];
    $email_input= $_POST['email'];

    // Verifica si el usuario existe en la base de datos
    $result = $usuario->buscarUsuario($usuario_input, $email_input);
	                            
    if ($result) {
        // Verifica la contrase�a utilizando la funci�n password_verify si usaste hash para almacenar la contrase�a
                    
        if ($email_input == $result['user_email']) {
                            
            // Login exitoso: guarda informaci�n del usuario en la sesi�n
            $_SESSION['id_usuario'] = $result['user_id'];
            $_SESSION['nombre_usuario'] = $result['username'];
           
            // Redirige al usuario a la p�gina de inicio o a otra p�gina protegida

            header('Location: index.php');
            exit();
        } else {
            // Contrase�a incorrecta
            echo 'Usuario o mail incorrectos.';
        }
    } else {
        // Usuario no encontrado
        echo 'Usuario o mail incorrectos.';
    }
}
?>
