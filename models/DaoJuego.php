<?php
class DaoJuego
{
    private DataBase $db;

    public function __construct()
    {
        $this->db = new DataBase();
    }

    /**
     * Comprueba si existen las estadisticas de un juego en un anio en concreto.
     *
     * @author	Xavier
     * @access	public
     * @param	string	$titulo	
     * @param	int   	$anio  	
     * @return	mixed
     */
    public function existeJuego(string $titulo, int $anio)
    {
        $datos = array();
        $sql = "SELECT count(*) FROM videojuegos WHERE nombre = '{$titulo}' AND anio = {$anio}";
        $this->db->conectar();
        if ($this->db->ejecutarSql($sql) > 0) {
            $sql = "SELECT * FROM videojuegos WHERE nombre = '{$titulo}' AND anio = {$anio}";
            $datos = $this->db->ejecutarSql($sql);
        }
        $this->db->desconectar();
        return $datos;
    }

    /**
     * Inserta en la tabla videojuegos el juego segun los datos proporcionados.
     *
     * @author	Sergio
     * @access	public
     * @param	juego	$juego	
     * @return	void
     */
    public function insertarJuego(Juego $juego)
    {
        $titulo = $juego->getNombre();
        $anio = $juego->getAnio();
        $numJugadores = $juego->getCantidadJugadores();
        $categorias = $juego->getCategorias();
        $descripcion = $juego->getDescripcion();
        $sql = "INSERT INTO videojuegos (nombre, anio, cantidadJugadores, categorias, descripcion) VALUES ('$titulo', $anio, $numJugadores, '$categorias', '$descripcion')";
        $args = array(':titulo' => $titulo, ':anio' => $anio, ':numJugadores' => $numJugadores, ':categorias' => $categorias, ':descripcion' => $descripcion);
        $this->db->conectar();
        $this->db->ejecutarSqlActualizacion($sql, $args);
        $this->db->desconectar();
    }

    /**
     * Borra el juego seleccionado.
     *
     * @author	Xavier
     * @access	public
     * @param	juego	$juego	
     * @return	void
     */
    public function borrarJuego(Juego $juego)
    {
        $titulo = $juego->getNombre();
        $anio = $juego->getAnio();
        $sql = "DELETE FROM videojuegos WHERE nombre = :titulo AND anio = :anio";
        $args = array(':titulo' => $titulo, ':anio' => $anio);
        $this->db->conectar();
        $this->db->ejecutarSqlActualizacion($sql, $args);
        $this->db->desconectar();
    }

    /**
     * Actualiza el juego segun los parametros proporcionados.
     *
     * @author	Sergio
     * @access	public
     * @param	juego	$juego	
     * @return	void
     */
    public function actualizarJuego(Juego $juego)
    {
        $id = $juego->getId();
        $numJugadores = $juego->getCantidadJugadores();
        $categorias = $juego->getCategorias();
        $descripcion = $juego->getDescripcion();
        $sql = "UPDATE videojuegos SET cantidadJugadores = $numJugadores, categorias = '$categorias', descripcion = '$descripcion' WHERE id = $id";
        $args = array(':id' => $id, ':numJugadores' => $numJugadores, ':categorias' => $categorias, ':descripcion' => $descripcion);
        $this->db->conectar();
        $this->db->ejecutarSqlActualizacion($sql, $args);
        $this->db->desconectar();
    }


    /**
     * Carga todos los juegos de la base para los controles de
     * modificar y borrar juegos.
     *
     * @author	Xavier
     * @access	public
     * @return	mixed
     */
    public function cargarJuegos()
    {
        $sql = "SELECT * FROM videojuegos";
        $this->db->conectar();
        $juegos = $this->db->ejecutarSql($sql);
        $this->db->desconectar();
        return $juegos;
    }
}
