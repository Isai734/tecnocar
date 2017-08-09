<?php

class cita
{
    const ID = "id";
    const TITLE = "title";
    const BODY = "body";
    const URL = "url";
    const CLASE = "class";
    const START = "start";
    const END = "end";
    const INICIO_NORMAL = "inicio_normal";
    const FINAL_NORMAL = "final_normal";
    const AUTO_PLACA = "auto_placa";
    const EMPRESA_CLAVE = "empresa_clave";
    const CLIENTE_CLAVE = "cliente_clave";
    const STATUS = "status";
    const NOMBRE_TABLA = "cita";

//id, title, body, url, class, start, end, inicio_normal, final_normal, auto_placa, empresa_clave, cliente_clave
    public static function post()
    {
        $payload = file_get_contents('php://input');
        $payload = json_decode($payload);
        return self::createCita($payload);
    }

    public static function get($request)
    {
        return self::getCitaCliente(isset($request[0]) ? $request[0] : null);
    }

    public static function put($request){
        if (isset($request[0])) {
            $payload = file_get_contents('php://input');
            $payload = json_decode($payload);
            return self::createCita($payload);
        } else {
            throw new ExcepcionApi(
                Constantes::ESTADO_MALA_SINTAXIS,
                utf8_encode("Falta Id"), 422);
        }
    }

    public static function delete($request)
    {
        if (!empty($request[0])) {
            self::deleteCita($request[0]);
        } else {
            throw new ExcepcionApi(Constantes::ESTADO_MALA_SINTAXIS, "Falta id", 422);
        }
        //return self::getPersonas(isset($request[0]) ? $request[0] : null);
    }

    public static function createCita($auto = null)
    {
        if ($auto) {
            try {
                $pdo = ConexionBD::obtenerInstancia()->obtenerBD();
                $pdo->beginTransaction();

                // Sentencia INSERT
                $comando = 'INSERT INTO ' . self::NOMBRE_TABLA . '('
                    . self::TITLE . ','
                    . self::BODY . ','
                    . self::URL . ','
                    . self::CLASE . ','
                    . self::START . ','
                    . self::END . ','
                    . self::INICIO_NORMAL . ','
                    . self::FINAL_NORMAL . ','
                    . self::AUTO_PLACA . ','
                    . self::EMPRESA_CLAVE . ','
                    . self::CLIENTE_CLAVE . ') VALUES(?,?,?,?,?,?,?,?,?,?,?)';
                // Preparar la sentencia
                $sentencia = $pdo->prepare($comando);
                // Generar Pk
                $sentencia->bindParam(1, $auto->title);
                $sentencia->bindParam(2, $auto->body);
                $sentencia->bindParam(3, $auto->url);
                $sentencia->bindParam(4, $auto->class);
                $sentencia->bindParam(5, $auto->start);
                $sentencia->bindParam(6, $auto->end);
                $sentencia->bindParam(7, $auto->inicio_normal);
                $sentencia->bindParam(8, $auto->final_normal);
                $sentencia->bindParam(9, $auto->auto_placa);
                $sentencia->bindParam(10, $auto->empresa_clave);
                $sentencia->bindParam(11, $auto->cliente_clave);
                // Retornar en el ultimo id insertado
                if ($sentencia->execute()) {

                    return self::setUrl($pdo,self::getMaxId());
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

    public static function setUrl($pdo,$id)
    {
        include '../clientes/citas/config.php';
        $link = $base_url . "descripcion_evento.php?id=" . ($id);

        try {

            $comando = 'UPDATE ' . self::NOMBRE_TABLA . ' SET '
                . self::URL . '=? WHERE ' . self::ID . " =?";
            // Preparar la sentencia
            $sentencia = $pdo->prepare($comando);
            // Generar Pk
            $sentencia->bindParam(1, $link);
            $sentencia->bindParam(2, $id);
            // Retornar en el último id insertado

            if ($sentencia->execute()) {
                http_response_code(201);
                $respuesta['estado'] = Constantes::CODIGO_EXITO;
                $respuesta['mensaje'] = utf8_encode("Registro actualizado con Exito¡¡");
                $pdo->commit();
                return $respuesta;
            }else{
                $pdo->rollBack();
                throw new ExcepcionApi(Constantes::ESTADO_ERROR_BD, "Fallo al realizar el registro");
            }
        } catch (PDOException $e) {
            throw new ExcepcionApi(Constantes::ESTADO_ERROR_BD, $e->getMessage());
        }

    }

    public static function updateCita($auto)
    {
        if ($auto) {
            try {
                $pdo = ConexionBD::obtenerInstancia()->obtenerBD();
                // Sentencia
//id, title, body, url, class, start, end, inicio_normal, final_normal, auto_placa, empresa_clave, cliente_clave
                $comando = 'UPDATE ' . self::NOMBRE_TABLA . ' SET '
                    . self::TITLE . '=?,'
                    . self::BODY . '=?,'
                    . self::URL . '=?,'
                    . self::CLASE . '=?,'
                    . self::START . '=?,'
                    . self::END . '=?,'
                    . self::INICIO_NORMAL . '=?,'
                    . self::FINAL_NORMAL . '=?,'
                    . self::AUTO_PLACA . '=?,'
                    . self::EMPRESA_CLAVE . '=?,'
                    . self::CLIENTE_CLAVE . '=? WHERE ' . self::ID . " =?";
                // Preparar la sentencia
                $sentencia = $pdo->prepare($comando);
                // Generar Pk
                $sentencia->bindParam(1, $auto->title);
                $sentencia->bindParam(2, $auto->body);
                $sentencia->bindParam(3, $auto->url);
                $sentencia->bindParam(4, $auto->class);
                $sentencia->bindParam(5, $auto->start);
                $sentencia->bindParam(6, $auto->end);
                $sentencia->bindParam(7, $auto->inicio_normal);
                $sentencia->bindParam(8, $auto->final_normal);
                $sentencia->bindParam(9, $auto->auto_placa);
                $sentencia->bindParam(10, $auto->empresa_clave);
                $sentencia->bindParam(11, $auto->cliente_clave);
                $sentencia->bindParam(12, $auto->id);
                // Retornar en el último id insertado

                if ($sentencia->execute()) {
                    http_response_code(201);
                    $respuesta[self::ID] = $auto->id;
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


    public static function getMaxId()
    {
        try {
            $comando = "SELECT MAX(id) AS id FROM " . self::NOMBRE_TABLA;
            // Preparar sentencia
            $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);
            // Ligar idUsuario
            $sentencia->bindParam(1, $idPersona);

            // Ejecutar sentencia preparada
            if ($sentencia->execute()) {
                $respuesta = $sentencia->fetch(PDO::FETCH_ASSOC);
                return $respuesta['id'];
            } else
                throw new ExcepcionApi(Constantes::ESTADO_ERROR, "Se ha producido un error");

        } catch (PDOException $e) {
            throw new ExcepcionApi(Constantes::ESTADO_ERROR_BD, $e->getMessage());
        }
    }

    public static function getCitaPersona($idPersona = null)
    {
        try {
            if ($idPersona) {
                $comando = "SELECT * FROM " . self::NOMBRE_TABLA . "," . auto::NOMBRE_TABLA . " WHERE " . self::AUTO_PLACA . " = " . auto::PLACA . " AND " . self::CLIENTE_CLAVE . "=?";

                // Preparar sentencia
                $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);
                // Ligar idUsuario
                $sentencia->bindParam(1, $idPersona);
            } else {
                $comando = "SELECT * FROM " . self::NOMBRE_TABLA . " WHERE " . self::AUTO_PLACA . " = " . auto::PLACA;
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

    public static function getCitaCliente($id = null)
    {
        try {
            if ($id) {
                $comando = "SELECT * FROM " . self::NOMBRE_TABLA . " A," . auto::NOMBRE_TABLA . " WHERE " . self::AUTO_PLACA . " = " . auto::PLACA . " AND A." . self::CLIENTE_CLAVE . "=?";
                // Preparar sentencia
                $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);
                // Ligar idUsuario
                $sentencia->bindParam(1, $id);
            } else {
                $comando = "SELECT * FROM " . self::NOMBRE_TABLA . "," . auto::NOMBRE_TABLA . " WHERE " . self::AUTO_PLACA . " = " . auto::PLACA;

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

    public static function getCita($id = null)
    {
        try {
            if ($id) {
                $comando = "SELECT * FROM " . self::NOMBRE_TABLA . " WHERE " . self::ID . "=?";

                // Preparar sentencia
                $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);
                // Ligar idUsuario
                $sentencia->bindParam(1, $id);
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

    public static function deleteCita($id)
    {
        try {
            // Sentencia DELETE
            $comando = "DELETE FROM " . self::NOMBRE_TABLA .
                " WHERE " . self::ID . "=?";
            // Preparar la sentencia
            $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);
            $sentencia->bindParam(1, $id);
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