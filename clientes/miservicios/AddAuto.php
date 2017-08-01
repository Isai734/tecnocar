<?php
include '../../modelo/ConexionBD.php';
include '../../control/auto.php';
include '../../control/persona.php';
include '../../control/login.php';
include '../../utilidades/Constantes.php';
include '../../utilidades/ExcepcionApi.php';
session_start();
$rows = null;
$id = null;
if (isset($_SESSION[login::NOMBRE_TABLA]) | !empty($_SESSION[login::NOMBRE_TABLA])) {
    include "main_in.php";
    $user = $_SESSION[login::NOMBRE_TABLA];
    $id = $user[login::PERSONA_CLAVE];
    $rows = persona::getPersonas($id)[persona::NOMBRE_TABLA][0];
} else {
    header("Location: ../login/login.php");
}

?>
<!DOCTYPE html>
<html>
<head>
    <script src="../../vista/style/js/validaciones.js"></script>
    <script src="../../vista/style/js/bootstrap.js"></script>
    <script src="../../vista/style/js/jquery-3.2.0.min.js"></script>
    <script src="../../vista/style/sweet/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../../vista/style/sweet/sweetalert.css">
    <!-- Scripts y styleshet-->
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,700,500,900' rel='stylesheet' type='text/css'>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
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
        <br>
    </div>
</div>
<div id="page-wrapper">
    <div class="container">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <span class="glyphicon glyphicon-plus"></span> Nuevo Auto
                </h1>
            </div>
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-lg-12">
                <!-- FORMULARIO -->
                <form class="form-horizontal" action="CrudAlert.php?&metodo=add&id=<?php echo $id ?>" method="POST"
                      onsubmit="return validarAuto()" autocomplete="off">

                    <!-- Datos cliente si se selecciono -->
                    <div class="form-group">
                        <?php echo "
                        <label class='control-label col-sm-2'>Cliente :</label>
                        <div class='col-sm-3'>
                            <input class='form-control' type='text' name='clave' value='"
                            . $rows[persona::NOMBRE] . " " . $rows[persona::A_PATERNO] . " " . $rows[persona::A_MATERNO] . "'
                                   readonly>
                        </div>
                        "; ?>
                    </div>
                    <!--Placa del auto-->
                    <div class="form-group">
                        <label class="control-label col-sm-2">Placa:</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="placa" name="placa" autofocus>
                        </div>
                    </div>
                    <!-- Marca del auto-->
                    <div class="form-group">
                        <label class="control-label col-sm-2">Marca:</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="marca" name="marca">
                        </div>
                    </div>

                    <!-- Modelo del auto-->
                    <div class="form-group">
                        <label class="control-label col-sm-2">Modelo:</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="modelo" name="modelo">
                        </div>
                    </div>


                    <!-- Color -->
                    <div class="form-group">
                        <label class="control-label col-sm-2">Color:</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="color" name="color">
                        </div>
                    </div>

                    <!-- Aqui va la etiqueta select del año del auto -->
                    <div class="form-group">
                        <label class="control-label col-sm-2">Año:</label>
                        <div class="col-sm-3">
                            <select class="form-control" name="anio">
                                <?php for ($i = date("Y"); $i > 1949; $i--)
                                    echo "<option value='" . $i . "'>" . $i . "</option>";
                                ?>
                            </select>
                        </div>
                    </div>

                    <!-- Transmision select -->
                    <div class="form-group">
                        <label class="control-label col-sm-2">Trasmision:</label>
                        <div class="col-sm-3">
                            <select class="form-control" name="transmision">
                                <option value="MANUAL">MANUAL</option>
                                <option value="AUTOMATICA" selected>AUTOMATICA</option>
                            </select>
                        </div>
                    </div>


                    <!-- Botónnes para registrar y cancelar -->
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-success">Registrar</button>
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
                <h4 class="modal-title">Aviso</h4>
            </div>
            <div class="modal-body">
                <p>¿Seguro que desea cancelar el registro del cliente?</p>
            </div>
            <div class="modal-footer">
                <a href="../index.php">
                    <button type="button" class="btn btn-success">Si</button>
                </a>
                <button type="button" data-dismiss="modal" class="btn btn-danger">No</button>
            </div>
        </div>
    </div>
</div>

</body>


</html>