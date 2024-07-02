<?php
session_start();

require_once 'Modelo/Database.php'; // Ajusta la ruta según tu estructura
require_once 'Controlador/Usuarios.php'; // Ajusta la ruta según tu estructura

$database = new Database();
$db = $database->getConnection();

$usuario = new Usuarios($db); // Ajusta el nombre de la clase y la instancia según tu estructura

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario_input = $_POST['usuario'];
    $email_input= $_POST['email'];

    // Verifica si el usuario existe en la base de datos
    $result = $usuario->buscarUsuario($usuario_input, $email_input);
	                            
    if ($result) {
        // Verifica la contraseña utilizando la función password_verify si usaste hash para almacenar la contraseña
                    
        if ($email_input == $result['user_email']) {
                            
            // Login exitoso: guarda información del usuario en la sesión
            $_SESSION['id_usuario'] = $result['user_id'];
            $_SESSION['nombre_usuario'] = $result['username'];
           
            // Redirige al usuario a la página de inicio o a otra página protegida

            header('Location: index.php');
            exit();
        } else {
            // Contraseña incorrecta
            echo 'Usuario o mail incorrectos.';
        }
    } else {
        // Usuario no encontrado
        echo 'Usuario o mail incorrectos.';
    }
}
?>
