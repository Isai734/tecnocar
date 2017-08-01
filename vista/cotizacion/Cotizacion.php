<?php

include '../../modelo/ConexionBD.php';
include '../../control/auto.php';
include '../../control/persona.php';
include '../../control/servicio.php';
include '../../control/producto.php';
include '../../control/empresa.php';
include '../../utilidades/Constantes.php';
include '../../utilidades/ExcepcionApi.php';
if (!isset($_GET['id'])) {
    include "main.php";
} else {
    echo '<!-- Custom CSS -->
     <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" type="text/css" href="../style/css/bootstrap.css">
    <script src= "../style/js/bootstrap.js"></script>
    <!-- Jquery -->
    <script src = "../style/js/jquery-3.2.0.min.js"></script>';
    $rows = null;
    $rows = persona::getPersonas($_GET['id'])[persona::NOMBRE_TABLA][0];
}


$idCita = null;

$clientes = persona::getPersonas("CLIENTE")[persona::NOMBRE_TABLA];
$mecanico = persona::getPersonas("MECANICO")[persona::NOMBRE_TABLA];

?>
<!DOCTYPE html>
<html>
<head>
    <script src="../style/js/validaciones.js"></script>
    <script src="../style/js/bootstrap.js"></script>
    <script src="../style/js/jquery-3.2.0.min.js"></script>
</head>
<body>
<br>
<div id="page-wrapper">
    <div class="container">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header" style="color: #00796B; font-size: 30pt;">
                    <span class="glyphicon glyphicon-plus"></span> Cotización
                </h1>
            </div>
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-lg-12">
                <!-- FORMULARIO -->
                <form class="form-horizontal" action="QueryCotizacion.php" method="POST"
                      onsubmit="return validarAddCliente()" autocomplete="off">
                    <!-- Datos de form

                    <!-- Datos cliente si se selecciono -->
                    <div class="form-group">
                        <?php if (isset($_GET['id'])) {
                            echo "
                                <label class='control-label col-sm-2'>Cliente :</label>
                                 <div class='col-sm-5'>
                                    <input class='form-control' type='text' name='cliente_clave' value='"
                                . $rows[persona::NOMBRE] . " " . $rows[persona::A_PATERNO] . " " . $rows[persona::A_MATERNO] . "' readonly>
                                </div>";
                        } else { ?>

                            <label class="control-label col-sm-2">Cliente:</label>
                            <div class="col-sm-5">
                                <select onchange="getAutos()" id="cliente_clave" class="form-control"
                                        name="cliente_clave">
                                    <option value="0">Seleccione un Cliente</option>
                                    <?php foreach ($clientes as $res) {
                                        $nombre = $res[persona::NOMBRE] . " " . $res[persona::A_PATERNO] . " " . $res[persona::A_MATERNO];
                                        echo "<option value='" . $res[persona::ID_PERSONA] . "'>" . $nombre . "</option>";
                                    } ?>
                                </select>
                            </div>
                        <?php } ?>
                    </div>
                    <!--Datos de auto-->
                    <br>
                    <div class="form-group">
                        <?php if (isset($_GET['placa'])) {
                            $auto = auto::getAuto($_GET['placa'])[auto::NOMBRE_TABLA][0];
                            echo "
                                <label class='control-label col-sm-2'>Auto :</label>
                                 <div class='col-sm-5'>
                                    <input class='form-control' type='text' name='auto_placa' value='"
                                . $auto[auto::PLACA] . " " . $auto[auto::MARCA] . " " . $auto[auto::MODELO] . " " . $auto[auto::COLOR] . "' readonly>
                                </div>";
                        } else { ?>

                        <label class="control-label col-sm-2">Seleccione un auto</label>
                        <div class="col-sm-5">
                            <select class="form-control" name="auto_placa" id="tipo_auto">
                            </select>
                        </div>
                    </div>
                    <?php } ?>
                    <br>


                    <!-- Seleccion del mecanico-->
                    <div class="form-group">
                        <label class="control-label col-sm-2">Mecanico:</label>
                        <div class="col-sm-5">
                            <select class="form-control" name="mecanico_clave">
                                <?php foreach ($mecanico as $res) {
                                    $nombre = $res[persona::NOMBRE] . " " . $res[persona::A_PATERNO] . " " . $res[persona::A_MATERNO];
                                    echo "--" . $nombre;
                                    echo "<option value='" . $res[persona::ID_PERSONA] . "'>" . $nombre . "</option>";
                                } ?>
                            </select>
                        </div>
                    </div>
                    <br>


                    <div class="form-group">
                        <label class="control-label col-sm-2">Mano de Obra:</label>
                        <div class="col-sm-5">
                            <input required min="1" type="number" class="form-control" id="marca" name="mano_obra">
                        </div>
                    </div>
                    <br>

                    <!--Select Servicios-->
                    <div class="form-group">
                        <label class="control-label col-sm-2">Seleccione un tipo de servicio</label>
                        <div class="col-sm-5">
                            <select onchange="addRowTblServicios()" class="form-control" name="tipo_servicio" id="tipo_servicio">
                                <option value="0">Seleccione un tipo</option>
                                <option value="A">Tipo A</option>
                                <option value="B">Tipo B</option>
                                <option value="C">Tipo C</option>
                                <option value="D">Tipo D</option>
                            </select>
                        </div>
                    </div>

                    <!--Tabla de Servicios-->

                    <div class="form-group">
                        <div id="div_id" class="table-responsive">
                            <table class="order-table table table-striped" id="tbl_servicios">
                                <thead>
                                <tr class="info" id="tr_servicios">
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>

                    <!-- Subtotal
                    <div class="form-group">
                        <label class="control-label col-sm-2">Subtotal:</label>
                        <div class="col-sm-5">
                            <input readonly type="text" class="form-control" id="marca" name="subtotal">
                        </div>
                    </div>
                    <br>
                    <!-- Total cotizacion
                    <div class="form-group">
                        <label class="control-label col-sm-2">Total:</label>
                        <div class="col-sm-5">
                            <input readonly type="text" class="form-control" id="modelo" name="total">
                        </div>
                    </div>
                    <br>-->
                    <!-- Productos -->
                    <div class="form-group">
                        <label class="control-label col-sm-2">Productos:</label>
                        <div class="col-sm-5">

                            <select onchange="addRow()" class="form-control" id="clave">
                                <option>Seleccione un producto</option>
                                <?php
                                $productos = producto::getProducto(null)[producto::NOMBRE_TABLA];
                                foreach ($productos as $res) {
                                    $nombre = "Nombre: " . $res[producto::NOMBRE] . "   Precio venta: $" . $res[producto::PRECIO_VENTA];
                                    //echo "--" . $nombre;
                                    echo "<option value='" . $res[producto::CLAVE] . "'>" . $nombre . "</option>";
                                } ?>
                            </select>
                        </div>
                    </div>
                    <br>
                    <!--Tabla de productos-->

                    <div class="form-group">
                        <div id="div_id" class="table-responsive">
                            <table class="order-table table table-striped" id="tabla">
                                <thead>
                                <tr class="info" id="tr_tabla">
                                </tr>
                                </thead>
                            </table>
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
                <a href="../citas/Calendario.php">
                        <button type="button" class="btn" style="background-color: #00796B; color: white">Si</button>
                    </a>
                    <button type="button" data-dismiss="modal" class="btn btn-danger">No</button>
            </div>
        </div>
    </div>
</div>

<script>
    var bol = true;
    var rowIds = 1;
    var aproductos =<?php echo json_encode(producto::getProducto(null)[producto::NOMBRE_TABLA]);?>;

    function genera_tabla() {
        // Obtener la referencia del elemento body
        var div = document.getElementById("div_id");
        // Crea un elemento <table> y un elemento <tbody>
        var tabla = document.createElement("table");
        var tblBody = document.createElement("tbody");
        tblBody.setAttribute("id", "tbody");
        // posiciona el <tbody> debajo del elemento <table>
        tabla.appendChild(tblBody);
        // appends <table> into <body>
        div.appendChild(tabla);
        tabla.setAttribute("id", "tabla1");
    }

    function setSubtotal(valor) {

        var cantidad=document.getElementById("cantidad").value;
        document.getElementById("idInput").value=(cantidad*valor);
    }

    function addThead() {
        //var tabla = document.getElementById("tabla");
        //var thead = document.createElement("thead");
        var tr = document.getElementById("tr_tabla");

        var th = document.createElement("th");
        var clave = document.createTextNode("Clave");
        th.appendChild(clave);
        tr.appendChild(th);
        var th = document.createElement("th");
        var nombre = document.createTextNode("Nombre");
        th.appendChild(nombre);
        tr.appendChild(th);
        var th = document.createElement("th");
        var precioc = document.createTextNode("Descripccion");
        th.appendChild(precioc);
        tr.appendChild(th);
        var th = document.createElement("th");
        var preciov = document.createTextNode("Venta");
        th.appendChild(preciov);
        tr.appendChild(th);
        var th = document.createElement("th");
        var proveedor = document.createTextNode("Preveedor");
        th.appendChild(proveedor);
        tr.appendChild(th);
        var th = document.createElement("th");
        var celda = document.createTextNode("Eliminar");
        th.appendChild(celda);
        tr.appendChild(th);
        var th = document.createElement("th");
        var celda1 = document.createTextNode("Cantidad");
        th.appendChild(celda1);
        tr.appendChild(th);
        /*
        var th = document.createElement("th");
        var celda2 = document.createTextNode("Subtotal");
        th.appendChild(celda2);
        tr.appendChild(th);
        */
        //thead.appendChild(tr);
        //tabla.appendChild(thead);
    }

    function addRow() {
        if (bol) {
            addThead();
            bol = false;
        }
        var select = document.getElementById("clave").value;
        var row = getRow(select);
        if (row == null)
            return;
        var tabla = document.getElementById("tabla");
        //tabla.setAttribute("border", "2");
        var tblBody = document.createElement("tbody");
        var hilera = document.createElement("tr");
        var hiden = document.createElement("input");//<input type="hidden" name="id[]" value="" />
        hiden.setAttribute("type", "hidden");
        hiden.setAttribute("name", "id[]");
        hiden.setAttribute("value", select);
        var celda = document.createElement("td");
        var textoCelda = document.createTextNode(row['clave']);
        celda.appendChild(textoCelda);
        hilera.appendChild(celda);
        var celda = document.createElement("td");
        var textoCelda = document.createTextNode(row['nombre']);
        celda.appendChild(textoCelda);
        hilera.appendChild(celda);
        var celda = document.createElement("td");
        var textoCelda = document.createTextNode(row['descripccion']);
        celda.appendChild(textoCelda);
        hilera.appendChild(celda);
        var celda = document.createElement("td");
        var textoCelda = document.createTextNode(row['precio_venta']);
        celda.appendChild(textoCelda);
        hilera.appendChild(celda);
        var celda = document.createElement("td");
        var textoCelda = document.createTextNode(row['razon_social']);
        celda.appendChild(textoCelda);
        hilera.appendChild(celda);
        var celda = document.createElement("td");
        var boton = document.createElement("input");
        boton.setAttribute("type", "button");
        boton.setAttribute("value", "X");
        boton.setAttribute("class", "btn btn-danger");
        boton.setAttribute("onclick", "deleteRow(" + (rowIds++) + ")");
        var span = document.createElement("span");
        span.setAttribute("class", "glyphicon glyphicon-remove");
        boton.appendChild(span);
        celda.appendChild(boton);
        hilera.appendChild(celda);

        var div = document.createElement("div");
        div.setAttribute("class", "col-sm-3");
        var cantidad = document.createElement("input");
        cantidad.setAttribute("type", "number");
        cantidad.setAttribute("name", "productos["+row['clave']+"]");
        cantidad.setAttribute("id", "cantidad");
        //cantidad.setAttribute("onblur", "setSubtotal("+row['precio_venta']+")");
        div.appendChild(cantidad);
        var celda1 = document.createElement("td");
        celda1.appendChild(div);
        hilera.appendChild(celda1);
/*
        var sub = document.createElement("input");
        sub.setAttribute("type", "number");
        sub.setAttribute("readonly", "true");
        sub.setAttribute("name", "subtotal[]");
        sub.setAttribute("id", "subtotal");
        sub.setAttribute("value","Otrro");
        var celda2 = document.createElement("td");
        celda2.appendChild(sub);
        hilera.appendChild(celda2);
        hilera.appendChild(hiden);*/
        tblBody.appendChild(hilera);
        tabla.appendChild(tblBody);
        form.appendChild(tabla);


    }

    function deleteRow(rowId) {
        try {
            var table = document.getElementById("tabla");
            table.deleteRow(rowId);
            rowIds--;
        } catch (e) {
            alert(e);
        }
    }

    function getRow(clave) {
        for (var i = 0; i < aproductos.length; i++) {
            if (aproductos[i]['clave'] == clave)
                return aproductos[i];
        }
        return null;
    }
</script>
<script>
    var autos =<?php echo json_encode(auto::getAuto(null)[auto::NOMBRE_TABLA]);?>;
    function getAutos() {
        var id = document.getElementById("cliente_clave").value;
        var autos = getArrayAutos(id);
        removeItems();
        addItems(autos);
    }

    function addItems(autoc) {
        try {
            var select = document.getElementById("tipo_auto");
            for (var i = 0; i < autoc.length; i++) {
                var option = document.createElement("option");
                var textoCelda = document.createTextNode(autoc[i]['placa'] + " - " + autoc[i]['marca'] + " - " + autoc[i]['modelo']);
                option.appendChild(textoCelda);
                option.setAttribute("value",autoc[i]['placa']);
                select.appendChild(option);
            }
        } catch (e) {
            alert(e);
        }
    }

    function getArrayAutos(idPersona) {
        var arrayAutos = [];
        try {
            var j = 0;
            for (var i = 0; i < autos.length; i++) {
                if (autos[i]['cliente_clave'] == idPersona) {
                    arrayAutos[j++] = autos[i];
                }
            }
            return arrayAutos;
        } catch (e) {
            alert(e);
        }
    }

    function removeItems() {

        try {
            var x = document.getElementById("tipo_auto");
            var lengt = x.length;
            for (var i = 0; i < lengt; i++) {
                x.remove(0);
            }
        } catch (e) {
            alert(e);
        }
    }
</script>
<script>

    var servicios =<?php echo json_encode(servicio::getServicios(null)[servicio::NOMBRE_TABLA]);?>;
    var bolSer=true;
    function addHeadServicios() {
        //var tabla = document.getElementById("tabla");
        //var thead = document.createElement("thead");
        var tr = document.getElementById("tr_servicios");

        var th = document.createElement("th");
        var clave = document.createTextNode("Clave");
        th.appendChild(clave);
        tr.appendChild(th);
        var th = document.createElement("th");
        var nombre = document.createTextNode("Nombre");
        th.appendChild(nombre);
        tr.appendChild(th);
        var th = document.createElement("th");
        var precioc = document.createTextNode("Costo");
        th.appendChild(precioc);
        tr.appendChild(th);
        var th = document.createElement("th");
        var preciov = document.createTextNode("Tipo");
        th.appendChild(preciov);
        tr.appendChild(th);

        var th = document.createElement("th");
        var celda2 = document.createTextNode("Seleccionar");
        th.appendChild(celda2);
        tr.appendChild(th);
    }

    function addRowTblServicios() {
        if (bolSer) {
            //genera_tabla();
            addHeadServicios();
            bolSer = false;
        }
        var select = document.getElementById("tipo_servicio").value;
        var autos = getArrayServicios(select);
        if (autos == null)
            return;
        var tabla = document.getElementById("tbl_servicios");
        var tblBody = document.createElement("tbody");
        try {
            for (var i = 0; i < autos.length; i++) {
                //alert("lenght"+autos.length);
                var hilera = document.createElement("tr");

                var celda = document.createElement("td");
                var textoCelda = document.createTextNode(autos[i]['clave']);
                celda.appendChild(textoCelda);
                hilera.appendChild(celda);
                var celda = document.createElement("td");
                var textoCelda = document.createTextNode(autos[i]['nombre']);
                celda.appendChild(textoCelda);
                hilera.appendChild(celda);
                var celda = document.createElement("td");
                var textoCelda = document.createTextNode(autos[i]['costo']);
                celda.appendChild(textoCelda);
                hilera.appendChild(celda);

                var celda = document.createElement("td");
                var textoCelda = document.createTextNode(autos[i]['tipo']);
                celda.appendChild(textoCelda);
                hilera.appendChild(celda);

                var div = document.createElement("div");
                div.setAttribute("class", "col-sm-3");
                var cantidad = document.createElement("input");
                cantidad.setAttribute("type", "checkbox");
                cantidad.setAttribute("name", "check[]");
                cantidad.setAttribute("value", autos[i]['clave']);
                div.appendChild(cantidad);
                var celda1 = document.createElement("td");
                celda1.appendChild(div);
                hilera.appendChild(celda1);
                tblBody.appendChild(hilera);
            }
        } catch (e) {
            alert(e);
        }

        tabla.appendChild(tblBody);
        form.appendChild(tabla);
    }


    function getArrayServicios(tipo) {
        var arrayServicios = [];
        try {
            var j = 0;
            for (var i = 0; i < servicios.length; i++) {
                if (servicios[i]['tipo'] == tipo) {
                    arrayServicios[j++] = servicios[i];
                }
            }
            return arrayServicios;
        } catch (e) {
            alert(e);
        }
    }
</script>

</body>
</html>
