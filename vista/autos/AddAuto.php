<?php include "main.php";

include '../../modelo/ConexionBD.php';
include '../../control/auto.php';
include '../../control/persona.php';
include '../../utilidades/Constantes.php';
include '../../utilidades/ExcepcionApi.php';
$id = null;
$rows = null;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $rows = persona::getPersonas($id)[persona::NOMBRE_TABLA][0];
} else {
    $rows = persona::getPersonas("CLIENTE")[persona::NOMBRE_TABLA];
}
?>
<!DOCTYPE html>
<html>
<head>
    <script src="../style/js/validaciones.js"></script>
    <script src="../style/js/bootstrap.js"></script>
    <script src="../style/js/jquery-3.2.0.min.js"></script>

</head>
<body>
<br>
<div id="page-wrapper">
    <div class="container">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header" style="color: #00796B; font-size: 30pt;">
                    <span class="glyphicon glyphicon-plus"></span> Nuevo Auto
                </h1>
            </div>
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-lg-12">
                <!-- FORMULARIO -->
                <form class="form-horizontal" action="CrudAlert.php?&metodo=add&id=<?php echo $id ?>" method="POST"
                      onsubmit="return validarAddCliente()" autocomplete="off">

                    <!-- Datos cliente si se selecciono -->
                    <div class="form-group">
                        <?php if (isset($_GET['id'])) {
                            echo "
                                <label class='control-label col-sm-2'>Cliente :</label>
                                 <div class='col-sm-3'>
                                    <input class='form-control' type='text' name='clave' value='"
                                . $rows[persona::NOMBRE] . " " . $rows[persona::A_PATERNO] . " " . $rows[persona::A_MATERNO] . "' readonly>
                                </div>";
                        } else { ?>
                            <div class="form-group">
                                <label class="control-label col-sm-2">Cliente:</label>
                                <div class="col-sm-3">
                                    <select class="form-control" name="cliente_clave">
                                        <?php foreach ($rows as $res) {
                                            $nombre = $res[persona::NOMBRE] . " " . $res[persona::A_PATERNO] . " " . $res[persona::A_MATERNO];
                                            echo "<option value='" . $res[persona::ID_PERSONA] . "'>" . $nombre . "</option>";
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        <?php } ?>

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
                            <button type="submit" class="btn" style="background-color: #00796B; color: white">Registrar</button>
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
                <?php if (isset($_GET['id'])) { ?>
                <a href="../personas/QueryPersona.php?tipo=CLIENTE">
                    <?php }else{ ?>
                    <a href="QueryAutos.php">
                        <?php } ?>
                        <button type="button" class="btn" style="background-color: #00796B; color: white">Si</button>
                    </a>
                    <button type="button" data-dismiss="modal" class="btn btn-danger">No</button>
            </div>
        </div>
    </div>
</div>

</body>


</html>