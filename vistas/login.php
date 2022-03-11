<?php
include "cabecera.php";
if (Input::siEnviado() && isset($accion)) {
    if ($accion == "validar") {
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
        <fieldset class="Usuario">
            <label>Usuario</label><br />
            <input type="text" name="usuario" placeholder="Usuario" value="<?php echo Input::get('usuario') ?>" /><br />
        </fieldset>
        <fieldset class="Contraseña">
            <label>Contraseña</label><br />
            <input type="password" name="contrasenia" placeholder="Contraseña" /><br />
        </fieldset>
    </div>
    <input type="submit" name="login" value="Login" />
</form>
<?php
include "pie.php";
?>