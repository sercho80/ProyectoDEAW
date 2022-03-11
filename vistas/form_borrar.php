<?php
include "cabecera.php";
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
        <?php
        if (sizeof($juegos) > 0) {
            echo "<fieldset class='Titulo'>
            <label>Videojuegos</label><br />
            <select name='juego'>
            ";
            foreach ($juegos as $juego) {
                echo "<option value='{$juego['nombre']};{$juego['anio']}'>{$juego['nombre']} - {$juego['anio']}</option>";
            }
            echo "</select>
                    </fieldset>
                    </div>
                    <input type='submit' name='borrar' value='Borrar' />";
        } else {
            echo "No se han encontrado juegos en la tabla";
        }
        ?>
</form>
<?php
if (isset($accion)) {
    if ($accion == 'borrar') {
        if (isset($resultado)) {
            echo "<div class='uno'>";
            echo $resultado;
            echo "</div>";
        }
    }
}
include "pie.php";
?>