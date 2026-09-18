<?php
// ── Helper: Correo (PHPMailer + SMTP Gmail) ─────────────────
require_once __DIR__ . '/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/PHPMailer/SMTP.php';
require_once __DIR__ . '/PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer {

    /** Configura una instancia base de PHPMailer con la identidad del IESTP Sangarará */
    private static function crearMailer(): PHPMailer {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = SMTP_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = SMTP_USER;
        $mail->Password   = SMTP_PASS;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = SMTP_PORT;
        $mail->CharSet    = 'UTF-8';

        // Identidad del remitente institucional
        $nombreInstitucion = APP_INST . ' - Mesa de Partes Virtual';
        $mail->setFrom(SMTP_USER, $nombreInstitucion);
        $mail->FromName   = $nombreInstitucion;
        $mail->addReplyTo(MAIL_TO, APP_INST);

        return $mail;
    }

    /** Envía el expediente registrado a la mesa de partes institucional (con adjunto si existe) */
    public static function enviarExpediente(array $datos, ?string $archivoRuta = null): bool {
        try {
            $mail = self::crearMailer();
            $mail->addAddress(MAIL_TO);

            $codigo  = $datos['codigo'];
            $asunto  = $datos['asunto'] ?? '';
            $fecha   = date('d/m/Y H:i');
            $adjuntoLabel = !empty($datos['archivo']) ? htmlspecialchars($datos['archivo']) : '<em>Sin documento adjunto</em>';
            $adjuntoAlt   = !empty($datos['archivo']) ? $datos['archivo'] : 'Sin documento adjunto';

            $mail->Subject = "[" . APP_INST . "] Nuevo Expediente $codigo - $asunto";

            $mail->isHTML(true);
            $mail->Body = "
<html><body style='font-family:Arial,Helvetica,sans-serif;color:#1f2937;background:#f9fafb;padding:16px 0;margin:0;'>
  <div style='max-width:600px;margin:0 auto;background:#ffffff;border:1px solid #e5e7eb;border-radius:10px;overflow:hidden;box-shadow:0 2px 4px rgba(0,0,0,.04);'>
    <div style='background:#14532d;color:#ffffff;padding:20px 24px;'>
      <div style='font-size:12px;text-transform:uppercase;letter-spacing:1px;font-weight:600;opacity:.9;margin-bottom:4px;'>" . APP_INST . "</div>
      <h2 style='margin:0;font-size:20px;font-weight:700;color:#ffffff;'>Nuevo Expediente Registrado</h2>
      <p style='margin:4px 0 0;font-size:13px;opacity:.85;color:#ffffff;'>Mesa de Partes Virtual</p>
    </div>
    <div style='padding:24px;font-size:14px;line-height:1.7;'>
      <table style='width:100%;border-collapse:collapse;'>
        <tr><td style='padding:6px 0;color:#6b7280;width:150px;'>Instituci&oacute;n</td><td><strong>" . APP_INST . "</strong></td></tr>
        <tr><td style='padding:6px 0;color:#6b7280;'>C&oacute;digo</td><td><strong style='font-size:15px;color:#14532d;font-family:monospace;'>$codigo</strong></td></tr>
        <tr><td style='padding:6px 0;color:#6b7280;'>Nombres</td><td>" . htmlspecialchars($datos['nombres'] ?? '') . "</td></tr>
        <tr><td style='padding:6px 0;color:#6b7280;'>Apellidos</td><td>" . htmlspecialchars($datos['apellidos'] ?? '') . "</td></tr>
        <tr><td style='padding:6px 0;color:#6b7280;'>DNI</td><td>" . htmlspecialchars($datos['dni'] ?? '') . "</td></tr>
        <tr><td style='padding:6px 0;color:#6b7280;'>Tel&eacute;fono</td><td>" . htmlspecialchars($datos['telefono'] ?? '-') . "</td></tr>
        <tr><td style='padding:6px 0;color:#6b7280;'>Correo solicitante</td><td>" . htmlspecialchars($datos['email'] ?? '-') . "</td></tr>
        <tr><td style='padding:6px 0;color:#6b7280;'>Asunto</td><td><strong>" . htmlspecialchars($asunto) . "</strong></td></tr>
        <tr><td style='padding:6px 0;color:#6b7280;'>Descripci&oacute;n</td><td>" . nl2br(htmlspecialchars($datos['descripcion'] ?? '-')) . "</td></tr>
        <tr><td style='padding:6px 0;color:#6b7280;'>Fecha de registro</td><td>$fecha</td></tr>
        <tr><td style='padding:6px 0;color:#6b7280;'>Documento adjunto</td><td>$adjuntoLabel</td></tr>
      </table>
      <div style='margin-top:24px;padding-top:16px;border-top:1px solid #e5e7eb;font-size:12px;color:#6b7280;text-align:center;'>
        <strong>" . APP_INST . "</strong> &mdash; Mesa de Partes Virtual<br>
        Correo institucional: <a href='mailto:" . MAIL_TO . "' style='color:#14532d;text-decoration:none;'>" . MAIL_TO . "</a>
      </div>
    </div>
  </div>
</body></html>";

            $mail->AltBody = "[" . APP_INST . "] Nuevo expediente $codigo - $asunto\n" .
                "Institución: " . APP_INST . "\n" .
                "Nombres: " . ($datos['nombres'] ?? '') . "\n" .
                "Apellidos: " . ($datos['apellidos'] ?? '') . "\n" .
                "DNI: " . ($datos['dni'] ?? '') . "\n" .
                "Teléfono: " . ($datos['telefono'] ?? '-') . "\n" .
                "Correo: " . ($datos['email'] ?? '-') . "\n" .
                "Asunto: " . $asunto . "\n" .
                "Descripción: " . ($datos['descripcion'] ?? '-') . "\n" .
                "Fecha: $fecha\nAdjunto: " . $adjuntoAlt;

            if (!empty($archivoRuta) && file_exists($archivoRuta)) {
                $mail->addAttachment($archivoRuta, $datos['archivo'] ?? basename($archivoRuta));
            }

            return $mail->send();
        } catch (Exception $e) {
            error_log("Mailer::enviarExpediente error: " . $e->getMessage());
            return false;
        }
    }

    /** Envía constancia de recepción al solicitante */
    public static function enviarConstanciaCiudadano(array $datos): bool {
        $emailDestino = trim($datos['email'] ?? '');
        if ($emailDestino === '' || !filter_var($emailDestino, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        try {
            $mail = self::crearMailer();
            $mail->addAddress($emailDestino);

            $codigo  = $datos['codigo'];
            $asunto  = $datos['asunto'] ?? '';
            $nombres = trim(($datos['nombres'] ?? '') . ' ' . ($datos['apellidos'] ?? ''));
            $fecha   = date('d/m/Y H:i');

            $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
            $proto = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
            $urlConsulta = $proto . '://' . $host . BASE_URL . 'consulta?codigo=' . rawurlencode($codigo);

            $mail->Subject = "[" . APP_INST . "] Constancia de Recepción de Trámite $codigo";

            $mail->isHTML(true);
            $mail->Body = "
<html><body style='font-family:Arial,Helvetica,sans-serif;color:#1f2937;background:#f9fafb;padding:20px 0;margin:0;'>
  <div style='max-width:560px;margin:0 auto;background:#ffffff;border:1px solid #e5e7eb;border-radius:10px;overflow:hidden;box-shadow:0 2px 4px rgba(0,0,0,.04);'>
    <div style='background:#14532d;color:#ffffff;padding:20px 24px;text-align:center;'>
      <div style='font-size:12px;text-transform:uppercase;letter-spacing:1px;font-weight:600;opacity:.9;margin-bottom:4px;'>" . APP_INST . "</div>
      <h2 style='margin:0;font-size:20px;font-weight:700;color:#ffffff;'>Tr&aacute;mite Registrado Exitosamente</h2>
      <p style='margin:4px 0 0;font-size:13px;opacity:.85;color:#ffffff;'>Mesa de Partes Virtual</p>
    </div>
    <div style='padding:24px;font-size:14px;line-height:1.7;'>
      <p>Estimado(a) <strong>" . htmlspecialchars($nombres) . "</strong>,</p>
      <p>Su solicitud ha sido recibida satisfactoriamente por la Mesa de Partes Virtual del <strong>" . APP_INST . "</strong>.</p>
      
      <div style='background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;padding:16px;margin:20px 0;text-align:center;'>
        <p style='margin:0;font-size:12px;color:#166534;text-transform:uppercase;letter-spacing:1px;font-weight:600;'>Su C&oacute;digo de Seguimiento</p>
        <p style='margin:6px 0;font-size:24px;font-weight:800;letter-spacing:2px;color:#14532d;font-family:monospace;'>$codigo</p>
        <p style='margin:0;font-size:12px;color:#4b5563;'>Guarde este c&oacute;digo para consultar el estado de su tr&aacute;mite.</p>
      </div>

      <table style='width:100%;border-collapse:collapse;margin-bottom:20px;font-size:13px;'>
        <tr><td style='padding:6px 0;color:#6b7280;width:120px;'>Asunto:</td><td><strong>" . htmlspecialchars($asunto) . "</strong></td></tr>
        <tr><td style='padding:6px 0;color:#6b7280;'>Fecha:</td><td>$fecha</td></tr>
        <tr><td style='padding:6px 0;color:#6b7280;'>DNI:</td><td>" . htmlspecialchars($datos['dni'] ?? '-') . "</td></tr>
      </table>

      <div style='text-align:center;margin:25px 0 15px;'>
        <a href='$urlConsulta' style='background:#14532d;color:#ffffff;text-decoration:none;padding:12px 24px;border-radius:6px;font-weight:600;display:inline-block;font-size:14px;'>
          Consultar Estado de mi Tr&aacute;mite &rarr;
        </a>
      </div>

      <div style='margin-top:25px;padding-top:16px;border-top:1px solid #e5e7eb;font-size:12px;color:#6b7280;text-align:center;'>
        <strong>" . APP_INST . "</strong> &mdash; Mesa de Partes Virtual<br>
        Contacto oficial: <a href='mailto:" . MAIL_TO . "' style='color:#14532d;text-decoration:none;'>" . MAIL_TO . "</a>
      </div>
    </div>
  </div>
</body></html>";

            $mail->AltBody = "Estimado(a) $nombres,\n\n" .
                "Su trámite ha sido registrado exitosamente en la Mesa de Partes Virtual de " . APP_INST . ".\n\n" .
                "Código de Expediente: $codigo\n" .
                "Asunto: $asunto\n" .
                "Fecha: $fecha\n\n" .
                "Puede consultar el estado de su trámite en el siguiente enlace:\n$urlConsulta\n\n" .
                "Atentamente,\n" . APP_INST;

            return $mail->send();
        } catch (Exception $e) {
            error_log("Mailer::enviarConstanciaCiudadano error: " . $e->getMessage());
            return false;
        }
    }
}