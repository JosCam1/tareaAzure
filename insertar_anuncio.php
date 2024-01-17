<?php
require_once "modelos/Usuario.php";
require_once "modelos/Anuncio.php";
require_once "modelos/AnuncioDAO.php";

$error = '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $titulo = htmlentities($_POST('titulo'));
    $descripcion = htmlentities($_POST('descripcion'));
    $precio = htmlentities($_POST('foto'));
    $foto = htmlentities($_POST('foto'));
    $idUsuario = isset($_SESSION['usuario']) ? $_SESSION['usuario']->getId() : '';

    $anuncio = new Anuncio();
    $anuncio($idUsuario,$titulo,$descripcion,$precio,$foto);
    $anuncioDAO = new AnuncioDAO($anuncio);
    $anuncioDAO->insertAnuncio($anuncio);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <style>
    </style>
</head>
<body>
    <form action="insertar_anuncio.php" method="post">
        <h3>Crear Anuncio</h3>

        <input type="text" placeholder="Titulo" id="titulo" name="titulo">
        <input type="text" placeholder="Descripción del producto" id="descripcion" name="descripcion">
        <input type="number" placeholder="Precio €" id="precio" name="precio">
        <input type="file" placeholder="Inserte la foto principal" id="foto" name="foto">
        <input type="submit" value="Crear Anuncio"><a href="./index.php">Volver</a>
    </form>
</body>
</html>