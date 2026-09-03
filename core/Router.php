<?php
// ── Router ───────────────────────────────────────────────────
class Router {

    /** @var array<string, array{0:string, 1:string}> */
    private array $routes = [
        ''              => ['HomeController',  'index'],
        'gracias'       => ['HomeController',  'gracias'],
        'consulta'      => ['HomeController',  'consulta'],
        'admin'         => ['AdminController', 'dashboard'],
        'admin/login'   => ['AdminController', 'login'],
        'admin/logout'  => ['AdminController', 'logout'],
        'admin/ver'           => ['AdminController', 'ver'],
        'admin/delete'        => ['AdminController', 'delete'],
        'admin/delete-masivo' => ['AdminController', 'deleteMasivo'],
    ];

    public function dispatch(): void {
        $url = trim($_GET['url'] ?? '', '/');

        if (isset($this->routes[$url])) {
            [$class, $method] = $this->routes[$url];
            (new $class())->$method();
        } else {
            http_response_code(404);
            $this->notFound();
        }
    }

    private function notFound(): void {
        require VIEW_PATH . 'layouts/header.php';
        echo '<main class="main-wrap"><div class="empty-state">
                <div class="empty-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg></div>
                <h2>Página no encontrada</h2>
                <p>La ruta solicitada no existe.</p>
                <a href="' . BASE_URL . '" class="btn btn-primary">Volver al inicio</a>
              </div></main>';
        require VIEW_PATH . 'layouts/footer.php';
    }
}
