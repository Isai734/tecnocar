<?php

/**
 **
 **  BY iCODEART
 **
 **********************************************************************
 **                      REDES SOCIALES                            ****
 **********************************************************************
 **                                                                ****
 ** FACEBOOK: https://www.facebook.com/icodeart                    ****
 ** TWIITER: https://twitter.com/icodeart                          ****
 ** YOUTUBE: https://www.youtube.com/c/icodeartdeveloper           ****
 ** GITHUB: https://github.com/icodeart                            ****
 ** TELEGRAM: https://telegram.me/icodeart                         ****
 ** EMAIL: info@icodeart.com                                       ****
 **                                                                ****
 **********************************************************************
 **********************************************************************
 **/
include '../../modelo/ConexionBD.php';
include '../../control/persona.php';
include '../../control/login.php';
include '../../control/cita.php';
include '../../utilidades/Constantes.php';
include '../../utilidades/ExcepcionApi.php';


//incluimos nuestro archivo config
include 'config.php';

// Incluimos nuestro archivo de funciones
include 'funciones.php';
session_start();
// Obtenemos el id del evento
$id = evaluar($_GET['id']);
$login = $_SESSION[login::NOMBRE_TABLA];
$user = login::getLogin($login['usuario']);
// y lo buscamos en la base de dato
$row = cita::getCita($id)[cita::NOMBRE_TABLA][0];
// Obtenemos los datos
$titulo = $row['title'];

// cuerpo
$evento = $row['body'];

// Fecha inicio
$inicio = $row['inicio_normal'];

// Fecha Termino
$final = $row['final_normal'];

// Eliminar evento
if (isset($_POST['eliminar_evento'])) {
    $id = evaluar($_GET['id']);
    cita::deleteCita($id);
    //header("Location: Calendario.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $titulo ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Custom CSS -->
    <link href="../../vista/style/css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../../vista/style/css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../../vista/style/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" type="text/css" href="../../vista/style/css/bootstrap.css">
    <script src="../../vista/style/js/bootstrap.js"></script>

    <!-- Jquery -->
    <script src="../../vista/style/js/jquery-3.2.0.min.js"></script>

    <!-- fin -->
</head>
<body>
<h3><?= $titulo ?></h3>
<hr>
<b>Fecha de cita:</b> <?= $inicio ?>
<p><?= $evento ?></p>
</body>

<form action="" method="post">
    <div class="pull-left form-inline">
        <button type="submit" class="btn btn-danger" name="eliminar_evento">Eliminar</button>
        <?php if ($user['tipo'] == "ADMIN") { ?>
            <a href="../../vista/cotizacion/Cotizacion.php?id=<?=$row['cliente_clave']?>&placa=<?=$row['auto_placa']?>"><button type="button" class="btn btn-primary" onclick="cerrarse()">Atender Cita</button></a>
        <?php } ?>
    </div>
</form>

<script>
    function cerrarse() {
        //alert("cerro");
        //location.close();
        window.
    }
    function clos()
    {
        $("#events-modal").modal("hide");
    }
</script>
</html>
