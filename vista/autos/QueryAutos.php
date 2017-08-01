<?php
include '../../modelo/ConexionBD.php';
include '../../control/auto.php';
include '../../control/persona.php';
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
<script src="../../vista/style/sweet/sweetalert.min.js"></script>
<link rel="stylesheet" type="text/css" href="../../vista/style/sweet/sweetalert.css">
<body>

<br>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <span class="glyphicon glyphicon-list-alt"></span> Autos
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

    <br>
    <!-- Tabla de clientes placa, marca, modelo, color, anio, transmision, cliente_clave-->
    <div class="table-responsive">
        <table class="order-table table table-striped" id="tabla">
            <thead>
            <tr class="info">
                <th>Placa</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Color</th>
                <th>anio</th>
                <th>Transmision</th>
                <th>Cliente</th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>

            <?php
            $datos = auto::getAuto(null)[auto::NOMBRE_TABLA];
            foreach ($datos as $res) {
                $nombre = $res[persona::NOMBRE] . " " . $res[persona::A_PATERNO] . " " . $res[persona::A_MATERNO];
                echo '<tr>
			    			<td>' . $res[auto::PLACA] . '</td>
			    			<td>' . $res[auto::MARCA] . '</td>
			    			<td>' . $res[auto::MODELO] . '</td>
			    			<td>' . $res[auto::COLOR] . '</td>
			    			<td>' . $res[auto::ANIO] . '</td>
			    			<td>' . $res[auto::TRANSMISION] . '</td>
                            <td>' . $nombre . '</td>';

                echo '		<td><a href="UpdateAuto.php?id=' . $res[auto::PLACA] . '&clave=' . $res[auto::CLIENTE_CLAVE] . '" data-toggle="tooltip" data-placement="top" title="Modificar"><button class="btn btn-warning"> <span class="glyphicon glyphicon-pencil"></span></button></a></td>
                            <td><a data-toggle="tooltip" data-placement="top" title="Eliminar"><button value="' . $res[auto::PLACA] . '" id="del" onclick="eliminar()" class="btn btn-danger"> <span class="glyphicon glyphicon-remove"></span></button></a></td>

			    		</tr>';
            }
            ?>
            </tbody>
        </table>
    </div>

</div>

</body>

<script src="../style/js/jquery-3.2.0.min.js"></script>
<script src="../style/js/bootstrap.js"></script>
<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

    function eliminar(id) {
        var ids=document.getElementById("del").value;
        swal({
                title: "Esta seguro que desea eliminar el registro?",
                text: "You will not be able to recover this imaginary file!",
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
                    //swal("Cancelled", "Your imaginary file is safe :)", "error");
                }
            });
    }
</script>

</body>
</html>