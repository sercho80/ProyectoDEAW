<?php
class Usuario
{
    private int $id;
    private string $nombre;
    private string $contrasenia;

    public function __construct(int $id = null,  string $nombre,  string $contrasenia)
    {
        if ($id != null) $this->id = $id;
        $this->nombre = $nombre;
        $this->contrasenia = $contrasenia;
    }

    /**
     * Get the value of id
     * @access  public
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of nombre
     * @access  public
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     * @access	public
     * @return  void
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * Get the value of contrasenia
     * @access	public
     */
    public function getContrasenia()
    {
        return $this->contrasenia;
    }

    /**
     * Set the value of contrasenia
     * @access	public
     * @return  void
     */
    public function setContrasenia($contrasenia)
    {
        $this->contrasenia = $contrasenia;
    }
}
