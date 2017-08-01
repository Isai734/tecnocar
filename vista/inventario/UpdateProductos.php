<?php
require "../../control/persona.php";
require "../../control/auto.php";
require "../../control/empresa.php";
require "../../control/producto.php";
require "../../modelo/ConexionBD.php";
require "../../utilidades/Constantes.php";
require "../../utilidades/ExcepcionApi.php";
$id = $_GET['id'];
echo $id;
//$tipo = $_GET['tipo'];
$row = producto::getProducto($id)[producto::NOMBRE_TABLA][0];
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
    <!-- Dialogo add -->
    <div class="modal fade" id="mostrarmodal" data-backdrop="static" data-keyboard="false"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Agregar nuevo Producto</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="CrudAlert.php?&metodo=update" method="POST"
                          onsubmit="return validarAddCliente()" autocomplete="off">

                        <!--clave, nombre, descripccion, precio_compra, precio_venta, proveedor_clave-->
                        <div class="form-group">
                            <label class="control-label col-sm-2">Clave:</label>
                            <div class="col-sm-7">
                                <input readonly type="text" class="form-control" id="nombre" value="<?=$row[producto::CLAVE]?>" name="clave">
                            </div>
                        </div>
                        <!-- Nombre -->
                        <div class="form-group">
                            <label class="control-label col-sm-2">Nombre:</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="nombre" value="<?=$row[producto::NOMBRE]?>" name="nombre">
                            </div>
                        </div>

                        <!-- Descripccion -->
                        <div class="form-group">
                            <label class="control-label col-sm-2">Descripccion:</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" value="<?=$row[producto::DESCRIPCCION]?>" id="descripccion" name="descripccion">
                            </div>
                        </div>
                        <!-- Precio compra -->
                        <div class="form-group">
                            <label class="control-label col-sm-2">Precio Compra:</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" value="<?=$row[producto::PRECIO_COMPRA]?>" id="precio_compra" name="precio_compra">
                            </div>
                        </div>
                        <!-- Precio venta -->
                        <div class="form-group">
                            <label class="control-label col-sm-2">Precio Venta:</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" value="<?=$row[producto::PRECIO_VENTA]?>" id="precio_venta" name="precio_venta">
                            </div>
                        </div>
                        <!-- Precio venta -->
                        <div class="form-group">
                            <label class="control-label col-sm-2">Cantidad:</label>
                            <div class="col-sm-7">
                                <input type="number" class="form-control" value="<?=$row[producto::CANTIDAD]?>" id="precio_venta" name="cantidad">
                            </div>
                        </div>
                        <!-- Select provvedor -->
                        <div class="form-group">
                            <label class="control-label col-sm-2">Provedor:</label>
                            <div class="col-sm-7">
                                <select class="form-control" name="proveedor_clave">
                                    <?php
                                    $datos = empresa::getEmpresa(null)[empresa::NOMBRE_TABLA];
                                    foreach ($datos as $res) {
                                        echo "<option value='" . $res[empresa::CLAVE] . "'>" . $res[empresa::RAZON_SOCIAL] . "</option>";
                                    } ?>
                                </select>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <a href="QueryProductos.php"><button href="QueryProductos.php" type="button" class="btn btn-danger"><i class="fa fa-times"></i>
                                    Cancelar
                                </button></a>
                            <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Agregar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Dialogo -->
</div>
</body>

<script>
    $(document).ready(function()
    {
        $("#mostrarmodal").modal("show");
    });
</script>
</html>