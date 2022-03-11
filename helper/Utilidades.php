<?php
class Utilidades
{
    /**
     * Funcion que valida si el elemento esta seleccionado y la marca
     *
     * @author	Xavier
     * @access  public
     * @param	array	$valores    	
     * @param	string	$categoria	
     * @return	void
     */
    public static function verificarLista(array $valores, string $categoria)
    {
        if (in_array($categoria, $valores)) {
            echo "Selected";
        }
    }
}
