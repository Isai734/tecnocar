<?php

include '../modelo/ConexionBD.php';
include '../control/persona.php';
include '../control/login.php';
include '../utilidades/Constantes.php';
include '../utilidades/ExcepcionApi.php';
session_start();
if (isset($_SESSION[login::NOMBRE_TABLA])) {
    $login = login::getLogin($_SESSION[login::NOMBRE_TABLA]['usuario']);
    //$user=$_SESSION[login::NOMBRE_TABLA];
    //echo "<script>alert('alerta para : ".$login['tipo']."')</script>";
    if($login['tipo']=="ADMIN"){
        header("Location: ../index.php");
    }else{
        include "main_in.php";
    }
} else {
    include "main.php";
}

?>
<!DOCTYPE HTML>
<!--
	Linear by TEMPLATED
    templated.co @templatedco
    Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<html>
<head>
    <title>Inicio Tecnocar</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta name="description" content=""/>
    <meta name="keywords" content=""/>
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,700,500,900' rel='stylesheet' type='text/css'>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="js/skel.min.js"></script>
    <script src="js/skel-panels.min.js"></script>
    <script src="js/init.js"></script>
    <noscript>
        <link rel="stylesheet" href="css/skel-noscript.css"/>
        <link rel="stylesheet" href="css/style.css"/>
        <link rel="stylesheet" href="css/style-desktop.css"/>
    </noscript>

    <script src="../vista/style/js/jquery-3.2.0.min.js"></script>
    <script src="../vista/style/js/bootstrap.js"></script>
</head>
<body class="homepage">

<!-- Header -->
<div id="header">
    <div class="container">

        <!-- Logo -->
        <div id="logo">
            <h1><a href="#">Bienvenido a TECNOCAR</a></h1>
            <span class="tag">Tu taller mecanico</span>
        </div>
    </div>
</div>

<!-- Featured -->
<div id="featured">
    <div class="container">
        <p>En <strong style="color: #00796B">Tecnocar</strong>, nuestra preocupación principal es el cliente, sus problemas son nuestros
            problemas.
            A continuación te compartimos una breve explicación de nuestras creencias, lo que hacemos, como lo hacemos,
            y nuestro compromiso con el cliente.</p>
        <hr/>
        <div class="row">
            <section class="6u">
                <span class="pennant"><span class="glyphicon glyphicon-road"></span></span>
                <h3>Misión</h3>
                <p>Proporcionar un buen servicio de mantenimiento automotriz en general, eficiente, con calidad, que satisfaga las necesidades y expectativas de nuestros clientes con personal capacitado, motivado, productivo, eficiente, leal, honesto, responsable y comprometido en resolver sus problemas laborales.
                </p>
            </section>
            <section class="6u">
                <span class="pennant"><span class="glyphicon glyphicon-eye-open"></span></span>
                <h3>Visión</h3>
                <p>Llegar a ser el taller líder y confiable a nivel zona en un plazo de 5 años, una vez cumplido ese objetivo mantenernos como los mejores en el mercado laboral ofreciendo el servicio para automóviles modernos y unidades Diesel utilizando tecnología de punta, con los mejores scanner, computadora, equipos, herramientas y sistema administrativo computarizado, así como el mejor personal eficaz y confiable.
                </p>
            </section>


        </div>
    </div>
</div>

<!-- Main -->
<div id="main">
    <div id="content" class="container">

        <div class="row">
            <section class="6u">
                <a href="#" class="image big"><img src="images/img_mch_4.jpg" alt=""></a>
                <header>
                    <h2>Mantenimiento preventivo</h2>
                </header>
                <p>El mantenimiento preventivo automotriz consta de una serie de revisiones que se efectúan en un tiempo determinado para disminuir las probabilidades de fallas o desgastes que amerite una reparación costosa del vehículo.
                    Si necesitas visitar un taller especializado en mecánica mejor  y mantenimiento preventivo automotriz no dudes en hacer tu cita con nosotros.
                </p>
            </section>
            <section class="6u">
                <a href="#" class="image big"><img src="images/img_mch_5.jpg" alt=""></a>
                <header>
                    <h2>Afinación</h2>
                </header>
                <p>La afinación de motor consiste en mantener en optimas condiciones el funcionamiento del motor, para una respuesta inmediata, una manejabilidad óptima y sobretodo para economía de combustible. En la afinación se revisan y/o se cambian filtros que son vitales para tener la mejor calidad de oxigeno, combustible y aceite, para que así, estén libres de impurezas. Los filtros tapados pueden presentar fallas como obstrucciones en el aire de admisión, alto indice de contaminación y consumo de combustible.
                </p>
            </section>
        </div>

        <div class="row">
            <section class="6u">
                <a href="#" class="image big"><img src="images/img_mch_7.jpg" alt=""></a>
                <header>
                    <h2>Alineación y balanceo</h2>
                </header>
                <p>Básicamente una alineación consiste en ajustar los ángulos de las ruedas y la dirección, con el propósito de balancear todas las fuerzas de fricción, gravedad, fuerza centrífuga e impulso. Todos los componentes de la suspensión y del sistema de dirección deben ser ajustados de acuerdo a especificaciones prescritas. Una correcta alineación logrará que el vehículo se desplace suavemente, mantenga el agarre apropiado, buena estabilidad en línea recta o en curva y las llantas tengan la máxima duración.
                </p>
            </section>
            <section class="6u">
                <a href="#" class="image big"><img src="images/img_mch_6.jpg" alt=""></a>
                <header>
                    <h2>Lavado y engrasado</h2>
                </header>
                <p>
                    Si realizas el lavado y engrasado con regularidad notarás mayor facilidad de manejo. También evitarás daños al sistema de suspensión y corrosión en el motor que afecte partes sensibles. Recuerda que este procedimiento debe ser realizado por expertos. No sólo para evitar daños a los componentes eléctricos, sino para aplicar las grasas sintéticas adecuadas para cada automóvil.
                </p>
            </section>
        </div>

    </div>
</div>

<!-- Tweet -->
<div id="tweet">
    <div class="container">
        <section>
            <blockquote>&ldquo;Tu mejor opcción en el camino.&rdquo;</blockquote>
        </section>
    </div>
</div>

</body>
</html>
