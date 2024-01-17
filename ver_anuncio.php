<?php
require_once("modelos/conexionBD.php");
require_once("modelos/Anuncio.php");
require_once("modelos/AnuncioDAO.php");
require_once("modelos/config.php");

//Creamos la conexion utilizando la clase que hemos creado
$conexionBD = new ConexionBD(getenv("DB_USER"), getenv("DB_PASSWORD"), getenv("DB_HOST"), getenv("DB_DATABASE"));
$conn = $conexionBD->getConexion();

//Creamos el objecto MensajeDAO para acceder a BBDD a traves de este objeto
$anuncioDAO = new AnuncioDAO($conn);

//Obtener el mensaje
$idAnuncio = htmlspecialchars($_GET['id']);
$anuncio = $anuncioDAO->getById($idAnuncio);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Mensaje</h1>
    <p>ID: <?= $anuncio->getId()?></p>
    <p>Titulo: <?= $anuncio->getTitulo()?></p>
    <p>Descripcion <?= $anuncio->getDescripcion()?></p>
    <div><?= $anuncio->getFoto()?></div>
</body>

</html>
