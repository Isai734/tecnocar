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

$citas=cita::getCita(null)[cita::NOMBRE_TABLA];

// Verificamos si existe un dato
if (count($citas)>0) {

    // Transformamos los datos encontrado en la BD al formato JSON
    echo json_encode(
        array(
            "success" => 1,
            "result" => $citas
        )
    );
} else {
    // Si no existen eventos mostramos este mensaje.
    echo "No hay datos";
}


?>
