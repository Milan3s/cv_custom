<?php
require_once __DIR__ . "/../config/ConexionDB.php";
require_once __DIR__ . "/../models/OtrosDatosModel.php";

class OtrosDatosController {
    private $db;

    public function __construct() {
        $this->db = ConexionDB::conectar();
    }

    // ========================
    // Obtener todos (por usuario opcional)
    // ========================
    public function getAll($usuario_id = null) {
        if ($usuario_id) {
            $stmt = $this->db->prepare("SELECT * FROM otros_datos_interes 
                                        WHERE usuario_id = :usuario_id 
                                        ORDER BY orden ASC");
            $stmt->execute([":usuario_id" => $usuario_id]);
        } else {
            $stmt = $this->db->prepare("SELECT * FROM otros_datos_interes ORDER BY orden ASC");
            $stmt->execute();
        }

        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $otrosDatos = [];
        foreach ($resultados as $row) {
            $otrosDatos[] = new OtrosDatosModel(
                $row["id"],
                $row["usuario_id"],
                $row["titulo"],
                $row["descripcion"],
                $row["seccion_id"],
                $row["orden"]
            );
        }
        return $otrosDatos;
    }

    // ========================
    // Obtener por ID
    // ========================
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM otros_datos_interes WHERE id = :id LIMIT 1");
        $stmt->execute([":id" => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new OtrosDatosModel(
                $row["id"],
                $row["usuario_id"],
                $row["titulo"],
                $row["descripcion"],
                $row["seccion_id"],
                $row["orden"]
            );
        }
        return null;
    }

    // ========================
    // Crear nuevo
    // ========================
    public function create($usuario_id, $titulo, $descripcion, $seccion_id, $orden = null) {
        // Si no se pasa orden, lo calculamos
        if ($orden === null) {
            $stmtOrden = $this->db->prepare("SELECT COALESCE(MAX(orden), 0) + 1 
                                             FROM otros_datos_interes 
                                             WHERE usuario_id = :usuario_id 
                                               AND seccion_id = :seccion_id");
            $stmtOrden->execute([
                ":usuario_id" => $usuario_id,
                ":seccion_id" => $seccion_id
            ]);
            $orden = (int)$stmtOrden->fetchColumn();
        }

        $stmt = $this->db->prepare("INSERT INTO otros_datos_interes 
                                    (usuario_id, titulo, descripcion, seccion_id, orden) 
                                    VALUES (:usuario_id, :titulo, :descripcion, :seccion_id, :orden)");
        $success = $stmt->execute([
            ":usuario_id"  => $usuario_id,
            ":titulo"      => $titulo,
            ":descripcion" => $descripcion,
            ":seccion_id"  => $seccion_id,
            ":orden"       => $orden
        ]);

        return $success ? $this->db->lastInsertId() : false;
    }

    // ========================
    // Actualizar existente
    // ========================
    public function update($id, array $data) {
        $stmt = $this->db->prepare("UPDATE otros_datos_interes 
                                    SET titulo = :titulo, 
                                        descripcion = :descripcion, 
                                        seccion_id = :seccion_id, 
                                        orden = :orden 
                                    WHERE id = :id 
                                    AND usuario_id = :usuario_id");

        return $stmt->execute([
            ":titulo"      => $data["titulo"],
            ":descripcion" => $data["descripcion"],
            ":seccion_id"  => $data["seccion_id"],
            ":orden"       => $data["orden"],
            ":id"          => $id,
            ":usuario_id"  => $data["usuario_id"]
        ]);
    }


    // ========================
    // Eliminar
    // ========================
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM otros_datos_interes WHERE id = :id");
        return $stmt->execute([":id" => $id]);
    }

    // ========================
    // Reordenar tras delete/update
    // ========================
    public function reordenar($usuario_id, $seccion_id) {
        $stmt = $this->db->prepare("SELECT id FROM otros_datos_interes 
                                    WHERE usuario_id = :usuario_id 
                                      AND seccion_id = :seccion_id 
                                    ORDER BY orden ASC");
        $stmt->execute([
            ":usuario_id" => $usuario_id,
            ":seccion_id" => $seccion_id
        ]);
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $orden = 1;
        foreach ($items as $item) {
            $stmtUpdate = $this->db->prepare("UPDATE otros_datos_interes SET orden = :orden WHERE id = :id");
            $stmtUpdate->execute([
                ":orden" => $orden,
                ":id"    => $item["id"]
            ]);
            $orden++;
        }
    }
}
