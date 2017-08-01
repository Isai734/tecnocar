<!-- CONEXION A LA BASE DE DATOS -->
<?php
include '../../modelo/ConexionBD.php';
include '../../control/persona.php';
include '../../control/login.php';
include '../../utilidades/Constantes.php';
include '../../utilidades/ExcepcionApi.php';
include '../cliente/main.php';
session_start();
$user=null;
if (!empty($_POST)) {
    try{
        $login = login::getLogin($_POST['usuario']);
        $user = $login[login::NOMBRE_TABLA];
        $error = '';
        if (count($user) == 0 | $user==null)
            $error = "  <div class='alert alert-danger'>
                    <strong>Error!</strong> El usuario no existe.
                    </div>";
        elseif ($user[login::CONTRASENIA] != $_POST['contra']) {
            $error = "<div class='alert alert-danger'>
                    <strong>Error!</strong> Contraseña incorrecta.
                    </div>";
        } elseif ($user[login::CONTRASENIA] == $_POST['contra']) {
            $_SESSION[login::NOMBRE_TABLA] = $login[login::NOMBRE_TABLA];
            header("location: ../index.php");
        }
    }catch (ExcepcionApi $e){
        $error = "<div class='alert alert-danger'>
                    <strong>Error!</strong> Error usuario desconocido.
                    </div>";
    }

}
?>


<!DOCTYPE html>
<html>
<head>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inicio De Sesión</title>
    <link rel="stylesheet" type="text/css" href="../../vista/style/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../../vista/style/sweet/sweetalert.css">
    <link rel="stylesheet" type="text/css" href="style_login.css">

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

    <style>

        .login {
            max-width: 330px;
            padding: 15px;
            margin: 0 auto;
        }

        #avatar {
            width: 200px;
            height: 200px;
            margin: 0px auto 10px;
            display: block;
            border-radius: 50%;
        }
        .container{
            max-width: 380px;
        }

    </style>


</head>
<body class="login">

<div class="container">
    <br>
    <div class="img-circle">
        <div class="col-xs-12">
            <img src="../../clientes/images/tecnologo.png" id="avatar">
        </div>
    </div>

    <!-- FORMULARIO -->
    <form name="form_1" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" onsubmit="return validar()"
          autocomplete="off">

        <label style="font-size: 19px; color:#cc0000;"><?php echo isset($error) ? utf8_decode($error) : ''; ?></label>
        <div class="form-group-lg">
            <input type="text" id="usuario" name="usuario" placeholder="Usuario" class="form-control" autofocus>
        </div>
        <br>
        <div class="form-group-lg">
            <input type="password" id="contra" name="contra" placeholder="Contraseña" class="form-control">
        </div>
        <br>
        <table class="table">
            <tr>
                <td>
                    <button name="boton" type="submit" class="btn btn-md" style="background-color: #00796B; color: white"><span class="glyphicon glyphicon-log-in glyphicon-align-right"></span> Iniciar Sesión</button>

                </td>
                <td>
                    <button name="entrar" onclick="registrar()" type="button" class="btn btn-md btn-primary"><span class="glyphicon glyphicon-check"></span> Registrate</button>
                </td>
            </tr>
        </table>
        
        
    </form>    
</div>

<script>
    function registrar() {
        window.location = "../cliente/AddPersona.php";
    }
</script>
<!-- SCRIPTS -->
<script src="../../vista/style/js/jquery-3.2.0.min.js"></script>
<script src="../../vista/style/js/validaciones.js"></script>
<script src="../../vista/style/js/bootstrap.js"></script>
<script src="../../vista/style/sweet/sweetalert.min.js"></script>

</body>
</html>