<?php

class empresa
{
    const CLAVE = "clave";
    const RAZON_SOCIAL = "razon_social";
    const DIRECCION = "direccion";
    const CP = "cp";
    const RFC = "rfc";
    const NOMBRE_TABLA = "empresa";
    public static function post()
    {
        $payload = file_get_contents('php://input');
        $payload = json_decode($payload);
        return self::createEmpresa($payload);
    }

    public static function get($request)
    {
        return self::getEmpresa(isset($request[0]) ? $request[0] : null);
    }

    public static function put($request)
    {
        if (isset($request[0])) {
            $payload = file_get_contents('php://input');
            $payload = json_decode($payload);
            return self::createEmpresa($payload);
        } else {
            throw new ExcepcionApi(
                Constantes::ESTADO_MALA_SINTAXIS,
                utf8_encode("Falta Id"), 422);
        }
    }

    public static function delete($request)
    {
        if (!empty($request[0])) {
            self::deleteEmpresa($request[0]);
        } else {
            throw new ExcepcionApi(Constantes::ESTADO_MALA_SINTAXIS, "Falta id", 422);
        }
        //return self::getPersonas(isset($request[0]) ? $request[0] : null);
    }

    public static function createEmpresa($empresa = null)
    {
        if ($empresa) {
            try {
                $pdo = ConexionBD::obtenerInstancia()->obtenerBD();
                // Sentencia INSERT
                $comando = 'INSERT INTO ' . self::NOMBRE_TABLA . '('
                    . self::RAZON_SOCIAL . ','
                    . self::DIRECCION . ','
                    . self::CP . ','
                    . self::RFC .  ') VALUES(?,?,?,?)';
                // Preparar la sentencia
                $sentencia = $pdo->prepare($comando);
                // Generar Pk
                $sentencia->bindParam(1, $empresa->razon_social);
                $sentencia->bindParam(2, $empresa->direccion);
                $sentencia->bindParam(3, $empresa->cp);
                $sentencia->bindParam(4, $empresa->rfc);
                // Retornar en el ultimo id insertado
                if ($sentencia->execute()) {
                    http_response_code(201);
                    $respuesta[self::RAZON_SOCIAL] = $empresa->razon_social;
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

    public static function updateEmpresa($auto)
    {
        if ($auto) {
            try {
                $pdo = ConexionBD::obtenerInstancia()->obtenerBD();
                // Sentencia Update //clave, razon_social, direccion, cp, rfc
                $comando = 'UPDATE ' . self::NOMBRE_TABLA . ' SET '
                    . self::RAZON_SOCIAL . '=?,'
                    . self::DIRECCION . '=?,'
                    . self::CP . '=?,'
                    . self::RFC . '=? WHERE ' . self::CLAVE . "=?";
                // Preparar la sentencia
                $sentencia = $pdo->prepare($comando);
                // Generar Pk
                $sentencia->bindParam(5, $auto->clave);
                $sentencia->bindParam(1, $auto->razon_social);
                $sentencia->bindParam(2, $auto->direccion);
                $sentencia->bindParam(3, $auto->cp);
                $sentencia->bindParam(4, $auto->rfc);
                // Retornar en el último id insertado

                if ($sentencia->execute()) {
                    http_response_code(201);
                    $respuesta[self::CLAVE] = $auto->clave;
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

    public static function getEmpresa($placa = null)
    {
        try {
            if ($placa) {
                $comando = "SELECT * FROM " . self::NOMBRE_TABLA . " WHERE " .self::CLAVE." =?";
                // Preparar sentencia
                $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);
                // Ligar idUsuario
                $sentencia->bindParam(1, $placa);
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

    public static function deleteEmpresa($placa)
    {
        try {
            // Sentencia DELETE
            $comando = "DELETE FROM " . self::NOMBRE_TABLA .
                " WHERE " . self::CLAVE . "=?";
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