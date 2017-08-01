<?php
include '../../modelo/ConexionBD.php';
include '../../control/auto.php';
include '../../control/persona.php';
include '../../control/orden.php';
include '../../utilidades/Constantes.php';
include '../../control/login.php';
session_start();
$rows = null;
$id = null;
if (isset($_SESSION[login::NOMBRE_TABLA]) | !empty($_SESSION[login::NOMBRE_TABLA])) {
    include "main_in.php";
    $user = $_SESSION[login::NOMBRE_TABLA];
    $id = $user[login::PERSONA_CLAVE];
    //$rows = persona::getPersonas($id)[persona::NOMBRE_TABLA][0];
} else {
    header("Location: ../login/login.php");
}
?>

<!DOCTYPE html>
<html>
<head>
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
    <script src="../../vista/style/js/bootstrap.js"></script>
    <script src="../../vista/style/js/jquery-3.2.0.min.js"></script>
    <script src="../../vista/style/sweet/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../../vista/style/sweet/sweetalert.css">
    <!-- Scripts y styleshet-->
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,700,500,900' rel='stylesheet' type='text/css'>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="../js/skel.min.js"></script>
    <script src="../js/skel-panels.min.js"></script>
    <script src="../js/init_c.js"></script>
    <noscript>
        <link rel="stylesheet" href="../css/skel-noscript.css"/>
        <link rel="stylesheet" href="../css/style.css"/>
        <link rel="stylesheet" href="../css/style-desktop.css"/>
    </noscript>
    <!-- fin -->

</head>

<body>

<!-- Header -->
<div id="header_2">
    <div class="container">
        <!-- Logo -->
        <br><br><br>
        <div id="logo">
            <h1><a href="#">Tecnocar</a></h1>
            <span class="tag">Tu taller mecanico</span>
        </div>
        <br>
    </div>
</div>

<div id="page-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header" style="font-size: 25pt; color: #00796B">
                    <span class="glyphicon glyphicon-list-alt"></span> Mis ordenes de servicio
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

        <?php $datos = orden::getOrden($id)[orden::NOMBRE_TABLA];
        if (count($datos) > 0) {
            echo '
        <div class="table-responsive">
            <table class="order-table table table-striped" id="tabla">
                <thead>
                <tr style="background-color: #00796B; color: white;">
                    <th>Placa</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Nombre</th>
                    <th>Mano Obra</th>
                    <th>Total</th>
                    <th>Estatus</th>
                    <th></th>
                </tr>
                </thead>
                <tbody style="font-size: 15pt; text-align: center;">';


            foreach ($datos as $res) {
                $nombre = $res[persona::NOMBRE] . " " . $res[persona::A_PATERNO] . " " . $res[persona::A_MATERNO];
                echo '<tr>
			    			<td>' . $res[auto::PLACA] . '</td>
			    			<td>' . $res[auto::MARCA] . '</td>
			    			<td>' . $res[auto::MODELO] . '</td>
			    			<td>' . $nombre . '</td>
			    			<td>' . $res[orden::MANO_OBRA] . '</td>
			    			<td>' . $res[orden::TOTAL] . '</td>
			    			<td>' . $res[orden::ESTATUS_ORDEN] . '</td>';
                echo '<td><a href="DetalleOrden.php?id=' . $res[orden::NUMERO] . '&clave=' . $res[auto::CLIENTE_CLAVE] . '" data-toggle="tooltip" data-placement="top" title="Detalle">
                <button class="btn btn-primary"> <span class="glyphicon glyphicon-list"></span></button></a></td>';

            }


            echo '</tbody>
            </table>
        </div>';
        }else{
            echo '<h1 class="fa-heart">Aun no tiene ninguna Orden de Servicio</h1>';
        }?>
    </div>
</div>

<!--Alert-->
<div class="modal fade" id="add_evento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Agendar una cita</h4>
            </div>
            <div class="modal-body">
                <!--tabla-->

                <!--fin tabla-->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>

</body>
<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

    function eliminar(id) {
        var ids = document.getElementById("del").value;
        swal({
                title: "Esta seguro que desea eliminar el registro?",
                text: "You will not be able to recover this imaginary file!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Aceptar!",
                cancelButtonText: "Cancelar",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function (isConfirm) {
                if (isConfirm) {
                    window.location = "CrudAlert.php?id=" + ids + "&metodo=delete";
                } else {
                    //swal("Cancelled", "Your imaginary file is safe :)", "error");
                }
            });
    }

    function addauto() {
        window.location = "AddAuto.php?id=<?php echo $id?>";
    }
</script>

</body>
</html>