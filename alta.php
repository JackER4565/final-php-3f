<?php
session_start();

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    // Si no ha iniciado sesión, redirige al formulario de login
    header('Location: home.php'); // Ajusta la ruta según tu estructura
    exit();
}
require_once 'Modelo/Database.php';
require_once 'Controlador/Items.php';

$database = new Database();
$db = $database->getConnection();

$items = new Items($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = (float) $_POST['price']; // Asegurarse de que el precio sea float
    $category_id = (int) $_POST['category_id']; // Asegurarse de que category_id sea int
    $created = new DateTime();

    try {
        if ($items->create($name, $description, $price, $category_id, $created)) {
            header('Location: index.php');
        } else {
            echo 'Error: Unable to create item.';
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Crear item</title>
</head>
<body>
    <h1>Crear Nuevo item</h1>
    <form method="post" action="alta.php">
        <label for="name">Nombre:</label>
        <input type="text" id="name" name="name" required>
        <br>
        <label for="description">Descripcion:</label>
        <input type="text" id="description" name="description" required>
        <br>
        <label for="price">Precio:</label>
        <input type="number" step="0.01" id="price" name="price" required>
        <br>
        <label for="category_id">Categoria:</label>
        <input type="number" id="category_id" name="category_id" required>
        <br>
        <input type="submit" value="Crear">
    </form>
</body>
</html>
