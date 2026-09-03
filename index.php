<?php
// ── Front Controller ─────────────────────────────────────────
session_start();

require_once __DIR__ . '/config/app.php';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/core/Router.php';
require_once __DIR__ . '/core/Controller.php';
require_once __DIR__ . '/core/Mailer.php';
require_once __DIR__ . '/app/Models/Expediente.php';
require_once __DIR__ . '/app/Models/Administrador.php';
require_once __DIR__ . '/app/Controllers/HomeController.php';
require_once __DIR__ . '/app/Controllers/AdminController.php';

(new Router())->dispatch();
