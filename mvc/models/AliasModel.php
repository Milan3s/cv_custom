<?php
class AliasModel {
    /* =======================
       ATRIBUTOS
    ======================== */
    private $id;
    private $usuarioId;
    private $alias;
    private $profesion;
    private $bio;
    private $email;
    private $telefono;
    private $direccion;
    private $sitioWeb;
    private $foto;
    private $iconoEmail;
    private $iconoTelefono;
    private $iconoDireccion;
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
    public function getAlias() {
        return $this->alias;
    }
    public function getProfesion() {
        return $this->profesion;
    }
    public function getBio() {
        return $this->bio;
    }
    public function getEmail() {
        return $this->email;
    }
    public function getTelefono() {
        return $this->telefono;
    }
    public function getDireccion() {
        return $this->direccion;
    }
    public function getSitioWeb() {
        return $this->sitioWeb;
    }
    public function getFoto() {
        return $this->foto;
    }
    public function getIconoEmail() {
        return $this->iconoEmail;
    }
    public function getIconoTelefono() {
        return $this->iconoTelefono;
    }
    public function getIconoDireccion() {
        return $this->iconoDireccion;
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
    public function setAlias($alias) {
        $this->alias = $alias;
    }
    public function setProfesion($profesion) {
        $this->profesion = $profesion;
    }
    public function setBio($bio) {
        $this->bio = $bio;
    }
    public function setEmail($email) {
        $this->email = $email;
    }
    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }
    public function setDireccion($direccion) {
        $this->direccion = $direccion;
    }
    public function setSitioWeb($sitioWeb) {
        $this->sitioWeb = $sitioWeb;
    }
    public function setFoto($foto) {
        $this->foto = $foto;
    }
    public function setIconoEmail($iconoEmail) {
        $this->iconoEmail = $iconoEmail;
    }
    public function setIconoTelefono($iconoTelefono) {
        $this->iconoTelefono = $iconoTelefono;
    }
    public function setIconoDireccion($iconoDireccion) {
        $this->iconoDireccion = $iconoDireccion;
    }
    public function setCreadoEn($creadoEn) {
        $this->creadoEn = $creadoEn;
    }
}
?>
