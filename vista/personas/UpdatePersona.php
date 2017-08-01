<?php
require "../../control/persona.php";
require "../../modelo/ConexionBD.php";
require "../../utilidades/Constantes.php";
$id = $_GET['id'];
$tipo = $_GET['tipo'];
$row = persona::getPersonas($id)[persona::NOMBRE_TABLA][0];
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
            <h1 class="page-header" style="color: #00796B; font-size: 30pt;">
                <span class="glyphicon glyphicon-pencil"></span> Modifcar Cliente
            </h1>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <form class="form-horizontal"
                  action="CrudAlert.php?id=<?php echo $id; ?>&metodo=update&tipo=<?php echo $tipo; ?>" method="POST">
                <!-- Id del cliente clave, nombre, apellido_paterno, apellido_materno, telefono, -->
                <div class="form-group">
                    <label class="control-label col-sm-2">Clave:</label>
                    <div class="col-lg-1">
                        <input class="form-control" type="text" name="clave" value="<?php echo $id; ?>" readonly>
                    </div>
                </div>
                <!--Nombre del cliente-->
                <div class="form-group">
                    <label class="control-label col-sm-2">Nombre:</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="nombre"
                               value="<?php echo $row[persona::NOMBRE]; ?>" required autofocus>
                    </div>
                </div>
                <!-- Apellido paterno del cliente-->
                <div class="form-group">
                    <label class="control-label col-sm-2">Primer Apellido:</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="apellido_paterno"
                               value="<?php echo $row[persona::A_PATERNO]; ?>" required>
                    </div>
                </div>
                <!-- Apellido Materno del cliente -->
                <div class="form-group">
                    <label class="control-label col-sm-2">Segundo Apellido:</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="apellido_materno"
                               value="<?php echo $row[persona::A_MATERNO]; ?>" required>
                    </div>
                </div>
                <!-- Teléfono del cliente -->
                <div class="form-group">
                    <label class="control-label col-sm-2">Teléfono:</label>
                    <div class="col-sm-3">
                        <input type="phone" class="form-control" name="telefono"
                               value="<?php echo $row[persona::TELEFONO]; ?>" required>
                    </div>
                </div>
                <!-- Dirección del cliente direccion, email, cp, rfc, especialidad, tipo, status-->
                <div class="form-group">
                    <label class="control-label col-sm-2">Dirección:</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="direccion"
                               value="<?php echo $row[persona::DIRECCION]; ?>" required>
                    </div>
                </div>
                <?php if ($tipo == "CLIENTE") { ?>
                    <!-- Email del cliente -->
                    <div class="form-group">
                        <label class="control-label col-sm-2">E-mail:</label>
                        <div class="col-sm-3">
                            <input type="email" class="form-control" name="email"
                                   value="<?php echo $row[persona::EMAIL]; ?>" required>
                        </div>
                    </div>
                    <!-- RFC del cliente -->
                    <div class="form-group">
                        <label class="control-label col-sm-2">RFC:</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="rfc" value="<?php echo $row[persona::RFC]; ?>"
                                   required>
                        </div>
                    </div>
                <?php }
                if ($tipo == "MECANICO") { ?>
                    <!-- Especialidad -->
                    <div class="form-group">
                        <label class="control-label col-sm-2">Especialidad:</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="rfc" name="especialidad"
                                   value="<?php echo $row[persona::ESPECIALIDAD]; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">Status:</label>
                        <div class="col-sm-3">
                            <select class="form-control" name="status">
                                <?php if ($row[persona::STATUS] == 'LIBRE') {
                                    echo "<option value='LIBRE' selected>LIBRE</option>
                                    <option  value='OCUPADO'>OCUPADO</option>";
                                } else {
                                    echo "<option value='LIBRE'>LIBRE</option>
                                    <option  value='OCUPADO' selected>OCUPADO</option>";
                                } ?>
                            </select>
                        </div>
                    </div>

                <?php } ?>
                <!-- Botónnes para registrar y cancelar -->
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn" style="background-color: #00796B; color: white">Actualizar</button>


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
                <p>¿Seguro que desea cancelar la actualizacion del cliente?</p>
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