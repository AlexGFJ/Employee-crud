<?php
// 

require_once '../config/database.php';

class User {
    private $conn;

    // Constructor que recibe el objeto PDO de la base de datos
    public function __construct($pdo) {
        $this->conn = $pdo;
    }

    // Método para obtener todos los usuarios
    public function readAll() {
        $query = 'SELECT empleados.*, empresa.nombre AS empresa FROM empleados 
        LEFT JOIN empresa ON empleados.Id_empresa = empresa.Id_empresa 
        WHERE empleados.status = 0 '; // Consulta SQL para seleccionar todos los empleados
        $stmt = $this->conn->prepare($query); // Preparar la consulta
        $stmt->execute(); // Ejecutar la consulta
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Devolver todos los resultados en formato asociativo
    }
    // Nuevo método para obtener todas las empresas
    public function getCompanies() {
        $query = 'SELECT * FROM empresa'; // Consulta SQL para seleccionar todos las empresas
        $stmt = $this->conn->prepare($query); // Preparar la consulta
        $stmt->execute(); // Ejecutar la consulta
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para crear un nuevo usuario
    public function create($name, $adress, $phone, $email, $company) {
        $query = 'INSERT INTO empleados (nombre, direccion, telefono, email, Id_empresa, status) VALUES (?, ?, ?, ?, ?, 0)'; // Consulta SQL con marcadores de posición
        $stmt = $this->conn->prepare($query); // Preparar la consulta
        $stmt->execute([$name, $adress, $phone, $email, $company]); // Ejecutar la consulta con los valores en el mismo orden de los marcadores
        return $stmt->rowCount(); // Retornar el número de filas afectadas
    }

    // Método para actualizar un usuario existente
    public function update($id, $name, $adress, $phone, $email, $company) {
        $query = 'UPDATE empleados SET nombre = ?, direccion = ?, telefono = ?, email = ?, Id_empresa = ? WHERE Id_empleado = ?'; // Corregido el nombre de la columna
        $stmt = $this->conn->prepare($query); // Preparar la consulta
        $stmt->execute([$name, $adress, $phone, $email, $company, $id]); // Ejecutar la consulta con los valores
        return $stmt->rowCount(); // Retornar el número de filas afectadas
    }
    

    // Método para eliminar un usuario
    public function delete($id) {
        $query = 'UPDATE empleados SET status=1 WHERE Id_empleado = ?'; // Consulta SQL para la eliminacion logica del registro
        $stmt = $this->conn->prepare($query); // Preparar la consulta
        $stmt->execute([$id]); // Ejecutar la consulta con el valor del marcador
        return $stmt->rowCount(); // Retornar el número de filas afectadas
    }
}
