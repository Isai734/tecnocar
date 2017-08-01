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
                <h1 class="page-header">
                    <span class="glyphicon glyphicon-plus"></span> Nueva Empresa
                </h1>
            </div>
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-lg-12">
                <!-- FORMULARIO -->
                <form class="form-horizontal" action="CrudAlert.php?&metodo=add&id=<?php echo $id ?>" method="POST"
                      onsubmit="return validarAddCliente()" autocomplete="off">

                    <!--Clave clave, razon_social, direccion, cp, rfc-->
                    <!-- Razon social-->
                    <div class="form-group">
                        <label class="control-label col-sm-2">Razon Social:</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="razon_social" name="razon_social">
                        </div>
                    </div>

                    <!-- Direccion -->
                    <div class="form-group">
                        <label class="control-label col-sm-2">Direccion:</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="direccion" name="direccion">
                        </div>
                    </div>
                    <!-- CP -->
                    <div class="form-group">
                        <label class="control-label col-sm-2">Codigo Postal:</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="cp" name="cp">
                        </div>
                    </div>
                    <!-- RFC -->
                    <div class="form-group">
                        <label class="control-label col-sm-2">RFC:</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="rfc" name="rfc">
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
                <p>¿Seguro que desea cancelar el registro de la empresa?</p>
            </div>
            <div class="modal-footer">
                <a href="main.php">
                    <button type="button" class="btn btn-success">Si</button>
                </a>
                <button type="button" data-dismiss="modal" class="btn btn-danger">No</button>
            </div>
        </div>
    </div>
</div>

</body>


</html>