<?php
require_once __DIR__ . "/../config/ConexionDB.php";
require_once __DIR__ . "/../models/CertificadoModel.php";

class CertificadoController {
    private $db;

    public function __construct() {
        $this->db = ConexionDB::conectar();
    }

    /* ====== READ: Obtener todos ====== */
    public function getAll() {
        $sql = "SELECT id, usuario_id, titulo, entidad, fecha, url, seccion_id, orden 
                FROM certificados 
                ORDER BY orden ASC";
        $stmt = $this->db->query($sql);

        $resultados = [];
        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $cert = new CertificadoModel();
            $cert->setId($fila['id']);
            $cert->setUsuarioId($fila['usuario_id']);
            $cert->setTitulo($fila['titulo']);
            $cert->setEntidad($fila['entidad']);
            $cert->setFecha($fila['fecha']);
            $cert->setUrl($fila['url']);
            $cert->setSeccionId($fila['seccion_id']);
            $cert->setOrden($fila['orden']);
            $resultados[] = $cert;
        }
        return $resultados;
    }

    /* ====== READ: Paginado público de certificados (sin usuario) ====== */
        public function getPaginadoPublicoCertificado($pagina = 1, $por_pagina = 2) {
            // Asegurar valores válidos
            $pagina = max(1, (int)$pagina);
            $por_pagina = max(1, (int)$por_pagina);
            $offset = ($pagina - 1) * $por_pagina;

            // Consulta principal
            $sql = "SELECT 
                        id,
                        usuario_id,
                        titulo,
                        entidad,
                        fecha,
                        url,
                        seccion_id,
                        orden
                    FROM certificados
                    ORDER BY orden ASC
                    LIMIT :limit OFFSET :offset";

            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':limit', $por_pagina, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();

            // Crear modelos
            $resultados = [];
            while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $cert = new CertificadoModel();
                $cert->setId($fila['id']);
                $cert->setUsuarioId($fila['usuario_id']);
                $cert->setTitulo($fila['titulo']);
                $cert->setEntidad($fila['entidad']);
                $cert->setFecha($fila['fecha']);
                $cert->setUrl($fila['url']);
                $cert->setSeccionId($fila['seccion_id']);
                $cert->setOrden($fila['orden']);
                $resultados[] = $cert;
            }

            // Total de registros
            $sqlTotal = "SELECT COUNT(*) FROM certificados";
            $total = (int)$this->db->query($sqlTotal)->fetchColumn();

            return [
                "certificados"   => $resultados,
                "total"          => $total,
                "pagina"         => $pagina,
                "por_pagina"     => $por_pagina,
                "total_paginas"  => ceil($total / $por_pagina)
            ];
        }

        /* ====== READ: Paginado privado de certificados (por usuario) ====== */
        public function getPaginadoPrivadoCertificado($usuario_id, $pagina = 1, $por_pagina = 2) {
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
                // Consulta principal (con filtro por usuario)
                // ===============================
                $sql = "SELECT 
                            id,
                            usuario_id,
                            titulo,
                            entidad,
                            fecha,
                            url,
                            seccion_id,
                            orden
                        FROM certificados
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
                while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $cert = new CertificadoModel();
                    $cert->setId($fila['id']);
                    $cert->setUsuarioId($fila['usuario_id']);
                    $cert->setTitulo($fila['titulo']);
                    $cert->setEntidad($fila['entidad']);
                    $cert->setFecha($fila['fecha']);
                    $cert->setUrl($fila['url']);
                    $cert->setSeccionId($fila['seccion_id']);
                    $cert->setOrden($fila['orden']);
                    $resultados[] = $cert;
                }

                // ===============================
                // Total de registros del usuario
                // ===============================
                $sqlTotal = "SELECT COUNT(*) FROM certificados WHERE usuario_id = :usuario_id";
                $stmtTotal = $this->db->prepare($sqlTotal);
                $stmtTotal->bindValue(':usuario_id', $usuario_id, PDO::PARAM_INT);
                $stmtTotal->execute();
                $total = (int)$stmtTotal->fetchColumn();

                // ===============================
                // Retorno estructurado
                // ===============================
                return [
                    "certificados"   => $resultados,
                    "total"          => $total,
                    "pagina"         => $pagina,
                    "por_pagina"     => $por_pagina,
                    "total_paginas"  => ceil($total / $por_pagina)
                ];

            } catch (PDOException $e) {
                // Error en base de datos
                error_log("Error en getPaginadoPrivadoCertificado (PDO): " . $e->getMessage());
                return [
                    "certificados"   => [],
                    "total"          => 0,
                    "pagina"         => 1,
                    "por_pagina"     => $por_pagina,
                    "total_paginas"  => 0,
                    "error"          => "Error en la base de datos."
                ];
            } catch (Exception $e) {
                // Error general (usuario_id inválido u otros)
                error_log("Error en getPaginadoPrivadoCertificado: " . $e->getMessage());
                return [
                    "certificados"   => [],
                    "total"          => 0,
                    "pagina"         => 1,
                    "por_pagina"     => $por_pagina,
                    "total_paginas"  => 0,
                    "error"          => $e->getMessage()
                ];
            }
        }





    /* ====== READ: Obtener uno por ID ====== */
    public function getById($id) {
        $sql = "SELECT id, usuario_id, titulo, entidad, fecha, url, seccion_id, orden 
                FROM certificados 
                WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);

        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($fila) {
            $cert = new CertificadoModel();
            $cert->setId($fila['id']);
            $cert->setUsuarioId($fila['usuario_id']);
            $cert->setTitulo($fila['titulo']);
            $cert->setEntidad($fila['entidad']);
            $cert->setFecha($fila['fecha']);
            $cert->setUrl($fila['url']);
            $cert->setSeccionId($fila['seccion_id']);
            $cert->setOrden($fila['orden']);
            return $cert;
        }
        return null;
    }

    /* ====== CREATE ====== */
    public function create(CertificadoModel $cert) {
        $sql = "INSERT INTO certificados (usuario_id, titulo, entidad, fecha, url, seccion_id, orden) 
                VALUES (:usuario_id, :titulo, :entidad, :fecha, :url, :seccion_id, :orden)";
        $stmt = $this->db->prepare($sql);

        $ok = $stmt->execute([
            ':usuario_id' => $cert->getUsuarioId(),
            ':titulo'     => $cert->getTitulo(),
            ':entidad'    => $cert->getEntidad(),
            ':fecha'      => $cert->getFecha(),
            ':url'        => $cert->getUrl(),
            ':seccion_id' => $cert->getSeccionId(),
            ':orden'      => $cert->getOrden()
        ]);

        if ($ok) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    /* ====== UPDATE ====== */
    public function update($id, $data) {
        try {
            $campos = [];
            $params = [':id' => $id];

            foreach ($data as $columna => $valor) {
                if ($valor === "" || $valor === null) continue;
                $campos[] = "$columna = :$columna";
                $params[":$columna"] = $valor;
            }

            if (empty($campos)) return false;

            $sql = "UPDATE certificados SET " . implode(", ", $campos) . " WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute($params);

        } catch (PDOException $e) {
            return false;
        }
    }

    /* ====== DELETE ====== */
    public function delete($id) {
        $sql = "DELETE FROM certificados WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
