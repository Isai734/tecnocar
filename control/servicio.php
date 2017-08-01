<?php

class servicio
{
    const CLAVE = "clave";
    const NOMBRE = "nombre";
    const COSTO = "costo";
    const TIPO = "tipo";
    const NOMBRE_TABLA = "servicio";


    public static function post()
    {
        $payload = file_get_contents('php://input');
        $payload = json_decode($payload);
        return self::createAuto($payload);
    }

    public static function get($request)
    {
        $respuesta = self::getServiciosOrden(isset($request[0]) ? $request[0] : null);
        return Array("servicios" => $respuesta[self::NOMBRE_TABLA]);
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

    public static function delete($request)
    {
        if (!empty($request[0])) {
            self::deleteAuto($request[0]);
        } else {
            throw new ExcepcionApi(Constantes::ESTADO_MALA_SINTAXIS, "Falta id", 422);
        }
        //return self::getPersonas(isset($request[0]) ? $request[0] : null);
    }

    public static function createAuto($auto = null)
    {
        if ($auto) {
            try {
                $pdo = ConexionBD::obtenerInstancia()->obtenerBD();
                // Sentencia INSERT
                $comando = 'INSERT INTO ' . self::NOMBRE_TABLA . '('
                    . self::PLACA . ','
                    . self::MARCA . ','
                    . self::MODELO . ','
                    . self::COLOR . ','
                    . self::ANIO . ','
                    . self::TRANSMISION . ','
                    . self::CLIENTE_CLAVE . ') VALUES(?,?,?,?,?,?,?)';
                // Preparar la sentencia
                $sentencia = $pdo->prepare($comando);
                // Generar Pk
                $sentencia->bindParam(1, $auto->placa);
                $sentencia->bindParam(2, $auto->marca);
                $sentencia->bindParam(3, $auto->modelo);
                $sentencia->bindParam(4, $auto->color);
                $sentencia->bindParam(5, $auto->anio);
                $sentencia->bindParam(6, $auto->transmision);
                $sentencia->bindParam(7, $auto->cliente_clave);
                // Retornar en el ultimo id insertado
                if ($sentencia->execute()) {
                    http_response_code(201);
                    $respuesta[self::PLACA] = $auto->placa;
                    $respuesta['estado'] = Constantes::CODIGO_EXITO;
                    $respuesta['mensaje'] = utf8_encode("Registro creado con Exito¡¡");
                    return $respuesta;
                }
            } catch (PDOException $e) {
                throw new ExcepcionApi(Constantes::ESTADO_ERROR_BD, $e->getMessage());
            }
        } else {
            throw new ExcepcionApi(
                Constantes::ESTADO_MALA_SINTAXIS,
                utf8_encode("Error en existencia o sintaxis de parámetros"));
        }
    }

    public static function updateAuto($auto)
    {
        if ($auto) {
            try {
                $pdo = ConexionBD::obtenerInstancia()->obtenerBD();
                // Sentencia Update placa, marca, modelo, color, anio, transmision, cliente_clave
                $comando = 'UPDATE ' . self::NOMBRE_TABLA . ' SET '
                    . self::MARCA . '=?,'
                    . self::MODELO . '=?,'
                    . self::COLOR . '=?,'
                    . self::ANIO . '=?,'
                    . self::TRANSMISION . '=?,'
                    . self::CLIENTE_CLAVE . '=? WHERE ' . self::PLACA . " =?";
                // Preparar la sentencia
                $sentencia = $pdo->prepare($comando);
                // Generar Pk
                $sentencia->bindParam(7, $auto->placa);
                $sentencia->bindParam(1, $auto->marca);
                $sentencia->bindParam(2, $auto->modelo);
                $sentencia->bindParam(3, $auto->color);
                $sentencia->bindParam(4, $auto->anio);
                $sentencia->bindParam(5, $auto->transmision);
                $sentencia->bindParam(6, $auto->cliente_clave);
                // Retornar en el último id insertado

                if ($sentencia->execute()) {
                    http_response_code(201);
                    $respuesta[self::PLACA] = $auto->placa;
                    $respuesta['estado'] = Constantes::CODIGO_EXITO;
                    $respuesta['mensaje'] = utf8_encode("Registro actualizado con Exito¡¡");
                    return $respuesta;
                }
            } catch (PDOException $e) {
                throw new ExcepcionApi(Constantes::ESTADO_ERROR_BD, $e->getMessage());
            }
        } else {
            throw new ExcepcionApi(
                Constantes::ESTADO_MALA_SINTAXIS,
                utf8_encode("Falta Id"), 422);
        }
    }

    public static function getAutoId($idPersona = null)
    {
        try {
            $sentencia = null;
            if ($idPersona) {
                $comando = "SELECT * FROM " . self::NOMBRE_TABLA . " WHERE " . self::CLIENTE_CLAVE . "=?";
                // Preparar sentencia
                $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);
                // Ligar idUsuario
                $sentencia->bindParam(1, $idPersona);
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

    public static function getServiciosOrden($orden = null)
    {
        try {

            $comando = "select * from servicio, orden_servicio 
                where servicio.clave=orden_servicio.servicio_clave and orden_servicio.numero_orden=?";
            // Preparar sentencia
            $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);
            // Ligar idUsuario
            $sentencia->bindParam(1, $orden);
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


    public static function getServicios($clave = null)
    {
        try {
            if ($clave) {
                $comando = "SELECT * FROM " . self::NOMBRE_TABLA . " WHERE " . self::CLAVE . " =?";
                // Preparar sentencia
                $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);
                // Ligar idUsuario
                $sentencia->bindParam(1, $clave);
            } else {
                $comando = "SELECT * FROM " . self::NOMBRE_TABLA;
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

    public static function deleteAuto($placa)
    {
        try {
            // Sentencia DELETE
            $comando = "DELETE FROM " . self::NOMBRE_TABLA .
                " WHERE " . self::PLACA . "=?";
            // Preparar la sentencia
            $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);
            $sentencia->bindParam(1, $placa);
            $sentencia->execute();
            if (($sentencia->rowCount()) > 0) {
                http_response_code(200);
                $respuesta['estado'] = Constantes::CODIGO_EXITO;
                $respuesta['mensaje'] = utf8_encode("Registro eliminado correctamente");
                return $respuesta;
            } else {
                throw new ExcepcionApi(Constantes::ESTADO_NO_ENCONTRADO,
                    "Clave desconocida", 404);
            }
        } catch
        (PDOException $e) {
            throw new ExcepcionApi(Constantes::ESTADO_ERROR_BD, $e->getMessage());
        }
    }
}