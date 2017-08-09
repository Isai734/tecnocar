<?php
include '../../modelo/ConexionBD.php';
include '../../control/producto.php';
include '../../control/empresa.php';
include '../../control/persona.php';
include '../../control/servicio.php';
include '../../control/orden.php';
include '../../control/auto.php';
include '../../utilidades/Constantes.php';
include '../../utilidades/ExcepcionApi.php';
session_start();
print_r($_POST);

$num_orden = $_GET['id'];

$ordennes = orden::getOrdenPlaca($num_orden)[orden::NOMBRE_TABLA];
print_r($ordennes);
?>

<!DOCTYPE html>
<html>
//
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
                <div class="modal-header" align="center">
                    <h3 class="modal-title" id="myModalLabel">Historial</h3>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="../ordns_servicios/recepccionAuto.php" method="POST"
                          onsubmit="return validarAddCliente()" autocomplete="off">
                        <div class="table-responsive">
                            <?php
                            foreach ($ordennes as $orden) {

                                $cliente = persona::getPersonas($_GET['clave'])[persona::NOMBRE_TABLA][0];
                                $mecanico = persona::getPersonas($orden['mecanico_clave'])[persona::NOMBRE_TABLA][0];

                                $servicios = servicio::getServiciosOrden($orden[orden::NUMERO])[servicio::NOMBRE_TABLA];

                                $productos = producto::getProductosOrden($orden[orden::NUMERO])[producto::NOMBRE_TABLA];

                                $stproductos = 0;
                                $stservicios = 0;

                                $titulo = '
        <h1 align="center">Orden Numero</h1>
        <h3>' . $cliente[persona::NOMBRE] . ' ' . $cliente[persona::A_PATERNO] . ' ' . $cliente[persona::A_MATERNO] . '</h3>
        <h3>' . $mecanico[persona::NOMBRE] . ' ' . $mecanico[persona::A_PATERNO] . ' ' . $mecanico[persona::A_MATERNO] . '</h3>
 <p></p>';
                                /***********Aqui se llena la tabla de servicios************/
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

                                    $stservicios += $servicio[servicio::COSTO];
                                    $tbody .= '<tr>
                <td>' . $servicio[servicio::CLAVE] . '</td>
                <td>' . $servicio[servicio::NOMBRE] . '</td>
                <td>' . $servicio[servicio::COSTO] . '</td>
                <td>' . $servicio[servicio::TIPO] . '</td>' .
                                        '</tr>';
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

                                    $stproductos += ($producto[producto::PRECIO_VENTA] * $producto[producto::CANTIDAD]);
                                    $tbody .= '<tr>
                            <td>' . $producto[producto::CLAVE] . '</td>
                            <td>' . $producto[producto::NOMBRE] . '</td>
                            <td>' . $producto[producto::DESCRIPCCION] . '</td>
                            <td>' . $producto[producto::PRECIO_VENTA] . '</td>
                            <td>' . $producto[producto::CANTIDAD] . '</td>' .
                                        '</tr>';

                                }
                                $tbody .= '<tr><td></td></tr>';
                                //agregamos subtotal
                                $tbody .= '<tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><h5>Subtotal</h5></td>
                            <td><h5>' . $stproductos . '</h5></td>' .
                                    '</tr>';

                                $tbody .= '</tbody>';
                                $tproductos = '<table class="order-table table table-striped">' . $thead . ' ' . $tbody . '</table>';
                                $html = $titulo . ' ' . $tservicios . '<p></p> ' . $tproductos;
                                echo "<br>";
                                echo "<H4 align='center'>Orden Numero " . $orden[orden::NUMERO] . "</H4>";

                                $echo1 = '<h5>Meacnico Asigando:  ' .
                                    $mecanico[persona::NOMBRE] .
                                    ' ' . $mecanico[persona::A_PATERNO] .
                                    ' ' . $mecanico[persona::A_MATERNO] . '</h5>';

                                $echo2 = '<h5 class="info"><td>Mano de Obra:  ' . $orden['mano_obra'] . '</td></h5><br>';

                                $echo3 = $tservicios . '<br><br>' . $tproductos;
                                $echo4 = '<h5 align="right" class="info">Total:  ' . ($orden['mano_obra'] + $stproductos + $stservicios) . '</h5>';
                                $mpdf = $echo1 . '' . $echo2 . '' . $echo3 . '' . $echo4;
                                echo $mpdf;
                                $_POST['subtotal'] = $stproductos + $stservicios;
                                $_POST['total'] = ($orden['mano_obra'] + $stproductos + $stservicios);
                                $_SESSION['post'] = $_POST;

                            }
                            ?>
                        </div>


                        <div class="modal-footer">
                            <a href="QueryAutos.php">
                                <button type="button" class="btn btn-danger"><i
                                            class="fa fa-times"></i>
                                    Cerrar
                                </button>
                            </a>
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