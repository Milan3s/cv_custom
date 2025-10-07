<?php
require_once __DIR__ . "/../config/ConexionDB.php";
require_once __DIR__ . "/../models/RedesModel.php";

class RedesController {
    private $db;

    public function __construct() {
        $this->db = ConexionDB::conectar();
    }

    /**
     * Obtener todas las redes sociales visibles y ordenadas
     * @return array
     */
    public function getAll() {
        $sql = "SELECT * FROM redes_sociales ORDER BY orden ASC";
        $stmt = $this->db->query($sql);

        $redes_sociales = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $red = new RedesModel();
            $red->setId($row['id']);
            $red->setUsuarioId($row['usuario_id']);
            $red->setPlataforma($row['plataforma']);
            $red->setUrl($row['url']);
            $red->setUsuario($row['usuario']);
            $red->setIcono($row['icono']);
            $red->setOrden($row['orden']);
            $red->setVisible($row['visible']);

            $redes_sociales[] = $red;
        }

        return $redes_sociales;
    }

    /**
     * Obtener red social por ID
     */
    public function getById($id) {
        $sql = "SELECT * FROM redes_sociales WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $redes_sociales = new RedesModel();
            $redes_sociales->setId($row['id']);
            $redes_sociales->setUsuarioId($row['usuario_id']);
            $redes_sociales->setPlataforma($row['plataforma']);
            $redes_sociales->setUrl($row['url']);
            $redes_sociales->setUsuario($row['usuario']);
            $redes_sociales->setIcono($row['icono']);
            $redes_sociales->setOrden($row['orden']);
            $redes_sociales->setVisible($row['visible']);

            return $redes_sociales;
        }
        return null;
    }

    /**
     * Crear nueva red social
     */
    public function create(RedesModel $redes_sociales) {
        // fallback por si vienen valores vacíos
        $usuarioId = $redes_sociales->getUsuarioId() ?: 1;
        $orden = $redes_sociales->getOrden() ?: 1;
        $visible = $redes_sociales->getVisible();
        if ($visible === null) {
            $visible = 1; // por defecto visible
        }

        $sql = "INSERT INTO redes_sociales (usuario_id, plataforma, url, usuario, icono, orden, visible)
                VALUES (:usuario_id, :plataforma, :url, :usuario, :icono, :orden, :visible)";
        $stmt = $this->db->prepare($sql);

        $ok = $stmt->execute([
            ':usuario_id' => $usuarioId,
            ':plataforma' => $redes_sociales->getPlataforma(),
            ':url'        => $redes_sociales->getUrl(),
            ':usuario'    => $redes_sociales->getUsuario(),
            ':icono'      => $redes_sociales->getIcono(),
            ':orden'      => $orden,
            ':visible'    => $visible
        ]);

        if ($ok) {
            return $this->db->lastInsertId(); // devolver id real
        }
        return false;
    }


    /**
     * Actualizar red social (dinámico: solo actualiza los campos recibidos)
     */
    public function update($id, $datos) {
        try {
            $campos = [];
            $params = [':id' => $id];

            foreach ($datos as $columna => $valor) {
                $campos[] = "$columna = :$columna";
                $params[":$columna"] = $valor;
            }

            if (empty($campos)) return false; // nada que actualizar

            $sql = "UPDATE redes_sociales SET " . implode(", ", $campos) . " WHERE id = :id";
            $stmt = $this->db->prepare($sql);

            return $stmt->execute($params);
        } catch (PDOException $e) {
            die("Error al actualizar red social: " . $e->getMessage());
        }
    }

    /**
     * Eliminar red social por ID
     */
    public function delete($id) {
        $sql = "DELETE FROM redes_sociales WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
