<?php
class CertificadoModel {
    private $id;
    private $usuario_id;
    private $titulo;
    private $entidad;
    private $fecha;
    private $url;
    private $seccion_id;
    private $orden;

    // ====== GETTERS ======
    public function getId() {
        return $this->id;
    }

    public function getUsuarioId() {
        return $this->usuario_id;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function getEntidad() {
        return $this->entidad;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function getUrl() {
        return $this->url;
    }

    public function getSeccionId() {
        return $this->seccion_id;
    }

    public function getOrden() {
        return $this->orden;
    }

    // ====== SETTERS ======
    public function setId($id) {
        $this->id = $id;
    }

    public function setUsuarioId($usuario_id) {
        $this->usuario_id = $usuario_id;
    }

    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    public function setEntidad($entidad) {
        $this->entidad = $entidad;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    public function setUrl($url) {
        $this->url = $url;
    }

    public function setSeccionId($seccion_id) {
        $this->seccion_id = $seccion_id;
    }

    public function setOrden($orden) {
        $this->orden = $orden;
    }
}
