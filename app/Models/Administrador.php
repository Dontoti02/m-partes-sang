<?php
// ── Model: Administrador ─────────────────────────────────────
class Administrador {

    private mysqli $db;

    public function __construct() {
        $this->db = getDB();
    }

    public function findByUsuario(string $usuario): ?array {
        $stmt = $this->db->prepare(
            "SELECT id, nombre, password FROM administradores WHERE usuario = ?"
        );
        $stmt->bind_param('s', $usuario);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc() ?: null;
    }

    public function verifyPassword(string $plain, string $hash): bool {
        return password_verify($plain, $hash);
    }
}
