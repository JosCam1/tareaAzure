<?php
require_once "Anuncio.php";
require_once "login.php";

class AnuncioDAO{
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function getById($id){

        if(!$stmt=$this->conexion->prepare("SELECT * FROM anuncios WHERE id=?")){
            echo "Error en la SQL: " . $this->conexion->error;
        }
        //Asociar las variables a las interrogaciones(parametros)
        $stmt->bind_param('i',$id);
        //Ejecutar la SQL
        $stmt->execute();
        //Obtener el obeto mysql_result
        $result=$stmt->get_result();

        if($result->num_rows == 1){
            $anuncio = $result->fetch_object(Anuncio::class);
            return $anuncio;
        }else{
            return null;
        }
    }

    public function getAll():array{

        if(!$stmt=$this->conexion->prepare("SELECT * FROM anuncios")){
            echo "Error en la SQL: " . $this->conexion->error;
        }
        $stmt->execute();
        $result=$stmt->get_result();

        $array_anuncios = [];

        while($anuncio = $result->fetch_object(Anuncio::class)){
            $array_anuncios[]= $anuncio;
        }
        return $array_anuncios;
    }

    public function insertAnuncio($anuncio) {
        try {
            // Preparar la consulta SQL para insertar un anuncio en la base de datos
            $stmt = $this->conexion->prepare("INSERT INTO anuncios (usuario_id, titulo, descripcion, precio, foto_principal) VALUES (?, ?, ?, ?, ?)");
    
            // Obtener los atributos del anuncio
            $idUsuario = $anuncio->getIdUsuario();
            $titulo = $anuncio->getTitulo();
            $descripcion = $anuncio->getDescripcion();
            $precio = $anuncio->getPrecio();
            $foto = $anuncio->getFoto();
    
            // Vincular los parámetros y ejecutar la consulta
            $stmt->bind_param("issss", $idUsuario, $titulo, $descripcion, $precio, $foto);
            $stmt->execute();
    
            if ($stmt->error) {
                throw new Exception("Error en la ejecución de la consulta: " . $stmt->error);
            }
            $stmt->close();
    
            return true; 
        } catch (Exception $e) {
            error_log("Error al insertar el anuncio: " . $e->getMessage());
    
            return false; 
        }
    }
}

?>