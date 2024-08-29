<?php
// controllers/UserController.php

// Incluir el modelo User
require_once '../models/User.php';

// Crear una conexión PDO
$pdo = new PDO('mysql:host=localhost;dbname=crud_empleados', 'root', '');
$user = new User($pdo); // Instanciar el modelo User

// Obtener la acción solicitada de la URL
$action = isset($_GET['action']) ? $_GET['action'] : '';

// Procesar la acción solicitada
if ($action === 'readAll') {
    // Leer todos los usuarios y devolver en formato JSON
    echo json_encode($user->readAll());
} elseif ($action === 'create') {
    // Crear un nuevo usuario con los datos enviados por POST
    $name = $_POST['name'];
    $adress = $_POST['adress'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $company = $_POST['company'];
    
    $user->create($name, $adress, $phone, $email, $company);
} elseif ($action === 'update') {
    // Actualizar un usuario existente con los datos enviados por POST
    $id = $_POST['id'];
    $name = $_POST['name'];
    $adress = $_POST['adress'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $company = $_POST['company'];
    $user->update($id, $name, $adress, $phone, $email, $company);
} elseif ($action === 'delete') {
    // Eliminar un usuario con el ID enviado por POST
    $id = $_POST['id'];
    $user->delete($id);
} elseif ($action === 'getCompanies') {
    // Obtener todas las empresas y devolver en formato JSON
    echo json_encode($user->getCompanies());
}
