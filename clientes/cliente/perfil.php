<?php
require "../../control/persona.php";
require "../../modelo/ConexionBD.php";
require "../../utilidades/Constantes.php";
include '../../control/login.php';
include '../../utilidades/ExcepcionApi.php';
session_start();
$user=null;
if(isset($_SESSION[login::NOMBRE_TABLA]) | !empty($_SESSION[login::NOMBRE_TABLA])){
    include "main_in.php";
    $user=$_SESSION[login::NOMBRE_TABLA];
    $row = persona::getPersonas($user[login::PERSONA_CLAVE])[persona::NOMBRE_TABLA][0];
}else{
    header("Location: ../login/login.php");
}
//include "main.php";
//$tipo = $_GET['tipo'];
?>
<!DOCTYPE html>
<html>
<head>
    <script src="../../vista/style/js/validaciones.js"></script>
    <script src="../../vista/style/js/bootstrap.js"></script>
    <script src="../../vista/style/js/jquery-3.2.0.min.js"></script>
    <script src="../../vista/style/sweet/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../../vista/style/sweet/sweetalert.css">

    <!-- Scripts y styleshet-->
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,700,500,900' rel='stylesheet' type='text/css'>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
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
        
        <!-- /.row -->
        <!-- Boton edit -->
        <div class="pull-right form-inline"><br>
            <button class="btn btn-primary" onclick="edit()">
            <span class="glyphicon glyphicon-pencil"></span> Actulizar información</button>
        </div>

        
        <!-- Fin Boton edit -->
        <div class="row">
            <div class="col-lg-12">
                <!-- FORMULARIO -->
                <form class="form-horizontal" action="CrudAlert.php?metodo=add" method="POST"
                      onsubmit="return validarlogin()" autocomplete="off">
                      <table class="table">
                          <thead>
                            <tr>
                                <th colspan="2">
                                    <span class="label label-default" style="background-color: #00796B">
                                        <span class="glyphicon glyphicon-user"></span> Datos de sesión
                                    </span>
                                </th>
                                <th colspan="2">
                                    <span class="label label-default" style="background-color: #00796B">
                                        <span class="glyphicon glyphicon-bishop"></span> Datos del cliente
                                    </span>
                                </th>
                            </tr>
                          </thead>
                            <tbody>
                              <tr>
                                  <td class="contentPerfil col-sm-2">
                                    <label class="labelperfil">Usuario:</label>
                                    <br>
                                    <label class="labelperfil">Contraseña:</label>
                                  </td>
                                  <td class="contentPerfil" >
                                    <label class="labelDatos"><?php echo $user[login::USUARIO]?></label>
                                    <br>
                                    <label class="labelDatos">******</label>
                                  </td>
                                  <td class="contentPerfil col-sm-2">
                                    <label class="labelperfil">Nombre:</label>
                                    <br>
                                    <label class="labelperfil">Primer Apellido:</label>
                                    <br>
                                    <label class="labelperfil">Segundo Apellido:</label>
                                    <br>
                                    <label class="labelperfil">Teléfono:</label>
                                    <br>
                                    <label class="labelperfil">Dirección:</label>
                                    <br>
                                    <label class="labelperfil">E-mail:</label>
                                    <br>
                                    <label class="labelperfil">RFC:</label>
                                  </td>
                                  <td class="contentPerfil">
                                    <label class="labelDatos">
                                        <?php echo $row[persona::NOMBRE]?>
                                    </label>
                                    <br>
                                    <label class="labelDatos">
                                        <?php echo $row[persona::A_PATERNO]?>
                                    </label>
                                    <br>
                                    <label class="labelDatos">
                                        <?php echo $row[persona::A_MATERNO]?>
                                    </label>
                                    <br>
                                    <label class="labelDatos">
                                        <?php echo $row[persona::TELEFONO]?>
                                    </label>
                                    <br>
                                    <label class="labelDatos">
                                        <?php echo $row[persona::DIRECCION]?>
                                    </label>
                                    <br>
                                    <label class="labelDatos">
                                        <?php echo $row[persona::EMAIL]?>
                                    </label>
                                    <br>
                                    <label class="labelDatos">
                                        <?php echo $row[persona::RFC]?>
                                    </label>
                                  </td>
                              </tr>
                            </tbody>
                      </table>
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
                    <button type="button" class="btn btn-success">Si</button>
                </a>
                <button type="button" data-dismiss="modal" class="btn btn-danger">No</button>
            </div>
        </div>
    </div>
</div>

</body>
<script>
    function edit() {
        window.location = "EditPerfil.php?id=<?php echo $user[login::PERSONA_CLAVE]?>";
    }
</script>


</html>