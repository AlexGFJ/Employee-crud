<?php

// Parámetros de conexión a la base de datos
$host = 'localhost'; // Cambia esto si tu servidor es diferente
$dbname = 'crud_empleados'; // Nombre de base de datos
$username = 'root'; //Nombre de usuario de la base de datos
$password = ''; // Tu contraseña de la base de datos

try {
    // Crear una nueva conexión PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Configurar PDO para lanzar excepciones en caso de errores
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Mostrar mensaje de error si la conexión falla
    echo 'Connection failed: ' . $e->getMessage();
}