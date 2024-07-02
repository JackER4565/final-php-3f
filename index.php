<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    echo '<script>alert("Sesión no iniciada")</script>';
    header('Location: home.php');
    exit();
} 
require_once 'Modelo/Database.php';
require_once 'Controlador/Items.php';

$database = new Database();
$db = $database->getConnection();

$items = new Items($db);
$result = $items->read();

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>CRUD PHP</title>
    <style>
    .boton {
  background: none!important;
  border: none;
  padding: 0!important;
  /*optional*/
  font-family: arial, sans-serif;
  /*input has OS specific font-family*/
  color: #069;
  text-decoration: underline;
  cursor: pointer;
}
    </style>
</head>
<body>
    <h1>Lista de items</h1>
    <a href="alta.php">Crear Nuevo item</a>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripcion</th>
            <th>Precio</th>
            <th>Categoria</th>
            <th>Acciones</th>
        </tr>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($item = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $item['id']; ?></td>
                <td><?php echo $item['name']; ?></td>
                <td><?php echo $item['description']; ?></td>
                <td><?php echo $item['price']; ?></td>
                <td><?php echo $item['category_id']; ?></td>
                <td>
                    <a href="modificar.php?id=<?php echo $item['id']; ?>">Modificar</a>
                    <a href="Vista/delete.php?id=<?php echo $item['id']; ?>">Eliminar</a>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">No hay items.</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>
