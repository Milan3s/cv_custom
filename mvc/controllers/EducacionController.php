<?php
require_once __DIR__ . "/../config/ConexionDB.php";
require_once __DIR__ . "/../models/EducacionModel.php";

class EducacionController {
    private $db;

    public function __construct() {
        $this->db = ConexionDB::conectar();
    }

    /* ====== READ: Obtener todas las entradas de educación ====== */
    public function getAll() {
    $sql = "SELECT id, usuario_id, centro, titulacion, ubicacion, fecha_inicio, fecha_fin, descripcion, seccion_id, orden 
            FROM educacion 
            ORDER BY orden ASC";
    $stmt = $this->db->query($sql);
    
    $resultados = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $educacion = new EducacionModel();
        $educacion->setId($row['id']);
        $educacion->setUsuarioId($row['usuario_id']);
        $educacion->setCentro($row['centro']);
        $educacion->setTitulacion($row['titulacion']);
        $educacion->setUbicacion($row['ubicacion']);
        $educacion->setFechaInicio($row['fecha_inicio']);
        $educacion->setFechaFin($row['fecha_fin']);
        $educacion->setDescripcion($row['descripcion'] ?? "");
        $educacion->setSeccionId($row['seccion_id'] ?? null);
        $educacion->setOrden($row['orden']);
        $resultados[] = $educacion;
    }
    return $resultados;
}


    /* ====== READ: Obtener una entrada por ID ====== */
    public function getById($id) {
        $sql = "SELECT id, usuario_id, centro, titulacion, ubicacion, fecha_inicio, fecha_fin, orden 
                FROM educacion 
                WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $educacion = new EducacionModel();
            $educacion->setId($row['id']);
            $educacion->setUsuarioId($row['usuario_id']); // 👈 importante
            $educacion->setCentro($row['centro']);
            $educacion->setTitulacion($row['titulacion']);
            $educacion->setUbicacion($row['ubicacion']);
            $educacion->setFechaInicio($row['fecha_inicio']);
            $educacion->setFechaFin($row['fecha_fin']);
            $educacion->setOrden($row['orden']);
            return $educacion;
        }
        return null;
    }

    public function create(EducacionModel $educacion) {
            $usuarioId = $educacion->getUsuarioId() ?: 1;
            $orden = $educacion->getOrden() ?: 1; // 👈 fallback

            $sql = "INSERT INTO educacion (usuario_id, centro, titulacion, ubicacion, fecha_inicio, fecha_fin, orden) 
                    VALUES (:usuario_id, :centro, :titulacion, :ubicacion, :fecha_inicio, :fecha_fin, :orden)";
            $stmt = $this->db->prepare($sql);

            $ok = $stmt->execute([
                ':usuario_id'   => $usuarioId,
                ':centro'       => $educacion->getCentro(),
                ':titulacion'   => $educacion->getTitulacion(),
                ':ubicacion'    => $educacion->getUbicacion(),
                ':fecha_inicio' => $educacion->getFechaInicio(),
                ':fecha_fin'    => $educacion->getFechaFin(),
                ':orden'        => $orden
            ]);

            if ($ok) {
                return $this->db->lastInsertId(); 
            }
            return false;
        }


    /* ====== UPDATE dinámico ====== */
    public function update($id, $datos) {
        try {
            $campos = [];
            $params = [':id' => $id];

            foreach ($datos as $columna => $valor) {
                if ($valor === "" || $valor === null) {
                    continue;
                }

                $campos[] = "$columna = :$columna";
                $params[":$columna"] = $valor;
            }

            if (empty($campos)) return false;

            $sql = "UPDATE educacion SET " . implode(", ", $campos) . " WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute($params);

        } catch (PDOException $e) {
            die("Error al actualizar educación: " . $e->getMessage());
        }
    }

    /* ====== DELETE: Eliminar entrada ====== */
    public function delete($id) {
        $sql = "DELETE FROM educacion WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
