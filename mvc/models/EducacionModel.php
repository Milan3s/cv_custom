<?php
class EducacionModel {
    private $id;
    private $usuario_id;
    private $centro;
    private $titulacion;
    private $ubicacion;
    private $fecha_inicio;
    private $fecha_fin;
    private $descripcion;   // 👈 nuevo
    private $seccion_id;    // 👈 nuevo
    private $orden;

    /* =====================
       GETTERS
    ===================== */
    public function getId() {
        return $this->id;
    }
    public function getUsuarioId() {
        return $this->usuario_id;
    }
    public function getCentro() {
        return $this->centro;
    }
    public function getTitulacion() {
        return $this->titulacion;
    }
    public function getUbicacion() {
        return $this->ubicacion;
    }
    public function getFechaInicio() {
        return $this->fecha_inicio;
    }
    public function getFechaFin() {
        return $this->fecha_fin;
    }
    public function getDescripcion() {
        return $this->descripcion;
    }
    public function getSeccionId() {
        return $this->seccion_id;
    }
    public function getOrden() {
        return $this->orden;
    }

    /* =====================
       SETTERS
    ===================== */
    public function setId($id) {
        $this->id = $id;
    }
    public function setUsuarioId($usuario_id) {
        $this->usuario_id = $usuario_id;
    }
    public function setCentro($centro) {
        $this->centro = $centro;
    }
    public function setTitulacion($titulacion) {
        $this->titulacion = $titulacion;
    }
    public function setUbicacion($ubicacion) {
        $this->ubicacion = $ubicacion;
    }
    public function setFechaInicio($fecha_inicio) {
        $this->fecha_inicio = $fecha_inicio;
    }
    public function setFechaFin($fecha_fin) {
        $this->fecha_fin = $fecha_fin;
    }
    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }
    public function setSeccionId($seccion_id) {
        $this->seccion_id = $seccion_id;
    }
    public function setOrden($orden) {
        $this->orden = $orden;
    }
}
