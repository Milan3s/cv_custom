# 📄 Guía de Instalación - CV Custom (CRUD PHP MySQL POO PDO)

<p align="center">
  <a href="https://www.php.net/" target="_blank">
    <img src="https://www.php.net/images/logos/new-php-logo.svg" width="200" alt="PHP Logo">
  </a>
</p>

---

## 🚀 Tecnologías Utilizadas

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)
![PDO](https://img.shields.io/badge/PDO-Database%20Access-lightgrey?style=for-the-badge)
![POO](https://img.shields.io/badge/POO-Orientado%20a%20Objetos-blue?style=for-the-badge)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)

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

   ```
   cv_custom
   ```

3. Haz clic en **Importar** y selecciona el archivo SQL del proyecto:

   ```
   /cv_custom/mvc/database/cv_custom.sql
   ```

4. Pulsa **Continuar** para ejecutar la importación.

---

## ⚙️ Paso 3: Configuración del Proyecto

Edita la configuración de conexión a la base de datos, normalmente ubicada en:

```
/mvc/config/database.php
```

Ejemplo:

```php
$host = '127.0.0.1';
$dbname = 'cv_custom';
$username = 'root';
$password = '';
```

No se requiere archivo `.env` para este proyecto.

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

## 🧩 Estructura del Proyecto

```
cv_custom/
│
├── assets/                   # Recursos estáticos (CSS, JS, imágenes)
├── mvc/
│   ├── ajax/                 # Peticiones asíncronas
│   ├── config/               # Configuración y conexión DB
│   ├── controllers/          # Controladores MVC
│   ├── models/               # Modelos (lógica de negocio y consultas)
│   ├── noperimitido/         # Páginas de error/acceso denegado
│   ├── partials/             # Componentes comunes (header, footer)
│   └── views/                # Vistas del sistema
│       ├── acceder/          # Login, logout y registro
│       ├── certificados/
│       ├── educacion/
│       ├── experiencia/
│       ├── habilidades/
│       ├── otros-datos/
│       ├── perfil/
│       ├── redes/
│       └── secciones/
└── index.php                 # Punto de entrada principal
```

---

## ⚡ Descripción

**CV Custom** es un sistema CRUD completo para la gestión de un **Currículum Vitae profesional**, desarrollado en **PHP (POO + PDO)** y **MySQL**.

Permite administrar desde un panel seguro la información del usuario, incluyendo:

- Certificados  
- Educación  
- Experiencia laboral  
- Habilidades  
- Perfil profesional  
- Redes sociales  
- Secciones del CV  
- Usuarios y autenticación

---

## 👨‍💻 Autor

✍️ **Desarrollado por:** Milan3s  
📌 **Proyecto:** CV Custom  
🗓️ **Base de datos:** MySQL (phpMyAdmin)  
💻 **Tecnología:** PHP + PDO + POO  

---

© 2025 - Proyecto educativo y de libre uso.
