<?php
// install.php — Ejecutar una sola vez para crear la base de datos
$conn = new mysqli('localhost', 'root', '');
if ($conn->connect_error) die('Error: ' . $conn->connect_error);

$sql = "
CREATE DATABASE IF NOT EXISTS mesa_partes_sangarara CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE mesa_partes_sangarara;

CREATE TABLE IF NOT EXISTS expedientes (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    codigo      VARCHAR(20) UNIQUE NOT NULL,
    nombres     VARCHAR(120) NOT NULL,
    apellidos   VARCHAR(120) NOT NULL,
    dni         VARCHAR(12) NOT NULL,
    telefono    VARCHAR(20),
    email       VARCHAR(120),
    asunto      VARCHAR(255) NOT NULL,
    descripcion TEXT,
    archivo     VARCHAR(255) NULL DEFAULT NULL,
    estado      ENUM('pendiente','aprobado','rechazado') DEFAULT 'pendiente',
    comentario  TEXT,
    ip          VARCHAR(45),
    created_at  DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at  DATETIME ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS administradores (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    usuario     VARCHAR(60) UNIQUE NOT NULL,
    password    VARCHAR(255) NOT NULL,
    nombre      VARCHAR(120) NOT NULL,
    created_at  DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT IGNORE INTO administradores (usuario, password, nombre)
VALUES ('admin', '" . password_hash('admin123', PASSWORD_DEFAULT) . "', 'Administrador Mesa de Partes');
";

// Ejecutar multi-query
if ($conn->multi_query($sql)) {
    do { if ($res = $conn->store_result()) $res->free(); } while ($conn->next_result());
}

if ($conn->errno) {
    echo '<div style="font-family:sans-serif;padding:2rem;color:#c0392b;"><h2>Error</h2><p>'.$conn->error.'</p></div>';
} else {
    echo '<div style="font-family:sans-serif;padding:2rem;background:#eafaf1;border-radius:10px;max-width:500px;margin:3rem auto;">
        <h2 style="color:#27ae60;">✅ Instalación Completada</h2>
        <p>Base de datos <strong>mesa_partes</strong> creada exitosamente.</p>
        <p>Usuario admin: <strong>admin</strong> / Contraseña: <strong>admin123</strong></p>
        <p style="color:#e74c3c;font-weight:bold;">⚠ Elimine este archivo (install.php) luego de instalar.</p>
        <a href="index.php" style="display:inline-block;margin-top:1rem;padding:.7rem 1.5rem;background:#2c3e8c;color:#fff;border-radius:6px;text-decoration:none;">Ir al Sistema →</a>
    </div>';
}
$conn->close();
