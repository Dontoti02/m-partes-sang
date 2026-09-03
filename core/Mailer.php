<?php
// ── Helper: Correo (PHPMailer + SMTP Gmail) ─────────────────
require_once __DIR__ . '/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/PHPMailer/SMTP.php';
require_once __DIR__ . '/PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer {

    /** Envía el expediente registrado a la mesa de partes con su adjunto */
    public static function enviarExpediente(array $datos, string $archivoRuta): bool {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = SMTP_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = SMTP_USER;
            $mail->Password   = SMTP_PASS;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = SMTP_PORT;
            $mail->CharSet    = 'UTF-8';

            $mail->setFrom(SMTP_USER, APP_INST . ' - Mesa de Partes Virtual');
            $mail->addAddress(MAIL_TO);

            $codigo  = $datos['codigo'];
            $asunto  = $datos['asunto'] ?? '';
            $fecha   = date('d/m/Y H:i');

            $mail->Subject = "Nuevo expediente $codigo - $asunto";

            $mail->isHTML(true);
            $mail->Body = "
<html><body style='font-family:Arial,Helvetica,sans-serif;color:#1f2937;'>
  <div style='max-width:600px;margin:0 auto;border:1px solid #e5e7eb;border-radius:10px;overflow:hidden;'>
    <div style='background:#14532d;color:#fff;padding:16px 24px;'>
      <h2 style='margin:0;font-size:18px;'>Nuevo Expediente Registrado</h2>
      <p style='margin:4px 0 0;font-size:13px;opacity:.85;'>" . APP_INST . " &mdash; Mesa de Partes Virtual</p>
    </div>
    <div style='padding:24px;font-size:14px;line-height:1.7;'>
      <table style='width:100%;border-collapse:collapse;'>
        <tr><td style='padding:6px 0;color:#6b7280;width:160px;'>C&oacute;digo</td><td><strong>$codigo</strong></td></tr>
        <tr><td style='padding:6px 0;color:#6b7280;'>Nombres</td><td>" . htmlspecialchars($datos['nombres'] ?? '') . "</td></tr>
        <tr><td style='padding:6px 0;color:#6b7280;'>Apellidos</td><td>" . htmlspecialchars($datos['apellidos'] ?? '') . "</td></tr>
        <tr><td style='padding:6px 0;color:#6b7280;'>DNI</td><td>" . htmlspecialchars($datos['dni'] ?? '') . "</td></tr>
        <tr><td style='padding:6px 0;color:#6b7280;'>Tel&eacute;fono</td><td>" . htmlspecialchars($datos['telefono'] ?? '-') . "</td></tr>
        <tr><td style='padding:6px 0;color:#6b7280;'>Correo</td><td>" . htmlspecialchars($datos['email'] ?? '-') . "</td></tr>
        <tr><td style='padding:6px 0;color:#6b7280;'>Asunto</td><td>" . htmlspecialchars($asunto) . "</td></tr>
        <tr><td style='padding:6px 0;color:#6b7280;'>Descripci&oacute;n</td><td>" . nl2br(htmlspecialchars($datos['descripcion'] ?? '-')) . "</td></tr>
        <tr><td style='padding:6px 0;color:#6b7280;'>Fecha</td><td>$fecha</td></tr>
        <tr><td style='padding:6px 0;color:#6b7280;'>Adjunto</td><td>" . htmlspecialchars($datos['archivo'] ?? '-') . "</td></tr>
      </table>
      <p style='margin-top:20px;padding-top:16px;border-top:1px solid #e5e7eb;font-size:12px;color:#9ca3af;'>
        Correo generado autom&aacute;ticamente por el sistema de Mesa de Partes Virtual.
      </p>
    </div>
  </div>
</body></html>";

            $mail->AltBody = "Nuevo expediente $codigo - $asunto\n" .
                "Nombres: " . ($datos['nombres'] ?? '') . "\n" .
                "Apellidos: " . ($datos['apellidos'] ?? '') . "\n" .
                "DNI: " . ($datos['dni'] ?? '') . "\n" .
                "Teléfono: " . ($datos['telefono'] ?? '-') . "\n" .
                "Correo: " . ($datos['email'] ?? '-') . "\n" .
                "Asunto: " . $asunto . "\n" .
                "Descripción: " . ($datos['descripcion'] ?? '-') . "\n" .
                "Fecha: $fecha\nAdjunto: " . ($datos['archivo'] ?? '-');

            if (file_exists($archivoRuta)) {
                $mail->addAttachment($archivoRuta, $datos['archivo'] ?? basename($archivoRuta));
            }

            return $mail->send();
        } catch (Exception $e) {
            return false;
        }
    }
}