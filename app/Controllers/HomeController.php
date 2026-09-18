<?php
// ── Controller: Home (ciudadano) ─────────────────────────────
class HomeController extends Controller {

    private Expediente $expedienteModel;

    public function __construct() {
        $this->expedienteModel = new Expediente();
    }

    public function index(): void {
        $error = '';
        $old   = [];

        if ($this->isPost()) {
            $old = $_POST;

            $asunto             = trim($this->post('asunto')); // Solicita
            $nombres            = trim($this->post('nombres'));
            $apellidos          = trim($this->post('apellidos'));
            $dni                = trim($this->post('dni'));
            $cargo              = trim($this->post('cargo'));
            $codigo_modular     = trim($this->post('codigo_modular'));
            $direccion          = trim($this->post('direccion'));
            $distrito           = trim($this->post('distrito'));
            $provincia          = trim($this->post('provincia'));
            $region             = trim($this->post('region'));
            $telefono           = trim($this->post('telefono'));
            $email              = trim($this->post('email'));
            $fundamento         = trim($this->post('fundamento'));
            $descripcion        = trim($this->post('descripcion'));
            $documentos_sustento= trim($this->post('documentos_sustento'));

            // ── Validaciones ──────────────────────────────────
            if (!$asunto || !$nombres || !$apellidos || !$dni || !$fundamento) {
                $error = 'Por favor complete los campos obligatorios del FUT (Solicita, Nombres, Apellidos, DNI y Fundamento de lo solicitado).';

            } elseif (!preg_match('/^\d{8}$/', $dni)) {
                $error = 'El DNI debe contener exactamente 8 dígitos numéricos.';

            } else {
                $hasFile  = !empty($_FILES['archivo']['name']);
                $filename = null;
                $dest     = null;

                if ($hasFile) {
                    $file = $_FILES['archivo'];
                    $ext  = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

                    if ($file['size'] > 10 * 1024 * 1024) {
                        $error = 'El archivo supera el límite de 10 MB.';
                    } elseif (!in_array($ext, ['pdf','doc','docx','jpg','jpeg','png'], true)) {
                        $error = 'Solo se aceptan archivos PDF, DOC, DOCX o imágenes JPG/PNG.';
                    } else {
                        $filename = 'SUSTENTO_' . date('YmdHis') . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
                        $dest     = UPLOAD_PATH . $filename;

                        if (!move_uploaded_file($file['tmp_name'], $dest)) {
                            $error = 'No se pudo guardar el archivo adjunto. Contacte al administrador.';
                            $filename = null;
                            $dest     = null;
                        }
                    }
                }

                if (!$error) {
                    $datosExp = [
                        'nombres'             => $nombres,
                        'apellidos'           => $apellidos,
                        'dni'                 => $dni,
                        'cargo'               => $cargo,
                        'codigo_modular'      => $codigo_modular,
                        'direccion'           => $direccion,
                        'distrito'            => $distrito,
                        'provincia'           => $provincia,
                        'region'              => $region,
                        'telefono'            => $telefono,
                        'email'               => $email,
                        'asunto'              => $asunto,
                        'fundamento'          => $fundamento,
                        'descripcion'         => $descripcion,
                        'documentos_sustento' => $documentos_sustento,
                        'archivo'             => $filename,
                        'ip'                  => $_SERVER['REMOTE_ADDR'] ?? '',
                    ];

                    $codigo = $this->expedienteModel->create($datosExp);

                    if ($codigo) {
                        $datosExp['codigo'] = $codigo;

                        $mailOk = Mailer::enviarExpediente($datosExp, $dest);
                        if (!$mailOk) {
                            error_log("Mesa de Partes: no se pudo enviar el correo del expediente $codigo a la institución");
                        }

                        if (!empty($email)) {
                            Mailer::enviarConstanciaCiudadano($datosExp);
                        }

                        $_SESSION['mp_success'] = $codigo;
                        $this->redirect('gracias');
                    } else {
                        $error = 'Error al registrar el expediente. Intente nuevamente.';
                        if ($dest && file_exists($dest)) {
                            @unlink($dest);
                        }
                    }
                }
            }
        }

        $this->render('home/index', compact('error', 'old'));
    }

    public function gracias(): void {
        $codigo = $_SESSION['mp_success'] ?? null;
        if (!$codigo) {
            $this->redirect('');
        }
        unset($_SESSION['mp_success']);
        $this->render('home/gracias', compact('codigo'));
    }

    // ── Consulta pública de estado ─────────────────────────────
    public function consulta(): void {
        $expediente = null;
        $error      = '';
        $codigo     = strtoupper(trim($this->get('codigo')));

        if ($codigo !== '') {
            $expediente = $this->expedienteModel->findByCodigo($codigo);
            if (!$expediente) {
                $error = "No se encontró ningún expediente con el código <strong>" .
                         htmlspecialchars($codigo) . "</strong>. Verifique e intente nuevamente.";
            }
        }

        $this->render('home/consulta', compact('expediente', 'error', 'codigo'));
    }
}
