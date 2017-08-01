<?php

include 'modelo/ConexionBD.php';
include 'control/persona.php';
include 'control/login.php';
include 'utilidades/Constantes.php';
include 'utilidades/ExcepcionApi.php';
session_start();
$user = null;
if (isset($_SESSION[login::NOMBRE_TABLA]) | !empty($_SESSION[login::NOMBRE_TABLA])) {
    $login = login::getLogin($_SESSION[login::NOMBRE_TABLA]['usuario']);
    //$user=$_SESSION[login::NOMBRE_TABLA];
    //include "main.php";
    header("Location: vista/citas/Calendario.php");
    //$row = persona::getPersonas($user[login::PERSONA_CLAVE])[persona::NOMBRE_TABLA][0];
} else {
    header("Location: clientes/");
}
?>
