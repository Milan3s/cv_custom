<?php
class HabilidadModel {
    private int $id;
    private int $usuario_id;
    private string $tipo;          // enum: frontend, backend, base_datos, multiplataforma, softskill
    private string $nombre;        // varchar(100)
    private ?string $descripcion;  // text, puede ser null
    private ?int $seccion_id;      // int(11), puede ser null
    private int $orden;            // int(11), default 1

    // ====== GETTERS ======
    public function getId(): int {
        return $this->id;
    }

    public function getUsuarioId(): int {
        return $this->usuario_id;
    }

    public function getTipo(): string {
        return $this->tipo;
    }

    public function getNombre(): string {
        return $this->nombre;
    }

    public function getDescripcion(): ?string {
        return $this->descripcion;
    }

    public function getSeccionId(): ?int {
        return $this->seccion_id;
    }

    public function getOrden(): int {
        return $this->orden;
    }

    // ====== SETTERS ======
    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setUsuarioId(int $usuario_id): void {
        $this->usuario_id = $usuario_id;
    }

    public function setTipo(string $tipo): void {
        $this->tipo = $tipo;
    }

    public function setNombre(string $nombre): void {
        $this->nombre = $nombre;
    }

    public function setDescripcion(?string $descripcion): void {
        $this->descripcion = $descripcion;
    }

    public function setSeccionId(?int $seccion_id): void {
        $this->seccion_id = $seccion_id;
    }

    public function setOrden(int $orden): void {
        $this->orden = $orden;
    }
}
?>
