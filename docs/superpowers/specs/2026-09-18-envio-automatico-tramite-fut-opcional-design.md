# Especificación de Diseño: Envío Automático de Trámite a Iestpsanga2023@gmail.com y FUT Opcional

**Fecha:** 2026-09-18  
**Proyecto:** Mesa de Partes Virtual - IESTP Sangarará (`m-partes-sang`)

---

## 1. Contexto y Problema

Actualmente, el sistema de Mesa de Partes Virtual del IESTP Sangarará presenta los siguientes puntos a resolver:
1. El correo institucional de destino está configurado como `mesadepartessangarara@gmail.com` en lugar del correo oficial proporcionado: `Iestpsanga2023@gmail.com`.
2. El formulario virtual exige obligatoriamente adjuntar el Formulario Único de Trámite (FUT) completado tanto en el cliente (HTML `required`) como en el servidor (`empty($_FILES['archivo']['name'])`), impidiendo que los usuarios envíen su trámite si no tienen el archivo a la mano.
3. Al intentar ingresar al panel de administración o consultar la base de datos, se produce un error fatal (`Table 'mesa_partes.administradores' doesn't exist`), debido a que en el entorno local de XAMPP la base de datos `mesa_partes` contenía tablas heredadas de otro proyecto y nunca se inicializó el esquema propio de Sangarará con su tabla `administradores` y `expedientes`.
4. El solicitante no recibe una confirmación automática cuando registra su trámite virtual indicando su código de seguimiento.

---

## 2. Objetivos

1. **Configurar el envío automático del trámite:**
   - La cuenta emisora (servidor SMTP) sigue siendo `conectandoselva@gmail.com` (con autenticación segura de contraseña de aplicación).
   - El correo destinatario institucional debe ser exclusivamente `Iestpsanga2023@gmail.com`.
   - Adicionalmente, si el solicitante proporciona su correo, el sistema le enviará automáticamente un acuse de recibo con su código de expediente y enlace de consulta.
2. **Hacer opcional la carga del archivo FUT:**
   - En la interfaz de usuario, quitar la obligatoriedad visual y el atributo `required`.
   - En el backend, permitir el procesamiento y registro del expediente sin archivo adjunto (`$filename = null`).
   - En caso de subir archivo, validar que no exceda los 10 MB y sea PDF/DOC/DOCX.
   - En el correo institucional, si no hay archivo, notificar adecuadamente sin error y sin adjunto indicando *"Sin documento adjunto"*.
   - En el panel administrativo (`admin/ver.php`), mostrar claramente si el expediente tiene archivo adjunto o si no se adjuntó ninguno.
3. **Subsanar el error de base de datos (`administradores` y `expedientes`):**
   - Configurar la base de datos propia `mesa_partes_sangarara` en `config/db.php` y `install.php`.
   - Configurar la columna `archivo` en `expedientes` como `VARCHAR(255) NULL DEFAULT NULL`.
   - Ejecutar la inicialización para que existan las tablas `expedientes` y `administradores` (usuario por defecto `admin` / `admin123`).

---

## 3. Arquitectura y Componentes Afectados

### 3.1. Configuración (`config/app.php` y `config/db.php`)
- `config/app.php`: Actualizar `MAIL_TO` a `'Iestpsanga2023@gmail.com'`.
- `config/db.php`: Configurar `DB_NAME` como `'mesa_partes_sangarara'` para aislar el esquema del IESTP Sangarará de otros proyectos en XAMPP.

### 3.2. Instalador y Esquema de BD (`install.php`)
- Definir la base de datos `mesa_partes_sangarara`.
- Crear la tabla `expedientes` con `archivo VARCHAR(255) NULL DEFAULT NULL`.
- Crear la tabla `administradores` con el hash de contraseña seguro para `admin`.

### 3.3. Servicio de Correo (`core/Mailer.php`)
- Adaptar `Mailer::enviarExpediente(array $datos, ?string $archivoRuta = null): bool`:
  - Solo adjuntar el archivo si `$archivoRuta` no es nulo, no está vacío y `file_exists($archivoRuta)` es verdadero.
  - En el cuerpo del correo HTML y texto plano, mostrar el nombre del archivo o *"Sin documento adjunto"*.
- Crear `Mailer::enviarConstanciaCiudadano(array $datos): bool`:
  - Si `$datos['email']` es válido, enviar correo al solicitante con asunto `"Constancia de recepción de trámite - Código " . $datos['codigo']`.
  - Incluir el código de seguimiento, fecha, asunto y enlace directo para consultar el trámite (`BASE_URL . 'consulta?codigo=' . $datos['codigo']`).

### 3.4. Controlador Principal (`app/Controllers/HomeController.php`)
- En `index()`:
  - Eliminar el bloque que obligaba a que `$_FILES['archivo']['name']` no estuviera vacío.
  - Si `!empty($_FILES['archivo']['name'])`:
    - Validar tamaño (< 10MB) y tipo (pdf, doc, docx).
    - Guardar en `UPLOAD_PATH`.
    - Si falla el guardado, reportar error.
  - Si no se subió archivo:
    - Asignar `$filename = null` y `$dest = null`.
  - Crear el expediente en `expedientes` con `'archivo' => $filename`.
  - Enviar notificación a la institución: `Mailer::enviarExpediente($datos, $dest)`.
  - Si el solicitante ingresó correo electrónico: llamar a `Mailer::enviarConstanciaCiudadano($datos)`.

### 3.5. Vistas Ciudadano (`app/Views/home/index.php`)
- Barra de pasos: Cambiar paso 4 a *"Adjunte (opcional) y envíe"*.
- Quitar asterisco de obligatoriedad en *"Adjuntar FUT Completado"*; renombrar a *"Adjuntar FUT u otro documento (Opcional)"*.
- Quitar atributo `required` en `<input type="file" name="archivo">`.
- Ajustar el texto descriptivo del cuadro de carga indicando que es opcional.

### 3.6. Vista del Administrador (`app/Views/admin/ver.php`)
- Condicionar la sección de descarga de archivo:
  - Si `!empty($expediente['archivo'])`: mostrar el botón de ver/descargar archivo.
  - Si está vacío: mostrar una alerta o insignia neutral *"Sin documento adjunto"*.
- En `AdminController.php`: proteger la eliminación física de archivos (`unlink`) verificando que `$exp['archivo']` no esté vacío y sea un archivo regular (`is_file($ruta)`).

---

## 4. Plan de Verificación

1. **Verificación de Base de Datos:**
   - Ejecutar la inicialización de `mesa_partes_sangarara`.
   - Probar el acceso al login de administración (`admin` / `admin123`) comprobando que no ocurra el `Fatal error`.
2. **Verificación de Registro sin Archivo:**
   - Enviar un trámite completando datos personales y asunto, sin seleccionar ningún archivo.
   - Verificar que el expediente se cree exitosamente en la BD con `archivo = NULL`.
   - Comprobar que se genere el código de expediente y redirija a la pantalla de confirmación (`/gracias`).
3. **Verificación de Envío de Correo Institucional:**
   - Comprobar que `Mailer::enviarExpediente` envíe el correo a `Iestpsanga2023@gmail.com`.
   - Validar que no se generen excepciones en PHPMailer por ausencia de archivo adjunto.
4. **Verificación de Constancia al Solicitante:**
   - Enviar un trámite con un correo de prueba de solicitante.
   - Verificar que reciba la constancia con su código de trámite y enlace.
5. **Verificación de Registro con Archivo Adjunto (Opcional):**
   - Enviar un trámite adjuntando un documento PDF.
   - Verificar que el archivo se guarde en `uploads/`, se registre en la BD y se adjunte correctamente al correo institucional.
