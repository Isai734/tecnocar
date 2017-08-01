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
//print_r($_SESSION['post']);

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

$_POST=array_merge($_SESSION['post'],$_POST);
$cliente = persona::getPersonas($_POST['cliente_clave'])[persona::NOMBRE_TABLA][0];
$auto = auto::getAuto($_POST['auto_placa'])[auto::NOMBRE_TABLA][0];

$html ='<div id="page-wrapper">
    <div class="container">
        <!-- Page Heading -->
        <div>
            <div>
                <h2 align="center">
                   Recección del  auto
                </h2>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <!-- FORMULARIO -->
                <form class="form-horizontal" method="POST"
                      onsubmit="return validarAddCliente()" autocomplete="off">

                    <!-- Datos cliente si se selecciono -->
                    <div class="form-group">
                        <div class="col-lg-12">
                            <h4 class="page-header">
                                <span class="glyphicon glyphicon-list-alt"></span> Cliente :'.$cliente['nombre'].
                                ' '.$cliente['apellido_paterno'].
                                ' '.$cliente['apellido_materno'].'
                                <br>
                                <br>
                                <span class="glyphicon glyphicon-bed"></span> Auto : <b>Placa</b>
                                '.$auto[auto::PLACA].
                                ' <b>Marca:</b> '.$auto[auto::MARCA].
                                ' <b/>Modelo:</b> '.$auto[auto::MODELO].
                                ' <b/>Color :</b> '.$auto[auto::COLOR].'
                                <br>
                                <br>
                                <th>Kilometraje</th>
                                <th style="width: 56px;">'.$_POST['kilometraje'].'</th>
                                
                            </h4>

                        </div>
                    </div>

                    <div align="center" class="table-responsive">
                        <table style="table-layout: fixed;" style="font-size: 15px" class="order-table table table-striped" id="tabla">
                            <tbody class="headerrow">
                            <tr class="">
                                <th height="30">Fecha de llegda</th>
                                <th>'.$_POST['fecha_llegada'].'</th>
                                <th>Fecha de Entrega</th>
                                <th>'.$_POST['fecha_entregada'].'</th>
                                
                            </tr>

                            <tr class="">
                                <th  height="30">Espejo Izquierdo</th>
                                <th>';if(isset($_POST['espejo_izquierdo']))$html.='SI';
                                else
                                    $html.='NO';
                                $html.='</th>
                                <th>Gato</th>
                                <th>';if(isset($_POST['gato']))$html.='SI';
else
    $html.='NO';$html.='</th>
                            </tr>

                            <tr class="">
                                <th height="30">Aire Acondicionado</th>
                                <th>';if(isset($_POST['aire_acondicionado']))$html.='SI';
else
    $html.='NO'; $html.='</th>
                                <th>Tapones</th>
                                <th>';if(isset($_POST['tapones']))$html.='SI';
else
    $html.='NO';$html.='</th>
                            </tr>

                            <tr class="">
                                <th height="30">Tapetes</th>
                                <th>';if(isset($_POST['tapetes']))$html.='SI';
else
    $html.='NO'; $html.='</th>
                                <th>Limpiadores</th>
                                
                                <th>';if(isset($_POST['limpiadores']))$html.='SI';
else
    $html.='NO'; $html.='</th>

                            </tr>

                            <tr class="">
                                <th height="30">Estereo</th>
                                <th>';if(isset($_POST['estereo']))$html.='SI';
else
    $html.='NO'; $html.='</th>
                                <th>Espejo Derecho</th>
                                <th>';if(isset($_POST['espejo_derecho']))$html.='SI';
else
    $html.='NO'; $html.='</th>

                            </tr>
                            <tr class="">
                                <th>Refaccion</th>
                                <th>';if(isset($_POST['refaccion']))$html.='SI';
else
    $html.='NO'; $html.='</th>
                                <th>Tapon Gasolina</th>
                                <th>';if(isset($_POST['tapon_gasolina']))$html.='SI';
else
    $html.='NO'; $html.='</th>
                            </tr>
                            <tr class="">
                            </tr>
                            <tr class="">
                                <th></th>
                                <th></th>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div align="center">
                        <label><b>Obervaciones</b></label>
                        <p>'.$_POST['observaciones'].'</p>
                    </div>
                    <br>
                    <div align="center">
                        <label><b>Contendo Adicional</b></label><br>
                        <p>'.$_POST['contenido_adicional'].'</p>
                    </div>
                </form>
                <br><br>
                <p>Yo <b>'.$cliente['nombre'].
    ' '.$cliente['apellido_paterno'].
    ' '.$cliente['apellido_materno'].'</b> acepto que he leido y quedo en total acuerdo con lo descrito en este documento el cual representa 
    fielmente el estado de mi auto en el taller y que en lo posterior me regire en el presente para pedir cualquier aclaracion.</p>
                <br>
                <br>
                <br>
                <br>
                <br>
                <hr style="width: 300px">
                <div align="center"><b>'.$cliente['nombre'].
    ' '.$cliente['apellido_paterno'].
    ' '.$cliente['apellido_materno'].'</b></div>
            </div>
        </div>
    </div>
</div>';
include("../mpdf.php");
$mpdf = new mPDF('c', 'A4', '', '', 32, 25, 27, 25, 16, 13);

$mpdf->SetDisplayMode('fullpage');

$mpdf->list_indent_first_level = 0;    // 1 or 0 - whether to indent the first level of a list

// LOAD a stylesheet
$stylesheet = file_get_contents('mpdfstyletables.css');
$mpdf->WriteHTML($stylesheet, 1);    // The parameter 1 tells that this is css/style only and no body/html/text
// LOAD a stylesheet
$stylesheet = file_get_contents('../../vista/style/css/bootstrap.css');
$mpdf->WriteHTML($stylesheet, 1);    // The parameter 1 tells that this is css/style only and no body/html/text
$stylesheet = file_get_contents('../../vista/style/js/bootstrap.js');
$mpdf->WriteHTML($stylesheet, 1);    // The parameter 1 tells that this is css/style only and no body/html/text

$mpdf->WriteHTML($html, 2);

$mpdf->Output('Recepccion.pdf', 'D');
exit;

?>

