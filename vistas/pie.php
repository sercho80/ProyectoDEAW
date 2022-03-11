</section>
</main>
<footer>
    <?php
    if (isset($_SESSION['usuario'])) {
        echo "Sesion iniciada como: " . $_SESSION['usuario'];
    }
    ?>
    <p>Desarrollo web en entorno servidor</p>
    <p class="copyright">
        &copy;
        <?php
        setlocale(LC_TIME, 'Spanish');
        $fecha = date("d/m/Y", time());
        echo utf8_encode($fecha);
        ?> Sprint 3 - Xavier I. y Sergio E.
    </p>
</footer>
</body>

</html>