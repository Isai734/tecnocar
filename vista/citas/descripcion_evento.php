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

// Incluimos nuest
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
</head>
<body>
<h3><?= $titulo ?></h3>
<hr>
<b>Fecha de cita:</b> <?= $inicio ?>
<p><?= $evento ?></p>
</body>
<form action="" method="post">
    <button type="submit" class="btn btn-danger" name="eliminar_evento">Eliminar</button>
</form>
</html>
