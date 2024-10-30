<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>Bienvenido</h1>
            <p>Inicia sesión en tu cuenta</p>
        </div>
        <form class="login-form" action="login.php" method="POST">
            <label for="username">Usuario</label>
            <input type="text" id="username" name="username" placeholder="Ingresa tu usuario" required>
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" placeholder="Ingresa tu contraseña" required>
            <button type="submit">Iniciar Sesión</button>
        </form>
        <p class="signup-link">¿No tienes una cuenta? <a href="#">Regístrate aquí</a></p>
    </div>
</body>
</html>