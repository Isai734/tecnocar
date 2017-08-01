<?php
require "../../control/persona.php";
require "../../modelo/ConexionBD.php";
require "../../utilidades/Constantes.php";
include '../../control/login.php';
include '../../utilidades/ExcepcionApi.php';
$id = $_GET['id'];
//$tipo = $_GET['tipo'];

session_start();
$user=null;
if(isset($_SESSION[login::NOMBRE_TABLA])){
    include "main_in.php";
    $user=$_SESSION[login::NOMBRE_TABLA];
    $row = persona::getPersonas($id)[persona::NOMBRE_TABLA][0];
}else{
    include "../login/login.php";
}
//include "main.php";
//$tipo = $_GET['tipo'];
?>
<!DOCTYPE html>
<html>
<head>
    <script src="../../vista/style/sweet/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../../vista/style/sweet/sweetalert.css">
    <!-- Scripts y styleshet-->
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,700,500,900' rel='stylesheet' type='text/css'>
    <script src="../js/skel.min.js"></script>
    <script src="../js/skel-panels.min.js"></script>
    <script src="../js/init_c.js"></script>
    <noscript>
        <link rel="stylesheet" href="../css/skel-noscript.css"/>
        <link rel="stylesheet" href="../css/style.css"/>
        <link rel="stylesheet" href="../css/style-desktop.css"/>
    </noscript>
    <!-- fin -->
</head>
<body>

<!-- Header -->
<div id="header_2">
    <div class="container">
        <!-- Logo -->
        <br><br><br>
        <div id="logo">
            <h1><a href="#">Tecnocar</a></h1>
            <span class="tag">Tu taller mecanico</span>
        </div>
        <br><br><br>
    </div>
</div>

<br>
<div id="page-wrapper">
    <div class="container">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header" style="font-size: 25pt; color: #00796B">
                    <span class="glyphicon glyphicon-user"></span> Datos de sesión
                </h1>
            </div>
        </div>
        <!-- /.row -->
        <!-- Boton edit -->

        <!-- Fin Boton edit -->
        <div class="row">
            <div class="col-lg-12">
                <!-- FORMULARIO -->
                <form class="form-horizontal" action="CrudAlert.php?metodo=update" method="POST"
                      onsubmit="return validar();" autocomplete="off">
                    <!--Datos de usuario-->
                    <div class="form-group">
                        <label class="control-label col-sm-2">Usuario:</label>
                        <div class="col-sm-3">
                            <input value="<?php echo $user[login::USUARIO]?>" type="text" class="form-control" id="usuario" name="usuario" autofocus>

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Contraseña:</label>
                        <div class="col-sm-3">
                            <input value="<?php echo $user[login::CONTRASENIA]?>" type="password" class="form-control" id="contra" name="contrasenia">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">Confirme Contraseña:</label>
                        <div class="col-sm-3" id="aviso">
                            <input input value="<?php echo $user[login::CONTRASENIA]?>" type="password" class="form-control" id="recontra">
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="page-header" style="font-size: 25pt; color: #00796B">
                            <span class="glyphicon glyphicon-bishop"></span> Datos del cliente
                        </div>
                    </div>
                    <!--Nombre del cliente-->
                    <div class="form-group">
                        <label class="control-label col-sm-2">Nombre:</label>
                        <div class="col-sm-3">
                            <input value="<?php echo $row[persona::NOMBRE]?>" type="text" class="form-control" id="nombre" name="nombre">
                        </div>
                    </div>
                    <!-- Apellido paterno del cliente-->
                    <div class="form-group">
                        <label class="control-label col-sm-2">Primer Apellido:</label>
                        <div class="col-sm-3">
                            <input value="<?php echo $row[persona::A_PATERNO]?>" type="text" class="form-control" id="apellido_paterno" name="apellido_paterno">
                        </div>
                    </div>

                    <!-- Apellido Materno del cliente -->
                    <div class="form-group">
                        <label class="control-label col-sm-2">Segundo Apellido:</label>
                        <div class="col-sm-3">
                            <input value="<?php echo $row[persona::A_MATERNO]?>" type="text" class="form-control" id="apellido_paterno" name="apellido_materno">
                        </div>
                    </div>

                    <!-- Teléfono del cliente -->
                    <div class="form-group">
                        <label class="control-label col-sm-2">Teléfono:</label>
                        <div class="col-sm-3">
                            <input value="<?php echo $row[persona::TELEFONO]?>" type="phone" class="form-control" id="telefono" name="telefono">
                        </div>
                    </div>

                    <!-- Dirección del cliente -->
                    <div class="form-group">
                        <label class="control-label col-sm-2">Dirección:</label>
                        <div class="col-sm-3">
                            <input value="<?php echo $row[persona::DIRECCION]?>" type="text" class="form-control" id="direccion" name="direccion">
                        </div>
                    </div>
                    <!-- Email del cliente -->
                    <div class="form-group">
                        <label class="control-label col-sm-2">E-mail:</label>
                        <div class="col-sm-3">
                            <input value="<?php echo $row[persona::EMAIL]?>" type="email" class="form-control" id="email" name="email">
                        </div>
                    </div>

                    <!-- RFC del cliente -->
                    <div class="form-group">
                        <label class="control-label col-sm-2">RFC:</label>
                        <div class="col-sm-3">
                            <input value="<?php echo $row[persona::RFC]?>" type="text" class="form-control" id="rfc" name="rfc">
                            <span>*Opcional</span>
                        </div>
                    </div>


                    <!-- Botónnes para registrar y cancelar -->
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn" style="background-color: #009688; color: white">Actulizar</button>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#mymodal">
                                Cancelar
                            </button>
                        </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

</div>


<div id="mymodal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    &times;
                </button>
                <h3 class="modal-title" style="color: #009688">Aviso</h3>
            </div>
            <div class="modal-body">
                <p>¿Seguro que desea cancelar la operacion?</p>
            </div>
            <div class="modal-footer">
                <a href="perfil.php">
                    <button type="button" class="btn" style="background-color: #009688; color: white">Si</button>
                </a>
                <button type="button" data-dismiss="modal" class="btn btn-danger">No</button>
            </div>
        </div>
    </div>
</div>

<!-- SCRIPTS -->
<script src="../../vista/style/js/bootstrap.js"></script>
<script src="../../vista/style/js/jquery-3.2.0.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="../../Validaciones/validar_perfil.js"></script>

</body>

</html>