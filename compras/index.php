<?php
// Incluir el archivo de conexión a la base de datos
include '../db.php';

// Verificar si se enviaron los datos del producto
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_producto = $_POST['id_producto'];
    $nombre_producto = $_POST['nombre_producto'];
    $precio = $_POST['precio'];
    $imagen = $_POST['imagen'];
} else {
    // Si no se envió el formulario correctamente, redirigir a la página principal
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Compra - Mockup de Tienda</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="header-content">
            <div class="logo">
                <img src="../logo.png" alt="Logo" />
            </div>
            <div class="search-bar">
                <form action="../index.php" method="GET">
                    <input type="text" name="buscar" placeholder="Buscar">
                    <button type="submit">🔍</button>
                </form>
            </div>
        </div>
    </header>
    <main>
        <section class="confirmation">
            <h1>¡Compra Confirmada!</h1>
            <p>Gracias por tu compra. A continuación se muestran los detalles de tu pedido:</p>
            <div class="product-confirmation-card">
                <div class="image">
                    <img src="../stock/<?php echo htmlspecialchars($imagen); ?>" alt="<?php echo htmlspecialchars($nombre_producto); ?>">
                </div>
                <p class="product-name"><?php echo htmlspecialchars($nombre_producto); ?></p>
                <p class="price">$<?php echo number_format($precio, 2); ?></p>
            </div>
            <a href="../index.php" class="back-button">Volver a la tienda</a>
        </section>
    </main>
</body>
</html>
