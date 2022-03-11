<?php
class ValidadorForm
{
    private array $errores;
    private array $reglasValidacion;
    private bool $valido;

    public function __construct()
    {
        $this->errores = array();
        $this->valido = false;
        $this->reglasValidacion = array();
    }

    /**
     * Valida todos los datos que han sido enviados
     * En caso de existir algun error este se almacena
     * para mostrarlo al principio del formulario, 
     * si se indica que es SQL comprueba que existan
     * registros con esos datos
     *
     * @author	Sergio
     * @param   string  $modo
     * @param	array	$fuente          	
     * @param	array	$reglasValidacion	
     * @return	void
     */
    public function validar(array $fuente = null, array $reglasValidacion = null)
    {
        $this->valido = false;
        foreach ($reglasValidacion as $regla => $valorRegla) {
            if (array_key_exists($regla, $fuente)) {
                if ($valorRegla["required"] != null) {
                    if (empty($fuente[$regla])) {
                        $this->addError($regla, "Introduzca $regla. ");
                        continue;
                    }
                    if (isset($valorRegla['min'])) {
                        if ($fuente[$regla] < $valorRegla['min']) {
                            $this->addError($regla, "Valor por debajo del minimo {$valorRegla['min']}. ");
                            continue;
                        }
                    }
                    if (isset($valorRegla['max'])) {
                        if ($fuente[$regla] > $valorRegla['max']) {
                            $this->addError($regla, "Valor por encima del maximo {$valorRegla['max']}. ");
                            continue;
                        }
                    }
                }
            }
        }

        if (empty($this->getErrores())) {
            $this->valido = true;
        }
    }

    /**
     * Añade el error a un array
     *
     * @author	Xavier
     * @param	string	$nombreCampo	
     * @param	string	$error      	
     * @return	void
     */
    public function addError(string $nombreCampo, string $error)
    {
        $this->errores[$nombreCampo] = $error;
    }


    /**
     * Devuelve si todos los datos son válidos
     *
     * @author	Sergio
     * @return	mixed
     */
    public function esValido()
    {
        return $this->valido;
    }

    /**
     * Devuelve el error de un campo concreto
     *
     * @author	Sergio
     * @param	mixed	$campo	
     * @return	mixed
     */
    public function getMensajeError(string $campo)
    {
        return $this->errores[$campo];
    }
    /**
     * Devuelve todos los errores
     *
     * @author	Xavier
     * @return	mixed
     */
    public function getErrores()
    {
        return $this->errores;
    }
}
