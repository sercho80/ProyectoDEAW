<?php
class Controlador
{
    private DaoJuego $daoJuego;
    public function run()
    {
        try {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $this->daoJuego = new DaoJuego();
            if (!isset($_POST['enviar']) && !isset($_POST['consulta']) && !isset($_POST['borrar']) && !isset($_POST['modificar']) && !isset($_POST['login'])) {
                $this->mostrarFormulario();
                exit();
            }
            if (isset($_POST['enviar'])) {
                $datos = $this->recogerDatos();
                $this->validar($datos);
            }
            if (isset($_POST['consulta'])) {
                $datos = $this->recogerDatos();
                $this->validar($datos, "consulta");
            }
            if (isset($_POST['borrar'])) {
                $datos = $this->recogerDatos();
                $this->validar($datos, "borrar");
            }
            if (isset($_POST['modificar'])) {
                $datos = $this->recogerDatos();
                $this->validar($datos, "modificar");
            }
            if (isset($_POST['login'])) {
                $datos = $this->recogerDatos();
                $this->validar($datos, "login");
            }
        } catch (SQLInjectException $sqlex) {
            $this->mostrarFormulario("sql", null, "No te pases de listo");
            exit();
        } catch (Exception $ex) {
            $this->mostrarFormulario('continuar', null, 'Error: contacte con el administrador');
            exit();
        }
    }

    /**
     * Funcion que muestra el formulario de inicio cambiando su contenido en funcion del parametro.
     *
     * @author Xavier
     * @param string $accion
     * @param ValidadorForm $validador
     * @param mixed $resultado
     * @return void
     */
    private function mostrarFormulario(string $accion = null, ValidadorForm $validador = null,  $resultado = null)
    {
        $frm = "";
        if (isset($_GET)) if (isset($_GET['link'])) $frm = $_GET['link'];
        if (isset($_GET)) if (!isset($_SESSION['sesionIniciada']) && isset($_GET)) if (isset($_GET['link']) && $_GET['link'] != "login") $frm = "";
        switch ($frm) {
            case 'insertar':
                //Para ver el formulario de inserción manual
                include 'vistas/form_manual.php';
                break;
            case 'delete':
                //Para ver el formulario de borrar
                $juegos = $this->daoJuego->cargarJuegos();
                include 'vistas/form_borrar.php';
                break;
            case 'mod':
                //Para ver el formulario de modificar
                $juegos = $this->daoJuego->cargarJuegos();
                include 'vistas/form_modificar.php';
                break;
            case 'login':
                //Para ver el formulario de login
                include 'vistas/login.php';
                break;
            default:
                //Para ver el formulario de consulta
                include 'vistas/form_consulta.php';
                break;
        }
    }

    /**
     * Funcion que recoge los datos del formulario.
     *
     * @author Sergio
     * @return array
     */
    private function recogerDatos()
    {
        $datos = array();
        $datoFiltrado = "";
        if (!empty($_POST['nombre'])) {
            $datoFiltrado = Input::filtrarDato($_POST['nombre']);
            $datos['nombre'] = $datoFiltrado;
        }

        if (!empty($_POST['anio'])) {
            $datoFiltrado = Input::filtrarDato($_POST['anio']);
            $datos['anio'] = $datoFiltrado;
        }

        if (!empty($_POST['cantidadJugadores'])) {
            $datoFiltrado = Input::filtrarDato($_POST['cantidadJugadores']);
            $datos['cantidadJugadores'] = $datoFiltrado;
        }

        if (isset($_POST['categorias'])) {
            $categorias = "";
            foreach ($_POST['categorias'] as $categoria) {
                $datoFiltrado = Input::filtrarDato($categoria);
                $categorias .= "{$datoFiltrado};";
            }
            $datos['categorias'] = $categorias;
        }

        if (!empty($_POST['descripcion'])) {
            $datoFiltrado = Input::filtrarDato($_POST['descripcion']);
            $datos['descripcion'] = $datoFiltrado;
        }

        if (!empty($_POST['juego'])) {
            $datoFiltrado = explode(";", $_POST['juego']);
            $datos['nombre'] = Input::filtrarDato($datoFiltrado[0]);
            $datos['anio'] = Input::filtrarDato($datoFiltrado[1]);
        }

        if (!empty($_POST['usuario'])) {
            $datoFiltrado = Input::filtrarDato($_POST['usuario']);
            $datos['usuario'] = $datoFiltrado;
        }

        if (!empty($_POST['contrasenia'])) {
            $datoFiltrado = Input::filtrarDato($_POST['contrasenia']);
            $datoFiltrado =
                password_hash($datoFiltrado, PASSWORD_DEFAULT, array('cost' => 12));
            $datos['contrasenia'] = $datoFiltrado;
        }
        return $datos;
    }

    /**
     * Funcion que crea la reglas para la validación
     *
     * @author Xavier
     * @return array
     */
    private function crearReglasDeValidacion()
    {
        return array(
            "nombre" => array("required" => true),
            "anio" => array("min" => 2003, "max" => 2022, "required" => true),
            "cantidadJugadores" => array("min" => 1, "required" => true),
            "categorias" => array("required" => true),
            "descripcion" => array("required" => true),
        );;
    }

    /**
     * Funcion que valida los datos, en caso de ser correctos 
     * los muestra en el formulario, 
     * pero en caso de que exista algún error mostrará un mensaje
     *
     * @author Xavier
     * @param mixed $name
     * @param mixed $modo
     * @param mixed $anterior
     * @return void
     */
    public function validar($datos, $modo = null)
    {
        $validador = new ValidadorForm();
        $reglasValidacion = $this->crearReglasDeValidacion();
        if (empty($datos['nombre'])) $datos['nombre'] = "";
        if (empty($datos['anio'])) $datos['anio'] = 0;
        switch ($modo) {
            case 'consulta':
                $validador->validar($datos, $reglasValidacion);
                if ($validador->esValido()) {
                    $datosJuego = $this->daoJuego->existeJuego($datos['nombre'], $datos['anio']);
                    if (!empty($datosJuego)) {
                        $datosJuego['nombre'] = $datosJuego[0]['nombre'];
                        $datosJuego['anio'] = $datosJuego[0]['anio'];
                        $datosJuego['cantidadJugadores'] = $datosJuego[0]['cantidadJugadores'];
                        unset($datosJuego[0]);
                        $this->mostrarFormulario("continuar", $validador, $datosJuego);
                        exit();
                    }
                    $this->mostrarFormulario("continuar", null, "No se ha encontrado ningun registro con los datos proporcionados");
                    exit();
                }
                $this->mostrarFormulario("validar", $validador);
                exit();
            case 'borrar':
                $validador->validar($datos, $reglasValidacion);
                if ($validador->esValido()) {
                    $validos = array('id', 'nombre', 'anio', 'cantidadJugadores', 'categorias', 'descripcion');
                    $datosJuego = $this->daoJuego->existeJuego($datos['nombre'], $datos['anio']);
                    $datos = array();
                    foreach ($datosJuego[0] as $campo => $valor) {
                        if (in_array($campo, $validos)) {
                            $datos[$campo] = $valor;
                        }
                    }
                    $juego = $this->crearJuego($datos);
                    $this->daoJuego->borrarJuego($juego);
                    $resultado = "Se ha borrado el videojuego con exito";
                    $juego = null;
                    $this->mostrarFormulario('borrar', null, $resultado);
                    exit();
                }
                $this->mostrarFormulario("validar", $validador);
                exit();
            case 'modificar':
                if (empty($datos['cantidadJugadores'])) $datos['cantidadJugadores'] = 0;
                if (empty($datos['categorias'])) $datos['categorias'] = "";
                if (empty($datos['descripcion'])) $datos['descripcion'] = "";
                $validador->validar($datos, $reglasValidacion);
                if ($validador->esValido()) {
                    $validos = array('id', 'nombre', 'anio', 'cantidadJugadores', 'categorias', 'descripcion');
                    $datosJuego = $this->daoJuego->existeJuego($datos['nombre'], $datos['anio']);
                    $categorias = $datos['categorias'];
                    $descripcion = $datos['descripcion'];
                    $cantidadJugadores = $datos['cantidadJugadores'];
                    $datos = array();
                    foreach ($datosJuego[0] as $campo => $valor) {
                        if (in_array($campo, $validos)) {
                            $datos[$campo] = $valor;
                        }
                    }
                    unset($datos[0]);
                    $juego = $this->crearJuego($datos);
                    $juego->setCategorias($categorias);
                    $juego->setDescripcion($descripcion);
                    $juego->setCantidadJugadores($cantidadJugadores);
                    $this->daoJuego->actualizarJuego($juego);
                    $resultado = "Se ha actualizado el videojuego con exito";
                    $juego = null;
                    $this->mostrarFormulario('modificar', null, $resultado);
                    exit();
                }
                $this->mostrarFormulario("validar", $validador);
                exit();
            case 'login':
                unset($datos['nombre']);
                unset($datos['anio']);
                if (empty($datos['usuario'])) $datos['usuario'] = "";
                if (empty($datos['contrasenia'])) $datos['contrasenia'] = 0;
                $reglasValidacion = array("usuario" => array("required" => true), "contrasenia" => array("required" => true));
                $validador->validar($datos, $reglasValidacion);
                if ($validador->esValido()) {
                    $daoUsuario = new DaoUsuario();
                    $usuario = $this->crearUsuario($datos);
                    $resul = $daoUsuario->comprobarUsuario($usuario);
                    if ($resul) {
                        $daoUsuario = null;
                        $_SESSION["sesionIniciada"] = true;
                        $_SESSION["usuario"] = $usuario->getNombre();
                        $usuario = null;
                        unset($_GET);
                        $this->mostrarFormulario("continuar");
                        exit();
                    } else {
                        $validador->validar(array());
                        unset($_SESSION);
                    }
                }
                $this->mostrarFormulario("validar", $validador);
                exit();
            default:
                if (empty($datos['cantidadJugadores'])) $datos['cantidadJugadores'] = 0;
                if (empty($datos['categorias'])) $datos['categorias'] = "";
                if (empty($datos['descripcion'])) $datos['descripcion'] = "";
                $reglasValidacion = $this->crearReglasDeValidacion();
                $validador->validar($datos, $reglasValidacion);
                if ($validador->esValido()) {
                    if (empty($this->daoJuego->existeJuego($datos['nombre'], $datos['anio']))) {
                        $juego = $this->crearJuego($datos);
                        $this->daoJuego->insertarJuego($juego);
                        $resultado = "Se ha insertado el videojuego con exito";
                        $juego = null;
                    } else {
                        $resultado = "El juego: {$datos['nombre']} para el año: {$datos['anio']} ya existe";
                    }
                    $this->mostrarFormulario("continuar", $validador, $resultado);
                    exit();
                }
                $this->mostrarFormulario("validar", $validador);
                exit();
        }
    }

    /**
     * Funcion que crea un Juego.
     *
     * @author	Sergio
     * @access	private
     * @param	array	$datos	
     */
    private function crearJuego(array $datos)
    {
        if (!isset($datos['id'])) {
            return
                new Juego(null, $datos["nombre"], $datos["anio"], $datos["cantidadJugadores"], $datos["categorias"], $datos["descripcion"]);
        }
        return
            new Juego($datos["id"], $datos["nombre"], $datos["anio"], $datos["cantidadJugadores"], $datos["categorias"], $datos["descripcion"]);
    }

    /**
     * Funcion que crea un Usuario.
     *
     * @author	Xavier
     * @access	private
     * @param	array	$datos	
     */
    private function crearUsuario(array $datos)
    {
        if (!isset($datos['id'])) {
            return
                new Usuario(null, $datos["usuario"], $datos["contrasenia"]);
        }
        return
            new Usuario($datos["id"], $datos["usuario"], $datos["contrasenia"]);
    }
}
