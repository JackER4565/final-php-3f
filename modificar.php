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

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $items->read($id);
    $item = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];
    $created = new DateTime();

    try {
        $items->update($id, $name, $description, $price, $category_id, $created);
        header('Location: index.php');
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Modificar item</title>
</head>
<body>
    <h1>Modificar item</h1>
    <form method="post" action="modificar.php">
        <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
        <label for="name">Nombre:</label>
        <input type="text" id="name" name="name" value="<?php echo $item['name']; ?>" required>
        <br>
        <label for="description">Descripcion:</label>
        <input type="text" id="description" name="description" value="<?php echo $item['description']; ?>" required>
        <br>
        <label for="price">Precio:</label>
        <input type="number" step="0.01" id="price" name="price" value="<?php echo $item['price']; ?>" required>
        <br>
        <label for="category_id">Categoria:</label>
        <input type="number" id="category_id" name="category_id" value="<?php echo $item['category_id']; ?>" required>
        <br>
        <input type="submit" value="Actualizar">
    </form>
</body>
</html>
