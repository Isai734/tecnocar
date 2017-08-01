<?php
include '../../modelo/ConexionBD.php';
include '../../control/producto.php';
include '../../control/empresa.php';
include '../../utilidades/Constantes.php';
include '../../utilidades/ExcepcionApi.php';
?>

<!DOCTYPE html>
<html>
<head>
    <?php include "main.php"; ?>
    <!-- Filtrar tabla -->
    <script type="text/javascript">
        (function (document) {
            'use strict';
            var LightTableFilter = (function (Arr) {
                var _input;

                function _onInputEvent(e) {
                    _input = e.target;
                    var tables = document.getElementsByClassName(_input.getAttribute('data-table'));
                    Arr.forEach.call(tables, function (table) {
                        Arr.forEach.call(table.tBodies, function (tbody) {
                            Arr.forEach.call(tbody.rows, _filter);
                        });
                    });
                }

                function _filter(row) {
                    var text = row.textContent.toLowerCase(), val = _input.value.toLowerCase();
                    row.style.display = text.indexOf(val) === -1 ? 'none' : 'table-row';
                }

                return {
                    init: function () {
                        var inputs = document.getElementsByClassName('light-table-filter');
                        Arr.forEach.call(inputs, function (input) {
                            input.oninput = _onInputEvent;
                        });
                    }
                };
            })(Array.prototype);

            document.addEventListener('readystatechange', function () {
                if (document.readyState === 'complete') {
                    LightTableFilter.init();
                }
            });
        })(document);
    </script>

    <!-- script -->
    <script src="../../vista/style/js/validaciones.js"></script>
    <script src="../../vista/style/sweet/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../../vista/style/sweet/sweetalert.css">
    <!-- Scripts y styleshet-->
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,700,500,900' rel='stylesheet' type='text/css'>

    <!-- fin -->
</head>

<body>

<br>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header" style="color: #00796B; font-size: 30pt;">
                <span class="glyphicon glyphicon-list-alt"></span> Inventario
            </h1>
        </div>
    </div>
    <!-- Barra de busqueda -->
    <form class="form-horizontal">

        <div class="input-group col-lg-3">
            <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
            <input class="light-table-filter form-control col-lg-4" type="search" placeholder="Buscar..."
                   id="txt_buscar" data-table="order-table">
        </div>
    </form>
    <!-- Boton add -->
    <div class="pull-right form-inline"><br>

        <button class="btn btn-primary" data-toggle='modal' data-target='#add_evento'><span
                    class="glyphicon glyphicon-plus"> Agregar Producto</button>
    </div>


    <br>

    <div class="row">
        
    </div>
    <br>
    <!-- Tabla de productos clave, nombre, descripccion, precio_compra, precio_venta, proveedor_clave-->
    <div class="table-responsive">
        <table class="order-table table table-striped" id="tabla">
            <thead>
            <tr style="background-color: #00796B; color: white;">
                <th>Clave</th>
                <th>Nombre</th>
                <th>Descripccion</th>
                <th>Precio Compra</th>
                <th>Precio Venta</th>
                <th>Cantidad</th>
                <th>Preveedor</th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody style="text-align: center;">

            <?php
            $datos = producto::getProducto(null)[producto::NOMBRE_TABLA];
            foreach ($datos as $res) {
                $nombre = $res[empresa::RAZON_SOCIAL];
                echo '<tr>
			    			<td>' . $res[producto::CLAVE] . '</td>
			    			<td>' . $res[producto::NOMBRE] . '</td>
			    			<td>' . $res[producto::DESCRIPCCION] . '</td>
			    			<td>' . $res[producto::PRECIO_COMPRA] . '</td>
			    			<td>' . $res[producto::PRECIO_VENTA] . '</td>
			    			<td>' . $res[producto::CANTIDAD] . '</td>
                            <td>' . $nombre . '</td>';

                echo '		<td><a href="UpdateProductos.php?id=' . $res[producto::CLAVE] . '&clave=' . $res[producto::PROVEEDOR_CLAVE] . '" data-toggle="tooltip" data-placement="top" title="Modificar"><button class="btn btn-warning"> <span class="glyphicon glyphicon-pencil"></span></button></a></td>
			        		<td><a data-toggle="tooltip" data-placement="top" title="Eliminar"><button onclick="eliminar()" id="del" value="' . $res[producto::CLAVE] . '" class="btn btn-danger"> <span class="glyphicon glyphicon-remove"></span></button></a></td>
			    		</tr>';
            }
            ?>
            </tbody>
        </table>
    </div>

</div>

</body>
<!-- Dialogo add -->
<div class="modal fade" id="add_evento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Agregar nuevo Producto</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="CrudAlert.php?&metodo=add" method="POST"
                      onsubmit="return validarAddCliente()" autocomplete="off">

                    <!--clave, nombre, descripccion, precio_compra, precio_venta, proveedor_clave-->
                    <!-- Nombre -->
                    <div class="form-group">
                        <label class="control-label col-sm-2">Nombre:</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="nombre" name="nombre">
                        </div>
                    </div>

                    <!-- Descripccion -->
                    <div class="form-group">
                        <label class="control-label col-sm-2">Descripccion:</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="descripccion" name="descripccion">
                        </div>
                    </div>
                    <!-- Precio compra -->
                    <div class="form-group">
                        <label class="control-label col-sm-2">Precio Compra:</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="precio_compra" name="precio_compra">
                        </div>
                    </div>
                    <!-- Precio venta -->
                    <div class="form-group">
                        <label class="control-label col-sm-2">Precio Venta:</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="precio_venta" name="precio_venta">
                        </div>
                    </div>
                    <!-- Precio venta -->
                    <div class="form-group">
                        <label class="control-label col-sm-2">Cantidad:</label>
                        <div class="col-sm-7">
                            <input type="number" class="form-control" id="precio_venta" name="cantidad">
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
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>
                            Cancelar
                        </button>
                        <button type="submit" class="btn" style="background-color: #00796B; color: white"><i class="fa fa-check"></i> Agregar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Fin Dialogo -->

<!-- Dialogo Update -->
<?php if (isset($_GET['clave'])){ ?>

    <script>
        $(document).ready(function()
        {
            $("#mostrarmodal").modal("show");
        });
    </script>
<div class="modal fade" id="mostrarmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Agregar nuevo Producto</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="CrudAlert.php?&metodo=add" method="POST"
                      onsubmit="return validarAddCliente()" autocomplete="off">

                    <!--clave, nombre, descripccion, precio_compra, precio_venta, proveedor_clave-->
                    <!-- Nombre -->
                    <div class="form-group">
                        <label class="control-label col-sm-2">Nombre:</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="nombre" name="nombre">
                        </div>
                    </div>

                    <!-- Descripccion -->
                    <div class="form-group">
                        <label class="control-label col-sm-2">Descripccion:</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="descripccion" name="descripccion">
                        </div>
                    </div>
                    <!-- Precio compra -->
                    <div class="form-group">
                        <label class="control-label col-sm-2">Precio Compra:</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="precio_compra" name="precio_compra">
                        </div>
                    </div>
                    <!-- Precio venta -->
                    <div class="form-group">
                        <label class="control-label col-sm-2">Precio Venta:</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="precio_venta" name="precio_venta">
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
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>
                            Cancelar
                        </button>
                        <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Agregar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php }?>
<!-- Fin Dialogo -->
<script src="../style/js/jquery-3.2.0.min.js"></script>
<script src="../style/js/bootstrap.js"></script>
<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });


    function eliminar() {
        //alert("hola");
        var ids=document.getElementById("del").value;
        swal({
                title: "Esta seguro que desea eliminar el registro?",
                text: "",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Aceptar!",
                cancelButtonText: "Cancelar",
                closeOnConfirm: false,
                closeOnCancel: true
            },
            function(isConfirm) {
                if (isConfirm) {
                    window.location = "CrudAlert.php?id="+ids+"&metodo=delete";
                } else {

                }
            });
    }
</script>

</body>
</html>