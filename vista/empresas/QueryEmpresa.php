<?php
include '../../modelo/ConexionBD.php';
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


</head>

<body>

<br>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header" style="color: #00796B; font-size: 30pt;">
                <span class="glyphicon glyphicon-credit-card"></span> Proveedores
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
                    class="glyphicon glyphicon-plus"> Agregar Proveedor</button>
    </div>
    <br>
    <div class="row">
        <div><h2></h2></div>
    </div>
    <!-- Fin Boton add --> 
    <br>
    <!-- Tabla de clientes placa, marca, modelo, color, anio, transmision, cliente_clave-->
    <div class="table-responsive">
        <table class="order-table table table-striped" id="tabla">
            <thead>
            <tr style="background-color: #00796B; color: white;">
                <th>Clave</th>
                <th>Razon Social</th>
                <th>Direccion</th>
                <th>CP</th>
                <th>RFC</th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>

            <?php
            $datos = empresa::getEmpresa(null)[empresa::NOMBRE_TABLA];
            foreach ($datos as $res) {
                echo '<tr>
			    			<td>' . $res[empresa::CLAVE] . '</td>
			    			<td>' . $res[empresa::RAZON_SOCIAL] . '</td>
			    			<td>' . $res[empresa::DIRECCION] . '</td>
			    			<td>' . $res[empresa::CP] . '</td>
			    			<td>' . $res[empresa::RFC] . '</td>';

                echo '		<td><a href="UpdateEmpresa.php?id=' . $res[empresa::CLAVE] . '&clave=' . $res[empresa::CLAVE] . '" data-toggle="tooltip" data-placement="top" title="Modificar"><button class="btn btn-warning"> <span class="glyphicon glyphicon-pencil"></span></button></a></td>
			        		<td><a href="CrudAlert.php?id=' . $res[empresa::CLAVE] . '&metodo=delete' . '" data-toggle="tooltip" data-placement="top" title="Eliminar"><button class="btn btn-danger"> <span class="glyphicon glyphicon-remove"></span></button></a></td>
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
                <h4 class="modal-title" id="myModalLabel">Agregar nuevo proveedor</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="CrudAlert.php?&metodo=add" method="POST"
                      onsubmit="return validarAddCliente()" autocomplete="off">

                    <!--Clave clave, razon_social, direccion, cp, rfc-->
                    <!-- Razon social-->
                    <div class="form-group">
                        <label class="control-label col-sm-2">Razon Social:</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="razon_social" name="razon_social">
                        </div>
                    </div>

                    <!-- Direccion -->
                    <div class="form-group">
                        <label class="control-label col-sm-2">Direccion:</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="direccion" name="direccion">
                        </div>
                    </div>
                    <!-- CP -->
                    <div class="form-group">
                        <label class="control-label col-sm-2">Codigo Postal:</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="cp" name="cp">
                        </div>
                    </div>
                    <!-- RFC -->
                    <div class="form-group">
                        <label class="control-label col-sm-2">RFC:</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="rfc" name="rfc">
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

<script src="../style/js/jquery-3.2.0.min.js"></script>
<script src="../style/js/bootstrap.js"></script>
<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>

</body>
</html>