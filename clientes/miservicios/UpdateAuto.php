<?php
require "../../control/persona.php";
require "../../control/auto.php";
require "../../control/login.php";
require "../../modelo/ConexionBD.php";
require "../../utilidades/Constantes.php";
require "../../utilidades/ExcepcionApi.php";
$id = $_GET['id'];
//echo $id;
//$tipo = $_GET['tipo'];
session_start();
$rows = null;
$id = null;
if (isset($_SESSION[login::NOMBRE_TABLA]) | !empty($_SESSION[login::NOMBRE_TABLA])) {
    include "main_in.php";
    $user = $_SESSION[login::NOMBRE_TABLA];
    $id = $_GET['id'];
    $row = auto::getAuto($id)[auto::NOMBRE_TABLA][0];
    //$rows = persona::getPersonas($id)[persona::NOMBRE_TABLA][0];
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
                    <span class="glyphicon glyphicon-pencil"></span> Modifcar Datos de Auto
                </h1>
            </div>
        </div>

        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <form class="form-horizontal"
                      action="CrudAlert.php?id=<?php echo $id; ?>&metodo=update&clave=<?php echo $row[auto::CLIENTE_CLAVE]; ?>"
                      method="POST">
                    <!-- Nombre del dueño, marca, modelo, color, anio, transmision, cliente_clave-->
                    <div class="form-group">
                        <label class="control-label col-sm-2">Nombre del dueño:</label>
                        <div class="col-sm-3">
                            <input class="form-control" type="text" name="clave"
                                   value="<?php echo $row[persona::NOMBRE] . " " . $row[persona::A_PATERNO] . " " . $row[persona::A_MATERNO];
                                   //$_POST[auto::CLIENTE_CLAVE] = $row[auto::CLIENTE_CLAVE] ?>" readonly>
                        </div>
                    </div>
                    <!-- Placa -->
                    <div class="form-group">
                        <label class="control-label col-sm-2">Placa:</label>
                        <div class="col-lg-3">
                            <input class="form-control" type="text" name="placa" value="<?php echo $id; ?>" readonly>
                        </div>
                    </div>
                    <!--Marca-->
                    <div class="form-group">
                        <label class="control-label col-sm-2">Marca:</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="marca"
                                   value="<?php echo $row[auto::MARCA]; ?>" required autofocus>
                        </div>
                    </div>
                    <!-- Color-->
                    <div class="form-group">
                        <label class="control-label col-sm-2">Color:</label>
                        <div class="col-sm-3">
                            <input type="color" style="color: <?php echo $row[auto::COLOR]; ?>" class="form-control"
                                   name="color"
                                   value="<?php echo $row[auto::COLOR]; ?>" required>
                        </div>
                    </div>
                    <!-- Año -->
                    <div class="form-group">
                        <label class="control-label col-sm-2">Año:</label>
                        <div class="col-sm-3">
                            <select class="form-control" name="anio">
                                <?php for ($i = date("Y"); $i > 1949; $i--)
                                    if ($row[auto::ANIO] == $i) {
                                        echo "<option value='" . $i . "' selected>" . $i . "</option>";
                                    } else {
                                        echo "<option value='" . $i . "' selected>" . $i . "</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <!-- Transmision -->
                    <div class="form-group">
                        <label class="control-label col-sm-2">Transmision:</label>
                        <div class="col-sm-3">
                            <select class="form-control" name="transmision">
                                <?php if ($row[auto::TRANSMISION] == 'MANUAL') {
                                    echo "<option value='MANUAL' selected>MANUAL</option>
                                    <option  value='AUTOMATICA'>AUTOMATICA</option>";
                                } else {
                                    echo "<option value='MANUAL'>MANUAL</option>
                                    <option  value='AUTOMATICA' selected>AUTOMATICA</option>";
                                } ?>
                            </select>
                        </div>
                    </div>

                    <!-- Botónnes para registrar y cancelar -->
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-success">Actualizar</button>


                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#mymodal">
                                Cancelar
                            </button>


                        </div>

                </form>
            </div>
        </div>

    </div>
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
                <p>¿Seguro que desea cancelar la actualizacion del cliente?</p>
            </div>
            <div class="modal-footer">
                <a href="main.html">
                    <button type="button" class="btn btn-success">Si</button>
                </a>
                <button type="button" data-dismiss="modal" class="btn btn-danger">No</button>
            </div>
        </div>
    </div>
</div>

</body>

</html>