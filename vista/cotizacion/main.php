<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Bienvenido</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Custom CSS -->
    <link href="../style/css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../style/css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../style/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" type="text/css" href="../style/css/bootstrap.css">
    <script src= "../style/js/bootstrap.js"></script>

    <!-- Jquery -->
    <script src = "../style/js/jquery-3.2.0.min.js"></script>


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
                <a class="navbar-brand" href="../citas/Calendario.php">
                    <span class="glyphicon glyphicon-wrench"></span> Administracion
                </a>
            </div>

            <div class="collapse navbar-collapse" id="menu">
                <ul class="nav navbar-nav">

                    <li>
                        <a href="../citas/Calendario.php">
                            <span class="glyphicon glyphicon-list-alt"></span> Citas
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="../personas/AddPersona.php">
                                    Cliente
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- Menu de clientes -->
                    <li class="dopdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="glyphicon glyphicon-user"></span> Clientes <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="../personas/AddPersona.php?tipo=CLIENTE">
                                    <span class="glyphicon glyphicon-plus"></span> Nuevo Cliente
                                </a>
                            </li>
                            <li>
                                <a href="../personas/QueryPersona.php?tipo=CLIENTE">
                                    <span class="glyphicon glyphicon-search"></span> Consultar Cliente
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- Menu de clientes -->
                    <li class="dopdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="glyphicon glyphicon-user"></span> Mecanicos <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="../personas/AddPersona.php?tipo=MECANICO">
                                    <span class="glyphicon glyphicon-plus"></span> Nuevo Mecanico
                                </a>
                            </li>
                            <li>
                                <a href="../personas/QueryPersona.php?tipo=MECANICO">
                                    <span class="glyphicon glyphicon-search"></span> Consultar Mecanicos
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="dopdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="glyphicon glyphicon-bed"></span> Autos <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="../autos/AddAuto.php">
                                    <span class="glyphicon glyphicon-plus"></span> Nuevo Auto
                                </a>
                            </li>
                            <li>
                                <a href="../autos/QueryAutos.php">
                                    <span class="glyphicon glyphicon-search"></span> Consultar Autos
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="dopdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="glyphicon glyphicon-pushpin"></span> Ordenes de servicio <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="Cotizacion.php">
                                    <span class="glyphicon glyphicon-credit-card"></span> Cotizar Servicio
                                </a>
                            </li>
                            <li>
                                <a href="../ordns_servicios/QueryOrden.php">
                                    <span class="glyphicon glyphicon-shopping-cart"></span> Ordenes de Servicio
                                </a>
                            </li>

                        </ul>
                    </li>


                    <li class="dopdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="glyphicon glyphicon-list"></span> Inventario<span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="../empresas/QueryEmpresa.php">
                                    <span class="glyphicon glyphicon-credit-card"></span> Proveedores
                                </a>
                            </li>

                            <li>
                                <a href="../inventario/QueryProductos.php">
                                    <span class="glyphicon glyphicon-search"></span> Inventario
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="../servicios/QueryServicio.php">
                            <span class="glyphicon glyphicon-check"></span> Servicios
                        </a>
                    </li>
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="../../clientes/cliente/logout.php">
                            <span class="glyphicon glyphicon-off"></span> Cerrar Sesión
                        </a>
                    </li>
                </ul>


            </div>


        </div>
    </nav>
</div>
</body>


</html>