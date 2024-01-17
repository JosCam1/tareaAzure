<?php
session_start();
require_once("modelos/conexionBD.php");
require_once("modelos/Usuario.php");
require_once("modelos/UsuarioDAO.php");

$error = '';

// Verificar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $conexionBD = new ConexionBD(getenv("DB_USER"), getenv("DB_PASSWORD"), getenv("DB_HOST"), getenv("DB_DATABASE"));
    $conn = $conexionBD->getConexion();

    $usuarioDAO = new UsuarioDAO($conn);
    $email = htmlentities($_POST['email']);
    $password = htmlentities($_POST['password']);

    $usuario = $usuarioDAO->getByEmail($email);

    if ($usuario && password_verify($password, $usuario->getPassword())) {
        $_SESSION['usuario'] = $usuario;
        header('Location: index.php');
        exit();
    } else {
        $error = 'Email o contraseña incorrectos';
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        /* Estilos CSS */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(to bottom, #3498db, #ffffff);
        }

        #form-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        form {
            margin-bottom: 20px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
            max-width: 300px;
        }

        form h3 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-top: 10px;
        }

        #inputR {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .inputL {
            width: 95%;
            padding: 8px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            margin-top: 20px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <?php if ($error !== '') : ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <div id="form-container">
        <form action="login.php" method="post">
            <h3>Login</h3>

            <!-- Mostrar el mensaje de error si existe -->
            <?php if ($error !== '') : ?>
                <p style="color: red;"><?php echo $error; ?></p>
            <?php endif; ?>

            <label for="email">Email</label>
            <input type="email" placeholder="Email" id="email" name="email" class="inputL">

            <label for="password">Password</label>
            <input type="password" placeholder="Password" id="password" name="password" class="inputL">

            <input type="submit" value="Login" class="inputL">
        </form>

        <form action="registrar.php" method="post">
            <input type="submit" value="Registrarse" id="inputR">
        </form>
    </div>
</body>

</html>
