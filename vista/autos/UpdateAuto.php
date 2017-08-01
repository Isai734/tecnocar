<?php
require "../../control/persona.php";
require "../../control/auto.php";
require "../../modelo/ConexionBD.php";
require "../../utilidades/Constantes.php";
require "../../utilidades/ExcepcionApi.php";
$id = $_GET['id'];
echo $id;
//$tipo = $_GET['tipo'];
$row = auto::getAuto($id)[auto::NOMBRE_TABLA][0];
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
                <span class="glyphicon glyphicon-pencil"></span> Modifcar Datos de Auto
            </h1>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <form class="form-horizontal" action="CrudAlert.php?id=<?php echo $id; ?>&metodo=update&clave=<?php echo $row[auto::CLIENTE_CLAVE];?>" method="POST">
                <!-- Nombre del dueño, marca, modelo, color, anio, transmision, cliente_clave-->
                <div class="form-group">
                    <label class="control-label col-sm-2">Nombre del dueño:</label>
                    <div class="col-sm-3">
                        <input class="form-control" type="text" name="clave" value="<?php echo $row[persona::NOMBRE] . " " . $row[persona::A_PATERNO] . " " . $row[persona::A_MATERNO];
                        $_POST[auto::CLIENTE_CLAVE]=$row[auto::CLIENTE_CLAVE]?>" readonly>
                    </div>
                </div>
                <!-- Placa -->
                <div class="form-group">
                    <label class="control-label col-sm-2">Placa:</label>
                    <div class="col-lg-1">
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
                <!--Modelo-->
                <div class="form-group">
                    <label class="control-label col-sm-2">Modelo:</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="modelo"
                               value="<?php echo $row[auto::MODELO]; ?>" required autofocus>
                    </div>
                </div>

                <!-- Color-->
                <div class="form-group">
                    <label class="control-label col-sm-2">Color:</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control"
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
                                if($row[auto::ANIO]==$i){
                                    echo "<option value='" . $i . "' selected>" . $i . "</option>";
                                }else{
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
                <a href="QueryAutos.php">
                    <button type="button" class="btn btn-success">Si</button>
                </a>
                <button type="button" data-dismiss="modal" class="btn btn-danger">No</button>
            </div>
        </div>
    </div>
</div>

</body>

</html>