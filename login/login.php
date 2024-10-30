<?php
// Incluir el archivo de conexión a la base de datos
include 'db.php';

// Verificar si se enviaron los datos de inicio de sesión
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Preparar la consulta para buscar el usuario en la base de datos
    $sql = "SELECT * FROM usuarios WHERE nombre_cliente = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si se encontró el usuario
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Verificar la contraseña sin hash
        if ($password === $user['contraseña']) {
            // Credenciales correctas, redirigir a la página principal
            header("Location: ../");
            exit();
        } else {
            // Contraseña incorrecta
            echo "<p style='color:red;'>Contraseña incorrecta.</p>";
        }
    } else {
        // Usuario no encontrado
        echo "<p style='color:red;'>Usuario no encontrado.</p>";
    }

    // Cerrar la conexión
    $stmt->close();
    $conn->close();
}
?>