<?php
require_once __DIR__ . "/../config/ConexionDB.php";
require_once __DIR__ . "/../models/ExperienciaModel.php";

class ExperienciaController {
    private $db;

    public function __construct() {
        $this->db = ConexionDB::conectar();
    }

    /* ====== READ: Obtener todas las experiencias ====== */
    public function getAll() {
        $sql = "SELECT * FROM experiencia ORDER BY orden ASC";
        $stmt = $this->db->query($sql);

        $resultados = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $exp = new ExperienciaModel();
            $exp->setId($row['id']);
            $exp->setUsuarioId($row['usuario_id']);
            $exp->setEmpresa($row['empresa']);
            $exp->setRol($row['rol']);
            $exp->setUbicacion($row['ubicacion']);
            $exp->setFechaInicio($row['fecha_inicio']);
            $exp->setFechaFin($row['fecha_fin']);
            $exp->setDescripcion($row['descripcion']);
            $exp->setSeccionId($row['seccion_id']);
            $exp->setOrden($row['orden']);
            $resultados[] = $exp;
        }
        return $resultados;
    }
   /* ====== READ: Paginado público de experiencias (sin usuario) ====== */
    public function getPaginadoPublicoExperiencia($pagina = 1, $por_pagina = 2) {
        // Asegurar valores válidos
        $pagina = max(1, (int)$pagina);
        $por_pagina = max(1, (int)$por_pagina);
        $offset = ($pagina - 1) * $por_pagina;

        // Consulta principal con límite y desplazamiento
        $sql = "SELECT 
                    id,
                    usuario_id,
                    empresa,
                    rol,
                    ubicacion,
                    fecha_inicio,
                    fecha_fin,
                    descripcion,
                    seccion_id,
                    orden
                FROM experiencia
                ORDER BY orden ASC
                LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $por_pagina, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        // Construir los objetos ExperienciaModel
        $resultados = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $exp = new ExperienciaModel();
            $exp->setId($row['id']);
            $exp->setUsuarioId($row['usuario_id']);
            $exp->setEmpresa($row['empresa']);
            $exp->setRol($row['rol']);
            $exp->setUbicacion($row['ubicacion']);
            $exp->setFechaInicio($row['fecha_inicio']);
            $exp->setFechaFin($row['fecha_fin']);
            $exp->setDescripcion($row['descripcion']);
            $exp->setSeccionId($row['seccion_id']);
            $exp->setOrden($row['orden']);
            $resultados[] = $exp;
        }

        // Total de registros
        $sqlTotal = "SELECT COUNT(*) FROM experiencia";
        $total = (int)$this->db->query($sqlTotal)->fetchColumn();

        // Retorno del paginado
        return [
            "experiencias"   => $resultados,
            "total"          => $total,
            "pagina"         => $pagina,
            "por_pagina"     => $por_pagina,
            "total_paginas"  => ceil($total / $por_pagina)
        ];
    }


   /* ====== READ: Paginado privado de experiencias (por usuario) ====== */
    public function getPaginadoPrivadoExperiencia($usuario_id, $pagina = 1, $por_pagina = 2) {
        try {
            // ===============================
            // Validación de parámetros
            // ===============================
            $usuario_id = (int)$usuario_id;
            if ($usuario_id <= 0) {
                throw new Exception("ID de usuario no válido");
            }

            $pagina = max(1, (int)$pagina);
            $por_pagina = max(1, (int)$por_pagina);
            $offset = ($pagina - 1) * $por_pagina;

            // ===============================
            // Consulta principal (paginada)
            // ===============================
            $sql = "SELECT 
                        id,
                        usuario_id,
                        empresa,
                        rol,
                        ubicacion,
                        fecha_inicio,
                        fecha_fin,
                        descripcion,
                        seccion_id,
                        orden
                    FROM experiencia
                    WHERE usuario_id = :usuario_id
                    ORDER BY orden ASC
                    LIMIT :limit OFFSET :offset";

            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':usuario_id', $usuario_id, PDO::PARAM_INT);
            $stmt->bindValue(':limit', $por_pagina, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();

            // ===============================
            // Construcción de modelos
            // ===============================
            $resultados = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $exp = new ExperienciaModel();
                $exp->setId($row['id']);
                $exp->setUsuarioId($row['usuario_id']);
                $exp->setEmpresa($row['empresa']);
                $exp->setRol($row['rol']);
                $exp->setUbicacion($row['ubicacion']);
                $exp->setFechaInicio($row['fecha_inicio']);
                $exp->setFechaFin($row['fecha_fin']);
                $exp->setDescripcion($row['descripcion']);
                $exp->setSeccionId($row['seccion_id']);
                $exp->setOrden($row['orden']);
                $resultados[] = $exp;
            }

            // ===============================
            // Total de registros (usuario)
            // ===============================
            $sqlTotal = "SELECT COUNT(*) FROM experiencia WHERE usuario_id = :usuario_id";
            $stmtTotal = $this->db->prepare($sqlTotal);
            $stmtTotal->bindValue(':usuario_id', $usuario_id, PDO::PARAM_INT);
            $stmtTotal->execute();
            $total = (int)$stmtTotal->fetchColumn();

            // ===============================
            // Resultado final
            // ===============================
            return [
                "experiencias"   => $resultados,
                "total"          => $total,
                "pagina"         => $pagina,
                "por_pagina"     => $por_pagina,
                "total_paginas"  => ceil($total / $por_pagina)
            ];

        } catch (PDOException $e) {
            // Error en la base de datos
            error_log("Error en getPaginadoPrivadoExperiencia (PDO): " . $e->getMessage());
            return [
                "experiencias"   => [],
                "total"          => 0,
                "pagina"         => 1,
                "por_pagina"     => $por_pagina,
                "total_paginas"  => 0,
                "error"          => "Error en la base de datos."
            ];
        } catch (Exception $e) {
            // Error general (por ejemplo, usuario_id inválido)
            error_log("Error en getPaginadoPrivadoExperiencia: " . $e->getMessage());
            return [
                "experiencias"   => [],
                "total"          => 0,
                "pagina"         => 1,
                "por_pagina"     => $por_pagina,
                "total_paginas"  => 0,
                "error"          => $e->getMessage()
            ];
        }
    }






    /* ====== READ: Obtener una experiencia por ID ====== */
    public function getById($id) {
        $sql = "SELECT * FROM experiencia WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $exp = new ExperienciaModel();
            $exp->setId($row['id']);
            $exp->setUsuarioId($row['usuario_id']);
            $exp->setEmpresa($row['empresa']);
            $exp->setRol($row['rol']);
            $exp->setUbicacion($row['ubicacion']);
            $exp->setFechaInicio($row['fecha_inicio']);
            $exp->setFechaFin($row['fecha_fin']);
            $exp->setDescripcion($row['descripcion']);
            $exp->setSeccionId($row['seccion_id']);
            $exp->setOrden($row['orden']);
            return $exp;
        }
        return null;
    }

    /* ====== CREATE: Insertar nueva experiencia ====== */
    public function create(ExperienciaModel $exp) {
        $sql = "INSERT INTO experiencia (usuario_id, empresa, rol, ubicacion, fecha_inicio, fecha_fin, descripcion, seccion_id, orden) 
                VALUES (:usuario_id, :empresa, :rol, :ubicacion, :fecha_inicio, :fecha_fin, :descripcion, :seccion_id, :orden)";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':usuario_id'   => $exp->getUsuarioId(),
            ':empresa'      => $exp->getEmpresa(),
            ':rol'          => $exp->getRol(),
            ':ubicacion'    => $exp->getUbicacion(),
            ':fecha_inicio' => $exp->getFechaInicio(),
            ':fecha_fin'    => $exp->getFechaFin(),
            ':descripcion'  => $exp->getDescripcion(),
            ':seccion_id'   => $exp->getSeccionId(),
            ':orden'        => $exp->getOrden()
        ]);
    }

    /* ====== UPDATE: Actualizar experiencia (dinámico) ====== */
    public function update($id, $datos) {
        try {
            $expActual = $this->getById($id);
            if (!$expActual) return false;

            $sql = "UPDATE experiencia 
                    SET empresa = :empresa, 
                        rol = :rol, 
                        ubicacion = :ubicacion, 
                        fecha_inicio = :fecha_inicio, 
                        fecha_fin = :fecha_fin, 
                        descripcion = :descripcion, 
                        seccion_id = :seccion_id, 
                        orden = :orden
                    WHERE id = :id";

            $stmt = $this->db->prepare($sql);

            return $stmt->execute([
                ':empresa'      => $datos['empresa']      ?? $expActual->getEmpresa(),
                ':rol'          => $datos['rol']          ?? $expActual->getRol(),
                ':ubicacion'    => $datos['ubicacion']    ?? $expActual->getUbicacion(),
                ':fecha_inicio' => $datos['fecha_inicio'] ?? $expActual->getFechaInicio(),
                ':fecha_fin'    => $datos['fecha_fin']    ?? $expActual->getFechaFin(),
                ':descripcion'  => $datos['descripcion']  ?? $expActual->getDescripcion(),
                ':seccion_id'   => $datos['seccion_id']   ?? $expActual->getSeccionId(),
                ':orden'        => $datos['orden']        ?? $expActual->getOrden(),
                ':id'           => $id
            ]);
        } catch (PDOException $e) {
            die("Error al actualizar experiencia: " . $e->getMessage());
        }
    }

    /* ====== DELETE: Eliminar experiencia ====== */
    public function delete($id) {
        $sql = "DELETE FROM experiencia WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
