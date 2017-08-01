<?php include "main.php";
//$tipo = $_GET['tipo'];
?>
<!DOCTYPE html>
<html>
<head>
    <script src="../../vista/style/sweet/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../../vista/style/sweet/sweetalert.css">

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
    <!-- fin -->
</head>
<body>

<!-- Header -->
<div id="header_2">
    <div class="container">
        <!-- Logo -->
        <br><br><br>
        <div id="logo">
            <h1><a href="#">Tecnocar</a></h1>
            <span class="tag">Tu taller mecanico</span>
        </div>
        <br><br><br>
    </div>
</div>

<br>
<div id="page-wrapper">
    <div class="container">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header" style="font-size: 25pt; color: #00796B">
                    <span class="glyphicon glyphicon-user"></span> Datos de sesión
                </h1>
            </div>
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-lg-12">
                <!-- FORMULARIO -->
                <form class="form-horizontal" action="CrudAlert.php?metodo=add" method="POST"
                      onsubmit="return validar();" autocomplete="off">
                    <!--Datos de usuario-->
                    <div class="form-group">
                        <label class="control-label col-sm-2">Usuario:</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="usuario" name="usuario" autofocus required>
                        </div>
                        <div class="col-sm-4">
                        <span>Solo puede contener letras y numeros y debe tener un tamaño mayor a 4 caracteres y menor de 15.</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Contraseña:</label>
                        <div class="col-sm-3">
                            <input type="password" class="form-control" id="contra" name="contrasenia" required>
                        </div>
                        <div class="col-sm-4">
                        <span>Dene contener letras y numeros y ser mayor a 5 caracteres.</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Confirme Contraseña:</label>
                        <div class="col-sm-3" id="aviso">
                            <input type="password" class="form-control" id="recontra" required>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="page-header" style="font-size: 25pt; color: #00796B">
                            <span class="glyphicon glyphicon-bishop"></span> Datos del cliente
                        </div>
                    </div>
                    <!--Nombre del cliente-->
                    <div class="form-group">
                        <label class="control-label col-sm-2">Nombre:</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                    </div>
                    <!-- Apellido paterno del cliente-->
                    <div class="form-group">
                        <label class="control-label col-sm-2">Primer Apellido:</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="apellido_paterno" name="apellido_paterno" required>
                        </div>
                    </div>

                    <!-- Apellido Materno del cliente -->
                    <div class="form-group">
                        <label class="control-label col-sm-2">Segundo Apellido:</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="apellido_paterno" name="apellido_materno" required>
                        </div>
                    </div>

                    <!-- Teléfono del cliente -->
                    <div class="form-group">
                        <label class="control-label col-sm-2">Teléfono:</label>
                        <div class="col-sm-3">
                            <input type="phone" class="form-control" id="telefono" name="telefono" required>
                            <span>Sin espacios ni guiones medios.</span>
                        </div>
                    </div>

                    <!-- Dirección del cliente -->
                    <div class="form-group">
                        <label class="control-label col-sm-2">Dirección:</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="direccion" name="direccion" required>
                        </div>
                    </div>
                    <!-- Email del cliente -->
                    <div class="form-group">
                        <label class="control-label col-sm-2">E-mail:</label>
                        <div class="col-sm-3">
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                    </div>

                    <!-- RFC del cliente -->
                    <div class="form-group">
                        <label class="control-label col-sm-2">RFC*:</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="rfc" name="rfc">
                            <span>*Opcional</span>
                        </div>
                    </div>


                    <!-- Botónnes para registrar y cancelar -->
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn" style="background-color: #00796B; color: white">Registrar</button>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#mymodal">
                                Cancelar
                            </button>
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
                <a href="../index.php">
                    <button type="button" class="btn" style="background-color: #00796B; color: white">Si</button>
                </a>
                <button type="button" data-dismiss="modal" class="btn btn-danger">No</button>
            </div>
        </div>
    </div>
</div>

    <script src="../../vista/style/js/jquery-3.2.0.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="../../vista/style/js/bootstrap.min.js"></script>
    <script src="../../Validaciones/validar_signup.js"></script>

</body>


</html>