<?php
require_once __DIR__ . "/../config/ConexionDB.php";
require_once __DIR__ . "/../models/SeccionModel.php";

class SeccionController {
    private $db;

    public function __construct() {
        $this->db = ConexionDB::conectar();
    }

    /* ==============================
       📌 CREAR SECCIÓN (INSERT)
    ============================== */
    public function crearSeccion($datos, $usuarioId = 1) {
        try {
            $query = "INSERT INTO secciones 
                      (usuario_id, nombre, titulo, columna, icono, orden, creado_en)
                      VALUES 
                      (:usuario_id, :nombre, :titulo, :columna, :icono, :orden, NOW())";

            $stmt = $this->db->prepare($query);

            return $stmt->execute([
                ':usuario_id' => $usuarioId,
                ':nombre'     => $datos['nombre'] ?? '',
                ':titulo'     => $datos['titulo'] ?? '',
                ':columna'    => $datos['columna'] ?? 'izquierda',
                ':icono'      => $datos['icono'] ?? '',
                ':orden'      => $datos['orden'] ?? 1
            ]);
        } catch (PDOException $e) {
            die("❌ Error al crear sección: " . $e->getMessage());
        }
    }

    /* ==============================
       📌 OBTENER TODAS LAS SECCIONES
    ============================== */
    public function getSecciones($usuarioId = 1) {
        try {
            $query = "SELECT * FROM secciones WHERE usuario_id = :usuario_id ORDER BY orden ASC";
            $stmt  = $this->db->prepare($query);
            $stmt->execute([":usuario_id" => $usuarioId]);

            $secciones = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $sec = new SeccionModel();
                $sec->setId($row['id']);
                $sec->setUsuarioId($row['usuario_id']);
                $sec->setNombre($row['nombre']);
                $sec->setTitulo($row['titulo']);
                $sec->setColumna($row['columna']);
                $sec->setIcono($row['icono']);
                $sec->setOrden($row['orden']);
                $sec->setCreadoEn($row['creado_en']);
                $secciones[] = $sec;
            }
            return $secciones;
        } catch (PDOException $e) {
            die("❌ Error al obtener secciones: " . $e->getMessage());
        }
    }

    /* ==============================
       📌 OBTENER UNA SECCIÓN POR ID
    ============================== */
    public function getSeccionById($id) {
        try {
            $query = "SELECT * FROM secciones WHERE id = :id LIMIT 1";
            $stmt  = $this->db->prepare($query);
            $stmt->execute([":id" => $id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                $sec = new SeccionModel();
                $sec->setId($row['id']);
                $sec->setUsuarioId($row['usuario_id']);
                $sec->setNombre($row['nombre']);
                $sec->setTitulo($row['titulo']);
                $sec->setColumna($row['columna']);
                $sec->setIcono($row['icono']);
                $sec->setOrden($row['orden']);
                $sec->setCreadoEn($row['creado_en']);
                return $sec;
            }
            return null;
        } catch (PDOException $e) {
            die("❌ Error al obtener sección: " . $e->getMessage());
        }
    }

    /* ==============================
       📌 ACTUALIZAR SECCIÓN (UPDATE dinámico)
    ============================== */
    public function actualizarSeccion($id, $datos) {
        try {
            if (empty($datos)) return false;

            $setParts = [];
            $params   = [":id" => $id];

            foreach ($datos as $campo => $valor) {
                $setParts[] = "$campo = :$campo";
                $params[":$campo"] = $valor;
            }

            $query = "UPDATE secciones SET " . implode(", ", $setParts) . " WHERE id = :id";
            $stmt  = $this->db->prepare($query);

            return $stmt->execute($params);
        } catch (PDOException $e) {
            die("❌ Error al actualizar sección: " . $e->getMessage());
        }
    }

    /* ==============================
       📌 ELIMINAR SECCIÓN (DELETE)
    ============================== */
    public function eliminarSeccion($id) {
        try {
            $query = "DELETE FROM secciones WHERE id = :id";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([":id" => $id]);
        } catch (PDOException $e) {
            die("❌ Error al eliminar sección: " . $e->getMessage());
        }
    }
}
