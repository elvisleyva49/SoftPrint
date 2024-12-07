<?php
class ClsUsuario {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function guardarUsuario($email, $password, $codigoConfirmacion) {
        // Hash de la contraseña
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
        // Valores estáticos para tipo y estado
        $tipo = 'cliente'; // Tipo de usuario
        $estado = 'activo'; // Estado del usuario
    
        // Insertar el usuario en la base de datos
        $stmt = $this->conn->prepare("INSERT INTO usuario (email, pass, cod_confirmacion, tipo, estado) VALUES (:email, :pass, :codigoConfirmacion, :tipo, :estado)");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':pass', $hashedPassword); // Usar la variable aquí
        $stmt->bindParam(':codigoConfirmacion', $codigoConfirmacion);
        $stmt->bindParam(':tipo', $tipo); // Usar el tipo estático
        $stmt->bindParam(':estado', $estado); // Usar el estado estático
        
        // Ejecutar la consulta e imprimir en la terminal
        $result = $stmt->execute(); // Devuelve true si la inserción fue exitosa
    
        // Imprimir en la terminal
        if ($result) {
            echo "Usuario guardado exitosamente:\n";
            echo "Email: $email\n";
            echo "Contraseña (hashed): $hashedPassword\n";
            echo "Código de confirmación: $codigoConfirmacion\n";
            echo "Tipo: $tipo\n";
            echo "Estado: $estado\n";
        } else {
            echo "Error al guardar el usuario.\n";
        }
    
        return $result;
    }
    
    public function obtenerTrabajadores() {
        $query = "SELECT id_empleado, nombre, apellido FROM empleado WHERE cargo = 'diseñador'"; // Asegúrate de que el nombre de la tabla sea correcto
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function validarCodigo($email, $codigo) {
        $stmt = $this->conn->prepare("SELECT cod_confirmacion FROM usuario WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $stmt->bindColumn(1, $codConfirmacion); // Vincular el resultado a una variable

        if ($stmt->fetch(PDO::FETCH_BOUND)) {
            echo "Código de confirmación encontrado: $codConfirmacion\n"; // Imprimir el código encontrado
            return $codConfirmacion == $codigo; // Comparar el código
        }
        return false; // No se encontró el email
    }

    public function iniciarSesion($email, $password) {
        // Consulta para obtener el hash de la contraseña y otros datos del usuario
        $stmt = $this->conn->prepare("SELECT id_usuario, estado, tipo, pass FROM usuario WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
    
        // Verifica si hay resultados
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $hashedPassword = $row['pass'];
    
            // Verificar la contraseña proporcionada contra el hash
            if (password_verify($password, $hashedPassword)) {
                // Si la contraseña es correcta, puedes devolver los datos del usuario
                return [
                    'id_usuario' => $row['id_usuario'],
                    'estado' => $row['estado'],
                    'tipo' => $row['tipo'],
                ]; // Devuelve los datos del usuario
            }
        }
    
        return false; // Credenciales incorrectas
    }
    
    public function CargarDatosCliente($idusuario){
        $stmt = $this->conn->prepare("SELECT * from cliente WHERE id_usuario = :idusuario");
        $stmt->bindParam(':idusuario', $idusuario);
        $stmt->execute();   
        $datoscliente = $stmt->fetch(PDO::FETCH_ASSOC);
        return $datoscliente;
    }
    
    

    public function obtenerIdUsuarioPorEmail($email) {
        $stmt = $this->conn->prepare("SELECT id_usuario FROM usuario WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            return $stmt->fetchColumn(); // Retorna el id_usuario
        }
        return null; // No se encontró el usuario
    }
    
}
?>
