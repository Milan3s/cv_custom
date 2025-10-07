# 📄 Guía de Instalación - CV Custom (CRUD PHP MySQL POO PDO)

<p align="center">
  <a href="https://www.php.net/" target="_blank">
    <img src="https://www.php.net/images/logos/new-php-logo.svg" width="200" alt="PHP Logo">
  </a>
</p>

---

## 📋 Prerrequisitos

Antes de comenzar, asegúrate de tener instalado:

1. **XAMPP** (para Apache y MySQL)  
   🔗 [Descargar XAMPP](https://www.apachefriends.org/)

2. **phpMyAdmin** (incluido con XAMPP)

3. **Editor de código** (recomendado Visual Studio Code)  
   🔗 [Visual Studio Code](https://code.visualstudio.com/)

---

## 📦 Paso 1: Clonar o Copiar el Proyecto

Clona o copia el repositorio del proyecto `cv_custom` en tu carpeta de servidor local:

- En Windows:  
  `C:\xampp\htdocs\cv_custom`

- En macOS/Linux (con MAMP o XAMPP):  
  `/Applications/XAMPP/htdocs/cv_custom`

---

## 🗃️ Paso 2: Crear la Base de Datos

1. Abre tu navegador y entra a **phpMyAdmin**:  
   👉 [http://localhost/phpmyadmin](http://localhost/phpmyadmin)

2. Crea una nueva base de datos llamada:

   cv_custom   

3. Haz clic en **Importar** y selecciona el archivo SQL del proyecto:
   
   cv_custom.sql
   
   (o el archivo SQL que te haya sido proporcionado con el proyecto).

4. Pulsa **Continuar** para ejecutar la importación.

---

## ⚙️ Paso 3: Configuración del Proyecto

No es necesario usar `.env`, pero asegúrate de que tu configuración de conexión a la base de datos (en el archivo PHP correspondiente, normalmente `config/database.php` o similar) tenga lo siguiente:

```php
$host = '127.0.0.1';
$dbname = 'cv_custom';
$username = 'root';
$password = '';
```

---

## ▶️ Paso 4: Iniciar el Servidor Local

1. Abre el **Panel de Control de XAMPP**.
2. Inicia los módulos:
   - ✅ Apache  
   - ✅ MySQL  
3. Verifica que ambos estén activos (color verde).

---

## 🌐 Paso 5: Acceder al Proyecto

### 👉 Acceso al Backend (login y gestión del CRUD)

Abre tu navegador y entra en:  
```
http://localhost/cv_custom/mvc/views/acceder/login.php
```

### 🌍 Acceso al Sitio Público (vista del CV)

Para ver la versión pública del CV, entra en:  
```
http://localhost/cv_custom/index.php
```

---

## 🧩 Tecnologías Usadas

- **PHP 8+**
- **MySQL / phpMyAdmin**
- **PDO (PHP Data Objects)**
- **Programación Orientada a Objetos (POO)**
- **HTML / CSS / JavaScript**

---

## ⚡ Descripción

Este proyecto es un **CRUD completo (Crear, Leer, Actualizar y Eliminar)** de un **Currículum Vitae personal**, desarrollado en **PHP con POO y PDO**, con una interfaz de administración para gestionar:

- Certificados  
- Educación  
- Experiencia laboral  
- Habilidades  
- Perfil profesional  
- Redes sociales  
- Secciones del CV  
- Usuarios  

---

## 👨‍💻 Autor

✍️ **Desarrollado por:** Milan3s  
📌 **Proyecto:** CV Custom  
🗓️ **Base de datos:** MySQL (phpMyAdmin)  
💻 **Tecnología:** PHP + PDO + POO  
