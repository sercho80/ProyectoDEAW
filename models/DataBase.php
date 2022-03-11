<?php
class Database implements IDatabase
{
    private $conexion;

    /**
     * Conecta la app con la base de datos.
     *
     * @author	Sergio
     * @access	public
     * @return	void
     */
    public function conectar()
    {
        try {
            $this->conexion = new PDO(
                'mysql:host=' . DB_SERVER . ';port=' . DB_PORT . ';dbname=' . DB_NAME,
                DB_USER
            );
            $this->conexion->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
            $this->conexion->exec('SET names utf8');
        } catch (Exception $ex) {
            $error = "Error: no se pudó conectar a la base de datos;";
            include "vistas/form_manual.php";
            exit();
        }
    }

    /**
     * Desconecta la app de la base de datos y borra el objeto PDO
     *
     * @author	Xavier
     * @access	public
     * @return	void
     */
    public function desconectar()
    {
        $this->conexion->query('KILL CONNECTION_ID()');
        $this->conexion = null;
    }

    /**
     * Ejecuta la consulta SQL.
     *
     * @author	Sergio
     * @access	public
     * @param	string	$sql	
     * @return	mixed
     */
    public function ejecutarSql(string $sql)
    {
        $resul = $this->conexion->query($sql);
        if (!is_bool($resul)) {
            $resul = $resul->fetchAll();
        }
        return $resul;
    }

    /**
     * Ejecuta la consulta SQL con los argumentos proporcionados.
     *
     * @author	Xavier
     * @access	public
     * @param	string	$sql 	
     * @param	array 	$args	
     * @return	void
     */
    public function ejecutarSqlActualizacion(string $sql, array $args)
    {
        $resul = $this->conexion->prepare($sql);
        $resul->execute($args);
    }
}
