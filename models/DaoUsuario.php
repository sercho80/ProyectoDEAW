<?php
class DaoUsuario
{
    private DataBase $db;

    public function __construct()
    {
        $this->db = new DataBase();
    }


    /**
     * Comprueba si el esuario proporcionado existe en la BBDD
     * y si el hash de la contaseña coincide con el de la 
     * contraseña proporcionada.
     *
     * @author	Sergio
     * @access	public
     * @param	usuario	$usuario	
     * @return	mixed
     */
    public function comprobarUsuario(Usuario $usuario)
    {
        $datos = false;
        $consulta = "SELECT count(*) FROM usuarios WHERE user = '{$usuario->getNombre()}'";
        $this->db->conectar();
        if ($this->db->ejecutarSql($consulta) > 0) {
            $consulta = "SELECT pass FROM usuarios WHERE user = '{$usuario->getNombre()}'";
            $datos = $this->db->ejecutarSql($consulta);
            if ($datos) {
                $aux = $datos[0][0];
                if (password_verify($usuario->getContrasenia(), $aux)) $datos = true;
            }
        }
        $this->db->desconectar();
        return $datos;
    }
}
