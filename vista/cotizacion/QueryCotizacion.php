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
print_r($_POST);
/**
 * Array ( [cliente_clave] => 1 [auto_placa] => FFF
 * [mecanico_clave] => 4 [mano_obra] => 45 [tipo_servicio] => B
 * [check] => Array ( [0] => 5 [1] => 6 ) [productos] => Array ( [3] => 67 ) )
 */
$cliente = persona::getPersonas($_POST['cliente_clave'])[persona::NOMBRE_TABLA][0];
$mecanico = persona::getPersonas($_POST['mecanico_clave'])[persona::NOMBRE_TABLA][0];
$servicios = servicio::getServicios(null)[servicio::NOMBRE_TABLA];
$productos = producto::getProducto(null)[producto::NOMBRE_TABLA];
$auto = auto::getAuto($_POST['auto_placa'])[auto::NOMBRE_TABLA];

$check = $_POST['check'];
$mproductos = $_POST['productos'];
$stproductos = 0;
$stservicios = 0;
$titulo = '
        <h1 align="center">COTIZACIÓN</h1>
    
    <h3>' . $cliente[persona::NOMBRE] . ' ' . $cliente[persona::A_PATERNO] . ' ' . $cliente[persona::A_MATERNO] . '</h3>
     <h3>' . $mecanico[persona::NOMBRE] . ' ' . $mecanico[persona::A_PATERNO] . ' ' . $mecanico[persona::A_MATERNO] . '</h3>

 <p></p>';
/**********Aqui se llena la tabla de servicios*****/
$thead = '
    <thead>
    <tr class="info">
        <th>Clave</th>
        <th>Nombre</th>
        <th>Costo</th>
        <th>Tipo</th>
    </tr>
    </thead>
';
$tbody = '<tbody>';

foreach ($servicios as $servicio) {
    foreach ($check as $clave) {
        if ($clave == $servicio[servicio::CLAVE]) {
            $stservicios += $servicio[servicio::COSTO];
            $tbody .= '<tr>
                            <td>' . $servicio[servicio::CLAVE] . '</td>
                            <td>' . $servicio[servicio::NOMBRE] . '</td>
                            <td>' . $servicio[servicio::COSTO] . '</td>
                            <td>' . $servicio[servicio::TIPO] . '</td>' .
                '</tr>';
        }
    }
}
$tbody .= '<tr></tr>';
//agregamos subtotal
$tbody .= '<tr>
                            <td></td>
                            <td></td>
                            <td>Subtotal</td>
                            <td>' . $stservicios . '</td>' .
    '</tr>';
$tbody .= '</tbody>';
$tservicios = '<table class="order-table table table-striped">' . $thead . ' ' . $tbody . '</table>';


/*******Productos***************/
$thead = '
    <thead>
    <tr class="info">
        <th>Clave</th>
        <th>Nombre</th>
        <th>Descripccion</th>
        <th>Precio</th>
        <th>Cantidad</th>
    </tr>
    </thead>
';
$tbody = '<tbody>';

foreach ($productos as $producto) {
    foreach ($mproductos as $clave => $valor) {
        if ($clave == $producto[producto::CLAVE]) {
            $stproductos += ($producto[producto::PRECIO_VENTA] * $valor);
            $tbody .= '<tr>
                            <td>' . $producto[producto::CLAVE] . '</td>
                            <td>' . $producto[producto::NOMBRE] . '</td>
                            <td>' . $producto[producto::DESCRIPCCION] . '</td>
                            <td>' . $producto[producto::PRECIO_VENTA] . '</td>
                            <td>' . $valor . '</td>' .
                '</tr>';
        }
    }
}
$tbody .= '<tr><td></td></tr>';
//agregamos subtotal
$tbody .= '<tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><h4>Subtotal</h4></td>
                            <td><h4>' . $stproductos . '</h4></td>' .
    '</tr>';

$tbody .= '</tbody>';
$tproductos = '<table class="order-table table table-striped">' . $thead . ' ' . $tbody . '</table>';
$html = $titulo . ' ' . $tservicios . '<p></p> ' . $tproductos;
/*include("../../mpdf60/mpdf.php");
$mpdf=new mPDF('c','A4','','',32,25,27,25,16,13);

$mpdf->SetDisplayMode('fullpage');

$mpdf->list_indent_first_level = 0;	// 1 or 0 - whether to indent the first level of a list

// LOAD a stylesheet
$stylesheet = file_get_contents('mpdfstyletables.css');
$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text

$mpdf->WriteHTML($html,2);

$mpdf->Output('mpdf.pdf','I');
exit;*/
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
    <div class="modal fade" id="mostrarmodal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel" aria-hidden="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="myModalLabel">Cotización</h3>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="../cotizacion/CrudAlert.php?metodo=add" method="POST"
                          onsubmit="return validarAddCliente()" autocomplete="off">
                        <div class="table-responsive">
                            <?php
                            $echo1 = '<h4>Meacnico Asigando:  ' .
                                $mecanico[persona::NOMBRE] .
                                ' ' . $mecanico[persona::A_PATERNO] .
                                ' ' . $mecanico[persona::A_MATERNO] . '</h4>';

                            $echo2 = '<h4 class="info"><td>Mano de Obra:  ' . $_POST['mano_obra'] . '</td></h4><br>';

                            $echo3 = $tservicios . '<br><br>' . $tproductos;
                            $echo4 = '<h3 align="right" class="info">Total:  ' . ($_POST['mano_obra'] + $stproductos + $stservicios) . '</h3>';
                            $mpdf = $echo1 . '' . $echo2 . '' . $echo3 . '' . $echo4;
                            echo $mpdf;
                            $_POST['subtotal'] = $stproductos + $stservicios;
                            $_POST['total'] = ($_POST['mano_obra'] + $stproductos + $stservicios);
                            $_SESSION['post'] = $_POST;
                            ?>
                        </div>


                        <div class="modal-footer">
                            <a href="Cotizacion.php">
                                <button type="button" class="btn btn-danger"><i
                                            class="fa fa-times"></i>
                                    Cancelar
                                </button>
                            </a>
                            <a href="../../mpdf60/examples/cotizacionPDF.php" target="_BLANK">
                                <button type="button" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-download"></span> Descargar
                                </button>
                            </a>
                            <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Dialogo -->
</div>
</body>
<script></script>
<script>
    $(document).ready(function () {
        $("#mostrarmodal").modal("show");
    });
</script>