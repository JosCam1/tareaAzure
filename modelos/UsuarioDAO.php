<?php
class UsuarioDAO {
    private mysqli $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getById($id): ?Usuario {
        return null; // Implementa la lógica para obtener un usuario por su ID si es necesario
    }

    public function insertUsuario(Usuario $usuario) {
        $sql = "INSERT INTO usuarios (email, password, nombre, telefono, poblacion) VALUES (?, ?, ?, ?, ?)";

        if (!$stmt = $this->conn->prepare($sql)) {
            die("Error al preparar la consulta insert: " . $this->conn->error);
        }

        $email = $usuario->getEmail();
        $password = $usuario->getPassword();
        $nombre = $usuario->getNombre();
        $telefono = $usuario->getTelefono();
        $poblacion = $usuario->getPoblacion();

        $stmt->bind_param('sssss', $email, $password, $nombre, $telefono, $poblacion);

        if ($stmt->execute()) {
            return $stmt->insert_id; // Devuelve el ID del usuario insertado
        } else {
            return false; // Retorna false si hay un error en la inserción
        }
    }

    public function getByEmail($email):Usuario|null {
        if (!$stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE email = ?")) {
            echo "Error en la SQL: " . $this->conn->error;
            return null;
        }
    
        // Asociar las variables a las interrogaciones (parámetros)
        $stmt->bind_param('s', $email);
    
        // Ejecutamos la SQL
        $stmt->execute();
    
        // Obtener el resultado de la consulta
        $result = $stmt->get_result();
    
        // Verificar si se encontraron resultados
        if ($result->num_rows >= 1) {
            // Obtener los datos del usuario desde la base de datos
            $userData = $result->fetch_assoc();
    
            // Crear un objeto Usuario y asignar los datos
            $usuario = new Usuario();
            $usuario->setId($userData['id']);
            $usuario->setEmail($userData['email']);
            $usuario->setPassword($userData['password']);
            $usuario->setNombre($userData['nombre']);
            $usuario->setTelefono($userData['telefono']);
            $usuario->setPoblacion($userData['poblacion']);
    
            return $usuario;
        } else {
            return null;
        }
    } 
}
?>