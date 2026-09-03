<?php
// ── Conexión a MySQL ─────────────────────────────────────────
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'mesa_partes');

function getDB(): mysqli {
    static $conn = null;
    if ($conn === null) {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($conn->connect_error) {
            http_response_code(500);
            die('<p style="font-family:monospace;padding:2rem;color:#7f1d1d;">
                 Error de BD: ' . htmlspecialchars($conn->connect_error) . '<br>
                 Ejecute <a href="/m-partes-sang/install.php">install.php</a> primero.</p>');
        }
        $conn->set_charset('utf8mb4');
    }
    return $conn;
}
