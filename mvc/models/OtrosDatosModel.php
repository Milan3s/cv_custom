<?php
class OtrosDatosModel
{
    private $id;
    private $usuario_id;
    private $titulo;
    private $descripcion;
    private $seccion_id;
    private $orden;

    public function __construct($id, $usuario_id, $titulo, $descripcion, $seccion_id, $orden)
    {
        $this->id = $id;
        $this->usuario_id = $usuario_id;
        $this->titulo = $titulo;
        $this->descripcion = $descripcion;
        $this->seccion_id = $seccion_id;
        $this->orden = $orden;
    }

    // --- Getters ---
    public function getId()
    {
        return $this->id;
    }

    public function getUsuarioId()
    {
        return $this->usuario_id;
    }

    public function getTitulo()
    {
        return $this->titulo;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function getSeccionId()
    {
        return $this->seccion_id;
    }

    public function getOrden()
    {
        return $this->orden;
    }

    // --- Setters ---
    public function setUsuarioId($usuario_id)
    {
        $this->usuario_id = $usuario_id;
    }

    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    public function setSeccionId($seccion_id)
    {
        $this->seccion_id = $seccion_id;
    }

    public function setOrden($orden)
    {
        $this->orden = $orden;
    }
}
