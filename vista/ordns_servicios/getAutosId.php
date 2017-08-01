<?php
include '../../modelo/ConexionBD.php';
include '../../control/auto.php';
include '../../control/empresa.php';
include '../../utilidades/Constantes.php';
include '../../utilidades/ExcepcionApi.php';

if(isset($_GET['id'])){
    echo json_encode(auto::getAutoId($_GET['id'])[auto::NOMBRE_TABLA]);
}