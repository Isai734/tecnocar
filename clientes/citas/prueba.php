<?php
//************************************************************
include '../../modelo/ConexionBD.php';
include '../../control/persona.php';
include '../../control/login.php';
include '../../control/cita.php';
include '../../utilidades/Constantes.php';
include '../../utilidades/ExcepcionApi.php';

echo cita::getMaxId().": id";
?>

<body>

</body>

<form action="" method="post">
    <div class="pull-left form-inline">
        <button onclick="cerrarse()" type="submit" class="btn btn-danger" name="eliminar_evento">Eliminar</button>

    </div>

</form>

<script>
    function cerrarse() {
        //alert("cerro");
        //location.close();
        window.close();
    }
</script>
</html>
