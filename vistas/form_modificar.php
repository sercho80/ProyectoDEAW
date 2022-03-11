<?php
include "cabecera.php";
if (Input::siEnviado() && isset($accion)) {
    if ($accion == "validar" || $accion == 'sql') {
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
        <fieldset class="Titulo">
            <label>Videojuegos</label><br />
            <p><strong>Control solo de ayuda</strong></p>
            <select name="juegoAux">
                <?php
                foreach ($juegos as $juego) {
                    echo "<option value='{$juego['nombre']};{$juego['anio']}'>{$juego['nombre']} - {$juego['anio']}</option>";
                }
                ?>
            </select>
        </fieldset>
    </div>
    <div>
        <fieldset class="Titulo">
            <label>Titulo</label><br />
            <input type="text" name="nombre" placeholder="Nombre del videojuego" value="<?php echo Input::get("nombre") ?>" /><br />
        </fieldset>
        <fieldset class="Año">
            <label>Año</label><br />
            <input type="number" name="anio" min="2003" max="<?php echo date("Y", time()); ?>" step="1" value="<?php echo Input::get("anio") ?>" /><br />
        </fieldset>
        <fieldset class="Jugadores">
            <label>Cantidad de jugadores</label><br />
            <input type="number" name="cantidadJugadores" min="1" step="1" value="<?php echo Input::get("cantidadJugadores") ?>" /><br />
        </fieldset>
        <fieldset class="Categoria">
            <label>Categoria</label>
            <select name="categorias[]" multiple id="categorias">
                <?php
                $categorias = array("Shooter", "Rpg", "Aventura", "Exploración", "Simulación");
                foreach ($categorias as $categoria) {
                    echo "<option value='$categoria'";
                    echo Utilidades::verificarLista(Input::get('categorias'), $categoria);
                    echo ">$categoria</option>\n";
                }
                ?>
            </select>
        </fieldset>
        <fieldset class="Descripcion">
            <textarea name="descripcion" cols="30" rows="10" placeholder="Descripcion del videojuego"><?php echo Input::get("descripcion") ?></textarea>
        </fieldset>
    </div>
    <input type="submit" name="modificar" value="Modificar" />
</form>
<?php
if (isset($accion)) {
    if ($accion == 'modificar') {
        if (isset($resultado)) {
            echo "<div class='uno'>";
            echo $resultado;
            echo "</div>";
        }
    }
}
include "pie.php";
?>
