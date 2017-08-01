<?php
include '../../modelo/ConexionBD.php';
include '../../control/persona.php';
include '../../utilidades/Constantes.php';
$tipo = $_GET['tipo'];
echo $tipo;
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
                <span class="glyphicon glyphicon-list-alt"></span> <?=$tipo?>
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
    <!-- Tabla de clientes -->
    <div class="table-responsive">
        <table class="order-table table table-striped" id="tabla">
            <thead>
            <tr style="background-color: #00796B; color: white;">
                <th>Clave</th>
                <th>Nombre</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
                <th>Teléfono</th>

                <th>Dirección</th>
                <?php if ($tipo == "CLIENTE") { ?>
                    <th>E-mail</th>
                    <th>RFC</th>
                <?php }
                if ($tipo == "MECANICO") { ?>
                    <th>Especialidad</th>
                    <th>Estatus</th>
                <?php } ?>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>

            <?php
            $datos = persona::getPersonas($tipo)[persona::NOMBRE_TABLA];
            foreach ($datos as $res) {
                echo '<tr>
			    			<td>' . $res[persona::ID_PERSONA] . '</td>
			    			<td>' . $res[persona::NOMBRE] . '</td>
			    			<td>' . $res[persona::A_PATERNO] . '</td>
			    			<td>' . $res[persona::A_MATERNO] . '</td>
			    			<td>' . $res[persona::TELEFONO] . '</td>
			    			<td>' . $res[persona::DIRECCION] . '</td>';
                if ($tipo == "CLIENTE") {
                    echo '  <td>' . $res[persona::EMAIL] . '</td>
			    			<td>' . $res[persona::RFC] . '</td>';
                    echo '		<td><a href="UpdatePersona.php?id=' . $res[persona::ID_PERSONA] . '&tipo=' . $tipo . '" data-toggle="tooltip" data-placement="top" title="Modificar"><button class="btn btn-warning"> <span class="glyphicon glyphicon-pencil"></span></button></a></td>
			        		<td><a href="CrudAlert.php?id=' . $res[persona::ID_PERSONA] . '&metodo=delete' . '&tipo=' . $tipo . '" data-toggle="tooltip" data-placement="top" title="Eliminar"><button class="btn btn-danger"> <span class="glyphicon glyphicon-remove"></span></button></a></td>
			        		<td><a href="../autos/AddAuto.php?id=' . $res[persona::ID_PERSONA] . '" data-toggle="tooltip" data-placement="top" title="Nuevo Auto"><button class="btn btn-primary"> <span class="glyphicon glyphicon-bed"></span></button></a></td>
			    		</tr>';
                }
                if ($tipo == "MECANICO") {
                    echo '  <td>' . $res[persona::ESPECIALIDAD] . '</td>
			    			<td>' . $res[persona::STATUS] . '</td>';
                    echo '		<td><a href="UpdatePersona.php?id=' . $res[persona::ID_PERSONA] . '&tipo=' . $tipo . '" data-toggle="tooltip" data-placement="top" title="Modificar"><button class="btn btn-warning"> <span class="glyphicon glyphicon-pencil"></span></button></a></td>
			        		<td><a href="CrudAlert.php?id=' . $res[persona::ID_PERSONA] . '&metodo=delete' . '&tipo=' . $tipo . '" data-toggle="tooltip" data-placement="top" title="Eliminar"><button class="btn btn-danger"> <span class="glyphicon glyphicon-remove"></span></button></a></td>
			    		</tr>';

                }

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
</script>

</body>
</html>