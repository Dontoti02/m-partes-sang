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

            $nombres     = $this->post('nombres');
            $apellidos   = $this->post('apellidos');
            $dni         = $this->post('dni');
            $telefono    = $this->post('telefono');
            $email       = $this->post('email');
            $asunto      = $this->post('asunto');
            $descripcion = $this->post('descripcion');

            // ── Validaciones ──────────────────────────────────
            if (!$nombres || !$apellidos || !$dni || !$asunto) {
                $error = 'Complete todos los campos obligatorios.';

            } elseif (!preg_match('/^\d{8}$/', $dni)) {
                $error = 'El DNI debe contener exactamente 8 dígitos numéricos.';

            } elseif (empty($_FILES['archivo']['name'])) {
                $error = 'Debe adjuntar el formulario FUT completado.';

            } else {
                $file = $_FILES['archivo'];
                $ext  = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

                if ($file['size'] > 10 * 1024 * 1024) {
                    $error = 'El archivo supera el límite de 10 MB.';

                } elseif (!in_array($ext, ['pdf','doc','docx'], true)) {
                    $error = 'Solo se aceptan archivos PDF, DOC o DOCX.';

                } else {
                    $filename = 'FUT_' . date('YmdHis') . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
                    $dest     = UPLOAD_PATH . $filename;

                    if (!move_uploaded_file($file['tmp_name'], $dest)) {
                        $error = 'No se pudo guardar el archivo. Contacte al administrador.';
                    } else {
                        $codigo = $this->expedienteModel->create([
                            'nombres'     => $nombres,
                            'apellidos'   => $apellidos,
                            'dni'         => $dni,
                            'telefono'    => $telefono,
                            'email'       => $email,
                            'asunto'      => $asunto,
                            'descripcion' => $descripcion,
                            'archivo'     => $filename,
                            'ip'          => $_SERVER['REMOTE_ADDR'] ?? '',
                        ]);

                        if ($codigo) {
                            $mailOk = Mailer::enviarExpediente([
                                'codigo'      => $codigo,
                                'nombres'     => $nombres,
                                'apellidos'   => $apellidos,
                                'dni'         => $dni,
                                'telefono'    => $telefono,
                                'email'       => $email,
                                'asunto'      => $asunto,
                                'descripcion' => $descripcion,
                                'archivo'     => $filename,
                            ], $dest);

                            if (!$mailOk) {
                                error_log("Mesa de Partes: no se pudo enviar el correo del expediente $codigo");
                            }

                            $_SESSION['mp_success'] = $codigo;
                            $this->redirect('gracias');
                        } else {
                            $error = 'Error al registrar el expediente. Intente nuevamente.';
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
