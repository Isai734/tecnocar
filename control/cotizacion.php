<?php
session_start();

class cotizacion
{
    const CLIENTE = "cliente_clave";
    const PLACA = "auto_placa";
    const MECANICO = "mecanico_clave";
    const MANO_OBRA = "mano_obra";
    const SERVICIO_TIPO = "tipo_servicio";
    const SERVICIOS = "check";
    const PRODUCTOS = "productos";
    const NOMBRE_TABLA = "cotizacion";

    public static function cotizar($datos = null)
    {
        /**
         * Array ( [cliente_clave] => 1 [auto_placa] => FFF
         * [mecanico_clave] => 4 [mano_obra] => 45 [tipo_servicio] => B
         * [check] => Array ( [0] => 5 [1] => 6 ) [productos] => Array ( [3] => 67 ) )
         */
        if ($datos) {
            $pdo = ConexionBD::obtenerInstancia()->obtenerBD();
            try {
                $pdo->beginTransaction();
                /**********INSERTS**************/
                //Hacemos los insert numero_orden, mano_obra, subtotal, total, mecanico_clave, auto_placa, estatus
                $comando = 'INSERT INTO ' . orden::NOMBRE_TABLA . ' VALUES  (?,?,?,?,?)';
                $sentencia = $pdo->prepare($comando);

                $sentencia->bindParam(1, $datos['mano_obra']);
                $sentencia->bindParam(2, $datos['subtotal']);
                $sentencia->bindParam(3, $datos['total']);
                $sentencia->bindParam(4, $datos['mecanico_clave']);
                $sentencia->bindParam(5, $datos['auto_placa']);

                if (!$sentencia->execute()) {
                    $pdo->rollBack();
                    throw new ExcepcionApi(Constantes::ESTADO_ERROR, "Se ha producido un error");
                }

                //orden_numero_orden, producto_refaccion_clave, cantidad
                $productos=$datos['productos'];
                $numero_orden=0;
                $sentencia=$pdo->prepare("SELECT MAX(numero_orden) FROM ".orden::NOMBRE_TABLA);
                if (!$sentencia->execute()) {
                    $pdo->rollBack();
                    throw new ExcepcionApi(Constantes::ESTADO_ERROR, "Se ha producido un error");
                }
                $numero_orden=$sentencia->fetch()['numero_orden'];
                $comando = 'INSERT INTO DETALLE_ORDEN VALUES  (?,?,?)';
                foreach ($productos as $clave => $valor) {
                    $sentencia = $pdo->prepare($comando);
                    $sentencia->bindParam(1, $numero_orden);
                    $sentencia->bindParam(2, $clave);
                    $sentencia->bindParam(3, $valor);
                    if (!$sentencia->execute()) {
                        $pdo->rollBack();
                        throw new ExcepcionApi(Constantes::ESTADO_ERROR, "Se ha producido un error");
                    }
                }
                //numero_orden, servicio_clave
                $servicios=$datos['check'];
                $comando = 'INSERT INTO orden_servicio VALUES  (?,?)';
                foreach ($servicios as $servicio_clave) {
                    $sentencia = $pdo->prepare($comando);
                    $sentencia->bindParam(1, $numero_orden);
                    $sentencia->bindParam(2, $servicio_clave);
                    if (!$sentencia->execute()) {
                        $pdo->rollBack();
                        throw new ExcepcionApi(Constantes::ESTADO_ERROR, "Se ha producido un error");
                    }
                }
                /*******UPDATES**************/
                $comando = 'UPDATE ' . cita::NOMBRE_TABLA . ' SET '.cita::STATUS .' =ATENDIDA';
                $sentencia = $pdo->prepare($comando);
                if (!$sentencia->execute()) {
                    $pdo->rollBack();
                    throw new ExcepcionApi(Constantes::ESTADO_ERROR, "Se ha producido un error");
                }
                foreach ($productos as $clave => $valor) {
                    //Obtenemos cantidad
                    $comando = "SELECT ".producto::CANTIDAD."  FROM " . producto::NOMBRE_TABLA . " WHERE " . producto::CLAVE . "=".$clave;
                    $sentencia = $pdo->prepare($comando);

                    if (!$sentencia->execute()) {
                        $pdo->rollBack();
                        throw new ExcepcionApi(Constantes::ESTADO_ERROR, "Se ha producido un error");
                    }
                    $ocantidad=$sentencia->fetch()[producto::CANTIDAD];
                    //Seteamos cantidad
                    $ncantidad=$ocantidad-$valor;
                    $comando = "UPDATE ".producto::NOMBRE_TABLA."  SET " . producto::CANTIDAD . "=".$ncantidad;
                    $sentencia = $pdo->prepare($comando);
                    if (!$sentencia->execute()) {
                        $pdo->rollBack();
                        throw new ExcepcionApi(Constantes::ESTADO_ERROR, "Se ha producido un error");
                    }
                }
                $pdo->commit();
            } catch (PDOException $e) {
                $pdo->rollBack();
                throw new ExcepcionApi(Constantes::ESTADO_ERROR_BD, $e->getMessage());
            }
        } else {
            throw new ExcepcionApi(
                Constantes::ESTADO_MALA_SINTAXIS,
                utf8_encode("Falta Datos"), 422);
        }
    }
}