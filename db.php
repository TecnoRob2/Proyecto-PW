<?php
// Configuración de la base de datos. Ajusta usuario/contraseña si tu XAMPP usa credenciales distintas.
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'festival_pw');

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS);
if ($mysqli->connect_error) {
    die('Error de conexión a la base de datos: ' . $mysqli->connect_error);
}

// Si ya tienes la base de datos creada en phpMyAdmin, este código solo la selecciona.
if (! $mysqli->select_db(DB_NAME)) {
    die('No se pudo seleccionar la base de datos: ' . $mysqli->error);
}

$createTable = "CREATE TABLE IF NOT EXISTS `usuario_registrado` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(120) NOT NULL,
    `email` VARCHAR(180) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `role` ENUM('admin', 'user') NOT NULL DEFAULT 'user',
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

if (! $mysqli->query($createTable)) {
    die('No se pudo crear la tabla usuario_registrado: ' . $mysqli->error);
}

function getConnection() {
    global $mysqli;
    return $mysqli;
}
