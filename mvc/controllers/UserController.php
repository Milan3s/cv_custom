<?php
require_once __DIR__ . "/../config/ConexionDB.php";
require_once __DIR__ . "/../models/UserModel.php";

class UserController {
    private $db;

    public function __construct() {
        $this->db = ConexionDB::conectar();
    }

    /* ========= REGISTER ========= */
    public function register($nombre, $email, $password) {
        $sql = "INSERT INTO usuarios (nombre, email, password) 
                VALUES (:nombre, :email, :password)";
        $stmt = $this->db->prepare($sql);
        $hash = password_hash($password, PASSWORD_BCRYPT);

        return $stmt->execute([
            ':nombre'   => $nombre,
            ':email'    => $email,
            ':password' => $hash
        ]);
    }

    /* ========= LOGIN ========= */
    public function login($nombre, $password) {
        $sql = "SELECT * FROM usuarios WHERE nombre = :nombre LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':nombre' => $nombre]);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($fila && password_verify($password, $fila['password'])) {
            $user = new UserModel();
            $user->setId($fila['id']);
            $user->setNombre($fila['nombre']);
            $user->setEmail($fila['email']);
            $user->setPassword($fila['password']);
            return $user;
        }
        return false;
    }

    /* ========= CRUD USUARIOS ========= */
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM usuarios");
        $usuarios = [];
        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $user = new UserModel();
            $user->setId($fila['id']);
            $user->setNombre($fila['nombre']);
            $user->setEmail($fila['email']);
            $usuarios[] = $user;
        }
        return $usuarios;
    }

    public function getById($id) {
        $sql = "SELECT * FROM usuarios WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($fila) {
            $user = new UserModel();
            $user->setId($fila['id']);
            $user->setNombre($fila['nombre']);
            $user->setEmail($fila['email']);
            $user->setPassword($fila['password']);
            return $user;
        }
        return null;
    }

    public function update($id, $nombre, $email) {
        $sql = "UPDATE usuarios SET nombre = :nombre, email = :email WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nombre' => $nombre,
            ':email'  => $email,
            ':id'     => $id
        ]);
    }

    public function delete($id) {
        $sql = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
