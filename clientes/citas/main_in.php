<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Bienvenido</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Custom CSS -->
    <link href="../../vista/style/css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../../vista/style/css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../../vista/style/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" type="text/css" href="../../vista/style/css/bootstrap.css">
    <script src="../../vista/style/js/bootstrap.js"></script>

    <!-- Jquery -->
    <script src="../../vista/style/js/jquery-3.2.0.min.js"></script>


</head>

<body>

<div>
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="../cliente/perfil.php">
                    <span class="glyphicon glyphicon-user"></span> Perfil
                </a>
            </div>

            <div class="collapse navbar-collapse" id="menu">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="../index.php">
                            <span class="glyphicon glyphicon-home"></span> Inicio
                        </a>
                    </li>
                    <li>
                        <a href="../citas/Calendario.php">
                            <span class="glyphicon glyphicon-pawn"></span> Citas
                        </a>
                    </li>
                    <!-- Menu de clientes -->
                    <li class="dopdown">
                        <a href="../autos/QueryAutos.php">
                            <span class="glyphicon glyphicon-bed"></span> Mis Autos
                        </a>
                    </li>
                    <!-- Menu de Servicios -->
                    <li class="dopdown">
                        <a href="../miservicios/QueryOrden.php">
                            <span class="glyphicon glyphicon-list"></span> Mis Servicios
                        </a>
                    </li>



                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="../cliente/logout.php">
                            <span class="glyphicon glyphicon-log-out"></span> Cerrar Sesión
                        </a>
                    </li>
                </ul>


            </div>


        </div>
    </nav>
</div>
</body>


</html>