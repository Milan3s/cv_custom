<?php
class RedesModel {
    private $id;
    private $usuario_id;
    private $plataforma;
    private $url;
    private $usuario;
    private $icono;
    private $orden;
    private $visible;

    // ====== GETTERS ======
    public function getId() {
        return $this->id;
    }

    public function getUsuarioId() {
        return $this->usuario_id;
    }

    public function getPlataforma() {
        return $this->plataforma;
    }

    public function getUrl() {
        return $this->url;
    }

    public function getUsuario() {
        return $this->usuario;
    }

    public function getIcono() {
        return $this->icono;
    }

    public function getOrden() {
        return $this->orden;
    }

    public function getVisible() {
        return $this->visible;
    }

    // ====== SETTERS ======
    public function setId($id) {
        $this->id = $id;
    }

    public function setUsuarioId($usuario_id) {
        $this->usuario_id = $usuario_id;
    }

    public function setPlataforma($plataforma) {
        $this->plataforma = $plataforma;
    }

    public function setUrl($url) {
        $this->url = $url;
    }

    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    public function setIcono($icono) {
        $this->icono = $icono;
    }

    public function setOrden($orden) {
        $this->orden = $orden;
    }

    public function setVisible($visible) {
        $this->visible = $visible;
    }
}
