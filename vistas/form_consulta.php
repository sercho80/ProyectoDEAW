<?php
include "cabecera.php";
if (Input::siEnviado() && isset($accion)) {
    if ($accion == "validar") {
        if (isset($validador)) {

            $errores = $validador->getErrores();
            if (!empty($errores)) {
                echo "<div class='errores'>";
                foreach ($errores as $campo => $mensajeError) {
                    echo "<p>$mensajeError</p>\n";
                }
                echo "</div>";
            }
        }
    }
}
if (isset($accion)) {
    if ($accion == 'sql') {
        if (isset($resultado)) {
            echo "<div class='uno'>";
            echo $resultado;
            echo "</div>";
        }
    }
}
?>
<form id="form" method="post">
    <div>
        <fieldset class="Titulo">
            <label>Titulo</label><br />
            <input type="text" name="nombre" placeholder="Nombre del videojuego" value="<?php echo Input::get("nombre") ?>" /><br />
        </fieldset>
        <fieldset class="Año Año2">
            <label>Año</label><br />
            <input type="number" name="anio" min="2003" max="<?php echo date("Y", time()); ?>" step="1" value="<?php echo Input::get("anio") ?>" /><br />
        </fieldset>
    </div>
    <input type="submit" name="consulta" value="Consultar" />
</form>
<?php
if (isset($accion)) {
    if ($accion == "continuar") {
        if (isset($resultado)) {
            echo "<div class='uno'>";
            if (is_array($resultado)) {
                $sb = "";
                $sb = "El videojuego: {$resultado['nombre']} ha tenido en el anio {$resultado['anio']} {$resultado['cantidadJugadores']} jugadores";
                echo $sb;
            } else {
                echo $resultado;
            }
            echo "</div>";
        }
    }
}
include "pie.php";
?>