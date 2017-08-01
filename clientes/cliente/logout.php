<?php

include '../../control/login.php';
session_start();
$user=null;
if(isset($_SESSION[login::NOMBRE_TABLA])){
    unset($_SESSION[login::NOMBRE_TABLA]);
    header("location: ../index.php");
}else{
    header("location: ../index.php");
}