<?php
class SeccionModel {
    /* =======================
       ATRIBUTOS
    ======================== */
    private $id;
    private $usuarioId;
    private $nombre;
    private $titulo;
    private $columna;
    private $icono;
    private $orden;
    private $creadoEn;

    /* =======================
       GETTERS
    ======================== */
    public function getId() {
        return $this->id;
    }
    public function getUsuarioId() {
        return $this->usuarioId;
    }
    public function getNombre() {
        return $this->nombre;
    }
    public function getTitulo() {
        return $this->titulo;
    }
    public function getColumna() {
        return $this->columna;
    }
    public function getIcono() {
        return $this->icono;
    }
    public function getOrden() {
        return $this->orden;
    }
    public function getCreadoEn() {
        return $this->creadoEn;
    }

    /* =======================
       SETTERS
    ======================== */
    public function setId($id) {
        $this->id = $id;
    }
    public function setUsuarioId($usuarioId) {
        $this->usuarioId = $usuarioId;
    }
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }
    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }
    public function setColumna($columna) {
        $this->columna = $columna;
    }
    public function setIcono($icono) {
        $this->icono = $icono;
    }
    public function setOrden($orden) {
        $this->orden = $orden;
    }
    public function setCreadoEn($creadoEn) {
        $this->creadoEn = $creadoEn;
    }
}
?>
