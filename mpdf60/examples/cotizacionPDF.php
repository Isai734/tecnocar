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


$titulo = '
	<table>
		<tr>
		<td>
			<div id="logo">
        	<img src="tecnologo.png">
      		</div>
		</td>
			<td>
			<div id="company">
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
		</td>
		</tr>
	</table>
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
        <div id="auto">
          <div class="to">Cliente:</div>
          <h2 class="name">' . $cliente[persona::NOMBRE] . ' ' . $cliente[persona::A_PATERNO] . ' ' . $cliente[persona::A_MATERNO] . '</h2>
          <div class="address">' . $cliente[persona::DIRECCION] . '</div>
          <div class="email"><a href="mailto:' . $cliente[persona::EMAIL] . '">' . $cliente[persona::EMAIL] . '</a></div>
        </div>
      </div>
     <table>
        <thead>
          <tr>
            <th class="service">Clave</th>
            <th class="desc">Descripción</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>';
        foreach ($servicios as $servicio) {
        	# code...
        	foreach ($check as $clave) {
	        	if ($clave == $servicio[servicio::CLAVE]) {
	            $stservicios += $servicio[servicio::COSTO];
	            $titulo .='<tr>
	            <td class="service">' . $servicio[servicio::CLAVE] . '</td>
	            <td class="desc">' . $servicio[servicio::NOMBRE] . '</td>
	            <td class="unit">$ ' . $servicio[servicio::COSTO] . '</td>
	            <td class="qty">' . $servicio[servicio::TIPO] . '</td>
	            <td class="total">$1,040.00</td>
	          </tr>';
        		}
        	}
    	}

    	foreach ($productos as $producto) {
    		foreach ($mproductos as $clave => $valor) {
        		if ($clave == $producto[producto::CLAVE]) {
           			 $stproductos += ($producto[producto::PRECIO_VENTA] * $valor);
            		$titulo .= '<tr>
		            <td class="service">' . $producto[producto::CLAVE] . '</td>
		            <td class="desc">' . $producto[producto::DESCRIPCCION] . '</td>
		            <td class="unit">$ ' . $producto[producto::PRECIO_VENTA] . '</td>
		            <td class="qty">' . $valor . '</td>
		            <td class="total">$ '.($valor * $producto[producto::PRECIO_VENTA]).'</td>
		          </tr>';
		      	}
		  	}
		}

		$titulo .='<tr>
            <td class="desc" colspan = "2">Mano de obra</td>
            <td class="unit">$ '.$_POST['mano_obra'].'</td>
            <td class="qty">1</td>
            <td class="total">$ '.$_POST['mano_obra'].'</td>
          </tr>
          <tr>';

		$subtotal = ($_POST['mano_obra'] + $stservicios + $stproductos);
		$iva = ($_POST['mano_obra'] + $stservicios + $stproductos)*0.16;

    	$titulo .= '
          <tr class="subtotal">
            <td colspan="4">SUBTOTAL</td>
            <td class="total">$ ' .$subtotal. '</td>
          </tr>
          <tr>
            <td colspan="4">IVA %16</td>
            <td class="total">$ '.$iva.'</td>
          </tr>
          <tr>
            <td colspan="4" class="grand total">TOTAL</td>
            <td class="grand total">$ '.($iva + $subtotal).'</td>
          </tr>
        </tbody>
      </table>
    </main>';






$html = $titulo;
$mpdf = new mPDF('c', 'A4');//('c', 'A4', '', '', 32, 25, 27, 25, 16, 13);

//$mpdf->SetDisplayMode('fullpage');

//$mpdf->list_indent_first_level = 0;

$stylesheet = file_get_contents('style.css');
$mpdf->WriteHTML($stylesheet, 1); 

$mpdf->WriteHTML($html, 2);

$mpdf->Output('Cotizacion.pdf', 'I');
exit();
?>