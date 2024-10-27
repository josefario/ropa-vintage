<?php
// Incluir la conexión a la base de datos
include 'db.php';

// Obtener el filtro de categoría desde la URL, si está establecido
$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';

// Construir la consulta SQL con filtro de categoría, si se ha seleccionado alguna
$sql = "SELECT nombre_producto, descripcion, precio, imagen FROM productos";
if ($categoria) {
    $sql .= " WHERE categoria = ?";
}

// Preparar y ejecutar la consulta
$stmt = $conn->prepare($sql);
if ($categoria) {
    $stmt->bind_param("s", $categoria);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mockup de Tienda</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="header-content">
            <div class="logo">
                <img src="logo.png" alt="Logo" />
            </div>
            <div class="search-bar">
                <input type="text" placeholder="Buscar">
                <button>🔍</button>
            </div>
        </div>
    </header>
    <main>
        <aside class="sidebar">
            <h2>[Categoria]</h2>
            <p>[N° de resultados]</p>
            <h3>Categorías</h3>
            <ul>
                <li><a href="?categoria=Accesorios">Accesorios</a></li>
                <li><a href="?categoria=Calzado">Calzado</a></li>
                <li><a href="?categoria=Ropa">Ropa</a></li>
            </ul>
            <h3>Precio</h3>
            <ul>
                <li><a href="?precio=max5000">Hasta $5000</a></li>
                <li><a href="?precio=5000a7500">$5000 a $7500</a></li>
                <li><a href="?precio=mas7500">Arriba de $8000</a></li>
            </ul>
        </aside>
        <section class="products">
            <?php
            // Verificar si hay resultados
            if ($result->num_rows > 0) {
                // Generar cada producto dinámicamente
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="product-card">';
                    echo '    <div class="image">';
                    echo '        <img src="stock/' . $row['imagen'] . '" alt="Producto">';
                    echo '    </div>';
                    echo '    <p class="description">' . htmlspecialchars($row['descripcion']) . '</p>';
                    echo '    <p class="price">$' . number_format($row['precio'], 2) . '</p>';
                    echo '</div>';
                }
            } else {
                echo '<p>No hay productos disponibles.</p>';
            }
            ?>
        </section>
    </main>
</body>
</html>