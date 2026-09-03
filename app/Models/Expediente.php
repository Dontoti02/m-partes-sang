<?php
// ── Model: Expediente ────────────────────────────────────────
class Expediente {

    private mysqli $db;

    public function __construct() {
        $this->db = getDB();
    }

    /** Crear nuevo expediente. Retorna código asignado o false */
    public function create(array $data): string|false {
        $codigo = $this->generarCodigo();

        $stmt = $this->db->prepare(
            "INSERT INTO expedientes
             (codigo, nombres, apellidos, dni, telefono, email, asunto, descripcion, archivo, ip)
             VALUES (?,?,?,?,?,?,?,?,?,?)"
        );
        $stmt->bind_param('ssssssssss',
            $codigo,
            $data['nombres'],
            $data['apellidos'],
            $data['dni'],
            $data['telefono'],
            $data['email'],
            $data['asunto'],
            $data['descripcion'],
            $data['archivo'],
            $data['ip']
        );

        return $stmt->execute() ? $codigo : false;
    }

    /** Buscar por ID */
    public function findById(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM expedientes WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc() ?: null;
    }

    /** Buscar por código público (para consulta ciudadana) */
    public function findByCodigo(string $codigo): ?array {
        $stmt = $this->db->prepare("SELECT * FROM expedientes WHERE codigo = ?");
        $stmt->bind_param('s', $codigo);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc() ?: null;
    }

    /** Listar expedientes con filtros opcionales */
    public function all(string $estado = '', string $busqueda = ''): array {
        $where  = [];
        $params = [];
        $types  = '';

        if ($estado && in_array($estado, ['pendiente','aprobado','rechazado'], true)) {
            $where[]  = 'estado = ?';
            $params[] = $estado;
            $types   .= 's';
        }

        if ($busqueda !== '') {
            $b        = "%{$busqueda}%";
            $where[]  = '(codigo LIKE ? OR nombres LIKE ? OR apellidos LIKE ? OR dni LIKE ?)';
            $params   = array_merge($params, [$b, $b, $b, $b]);
            $types   .= 'ssss';
        }

        $sql = 'SELECT * FROM expedientes';
        if ($where) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }
        $sql .= ' ORDER BY created_at DESC';

        $stmt = $this->db->prepare($sql);
        if ($params) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /** Actualizar estado y comentario */
    public function updateEstado(int $id, string $estado, string $comentario): bool {
        $stmt = $this->db->prepare(
            "UPDATE expedientes SET estado=?, comentario=?, updated_at=NOW() WHERE id=?"
        );
        $stmt->bind_param('ssi', $estado, $comentario, $id);
        return $stmt->execute();
    }

    /** Conteo por estado */
    public function countByEstado(): array {
        $totals = ['total' => 0, 'pendiente' => 0, 'aprobado' => 0, 'rechazado' => 0];
        $res    = $this->db->query(
            "SELECT estado, COUNT(*) c FROM expedientes GROUP BY estado"
        );
        while ($row = $res->fetch_assoc()) {
            if (isset($totals[$row['estado']])) {
                $totals[$row['estado']] = (int)$row['c'];
                $totals['total'] += (int)$row['c'];
            }
        }
        return $totals;
    }

    /** Eliminar uno o varios expedientes */
    public function delete(array $ids): int {
        if (empty($ids)) return 0;
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $stmt = $this->db->prepare("DELETE FROM expedientes WHERE id IN ($placeholders)");
        $types = str_repeat('i', count($ids));
        $stmt->bind_param($types, ...$ids);
        $stmt->execute();
        return $stmt->affected_rows;
    }

    /** Generar código único MP-YYYY-NNNN */
    private function generarCodigo(): string {
        do {
            $codigo = 'MP-' . date('Y') . '-' . str_pad(random_int(1, 9999), 4, '0', STR_PAD_LEFT);
            $chk    = $this->db->prepare("SELECT id FROM expedientes WHERE codigo=?");
            $chk->bind_param('s', $codigo);
            $chk->execute();
            $chk->store_result();
        } while ($chk->num_rows > 0);

        return $codigo;
    }
}
