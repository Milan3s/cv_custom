<?php
class ConexionDB {
    private static $conexion = null;

    /**
     * Detecta entorno y configura los parámetros dinámicamente
     */
    private static function getConfig() {
        $hostName = $_SERVER['HTTP_HOST'] ?? 'localhost';

        // 🔹 Configuración LOCAL
        if (strpos($hostName, 'localhost') !== false) {
            return [
                'host' => 'localhost',
                'dbname' => 'cv_custom',
                'username' => 'root',
                'password' => ''
            ];
        }

        // 🔹 Configuración PRODUCCIÓN (dmilanes.es)
        return [
            'host' => 'localhost',          // El host del servidor remoto (probablemente localhost)
            'dbname' => 'cv_custom',        // Nombre exacto de la base de datos en el hosting
            'username' => 'admin',          // Usuario MySQL del hosting
            'password' => 'Milanes1982-'    // Contraseña MySQL del hosting
        ];
    }

    /**
     * Conecta a la base de datos mediante PDO
     */
    public static function conectar() {
        if (self::$conexion === null) {
            try {
                $config = self::getConfig();
                $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8mb4";

                self::$conexion = new PDO($dsn, $config['username'], $config['password'], [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]);
            } catch (PDOException $e) {
                // 🔹 En producción, mejor no mostrar detalles del error
                if (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false) {
                    die("<strong>Error de conexión:</strong> " . $e->getMessage());
                } else {
                    error_log("❌ Error de conexión BD: " . $e->getMessage());
                    die("Error al conectar con la base de datos. Inténtelo más tarde.");
                }
            }
        }
        return self::$conexion;
    }
}
