<?php
include '../../modelo/ConexionBD.php';
include '../../control/persona.php';
include '../../control/login.php';
include '../../control/cita.php';
include '../../control/auto.php';
include '../../utilidades/Constantes.php';
include '../../utilidades/ExcepcionApi.php';

// Definimos nuestra zona horaria
date_default_timezone_set("America/Mexico_City");

// incluimos el archivo de funciones
include 'funciones.php';

// incluimos el archivo de configuracion
include 'config.php';
session_start();
$rows = null;
$id = null;
if (isset($_SESSION[login::NOMBRE_TABLA]) | !empty($_SESSION[login::NOMBRE_TABLA])) {
    include "main_in.php";
    $user = $_SESSION[login::NOMBRE_TABLA];
    $id = $user[login::PERSONA_CLAVE];
    $persona = persona::getPersonas($id)[persona::NOMBRE_TABLA][0];
    $nombre = $persona[persona::NOMBRE] . " " . $persona[persona::A_PATERNO] . " " . $persona[persona::A_MATERNO];
    $autos = auto::getAutoId($id)[auto::NOMBRE_TABLA];
} else {
    header("Location: ../login/login.php");
}


// Verificamos si se ha enviado el campo con name from
if (isset($_POST['from'])) {
    // Si se ha enviado verificamos que no vengan vacios

//id, title, body, url, class, start, end, inicio_normal, final_normal, auto_placa, empresa_clave, cliente_clave
    if ($_POST['from']) {
        // Recibimos el fecha de inicio y la fecha final desde el form
        $inicio = _formatear($_POST['from']);
        $_POST['start'] = $inicio;

        // y la formateamos con la funcion _formatear
        $final = _formatear($_POST['from']);
        $_POST['end'] = $final;

        // Recibimos el fecha de inicio y la fecha final desde el form
        $inicio_normal = $_POST['from'];
        $_POST['inicio_normal'] = $inicio_normal;
        $_POST['class'] = "event-important";
        // y la formateamos con la funcion _formatear
        $final_normal = $_POST['from'];
        $_POST['final_normal'] = $final_normal;

        // Recibimos los demas datos desde el form
        $titulo = evaluar($_POST['title']);
        $_POST['title'] = $titulo;

        // y con la funcion evaluar
        $body = evaluar($_POST['event']);
        $_POST['body'] = $body;

        // reemplazamos los caracteres no permitidos
        $clase = evaluar($_POST['auto_placa']);
        $_POST['auto_placa'] = $clase;
        $_POST[cita::CLIENTE_CLAVE] = $id;

        //Insertar
        $str = json_encode($_POST);
        cita::createCita(json_decode($str));
//Crear URL
        $id = cita::getMaxId();
        $_POST['id'] = $id;
        $link = "$base_url" . "descripcion_evento.php?id=" . ($id);
        $_POST['url'] = $link;
        $str = json_encode($_POST);
        cita::updateCita(json_decode($str));
        // redireccionamos a nuestro calendario
        header("Location:$base_url");
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Calendario</title>
    <link rel="stylesheet" href="<?= $base_url ?>css/calendar.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <script type="text/javascript" src="<?= $base_url ?>js/es-ES.js"></script>
    <script src="<?= $base_url ?>js/jquery.min.js"></script>
    <script src="<?= $base_url ?>js/moment.js"></script>
    <script src="<?= $base_url ?>js/bootstrap.min.js"></script>
    <script src="<?= $base_url ?>js/bootstrap-datetimepicker.js"></script>
    <link rel="stylesheet" href="<?= $base_url ?>css/bootstrap-datetimepicker.min.css"/>
    <script src="<?= $base_url ?>js/bootstrap-datetimepicker.es.js"></script>

    <script src="../../vista/style/js/validaciones.js"></script>
    <!-- Scripts y styleshet-->
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,700,500,900' rel='stylesheet' type='text/css'>
    <script src="../js/skel.min.js"></script>
    <script src="../js/skel-panels.min.js"></script>
    <script src="../js/init_c.js"></script>
    <noscript>
        <link rel="stylesheet" href="../css/skel-noscript.css"/>
        <link rel="stylesheet" href="../css/style.css"/>
        <link rel="stylesheet" href="../css/style-desktop.css"/>
    </noscript>


</head>
<body style="background: white;">

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
<div class="container">

    <div class="">
        <div class="page-header"><h2 style="color: #009688; font-size: 30pt;"></h2></div>
        <div class="pull-left form-inline"><br>
            <div class="btn-group">
                <button class="btn btn-primary" data-calendar-nav="prev"><< Anterior</button>
                <button class="btn" data-calendar-nav="today">Hoy</button>
                <button class="btn btn-primary" data-calendar-nav="next">Siguiente >></button>
            </div>
            <div class="btn-group">
                <button class="btn" data-calendar-view="year" style="background-color: #009688; color: white">Año</button>
                <button class="btn" data-calendar-view="month" style="background-color: #009688; color: white">Mes</button>
                <button class="btn" data-calendar-view="week" style="background-color: #009688; color: white">Semana</button>
                <button class="btn" data-calendar-view="day" style="background-color: #009688; color: white">Dia</button>
            </div>

        </div>
        <div class="pull-right form-inline"><br>
            <button class="btn btn-primary" data-toggle='modal' data-target='#add_evento'>Agende una Cita</button>
        </div>

    </div>
    <hr>

    <div class="row">
        <div id="calendar"></div> <!-- Aqui se mostrara nuestro calendario -->
    </div>

    <!--ventana modal para el calendario-->
    <div class="modal fade" id="events-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body" style="height: 400px">
                    <p>One fine body&hellip;</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>

<script src="<?= $base_url ?>js/underscore-min.js"></script>
<script src="<?= $base_url ?>js/calendar.js"></script>
<script type="text/javascript">
    (function ($) {
        //creamos la fecha actual
        var date = new Date();
        var yyyy = date.getFullYear().toString();
        var mm = (date.getMonth() + 1).toString().length == 1 ? "0" + (date.getMonth() + 1).toString() : (date.getMonth() + 1).toString();
        var dd = (date.getDate()).toString().length == 1 ? "0" + (date.getDate()).toString() : (date.getDate()).toString();

        //establecemos los valores del calendario
        var options = {

            // definimos que los eventos se mostraran en ventana modal
            modal: '#events-modal',

            // dentro de un iframe
            modal_type: 'iframe',

            //obtenemos los eventos de la base de datos
            events_source: '<?=$base_url?>obtener_eventos.php',

            // mostramos el calendario en el mes
            view: 'month',

            // y dia actual
            day: yyyy + "-" + mm + "-" + dd,


            // definimos el idioma por defecto
            language: 'es-ES',

            //Template de nuestro calendario
            tmpl_path: '<?=$base_url?>tmpls/',
            tmpl_cache: false,


            // Hora de inicio
            time_start: '08:00',

            // y Hora final de cada dia
            time_end: '22:00',

            // intervalo de tiempo entre las hora, en este caso son 30 minutos
            time_split: '30',

            // Definimos un ancho del 100% a nuestro calendario
            width: '100%',

            onAfterEventsLoad: function (events) {
                if (!events) {
                    return;
                }
                var list = $('#eventlist');
                list.html('');

                $.each(events, function (key, val) {
                    $(document.createElement('li'))
                        .html('<a href="' + val.url + '">' + val.title + '</a>')
                        .appendTo(list);
                });
            },
            onAfterViewLoad: function (view) {
                $('.page-header h2').text(this.getTitle());
                $('.btn-group button').removeClass('active');
                $('button[data-calendar-view="' + view + '"]').addClass('active');
            },
            classes: {
                months: {
                    general: 'label'
                }
            }
        };


        // id del div donde se mostrara el calendario
        var calendar = $('#calendar').calendar(options);

        $('.btn-group button[data-calendar-nav]').each(function () {
            var $this = $(this);
            $this.click(function () {
                calendar.navigate($this.data('calendar-nav'));
            });
        });

        $('.btn-group button[data-calendar-view]').each(function () {
            var $this = $(this);
            $this.click(function () {
                calendar.view($this.data('calendar-view'));
            });
        });

        $('#first_day').change(function () {
            var value = $(this).val();
            value = value.length ? parseInt(value) : null;
            calendar.setOptions({first_day: value});
            calendar.view();
        });
    }(jQuery));
</script>

<div class="modal fade" id="add_evento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Agendar una cita</h4>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <label for="from">Fecha de cita</label>
                    <div class='input-group date' id='from'>
                        <input type='text' id="from" name="from" class="form-control" readonly/>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                    </div>
                    <br>
                    <div>
                        <div class="pull-left form-inline">
                            <label for="tipo">Seleccione un auto</label>
                            <select class="form-control" name="auto_placa" id="tipo">
                                <?php
                                foreach ($autos as $res) {
                                    $auto = "Placa: " . $res[auto::PLACA] . " Marca: " . $res[auto::MARCA] . " Año: " . $res[auto::ANIO];
                                    echo "<option value='" . $res[auto::PLACA] . "'>" . $auto . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="pull-right form-inline">
                            <a href="../autos/AddAuto.php">
                                <button type="button" class="btn btn-primary">Nuevo Auto</button>
                            </a>
                        </div>
                    </div>
                    <br>
                    <br>


                    <label for="title">Nombre del Cliente</label>
                    <input type="text" required autocomplete="off" name="title" class="form-control" id="title"
                           value="<?= $nombre ?>" readonly>

                    <br>


                    <label for="body">Detalle de cita</label>
                    <textarea id="body" name="event"
                              placeholder="Escribe una descripccion del problema que tiene su auto o del tipo de servicio que le gustaria obtener."
                              required class="form-control" rows="3"></textarea>

                    <script type="text/javascript">
                        $(function () {
                            $('#from').datetimepicker({
                                language: 'es',
                                minDate: new Date()
                            });
                            $('#to').datetimepicker({
                                language: 'es',
                                minDate: new Date()
                            });

                        });
                    </script>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar
                </button>
                <button type="submit" class="btn" style="background-color: #009688; color: white"><i class="fa fa-check"></i> Agregar</button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
