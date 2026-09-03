# Mesa de Partes Virtual - IESTP Sangarará

Sistema de Mesa de Partes Virtual para el Instituto de Educación Superior Tecnológico Público "Sangarará". Permite a los ciudadanos presentar trámites en línea mediante el Formulario Único de Trámite (FUT).

## Características

- Presentación de expedientes en línea con formulario FUT
- Generación automática de códigos de seguimiento (MP-YYYY-NNNN)
- Consulta pública de estado de trámites
- Panel administrativo para gestión de expedientes
- Notificaciones por correo electrónico con adjuntos
- Eliminación individual y masiva de expedientes
- Diseño responsive y profesional

## Requisitos

- PHP 8.0 o superior
- MariaDB 10.5+ / MySQL 8.0+
- Apache 2.4+ con mod_rewrite o Nginx
- Extensión PHP: mysqli, mbstring, openssl

## Instalación en AlmaLinux VPS

### 1. Actualizar el sistema

```bash
sudo dnf update -y
sudo dnf install epel-release -y
```

### 2. Instalar Apache, PHP y MariaDB

```bash
sudo dnf install httpd mariadb-server -y
sudo dnf install php php-mysqli php-mbstring php-openssl php-json php-curl php-zip -y
```

### 3. Iniciar y habilitar servicios

```bash
sudo systemctl enable --now httpd
sudo systemctl enable --now mariadb
```

### 4. Asegurar MariaDB

```bash
sudo mysql_secure_installation
```

Sigue las instrucciones: establece contraseña root, elimina usuarios anónimos, deshabilita login root remoto, elimina base de datos test.

### 5. Crear base de datos y usuario

```bash
sudo mysql -u root -p
```

```sql
CREATE DATABASE mesa_partes CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'mesa_user'@'localhost' IDENTIFIED BY 'TuContraseñaSegura123!';
GRANT ALL PRIVILEGES ON mesa_partes.* TO 'mesa_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### 6. Clonar el repositorio

```bash
sudo mkdir -p /var/www/html
cd /var/www/html
sudo git clone https://github.com/Dontoti02/m-partes-sang.git
sudo chown -R apache:apache m-partes-sang
sudo chmod -R 755 m-partes-sang
sudo chmod -R 777 m-partes-sang/uploads
```

### 7. Configurar la aplicación

```bash
cd /var/www/html/m-partes-sang
sudo cp config/app.php.example config/app.php
sudo nano config/app.php
```

Edita las siguientes líneas:

```php
define('BASE_URL', '/m-partes-sang/');  // O '/' si es dominio raíz
define('DB_HOST', 'localhost');
define('DB_USER', 'mesa_user');
define('DB_PASS', 'TuContraseñaSegura123!');
define('DB_NAME', 'mesa_partes');

// Correo SMTP
define('MAIL_TO',   'mesadepartessangarara@gmail.com');
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'tu-cuenta@gmail.com');
define('SMTP_PASS', 'contraseña-de-aplicacion-16chars');
```

**Nota:** Para `SMTP_PASS` necesitas generar una "Contraseña de aplicación" en Google:
1. Activa la verificación en 2 pasos en tu cuenta Google
2. Ve a https://myaccount.google.com/apppasswords
3. Genera una contraseña de 16 caracteres

### 8. Ejecutar el instalador

Abre en tu navegador:
```
http://tu-dominio-o-IP/m-partes-sang/install.php
```

Esto creará las tablas y el usuario admin por defecto:
- **Usuario:** admin
- **Contraseña:** admin123

⚠️ **IMPORTANTE:** Elimina `install.php` después de la instalación:
```bash
sudo rm /var/www/html/m-partes-sang/install.php
```

### 9. Configurar Apache (Virtual Host)

```bash
sudo nano /etc/httpd/conf.d/m-partes-sang.conf
```

```apache
<VirtualHost *:80>
    ServerName tu-dominio.com
    DocumentRoot /var/www/html/m-partes-sang

    <Directory /var/www/html/m-partes-sang>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog /var/log/httpd/m-partes-sang-error.log
    CustomLog /var/log/httpd/m-partes-sang-access.log combined
</VirtualHost>
```

Reinicia Apache:
```bash
sudo systemctl restart httpd
```

### 10. Configurar Firewall

```bash
sudo firewall-cmd --permanent --add-service=http
sudo firewall-cmd --permanent --add-service=https
sudo firewall-cmd --reload
```

### 11. HTTPS con Let's Encrypt (Recomendado)

```bash
sudo dnf install certbot python3-certbot-apache -y
sudo certbot --apache -d tu-dominio.com
```

Certbot configurará automáticamente el SSL y la renovación automática.

### 12. Permisos de seguridad

```bash
sudo chown -R apache:apache /var/www/html/m-partes-sang
sudo find /var/www/html/m-partes-sang -type d -exec chmod 755 {} \;
sudo find /var/www/html/m-partes-sang -type f -exec chmod 644 {} \;
sudo chmod -R 777 /var/www/html/m-partes-sang/uploads
sudo chmod 600 /var/www/html/m-partes-sang/config/app.php
```

## Configuración de SELinux (si está activo)

```bash
sudo setsebool -P httpd_can_network_connect 1
sudo setsebool -P httpd_can_sendmail 1
sudo chcon -Rt httpd_sys_rw_content_t /var/www/html/m-partes-sang/uploads
```

## Configuración alternativa con Nginx

Si prefieres Nginx en lugar de Apache:

```bash
sudo dnf install nginx php-fpm -y
sudo systemctl enable --now nginx php-fpm
```

Configuración de Nginx:
```bash
sudo nano /etc/nginx/conf.d/m-partes-sang.conf
```

```nginx
server {
    listen 80;
    server_name tu-dominio.com;
    root /var/www/html/m-partes-sang;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?url=$uri&$args;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/run/php-fpm/www.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.ht {
        deny all;
    }
}
```

## Estructura del proyecto

```
m-partes-sang/
── app/
│   ├── Controllers/
│   │   ├── HomeController.php
│   │   └── AdminController.php
│   ├── Models/
│   │   ├── Expediente.php
│   │   └── Administrador.php
│   └── Views/
│       ├── admin/
│       ├── home/
│       └── layouts/
├── assets/
│   └── logo.jpeg
├── config/
│   ├── app.php
│   └── db.php
├── core/
│   ├── Controller.php
│   ├── Mailer.php
│   ├── PHPMailer/
│   └── Router.php
├── public/
│   └── css/
│       └── style.css
├── uploads/
├── .htaccess
├── index.php
└── install.php
```

## Credenciales por defecto

- **Panel Admin:** `/m-partes-sang/admin/login`
- **Usuario:** admin
- **Contraseña:** admin123

⚠️ **Cambia la contraseña inmediatamente después del primer login.**

## Solución de problemas

### Error 500
```bash
sudo tail -f /var/log/httpd/m-partes-sang-error.log
```

### Permisos de uploads
```bash
sudo chmod -R 777 /var/www/html/m-partes-sang/uploads
sudo chown -R apache:apache /var/www/html/m-partes-sang/uploads
```

### Correo no se envía
- Verifica que `SMTP_PASS` sea una contraseña de aplicación de Google (16 caracteres)
- Revisa el log de PHP: `sudo tail -f /var/log/php-fpm/error.log`
- Prueba la conexión SMTP: `telnet smtp.gmail.com 587`

### mod_rewrite no funciona
```bash
sudo nano /etc/httpd/conf/httpd.conf
```
Busca y cambia:
```apache
<Directory "/var/www/html">
    AllowOverride All  # Cambiar de None a All
</Directory>
```

## Seguridad

1. **Elimina `install.php`** después de la instalación
2. **Cambia la contraseña admin** inmediatamente
3. **Usa HTTPS** (Let's Encrypt)
4. **Restringe acceso** a `config/app.php` (chmod 600)
5. **Actualiza regularmente** el sistema y PHP
6. **Backups** periódicos de la base de datos:
   ```bash
   mysqldump -u mesa_user -p mesa_partes > backup_$(date +%Y%m%d).sql
   ```

## Soporte

Para reportar problemas o sugerencias, abre un issue en:
https://github.com/Dontoti02/m-partes-sang/issues

## Licencia

Proyecto desarrollado para el IESTP Sangarará.
