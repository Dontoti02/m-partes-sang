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

            $cargo              = htmlspecialchars($datos['cargo'] ?? '-');
            $codigoModular      = htmlspecialchars($datos['codigo_modular'] ?? '-');
            $direccion          = htmlspecialchars($datos['direccion'] ?? '-');
            $distrito           = htmlspecialchars($datos['distrito'] ?? '-');
            $provincia          = htmlspecialchars($datos['provincia'] ?? '-');
            $region             = htmlspecialchars($datos['region'] ?? '-');
            $fundamento         = nl2br(htmlspecialchars($datos['fundamento'] ?? '-'));
            $fundamentoAlt      = $datos['fundamento'] ?? '-';
            $docsSustento       = nl2br(htmlspecialchars($datos['documentos_sustento'] ?? '-'));
            $docsSustentoAlt    = $datos['documentos_sustento'] ?? '-';
            $nombresCompletos   = htmlspecialchars(trim(($datos['apellidos'] ?? '') . ' ' . ($datos['nombres'] ?? '')));

            $mail->Subject = "[" . APP_INST . "] FUT Digital - $codigo - $asunto";

            $mail->isHTML(true);
            $mail->Body = "
<html><body style='font-family:Arial,Helvetica,sans-serif;color:#1f2937;background:#f3f4f6;padding:20px 0;margin:0;'>
  <div style='max-width:680px;margin:0 auto;background:#ffffff;border:1px solid #d1d5db;border-radius:10px;overflow:hidden;box-shadow:0 4px 6px -1px rgba(0,0,0,0.05);'>
    
    <!-- Encabezado Oficial -->
    <div style='background:#14532d;color:#ffffff;padding:24px 28px;text-align:center;'>
      <div style='font-size:13px;letter-spacing:1px;font-weight:600;opacity:.95;text-transform:uppercase;'>" . APP_INST . "</div>
      <div style='font-size:11px;opacity:.8;margin-top:2px;'>R.M. N.&ordm; 821-88-ED</div>
      <h2 style='margin:10px 0 2px;font-size:21px;font-weight:800;letter-spacing:.5px;color:#ffffff;'>FORMULARIO &Uacute;NICO DE TR&Aacute;MITE (FUT) DIGITAL</h2>
      <div style='display:inline-block;margin-top:8px;background:#15803d;padding:4px 14px;border-radius:20px;font-size:12px;font-family:monospace;letter-spacing:1px;'>EXPEDIENTE: $codigo</div>
    </div>

    <!-- Destinatario del FUT -->
    <div style='background:#f0fdf4;border-bottom:1px solid #bbf7d0;padding:12px 28px;font-size:13px;color:#166534;font-weight:700;'>
      SE&Ntilde;OR DIRECTOR DEL IESTP SANGARAR&Aacute; &ndash; ACOMAYO
    </div>

    <div style='padding:26px 28px;font-size:14px;line-height:1.6;'>

      <!-- 1. Petitorio -->
      <div style='background:#f9fafb;border-left:4px solid #14532d;padding:12px 16px;margin-bottom:20px;border-radius:0 6px 6px 0;'>
        <div style='font-size:11px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:.5px;'>1. Solicito (Petitorio / Asunto)</div>
        <div style='font-size:16px;font-weight:800;color:#111827;margin-top:4px;'>" . htmlspecialchars($asunto) . "</div>
      </div>

      <!-- 2. Datos del Usuario -->
      <div style='margin-bottom:20px;'>
        <div style='font-size:12px;font-weight:700;color:#14532d;text-transform:uppercase;border-bottom:2px solid #e5e7eb;padding-bottom:4px;margin-bottom:12px;'>
          2. Datos del Usuario / Solicitante
        </div>
        <table style='width:100%;border-collapse:collapse;font-size:13px;'>
          <tr>
            <td style='padding:6px 0;color:#6b7280;width:150px;'>Apellidos y Nombres:</td>
            <td style='padding:6px 0;'><strong>$nombresCompletos</strong></td>
          </tr>
          <tr>
            <td style='padding:6px 0;color:#6b7280;'>N.&ordm; DNI:</td>
            <td style='padding:6px 0;'><strong>" . htmlspecialchars($datos['dni'] ?? '-') . "</strong></td>
          </tr>
          <tr>
            <td style='padding:6px 0;color:#6b7280;'>Condici&oacute;n / Cargo:</td>
            <td style='padding:6px 0;'>$cargo</td>
          </tr>
          <tr>
            <td style='padding:6px 0;color:#6b7280;'>C&oacute;digo Modular/Est.:</td>
            <td style='padding:6px 0;'>$codigoModular</td>
          </tr>
          <tr>
            <td style='padding:6px 0;color:#6b7280;'>Domicilio:</td>
            <td style='padding:6px 0;'>$direccion</td>
          </tr>
          <tr>
            <td style='padding:6px 0;color:#6b7280;'>Distrito / Prov. / Regi&oacute;n:</td>
            <td style='padding:6px 0;'>$distrito / $provincia / $region</td>
          </tr>
          <tr>
            <td style='padding:6px 0;color:#6b7280;'>Tel&eacute;fono / Celular:</td>
            <td style='padding:6px 0;'>" . htmlspecialchars($datos['telefono'] ?? '-') . "</td>
          </tr>
          <tr>
            <td style='padding:6px 0;color:#6b7280;'>Correo Electr&oacute;nico:</td>
            <td style='padding:6px 0;'>" . htmlspecialchars($datos['email'] ?? '-') . "</td>
          </tr>
        </table>
      </div>

      <!-- 3. Fundamento -->
      <div style='margin-bottom:20px;'>
        <div style='font-size:12px;font-weight:700;color:#14532d;text-transform:uppercase;border-bottom:2px solid #e5e7eb;padding-bottom:4px;margin-bottom:8px;'>
          3. Fundamento de lo Solicitado
        </div>
        <div style='background:#ffffff;border:1px solid #e5e7eb;border-radius:6px;padding:12px 16px;font-size:13px;line-height:1.7;color:#374151;'>
          $fundamento
        </div>
      </div>

      <!-- 4. Documentos que adjunta -->
      <div style='margin-bottom:20px;'>
        <div style='font-size:12px;font-weight:700;color:#14532d;text-transform:uppercase;border-bottom:2px solid #e5e7eb;padding-bottom:4px;margin-bottom:8px;'>
          4. Documentos que Adjunta (Sustento)
        </div>
        <div style='font-size:13px;color:#374151;margin-bottom:6px;'>
          <strong>Detalle:</strong> $docsSustento
        </div>
        <div style='font-size:13px;color:#374151;'>
          <strong>Archivo adjunto de sustento:</strong> $adjuntoLabel
        </div>
      </div>

      <!-- 5. Fecha y Firma -->
      <div style='margin-top:24px;border-top:1px dashed #d1d5db;padding-top:16px;font-size:12px;color:#6b7280;'>
        <table style='width:100%;border-collapse:collapse;'>
          <tr>
            <td><strong>Fecha de env&iacute;o:</strong> $fecha</td>
            <td style='text-align:right;'><strong>Firma virtual:</strong> $nombresCompletos (DNI: " . htmlspecialchars($datos['dni'] ?? '-') . ")</td>
          </tr>
        </table>
      </div>

      <!-- Pie oficial -->
      <div style='margin-top:24px;padding-top:16px;border-top:1px solid #e5e7eb;font-size:12px;color:#6b7280;text-align:center;'>
        <strong>" . APP_INST . "</strong> &mdash; Mesa de Partes Virtual<br>
        Bandeja oficial de recepci&oacute;n: <a href='mailto:" . MAIL_TO . "' style='color:#14532d;text-decoration:none;font-weight:600;'>" . MAIL_TO . "</a>
      </div>

    </div>
  </div>
</body></html>";

            $mail->AltBody = "FORMULARIO ÚNICO DE TRÁMITE (FUT) DIGITAL - " . APP_INST . "\n" .
                "EXPEDIENTE: $codigo\n" .
                "SEÑOR DIRECTOR DEL IESTP SANGARARÁ – ACOMAYO\n\n" .
                "1. SOLICITO: " . $asunto . "\n\n" .
                "2. DATOS DEL SOLICITANTE:\n" .
                "- Apellidos y Nombres: " . trim(($datos['apellidos'] ?? '') . ' ' . ($datos['nombres'] ?? '')) . "\n" .
                "- DNI: " . ($datos['dni'] ?? '-') . "\n" .
                "- Condición / Cargo: " . ($datos['cargo'] ?? '-') . "\n" .
                "- Código Modular/Estudiante: " . ($datos['codigo_modular'] ?? '-') . "\n" .
                "- Domicilio: " . ($datos['direccion'] ?? '-') . "\n" .
                "- Ubicación: " . ($datos['distrito'] ?? '-') . " / " . ($datos['provincia'] ?? '-') . " / " . ($datos['region'] ?? '-') . "\n" .
                "- Teléfono: " . ($datos['telefono'] ?? '-') . "\n" .
                "- Correo: " . ($datos['email'] ?? '-') . "\n\n" .
                "3. FUNDAMENTO DE LO SOLICITADO:\n" . $fundamentoAlt . "\n\n" .
                "4. DOCUMENTOS QUE ADJUNTA:\n" . $docsSustentoAlt . "\n" .
                "Archivo: " . $adjuntoAlt . "\n\n" .
                "Fecha de registro: $fecha\nFirma virtual registrada.";

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