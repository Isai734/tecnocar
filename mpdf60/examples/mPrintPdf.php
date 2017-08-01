<?php
include '../../modelo/ConexionBD.php';
include '../../control/producto.php';
include '../../control/empresa.php';
include '../../control/persona.php';
include '../../control/servicio.php';
include '../../control/auto.php';
include '../../utilidades/Constantes.php';
include '../../utilidades/ExcepcionApi.php';
date_default_timezone_set('America/Mexico_City');
$fecha = date("d/m/Y");
session_start();
$_POST = $_SESSION['post'];
$cliente = persona::getPersonas($_POST['cliente_clave'])[persona::NOMBRE_TABLA][0];
$mecanico = persona::getPersonas($_POST['mecanico_clave'])[persona::NOMBRE_TABLA][0];
$servicios = servicio::getServicios(null)[servicio::NOMBRE_TABLA];
$productos = producto::getProducto(null)[producto::NOMBRE_TABLA];
$auto = auto::getAuto($_POST['auto_placa'])[auto::NOMBRE_TABLA];

$check = $_POST['check'];
$mproductos = $_POST['productos'];
$stproductos = 0;
$stservicios = 0;
include("../mpdf.php");
$titulo = '<body>
    <header class="clearfix">
      <div id="logo">
        <img src="tecnologo.png">
      </div>
      <div id="company">
        <br>
        <br>
        <br>
        <h2 class="name">Servicio mecánico automotriz y Diesel Tecnocar</h2>
        <div>
          Boulevard Vicente Guerrero Km. 0.830
          <br>
          Col. San Juan C.P. 39030
        </div>
        <div>Tel. 74 71 02 86 94</div>
        <div><a href="mailto:nachobaxter7@live.com">nachobaxter7@live.com</a></div>
      </div>
      </div>
    </header>
    <main>
      <h1>
        Cotización
      </h1>
      <div class="date">Fecha: '.$fecha.'</div>
      <br>
      <div id="details" class="clearfix">
        <div id="client">
          <div class="to">Cliente:</div>
          <h2 class="name">' . $cliente[persona::NOMBRE] . ' ' . $cliente[persona::A_PATERNO] . ' ' . $cliente[persona::A_MATERNO] . '</h2>
          <div class="address">' . $cliente[persona::DIRECCION] . '</div>
          <div class="email"><a href="mailto:' . $cliente[persona::EMAIL] . '">' . $cliente[persona::EMAIL] . '</a></div>
        </div>

        <div id="invoice">
          <div id="mecanico">
          <div class="to">Auto:</div>
          <h2 class="name">' . $mecanico[persona::NOMBRE] . ' ' .
                                $mecanico[persona::A_PATERNO] . ' ' . $mecanico[persona::A_MATERNO] . '
            </h2>
        </div>
        </div>
      </div>';

/*$titulo = '
        <h1 align="center">COTIZACIÓN</h1>
    <br>
    <h4>Cliente:  ' . $cliente[persona::NOMBRE] . ' ' . $cliente[persona::A_PATERNO] . ' ' . $cliente[persona::A_MATERNO] . '</h4><br>
     <h5>Mecanico Asignado:  ' . $mecanico[persona::NOMBRE] . ' ' .
    $mecanico[persona::A_PATERNO] . ' ' . $mecanico[persona::A_MATERNO] . '</h5><br>

 <p></p>';
 */
/**********Aqui se llena la tabla de servicios*****/

$thead ='<table>
        <thead>
          <tr>
            <th class="service">Clave</th>
            <th class="desc">Descripción</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Total</th>
          </tr>
        </thead>';
/*$thead = '
    <thead>
    <tr class="headerrow">
        <th>Clave</th>
        <th>Nombre</th>
        <th>Costo</th>
        <th>Tipo</th>
    </tr>
    </thead>
';
*/

$tbody = '<tbody>';

foreach ($servicios as $servicio) {
    # code...
    foreach ($check as $clave) {
        if ($clave == $servicio[servicio::CLAVE]) {
            $stservicios += $servicio[servicio::COSTO];
            $tbody .='
            <tr>
                <td class="service">' . $servicio[servicio::CLAVE] . '</td>
                <td class="desc">' . $servicio[servicio::NOMBRE] . '</td>
                <td class="unit">$ ' . $servicio[servicio::COSTO] . '</td>
                <td class="qty">' . $servicio[servicio::TIPO] . '</td>
                <td class="total">$1,040.00</td>
          </tr>';
        }
    }
}

/*$tbody = '<tbody class="oddrow">';

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
$tbody .= '<tr></tr>';
//agregamos subtotal
$tbody .= '<tr>
                            <td></td>
                            <td></td>
                            <td><b>Subtotal</b></td>
                            <td><b>' . $stservicios . '</b></td>' .
    '</tr>';
$tbody .= '</tbody>';
$tservicios = '<table cellpadding="12px" style="font-size: 15px" class="order-table table table-striped">' . $thead . ' ' . $tbody . '</table>';
*/

/*******Productos***************/

$thead = '<table>
        <thead>
          <tr>
            <th class="service">Clave</th>
            <th class="desc">Descripción</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>TOTAL</th>
          </tr>
        </thead>';
/*$thead = '
    <thead>
    <tr class="headerrow">
        <th>Clave</th>
        <th>Descripccion</th>
        <th>Precio</th>
        <th>Cantidad</th>
    </tr>
    </thead>
';
*/

$tbody = '<tbody>
          <tr>
            <td class="service">Design</td>
            <td class="desc">Creating a recognizable design solution based on the companys existing visual identity</td>
            <td class="unit">$40.00</td>
            <td class="qty">26</td>
            <td class="total">$1,040.00</td>
          </tr>
          <tr>
            <td class="service">Development</td>
            <td class="desc">Developing a Content Management System-based Website</td>
            <td class="unit">$40.00</td>
            <td class="qty">80</td>
            <td class="total">$3,200.00</td>
          </tr>
          <tr>
            <td class="service">SEO</td>
            <td class="desc">Optimize the site for search engines (SEO)</td>
            <td class="unit">$40.00</td>
            <td class="qty">20</td>
            <td class="total">$800.00</td>
          </tr>
          <tr>
            <td class="service">Training</td>
            <td class="desc">Initial training sessions for staff responsible for uploading web content</td>
            <td class="unit">$40.00</td>
            <td class="qty">4</td>
            <td class="total">$160.00</td>
          </tr>
          <tr>
            <td colspan="4">SUBTOTAL</td>
            <td class="total">$5,200.00</td>
          </tr>
          <tr>
            <td colspan="4">TAX 25%</td>
            <td class="total">$1,300.00</td>
          </tr>
          <tr>
            <td colspan="4" class="grand total">GRAND TOTAL</td>
            <td class="grand total">$6,500.00</td>
          </tr>
        </tbody>
      </table>';
/*
$tbody = '<tbody class="oddrow">';

foreach ($productos as $producto) {
    foreach ($mproductos as $clave => $valor) {
        if ($clave == $producto[producto::CLAVE]) {
            $stproductos += ($producto[producto::PRECIO_VENTA] * $valor);
            $tbody .= '<tr>
                            <td>' . $producto[producto::CLAVE] . '</td>
                            <td>' . $producto[producto::DESCRIPCCION] . '</td>
                            <td>' . $producto[producto::PRECIO_VENTA] . '</td>
                            <td>' . $valor . '</td>' .
                '</tr>';
        }
    }
}
*/
$tbody .= '<tr></tr>';
$tbody .= '<tr></tr>';
//agregamos subtotal
$tbody .= '<tr>
                            <td></td>
                            <td></td>
                            <td><b>Subtotal</b></td>
                            <td><b>' . $stproductos . '</b></td>' .
    '</tr>';

$tbody .= '</tbody>';
$tmanoobra = '<table align="right" cellpadding="12px" style="font-size: 15px" class=""><thead class="headerrow">
<tr>t<td><h4>Mano Obra:     </h4></td><td> <h4>$ ' . $_POST['mano_obra'] . '.00</h4></td></tr>/thead></table>';

$total = '<table align="right" cellpadding="12px" style="font-size: 15px" class=""><thead class="headerrow">
<tr>t<td><h3>Total:     </h3></td><td> <h3>$ ' . ($_POST['mano_obra'] + $stservicios + $stproductos) . '.00</h3></td></tr>/thead></table>';

$tproductos = '<table cellpadding="12px" style="font-size: 15px" class="order-table table table-striped">' . $thead . ' ' . $tbody . '</table>';
$html = $titulo . ' ' . $tservicios . '<p></p> ' . $tproductos . '<br>' . $tmanoobra . '<br>' . $total;

$mpdf = new mPDF('c', 'A4', '', '', 32, 25, 27, 25, 16, 13);

$mpdf->SetDisplayMode('fullpage');

$mpdf->list_indent_first_level = 0;    // 1 or 0 - whether to indent the first level of a list

/*
// LOAD a stylesheet
$stylesheet = file_get_contents('mpdfstyletables.css');
$mpdf->WriteHTML($stylesheet, 1);    // The parameter 1 tells that this is css/style only and no body/html/text
// LOAD a stylesheet
$stylesheet = file_get_contents('../../vista/style/css/bootstrap.css');
$mpdf->WriteHTML($stylesheet, 1);    // The parameter 1 tells that this is css/style only and no body/html/text
$stylesheet = file_get_contents('../../vista/style/js/bootstrap.js');
$mpdf->WriteHTML($stylesheet, 1);    // The parameter 1 tells that this is css/style only and no body/html/text
*/
$stylesheet = file_get_contents('style.css');
$mpdf->WriteHTML($stylesheet, 1);    // The parameter 1 tells that this is css/style only and no body/html/text

$mpdf->WriteHTML($html, 2);

$mpdf->Output('Cotizacion.pdf', 'D');
exit;
?>