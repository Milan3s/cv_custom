<?php
require_once __DIR__ . "/../config/ConexionDB.php";
require_once __DIR__ . "/../models/HabilidadModel.php";

class HabilidadController {
    private $db;

    public function __construct() {
        $this->db = ConexionDB::conectar();
    }

    /* ====== READ: Obtener todas las habilidades ====== */
    public function getAll() {
        $sql = "SELECT * FROM habilidades ORDER BY orden ASC";
        $stmt = $this->db->query($sql);

        $habilidades = [];
        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $h = new HabilidadModel();
            $h->setId((int)$fila['id']);
            $h->setUsuarioId((int)$fila['usuario_id']);
            $h->setTipo($fila['tipo']);
            $h->setNombre($fila['nombre']);
            $h->setDescripcion($fila['descripcion'] ?? null);
            $h->setSeccionId($fila['seccion_id'] !== null ? (int)$fila['seccion_id'] : null);
            $h->setOrden($fila['orden'] !== null ? (int)$fila['orden'] : null);
            $habilidades[] = $h;
        }

        return $habilidades;
    }

    /* ====== READ: Obtener habilidad por ID ====== */
    public function getById($id) {
        $sql = "SELECT * FROM habilidades WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => (int)$id]);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($fila) {
            $h = new HabilidadModel();
            $h->setId((int)$fila['id']);
            $h->setUsuarioId((int)$fila['usuario_id']);
            $h->setTipo($fila['tipo']);
            $h->setNombre($fila['nombre']);
            $h->setDescripcion($fila['descripcion'] ?? null);
            $h->setSeccionId($fila['seccion_id'] !== null ? (int)$fila['seccion_id'] : null);
            $h->setOrden($fila['orden'] !== null ? (int)$fila['orden'] : null);
            return $h;
        }
        return null;
    }

    /* ====== CREATE ====== */
    public function create($data) {
        if (empty($data['orden'])) {
            $data['orden'] = $this->getNextOrden($data['usuario_id'], $data['seccion_id']);
        }

        $sql = "INSERT INTO habilidades (usuario_id, tipo, nombre, descripcion, seccion_id, orden) 
                VALUES (:usuario_id, :tipo, :nombre, :descripcion, :seccion_id, :orden)";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':usuario_id'  => (int)$data['usuario_id'],
            ':tipo'        => $data['tipo'],
            ':nombre'      => $data['nombre'],
            ':descripcion' => $data['descripcion'] ?? null,
            ':seccion_id'  => $data['seccion_id'] !== null ? (int)$data['seccion_id'] : null,
            ':orden'       => $data['orden'] !== null ? (int)$data['orden'] : null
        ]);
    }

    /* ====== UPDATE ====== */
    public function update($id, $data) {
        $sql = "UPDATE habilidades 
                SET usuario_id = :usuario_id,
                    tipo = :tipo,
                    nombre = :nombre,
                    descripcion = :descripcion,
                    seccion_id = :seccion_id,
                    orden = :orden
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':usuario_id'  => (int)$data['usuario_id'],
            ':tipo'        => $data['tipo'],
            ':nombre'      => $data['nombre'],
            ':descripcion' => $data['descripcion'] ?? null,
            ':seccion_id'  => $data['seccion_id'] !== null ? (int)$data['seccion_id'] : null,
            ':orden'       => $data['orden'] !== null ? (int)$data['orden'] : null,
            ':id'          => (int)$id
        ]);
    }

    /* ====== DELETE ====== */
    public function delete($id) {
        $sql = "DELETE FROM habilidades WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => (int)$id]);
    }

    /* ====== EXTRA: Obtener valores ENUM de tipo ====== */
    public function getTipos() {
        $sql = "SHOW COLUMNS FROM habilidades LIKE 'tipo'";
        $stmt = $this->db->query($sql);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            preg_match_all("/'([^']+)'/", $row['Type'], $matches);
            return $matches[1] ?? [];
        }
        return [];
    }

    /* ====== EXTRA: Obtener siguiente orden ====== */
    public function getNextOrden($usuarioId, $seccionId) {
        $sql = "SELECT COALESCE(MAX(orden),0)+1 as next 
                FROM habilidades 
                WHERE usuario_id = :uid AND seccion_id = :sid";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':uid' => (int)$usuarioId, 
            ':sid' => $seccionId !== null ? (int)$seccionId : null
        ]);
        return (int)$stmt->fetchColumn();
    }
}
