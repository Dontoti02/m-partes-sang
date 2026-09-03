<?php
// ── Base Controller ──────────────────────────────────────────
abstract class Controller {

    /** Renderiza una vista pasándole variables */
    protected function render(string $view, array $data = []): void {
        extract($data, EXTR_SKIP);
        $path = VIEW_PATH . $view . '.php';
        if (!file_exists($path)) {
            throw new RuntimeException("Vista no encontrada: $view");
        }
        require $path;
    }

    /** Redirección interna al BASE_URL */
    protected function redirect(string $path = ''): void {
        header('Location: ' . BASE_URL . ltrim($path, '/'));
        exit;
    }

    /** Proteger rutas de admin */
    protected function requireAdmin(): void {
        if (empty($_SESSION['admin_id'])) {
            $this->redirect('admin/login');
        }
    }

    protected function isPost(): bool {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    protected function post(string $key, string $default = ''): string {
        return trim((string)($_POST[$key] ?? $default));
    }

    protected function get(string $key, string $default = ''): string {
        return trim((string)($_GET[$key] ?? $default));
    }
}
