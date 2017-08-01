<?php

class orden
{
    const NUMERO = "numero_orden";
    const MANO_OBRA = "mano_obra";
    const SUBTOTAL = "subtotal";
    const TOTAL = "total";
    const MECANICO_CLAVE = "mecanico_clave";
    const AUTO_PLACA = "auto_placa";
    const ESTATUS_ORDEN = "estatus";
    const NOMBRE_TABLA = "orden";

    //numero_orden, mano_obra, subtotal, total, mecanico_clave, auto_placa, estatus

    public static function post()
    {
        $payload = file_get_contents('php://input');
        $payload = json_decode($payload);
        return self::createAuto($payload);
    }

    public static function get($request)
    {
        return self::getOrden(isset($request[0]) ? $request[0] : null);
    }

    public static function put($request)
    {
        if (isset($request[0])) {
            $payload = file_get_contents('php://input');
            $payload = json_decode($payload);
            return self::createAuto($payload);
        } else {
            throw new ExcepcionApi(
                Constantes::ESTADO_MALA_SINTAXIS,
                utf8_encode("Falta Id"), 422);
        }
    }

    public static function getOrden($clave = null)
    {
        try {
            if ($clave) {
                $comando = "SELECT numero_orden,placa,marca,modelo,nombre,apellido_paterno,apellido_materno,mano_obra, total,estatus,cliente_clave 
                from auto,persona,orden WHERE orden.auto_placa=auto.placa 
                AND orden.mecanico_clave=persona.clave AND auto.cliente_clave=?";
                // Preparar sentencia
                $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);
                // Ligar idUsuario
                $sentencia->bindParam(1, $clave);
            } else {
                $comando = "SELECT numero_orden,placa,marca,modelo,nombre,apellido_paterno,apellido_materno,mano_obra, total,estatus,cliente_clave 
                from auto,persona,orden WHERE orden.auto_placa=auto.placa 
                AND orden.mecanico_clave=persona.clave";
                // Preparar sentencia
                $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);
            }
            // Ejecutar sentencia preparada
            if ($sentencia->execute()) {
                http_response_code(200);
                $respuesta[self::NOMBRE_TABLA] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
                $respuesta['estado'] = Constantes::CODIGO_EXITO;
                $respuesta['mensaje'] = utf8_encode("Recursos Obtenidos");
                return $respuesta;
            } else
                throw new ExcepcionApi(Constantes::ESTADO_ERROR, "Se ha producido un error");

        } catch (PDOException $e) {
            throw new ExcepcionApi(Constantes::ESTADO_ERROR_BD, $e->getMessage());
        }
    }

    public static function getOrdenId($clave = null)
    {
        try {
            if ($clave) {
                $comando = "SELECT * from ".self::NOMBRE_TABLA." WHERE ".self::NUMERO." =?";
                // Preparar sentencia
                $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);
                $sentencia->bindParam(1,$clave);
            }
            // Ejecutar sentencia preparada
            if ($sentencia->execute()) {
                http_response_code(200);
                $respuesta[self::NOMBRE_TABLA] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
                $respuesta['estado'] = Constantes::CODIGO_EXITO;
                $respuesta['mensaje'] = utf8_encode("Recursos Obtenidos");
                return $respuesta;
            } else
                throw new ExcepcionApi(Constantes::ESTADO_ERROR, "Se ha producido un error");

        } catch (PDOException $e) {
            throw new ExcepcionApi(Constantes::ESTADO_ERROR_BD, $e->getMessage());
        }
    }

    public static function transaccionarOrden($datos = null)
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
                $comando = 'INSERT INTO ' . self::NOMBRE_TABLA . ' 
                (mano_obra, subtotal, total, mecanico_clave, auto_placa) VALUES  (?,?,?,?,?)';
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
                $sentencia=$pdo->prepare("SELECT MAX(numero_orden) as numero_orden FROM ".self::NOMBRE_TABLA);
                if (!$sentencia->execute()) {
                    $pdo->rollBack();
                    throw new ExcepcionApi(Constantes::ESTADO_ERROR, "Se ha producido un error");
                }
                //print_r($sentencia->fetch());
                $numero_orden=$sentencia->fetch()[self::NUMERO];

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
                $comando = 'UPDATE ' . cita::NOMBRE_TABLA . ' SET '.cita::STATUS .' = \'ATENDIDA\'';
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
                $respuesta['estado'] = Constantes::CODIGO_EXITO;
                $respuesta['mensaje'] = utf8_encode("Operación con exito");
                $pdo->commit();
                return $respuesta;

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