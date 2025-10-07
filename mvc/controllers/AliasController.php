<?php
require_once __DIR__ . "/../config/ConexionDB.php";
require_once __DIR__ . "/../models/AliasModel.php";

class AliasController {
    private $db;

    public function __construct() {
        $this->db = ConexionDB::conectar();
    }

    /* ==============================
       📌 CREAR PERFIL (INSERT)
    ============================== */
    public function crearPerfil($datos, $usuarioId = 1) {
        try {
            $query = "INSERT INTO perfil 
                      (usuario_id, alias, profesion, bio, email, telefono, direccion, sitio_web, 
                       icono_email, icono_telefono, icono_direccion, foto, creado_en)
                      VALUES 
                      (:usuario_id, :alias, :profesion, :bio, :email, :telefono, :direccion, :sitio_web, 
                       :icono_email, :icono_telefono, :icono_direccion, :foto, NOW())";

            $stmt = $this->db->prepare($query);

            return $stmt->execute([
                ':usuario_id'      => $usuarioId,
                ':alias'           => $datos['alias'] ?? '',
                ':profesion'       => $datos['profesion'] ?? '',
                ':bio'             => $datos['bio'] ?? '',
                ':email'           => $datos['email'] ?? '',
                ':telefono'        => $datos['telefono'] ?? '',
                ':direccion'       => $datos['direccion'] ?? '',
                ':sitio_web'       => $datos['sitio_web'] ?? '',
                ':icono_email'     => $datos['icono_email'] ?? '',
                ':icono_telefono'  => $datos['icono_telefono'] ?? '',
                ':icono_direccion' => $datos['icono_direccion'] ?? '',
                ':foto'            => $datos['foto'] ?? null,
            ]);
        } catch (PDOException $e) {
            die("❌ Error al crear perfil: " . $e->getMessage());
        }
    }

    /* ==============================
       📌 OBTENER PERFIL (SELECT)
    ============================== */
    public function getPerfil($usuarioId = 1) {
        try {
            $query = "SELECT id, usuario_id, alias, profesion, bio, email, telefono, direccion, sitio_web, foto,
                             icono_email, icono_telefono, icono_direccion, creado_en
                      FROM perfil 
                      WHERE usuario_id = :usuario_id
                      LIMIT 1";

            $stmt = $this->db->prepare($query);
            $stmt->execute([":usuario_id" => $usuarioId]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            $perfil = new AliasModel();
            if ($data) {
                $perfil->setId($data['id']);
                $perfil->setUsuarioId($data['usuario_id']);
                $perfil->setAlias($data['alias']);
                $perfil->setProfesion($data['profesion']);
                $perfil->setBio($data['bio']);
                $perfil->setEmail($data['email']);
                $perfil->setTelefono($data['telefono']);
                $perfil->setDireccion($data['direccion']);
                $perfil->setSitioWeb($data['sitio_web']);
                $perfil->setFoto($data['foto']);
                $perfil->setIconoEmail($data['icono_email']);
                $perfil->setIconoTelefono($data['icono_telefono']);
                $perfil->setIconoDireccion($data['icono_direccion']);
                $perfil->setCreadoEn($data['creado_en']);
            }
            return $perfil;
        } catch (PDOException $e) {
            die("❌ Error al obtener perfil: " . $e->getMessage());
        }
    }

    /* ==============================
       📌 ACTUALIZAR PERFIL (UPDATE dinámico)
    ============================== */
    public function actualizarPerfil($datos, $usuarioId = 1) {
        try {
            if (empty($datos)) return false;

            $setParts = [];
            $params   = [":usuario_id" => $usuarioId];

            foreach ($datos as $campo => $valor) {
                $setParts[] = "$campo = :$campo";
                $params[":$campo"] = $valor;
            }

            $query = "UPDATE perfil SET " . implode(", ", $setParts) . " WHERE usuario_id = :usuario_id";
            $stmt  = $this->db->prepare($query);

            return $stmt->execute($params);
        } catch (PDOException $e) {
            die("❌ Error al actualizar perfil: " . $e->getMessage());
        }
    }

    /* ==============================
       📌 ELIMINAR PERFIL (DELETE)
    ============================== */
    public function eliminarPerfil($usuarioId = 1) {
        try {
            $query = "DELETE FROM perfil WHERE usuario_id = :usuario_id";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([":usuario_id" => $usuarioId]);
        } catch (PDOException $e) {
            die("❌ Error al eliminar perfil: " . $e->getMessage());
        }
    }
}
