<?php
require "../../control/empresa.php";
require "../../modelo/ConexionBD.php";
require "../../utilidades/Constantes.php";
require "../../utilidades/ExcepcionApi.php";
$id = $_GET['id'];
echo $id;
//$tipo = $_GET['tipo'];
$row = empresa::getEmpresa($id)[empresa::NOMBRE_TABLA][0];
?>

<!DOCTYPE html>
<html>
<head>

</head>
<?php include "main.php" ?>

<script src="../style/js/jquery-3.2.0.min.js"></script>
<script src="../style/js/bootstrap.js"></script>

<body>

<br>
<br>
<div class="container">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <span class="glyphicon glyphicon-pencil"></span> Modifcar Datos de empresa
            </h1>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <form class="form-horizontal" action="CrudAlert.php?id=<?php echo $id; ?>&metodo=update" method="POST">

                <!-- Placa -->
                <div class="form-group">
                    <label class="control-label col-sm-2">Clave:</label>
                    <div class="col-lg-1">
                        <input class="form-control" type="text" name="clave" value="<?php echo $id; ?>" readonly>
                    </div>
                </div>
                <!--Marca  clave, razon_social, direccion, cp, rfc-->
                <div class="form-group">
                    <label class="control-label col-sm-2">Razon social:</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="razon_social"
                               value="<?php echo $row[empresa::RAZON_SOCIAL]; ?>" required empresafocus>
                    </div>
                </div>
                <!-- Direccion-->
                <div class="form-group">
                    <label class="control-label col-sm-2">Direccion:</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="direccion"
                               value="<?php echo $row[empresa::DIRECCION]; ?>" required>
                    </div>
                </div>
                <!-- CP-->
                <div class="form-group">
                    <label class="control-label col-sm-2">Codigo Postal:</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="cp"
                               value="<?php echo $row[empresa::CP]; ?>" required>
                    </div>
                </div>

                <!-- RFC-->
                <div class="form-group">
                    <label class="control-label col-sm-2">RFC:</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="rfc"
                               value="<?php echo $row[empresa::RFC]; ?>" required>
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
                <p>¿Seguro que desea cancelar la actualizacion de la empresa?</p>
            </div>
            <div class="modal-footer">
                <a href="QueryEmpresa.php">
                    <button type="button" class="btn btn-success">Si</button>
                </a>
                <button type="button" data-dismiss="modal" class="btn btn-danger">No</button>
            </div>
        </div>
    </div>
</div>

</body>

</html>