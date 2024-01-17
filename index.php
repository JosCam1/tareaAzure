<?php
require_once 'modelos/Usuario.php';
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    // Si no hay sesión iniciada, redirigir al login
    header('Location: login.php');
    exit();
}

// Si la sesión está iniciada, obtener el nombre de usuario
$nombreUsuario = isset($_SESSION['usuario']) ? $_SESSION['usuario']->getNombre() : '';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wallapop</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        /* Estilos del encabezado */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #fff;
            padding: 20px;
            text-align: center;
            background: linear-gradient(to bottom, #0056b3, #f4f4f4);
        }

        #logo {
            width: 200px;
            height: 100px;
        }

        #user {
            height: 40px;
            width: auto;
        }

        #bienvenido {
            display: flex;
            align-items: center;
            color: #fff;
        }

        #bienvenido p {
            margin-right: 10px;
        }

        /* Estilos de la barra de navegación */
        nav {
            background-color: #333;
            color: #fff;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            margin-right: 10px;
        }

        /* Estilos del contenido principal */
        #anuncios {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            grid-gap: 20px;
            padding: 20px;
            background: linear-gradient(to bottom, #0056b3, #f4f4f4);
        }

        .anuncio {
            background-color: #fff;
            border-radius: 5px;
            padding: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 10px;
        }

        .anuncio .titulo a {
            text-decoration: none;
            color: #333;
        }

        .anuncio .descripcion {
            color: #666;
        }

        .precio {
            color: red;
        }

        #insert {
            text-align: center;
        }
    </style>
</head>

<body>
    <header>
        <img src="./images/logo.png" alt="Logo" id="logo">
        <div id="bienvenido">
            <p>Bienvenido, <?php echo $nombreUsuario; ?>!</p>
            <img src="./images/usuario.png" alt="icono" id='user'>
        </div>
    </header>
    <nav>
        <a href="#">Anuncios</a>
        <a href="#">Mis Anuncios</a>
        <a href="./login.php">Iniciar Sesion</a>
    </nav>
    <div id="anuncios">
        <form action="insertar_anuncio.php" id="insert">
            <input type="submit" value="CREAR NUEVO ANUNCIO">
        </form>
    </div>
</body>

</html>
