<?php
// Incluir la conexión a la base de datos
include 'db.php';

// Obtener los filtros desde la URL, si están establecidos
$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';
$precio = isset($_GET['precio']) ? $_GET['precio'] : '';
$buscar = isset($_GET['buscar']) ? $_GET['buscar'] : '';

// Construir la consulta SQL con filtros de categoría, precio y búsqueda
$sql = "SELECT id_producto, nombre_producto, descripcion, precio, imagen FROM productos";
$conditions = []; // Array para almacenar las condiciones de la consulta

// Agregar condición de categoría si no es "Todos"
if ($categoria && $categoria !== 'Todos') {
    $conditions[] = "categoria = ?";
}

// Agregar condición de precio según el filtro seleccionado
if ($precio) {
    switch ($precio) {
        case 'max5000':
            $conditions[] = "precio <= 5000";
            break;
        case '5000a7500':
            $conditions[] = "precio BETWEEN 5000 AND 7500";
            break;
        case 'mas7500':
            $conditions[] = "precio > 7500";
            break;
    }
}

// Agregar condición de búsqueda si hay un término de búsqueda
if ($buscar) {
    $conditions[] = "(nombre_producto LIKE ? OR descripcion LIKE ?)";
}

// Unir las condiciones con AND
if (count($conditions) > 0) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

// Preparar y ejecutar la consulta
$stmt = $conn->prepare($sql);

// Vincular parámetros de categoría y búsqueda si aplican
$bind_types = '';
$bind_values = [];
if ($categoria && $categoria !== 'Todos') {
    $bind_types .= 's';
    $bind_values[] = $categoria;
}
if ($buscar) {
    $bind_types .= 'ss';
    $search_term = '%' . $buscar . '%';
    $bind_values[] = $search_term;
    $bind_values[] = $search_term;
}

// Vincular los parámetros si existen
if ($bind_types) {
    $stmt->bind_param($bind_types, ...$bind_values);
}
$stmt->execute();
$result = $stmt->get_result();

// Contar los resultados
$num_results = $result ? $result->num_rows : 0;

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
                <form action="" method="GET">
                    <input type="text" name="buscar" placeholder="Buscar" value="<?php echo htmlspecialchars($buscar); ?>">
                    <button type="submit">🔍</button>
                </form>
            </div>
        </div>
    </header>
    <main>
        <aside class="sidebar">
            <h2>Categoría: <?php echo $categoria ? htmlspecialchars($categoria) : "Todas"; ?></h2>
            <p>N° de resultados: <?php echo $num_results; ?></p>
            <h3>Categorías</h3>
            <ul>
                <li><a href="?categoria=Todos">Todos</a></li>
                <li><a href="?categoria=Accesorios">Accesorios</a></li>
                <li><a href="?categoria=Calzado">Calzado</a></li>
                <li><a href="?categoria=Ropa">Ropa</a></li>
            </ul>
            <h3>Precio</h3>
            <ul>
                <li><a href="?precio=max5000">Hasta $5000</a></li>
                <li><a href="?precio=5000a7500">$5000 a $7500</a></li>
                <li><a href="?precio=mas7500">Arriba de $7500</a></li>
            </ul>
        </aside>
        <section class="products">
            <?php
            // Verificar si hay resultados
            if ($num_results > 0) {
                // Generar cada producto dinámicamente
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="product-card">';
                    echo '    <div class="image">';
                    echo '        <img src="stock/' . $row['imagen'] . '" alt="Producto">';
                    echo '    </div>';
                    echo '    <p class="description">' . htmlspecialchars($row['descripcion']) . '</p>';
                    echo '    <p class="price">$' . number_format($row['precio'], 2) . '</p>';

                    // Formulario de compra
                    echo '    <form action="compras/index.php" method="POST">';
                    echo '        <input type="hidden" name="id_producto" value="' . $row['id_producto'] . '">'; // Suponiendo que el ID del producto es 'id_producto'
                    echo '        <input type="hidden" name="nombre_producto" value="' . htmlspecialchars($row['nombre_producto']) . '">';
                    echo '        <input type="hidden" name="precio" value="' . $row['precio'] . '">';
                    echo '        <input type="hidden" name="imagen" value="' . $row['imagen'] . '">';
                    echo '        <button type="submit" class="buy-button">Comprar</button>';
                    echo '    </form>';

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