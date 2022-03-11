<?php
class Input
{
    /**
     * Comprueba si el formulario ha sido enviado
     *
     * @author	Sergio
     * @return	bool
     */
    public static function siEnviado()
    {
        return (!empty($_POST)) ? true : false;
    }

    /**
     * Filtra los datos y elimina carácteres HTML y PHP
     * también quita los espacios si el dato proporcionado
     * no es ni el nombre ni la descripcion
     *
     * @author	Sergio
     * @param	mixed	$datos	
     * @return	mixed
     */
    public static function filtrarDato($dato)
    {
        if (Input::contieneSQL($dato)) throw new SQLInjectException();
        $filtrado = htmlspecialchars($dato);
        $filtrado = strip_tags($dato);
        if ($dato != "nombre" && $dato != "descripcion") {
            $filtrado = str_replace(" ", "", $dato);
        }
        return $filtrado;
    }

    /**
     * Si se han enviado datos, coge estos valores 
     * para rellenar el formulario con estos
     *
     * @author	Xavier
     * @param	mixed	$dato	
     * @return	mixed
     */
    public static function get($dato)
    {
        if (Input::contieneSQL($dato)) throw new SQLInjectException();
        $campo = "";
        if ($dato != "categorias") {
            if (isset($_POST[$dato])) {
                $campo = $_POST[$dato];
                $campo = Input::filtrarDato($campo);
            }
        } else {
            if (isset($_POST['categorias'])) {
                $campo = $_POST['categorias'];
            } else {
                $campo = array();
            }
        }
        return $campo;
    }

    /**
     * Comprueba si el dato proporcionado contiene
     * alguna sentencia SQL.
     *
     * @author	Sergio
     * @access	private static
     * @param	string	$dato	
     * @return	mixed
     */
    private static function contieneSQL(string $dato)
    {
        $sql = array(
            'SELECT',
            'UPDATE',
            'INSERT',
            'DELETE',
            'ALTER',
            'CREATE',
            'TRUNCATE',
            'DROP',
            'USE',
            'RENAME',
            'GRANT',
            'REVOKE',
            'COMMIT',
            'ROLLBACK'
        );
        $contieneSQL = false;
        $replace = preg_replace("/[\r\n]+/", " ", $dato);
        $query = explode(' ', strtoupper($replace));
        if (count(array_intersect($sql, $query)) > 0) {
            $contieneSQL = true;
        }
        return $contieneSQL;
    }
}
