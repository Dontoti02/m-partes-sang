<?php
// ── Controller: Admin ────────────────────────────────────────
class AdminController extends Controller {

    private Expediente    $expedienteModel;
    private Administrador $adminModel;

    public function __construct() {
        $this->expedienteModel = new Expediente();
        $this->adminModel      = new Administrador();
    }

    // ── Login ─────────────────────────────────────────────────
    public function login(): void {
        if (!empty($_SESSION['admin_id'])) {
            $this->redirect('admin');
        }

        $error = '';

        if ($this->isPost()) {
            $usuario  = $this->post('usuario');
            $password = $this->post('password');

            if (!$usuario || !$password) {
                $error = 'Ingrese usuario y contraseña.';
            } else {
                $admin = $this->adminModel->findByUsuario($usuario);
                if (!$admin || !$this->adminModel->verifyPassword($password, $admin['password'])) {
                    $error = 'Usuario o contraseña incorrectos.';
                } else {
                    $_SESSION['admin_id']     = $admin['id'];
                    $_SESSION['admin_nombre'] = $admin['nombre'];
                    session_regenerate_id(true);
                    $this->redirect('admin');
                }
            }
        }

        $this->render('admin/login', compact('error'));
    }

    // ── Dashboard (lista de expedientes) ──────────────────────
    public function dashboard(): void {
        $this->requireAdmin();

        $filtro   = $this->get('filtro');
        $busqueda = $this->get('q');

        $expedientes = $this->expedienteModel->all($filtro, $busqueda);
        $stats       = $this->expedienteModel->countByEstado();

        $this->render('admin/dashboard', compact('expedientes', 'stats', 'filtro', 'busqueda'));
    }

    // ── Ver / Resolver expediente ──────────────────────────────
    public function ver(): void {
        $this->requireAdmin();

        $id = (int)$this->get('id');
        if (!$id) {
            $this->redirect('admin');
        }

        $expediente = $this->expedienteModel->findById($id);
        if (!$expediente) {
            $this->redirect('admin');
        }

        $msg   = '';
        $error = '';

        if ($this->isPost()) {
            $accion     = $this->post('accion');
            $comentario = $this->post('comentario');

            if (!in_array($accion, ['aprobado','rechazado'], true)) {
                $error = 'Acción no válida.';
            } elseif ($accion === 'rechazado' && $comentario === '') {
                $error = 'Debe ingresar un comentario para rechazar el expediente.';
            } else {
                if ($this->expedienteModel->updateEstado($id, $accion, $comentario)) {
                    $expediente['estado']     = $accion;
                    $expediente['comentario'] = $comentario;
                    $expediente['updated_at'] = date('Y-m-d H:i:s');
                    $msg = $accion === 'aprobado'
                         ? 'Visto bueno otorgado al expediente.'
                         : 'Expediente rechazado correctamente.';
                } else {
                    $error = 'No se pudo actualizar el expediente.';
                }
            }
        }

        $this->render('admin/ver', compact('expediente', 'msg', 'error'));
    }

    // ── Eliminar expediente (individual) ──────────────────────
    public function delete(): void {
        $this->requireAdmin();

        if (!$this->isPost()) {
            $this->redirect('admin');
        }

        $id = (int)$this->post('id');
        if (!$id) {
            $this->redirect('admin');
        }

        $exp = $this->expedienteModel->findById($id);
        if ($exp) {
            if (!empty($exp['archivo'])) {
                $ruta = UPLOAD_PATH . $exp['archivo'];
                if (file_exists($ruta) && is_file($ruta)) @unlink($ruta);
            }
            $this->expedienteModel->delete([$id]);
        }

        $_SESSION['flash_ok'] = 'Expediente eliminado correctamente.';
        $this->redirect('admin');
    }

    // ── Eliminar expedientes en masa ─────────────────────────
    public function deleteMasivo(): void {
        $this->requireAdmin();

        if (!$this->isPost()) {
            $this->redirect('admin');
        }

        $ids = $_POST['ids'] ?? [];
        if (!is_array($ids) || empty($ids)) {
            $_SESSION['flash_err'] = 'Seleccione al menos un expediente.';
            $this->redirect('admin');
        }

        $ids = array_map('intval', $ids);
        $ids = array_filter($ids, fn($v) => $v > 0);

        if (empty($ids)) {
            $_SESSION['flash_err'] = 'IDs no válidos.';
            $this->redirect('admin');
        }

        // Eliminar archivos físicos
        foreach ($ids as $id) {
            $exp = $this->expedienteModel->findById($id);
            if ($exp && !empty($exp['archivo'])) {
                $ruta = UPLOAD_PATH . $exp['archivo'];
                if (file_exists($ruta) && is_file($ruta)) @unlink($ruta);
            }
        }

        $eliminados = $this->expedienteModel->delete($ids);
        $_SESSION['flash_ok'] = "$eliminados expediente(s) eliminado(s) correctamente.";
        $this->redirect('admin');
    }

    // ─ Logout ────────────────────────────────────────────────
    public function logout(): void {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $p = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $p['path'], $p['domain'], $p['secure'], $p['httponly']);
        }
        session_destroy();
        $this->redirect('admin/login');
    }
}
