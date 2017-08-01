<?php
include '../../modelo/ConexionBD.php';
include '../../control/producto.php';
include '../../control/empresa.php';
include '../../control/persona.php';
include '../../control/servicio.php';
include '../../control/auto.php';
include '../../utilidades/Constantes.php';
include '../../utilidades/ExcepcionApi.php';
session_start();
print_r($_SESSION['post']);
include "main.php";
/**
 * Array ( [cliente_clave] => 1 [auto_placa] => MAR-EE [mecanico_clave] => 7
 * [mano_obra] => 4567 [tipo_servicio] => B
 * [check] => Array ( [0] => 5 [1] => 6 [2] => 7 )
 * [productos] => Array ( [2] => 43 ) [subtotal] => 65950 [total] => 70517 )
 *
 *
 * clave, fecha_llegada, fecha_entregada, kilometraje,
 * observaciones, contenido_adicional, gato, aire_acondicionado,
 * tapones, tapetes, limpiadores, espejo_izquierdo, espejo_derecho,
 * refaccion, estereo, tapon_gasolina, auto_placa, cotizacion_clave, orden_numero_orden
 */
$_POST=$_SESSION['post'];
$cliente = persona::getPersonas($_POST['cliente_clave'])[persona::NOMBRE_TABLA][0];
$auto = auto::getAuto($_POST['auto_placa'])[auto::NOMBRE_TABLA][0];


?>

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
                    <span class="glyphicon glyphicon-check"></span> Recepción del  auto
                </h1>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <!-- FORMULARIO -->
                <form class="form-horizontal" action="../../mpdf60/examples/mpdfRecepccion.php" method="POST"
                      onsubmit="return validarAddCliente();" autocomplete="off">

                    <!-- Datos cliente si se selecciono -->
                    <div class="form-group">
                        <div class="col-lg-12">
                            <h4 class="page-header">
                                <table class="table table-condensed">
                                    <thead>
                                        <tr>
                                            <th>
                                                <span class="glyphicon glyphicon-user"></span> <b>Cliente</b>
                                            </th>
                                            <th>
                                                <span class="glyphicon glyphicon-bed"></span> <b>Auto</b>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <?=$cliente['nombre'].
                                                ' '.$cliente['apellido_paterno'].
                                                ' '.$cliente['apellido_materno']?>
                                            </td>
                                            <td>
                                                <b>Placa: </b>
                                                <?=$auto[auto::PLACA].
                                                ' <b> Marca: </b> '.$auto[auto::MARCA].
                                                ' <b/> Modelo: </b> '.$auto[auto::MODELO].
                                                ' <b/> Color : </b> '.$auto[auto::COLOR]?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <br>
                                <th>Kilometraje </th>
                                <th style="width: 56px;"><input required name="kilometraje" min="0" type="number"></th>
                                <div class="pull-right form-inline">

                                    <button class="btn btn-info" data-toggle='modal' data-target='#add_evento'><span
                                            class="glyphicon glyphicon-print"> Generar </button>
                                </div>
                            </h4>

                        </div>
                    </div>
<!--
                    clave, fecha_llegada, fecha_entregada, kilometraje,
                    * observaciones, contenido_adicional, gato, aire_acondicionado,
                    * tapones, tapetes, limpiadores, espejo_izquierdo, espejo_derecho,
                    * refaccion, estereo, tapon_gasolina, auto_placa, cotizacion_clave, orden_numero_orden-->

                    <div align="center" class="table-responsive">
                        <table style="width: 80%" class="order-table table table-striped" id="tabla">
                            <tbody>
                            <tr class="success">
                                <th>Fecha de llegda</th>
                                <th style="width: 56px;"><input required name="fecha_llegada" type="date"></th>
                                <th>Fecha de Entrega</th>
                                <th style="width: 56px;"><input required name="fecha_entregada" type="date"></th>
                            </tr>

                            <tr class="active">
                                <th>Espejo Izquierdo</th>
                                <th style="width: 56px;"><input name="espejo_izquierdo" min="0"  type="checkbox"></th>
                                <th>Gato</th>
                                <th style="width: 56px;"><input name="gato" min="0" type="checkbox"></th>
                            </tr>

                            <tr class="success">
                                <th>Aire Acondicionado</th>
                                <th style="width: 56px;"><input name="aire_acondicionado" min="0" type="checkbox"></th>
                                <th>Tapones</th>
                                <th style="width: 56px;"><input name="tapones" min="0" type="checkbox"></th>
                            </tr>

                            <tr class="active">
                                <th>Tapetes</th>
                                <th style="width: 56px;"><input name="tapetes" min="0" type="checkbox"></th>
                                <th>Limpiadores</th>
                                <th style="width: 56px;"><input name="limpiadores" min="0" type="checkbox"></th>

                            </tr>

                            <tr class="succes">
                                <th>Estereo</th>
                                <th style="width: 56px;"><input name="estereo" type="checkbox"></th>
                                <th>Espejo Derecho</th>
                                <th style="width: 56px;"><input type="checkbox" name="espejo_derecho"></th>

                            </tr>
                            <tr class="active">
                                <th>Refaccion</th>
                                <th style="width: 56px;"><input name="refaccion" type="checkbox"></th>
                                <th>Tapon Gasolina</th>
                                <th style="width: 56px;"><input name="tapon_gasolina" type="checkbox"></th>
                            </tr>
                            <tr class="active">

                            </tr>
                            <tr class="success">

                                <th>Obervaciones</th>
                                <th style="width: 56px;"><textarea required name="observaciones" min="0"></textarea></th>
                            </tr>


                            </tbody>
                        </table>



                    </div>
                    <div align="center">
                        <label>Contendo Adicional</label><br>
                        <textarea required style="width: 50%;height: 100px" name="contenido_adicional" min="0"></textarea>
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
                <a href="../cotizacion/main.php">
                    <button type="button" class="btn btn-success">Si</button>
                </a>
                <button type="button" data-dismiss="modal" class="btn btn-danger">No</button>
            </div>
        </div>
    </div>
</div>

</body>


</html>

