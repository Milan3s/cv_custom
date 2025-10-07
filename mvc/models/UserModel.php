<?php

class UserModel {
    private $id;
    private $nombre;
    private $email;
    private $password;

    // ======= GETTERS =======
    public function getId() { 
        return $this->id; 
    }

    public function getNombre() { 
        return $this->nombre; 
    }

    public function getEmail() { 
        return $this->email; 
    }

    public function getPassword() { 
        return $this->password; 
    }

    // ======= SETTERS =======
    public function setId($id) { 
        $this->id = $id; 
    }

    public function setNombre($nombre) { 
        $this->nombre = $nombre; 
    }

    public function setEmail($email) { 
        $this->email = $email; 
    }

    public function setPassword($password) { 
        $this->password = $password; 
    }
}
