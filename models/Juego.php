<?php
class Juego
{
    private int $id;
    private string $nombre;
    private int $anio;
    private float $cantidadJugadores;
    private string $categorias;
    private string $descripcion;

    public function __construct(int $id = null,  string $nombre,  int $anio,  float $cantidadJugadores,  string $categorias, string $descripcion)
    {
        if ($id != null) $this->id = $id;
        $this->nombre = $nombre;
        $this->anio = $anio;
        $this->cantidadJugadores = $cantidadJugadores;
        $this->categorias = $categorias;
        $this->descripcion = $descripcion;
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of nombre
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     *
     * @return  void
     */
    public function setNombre(string $nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * Get the value of anio
     */
    public function getAnio()
    {
        return $this->anio;
    }

    /**
     * Set the value of anio
     *
     * @return  void
     */
    public function setAnio(int $anio)
    {
        $this->anio = $anio;
    }

    /**
     * Get the value of cantidadJugadores
     */
    public function getCantidadJugadores()
    {
        return $this->cantidadJugadores;
    }

    /**
     * Set the value of cantidadJugadores
     *
     * @return  void
     */
    public function setCantidadJugadores(float $cantidadJugadores)
    {
        $this->cantidadJugadores = $cantidadJugadores;
    }

    /**
     * Get the value of categorias
     */
    public function getCategorias()
    {
        return $this->categorias;
    }

    /**
     * Set the value of categorias
     *
     * @return  void
     */
    public function setCategorias(string $categorias)
    {
        $this->categorias = $categorias;
    }

    /**
     * Get the value of descripcion
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set the value of descripcion
     *
     * @return  void
     */
    public function setDescripcion(string $descripcion)
    {
        $this->descripcion = $descripcion;
    }
}
