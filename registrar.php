<?php
require_once("modelos/conexionBD.php");
require_once("modelos/Usuario.php");
require_once("modelos/UsuarioDAO.php");

$conexionBD = new ConexionBD(getenv("DB_USER"), getenv("DB_PASSWORD"), getenv("DB_HOST"), getenv("DB_DATABASE"));
$conn = $conexionBD->getConexion();

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuariosDAO = new UsuarioDAO($conn);

    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
    $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : '';
    $poblacion = isset($_POST['poblacion']) ? $_POST['poblacion'] : '';

    if (empty($email) || empty($password)) {
        $error = "Los campos de email y contraseña son obligatorios";
    } else {
        // Encriptar la contraseña
        $passwordEncriptada = password_hash($password, PASSWORD_DEFAULT);

        $usuario = new Usuario();
        $usuario->setEmail($email);
        $usuario->setPassword($passwordEncriptada); // Guardar la contraseña encriptada
        $usuario->setNombre($nombre);
        $usuario->setTelefono($telefono);
        $usuario->setPoblacion($poblacion);

        $insertado = $usuariosDAO->insertUsuario($usuario);

        if ($insertado) {
            // Éxito al insertar en la base de datos
            echo "Usuario insertado";
        } else {
            // Manejo de errores en caso de fallo en la inserción
            echo "Error al insertar usuario en la base de datos";
        }
    }
}
?>






<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(to bottom, #0056b3, #f4f4f4);
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
            margin: 0 auto;
        }

        h1 {
            color: white;
            text-align: center;
            margin-bottom: 20px;
        }

        input {
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            border: none;
            cursor: pointer;
            padding: 10px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Registro</h1>
        <form action="registrar.php" method="post">
            <input type="email" name="email" placeholder="Email"><br>
            <input type="password" name="password" placeholder="Password"><br>
            <input type="text" name="nombre" placeholder="Nombre"><br>
            <input type="text" name="telefono" placeholder="Telefono"><br>
            <input type="text" name="poblacion" placeholder="Poblacion"><br>
            <input type="submit" value="Registrar">
            <a href="./login.php">Volver</a>
        </form>
    </div>
</body>

</html>

