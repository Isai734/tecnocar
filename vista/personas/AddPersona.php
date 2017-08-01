<?php include "main.php";
$tipo = $_GET['tipo'];
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
                    <span class="glyphicon glyphicon-plus"></span> Nuevo <?php echo $tipo;?>
                </h1>
            </div>
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-lg-12">
                <!-- FORMULARIO -->
                <form class="form-horizontal" action="CrudAlert.php?tipo=<?php echo $tipo; ?>&metodo=add" method="POST"
                      onsubmit="return validarAddCliente()" autocomplete="off">
                    <!--Nombre del cliente-->
                    <div class="form-group">
                        <label class="control-label col-sm-2">Nombre:</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="nombre" name="nombre" autofocus>
                        </div>
                    </div>
                    <!-- Apellido paterno del cliente-->
                    <div class="form-group">
                        <label class="control-label col-sm-2">Primer Apellido:</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="apellido_paterno" name="apellido_paterno">
                        </div>
                    </div>

                    <!-- Apellido Materno del cliente -->
                    <div class="form-group">
                        <label class="control-label col-sm-2">Segundo Apellido:</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="apellido_paterno" name="apellido_materno">
                        </div>
                    </div>

                    <!-- Teléfono del cliente -->
                    <div class="form-group">
                        <label class="control-label col-sm-2">Teléfono:</label>
                        <div class="col-sm-3">
                            <input type="phone" class="form-control" id="telefono" name="telefono">
                        </div>
                    </div>

                    <!-- Dirección del cliente -->
                    <div class="form-group">
                        <label class="control-label col-sm-2">Dirección:</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="direccion" name="direccion">
                        </div>
                    </div>
                    <?php if ($tipo == "CLIENTE") { ?>
                        <!-- Email del cliente -->
                        <div class="form-group">
                            <label class="control-label col-sm-2">E-mail:</label>
                            <div class="col-sm-3">
                                <input type="email" class="form-control" id="email" name="email">
                            </div>
                        </div>

                        <!-- RFC del cliente -->
                        <div class="form-group">
                            <label class="control-label col-sm-2">RFC:</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="rfc" name="rfc">
                            </div>
                        </div>

                    <?php }
                    if ($tipo == "MECANICO") { ?>
                        <!-- Especialidad -->
                        <div class="form-group">
                            <label class="control-label col-sm-2">Especialidad:</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="rfc" name="especialidad">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2">Status:</label>
                            <div class="col-sm-3">
                                <select class="form-control" name="status">
                                    <option value="LIBRE">LIBRE</option>
                                    <option  value="OCUPADO" selected>OCUPADO</option>
                                </select>
                            </div>
                        </div>
                    <?php } ?>

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
                <a href="QueryPersona.php?tipo=<?=$tipo?>">
                    <button type="button" class="btn" style="background-color: #00796B; color: white">Si</button>
                </a>
                <button type="button" data-dismiss="modal" class="btn btn-danger">No</button>
            </div>
        </div>
    </div>
</div>

</body>


</html>