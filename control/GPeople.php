<?php


class GPeople
{

    const ID_PERSONA = "clave";
    const NOMBRE_TABLA = "persona";
    const ID_SOLICITUD = "Id_Solicitud";
    const TIPO = "tipo";
    const NOMBRE = "nombre";
    const A_PATERNO = "apellido_paterno";
    const A_MATERNO = "apellido_materno";
    const TELEFONO = "telefono";
    const DIRECCION = "direccion";
    const ID_DEPARTAMENTO = "Id_Departamento";
    const CONTRASENIA = "Contrasenia";
    const EMAIL = "email";
    const CODIGO_POSTAL = "cp";
    const RFC = "rfc";
    const ESPECIALIDAD = "especialidad";
    const STATUS = "status";

    public static function post()
    {
        $payload = file_get_contents('php://input');
        $payload = json_decode($payload);

        $resultado = self::createPersona($payload);
        if ($resultado['estado'] == Constantes::CODIGO_EXITO) {
            $resultado = login::createLogin($payload);
        }
        return $resultado;
    }

    public static function get($request)
    {
        return self::getPersonas(isset($request[0]) ? $request[0] : null);
    }

    public static function put($request)
    {
        if (isset($request[0])) {
            $payload = file_get_contents('php://input');
            $payload = json_decode($payload);
            return self::createPersona($payload);
        } else {
            throw new ExcepcionApi(
                Constantes::ESTADO_MALA_SINTAXIS,
                utf8_encode("Falta Id"), 422);
        }
    }

    public static function delete($request)
    {
        if (!empty($request[0])) {
            self::deletePersona($request[0]);
        } else {
            throw new ExcepcionApi(Constantes::ESTADO_MALA_SINTAXIS, "Falta id", 422);
        }
        //return self::getPersonas(isset($request[0]) ? $request[0] : null);
    }

    public static function createPersona($persona = null)
    {
        if ($persona) {
            try {
                $pdo = ConexionBD::obtenerInstancia()->obtenerBD();
                $pdo->beginTransaction();
                $sentencia = null;
                switch ($persona->tipo) {
                    // Sentencia INSERT
                    case "CLIENTE":
                        $comando = 'INSERT INTO ' . self::NOMBRE_TABLA . '('
                            . self::NOMBRE . ','
                            . self::A_PATERNO . ','
                            . self::A_MATERNO . ','
                            . self::TELEFONO . ','
                            . self::DIRECCION . ','
                            . self::EMAIL . ','
                            . self::CODIGO_POSTAL . ','
                            . self::RFC . ','
                            . self::TIPO . ') VALUES(?,?,?,?,?,?,?,?,?)';
                        // Preparar la sentencia
                        $sentencia = $pdo->prepare($comando);
                        // Generar Pk
                        $sentencia->bindParam(1, $persona->nombre);
                        $sentencia->bindParam(2, $persona->apellido_paterno);
                        $sentencia->bindParam(3, $persona->apellido_materno);
                        $sentencia->bindParam(4, $persona->telefono);
                        $sentencia->bindParam(5, $persona->direccion);
                        $sentencia->bindParam(6, $persona->email);
                        $sentencia->bindParam(7, $persona->cp);
                        $sentencia->bindParam(8, $persona->rfc);
                        $sentencia->bindParam(9, $persona->tipo);
                        break;
                    case "MECANICO":
                        $comando = 'INSERT INTO ' . self::NOMBRE_TABLA . '('
                            . self::NOMBRE . ','
                            . self::A_PATERNO . ','
                            . self::A_MATERNO . ','
                            . self::TELEFONO . ','
                            . self::DIRECCION . ','
                            . self::ESPECIALIDAD . ','
                            . self::TIPO . ','
                            . self::STATUS . ') VALUES(?,?,?,?,?,?,?,?)';
                        // Preparar la sentencia
                        $sentencia = $pdo->prepare($comando);
                        // Generar Pk clave, nombre, apellido_paterno, apellido_materno, telefono, direccion, email, cp, rfc, especialidad, tipo, status
                        $sentencia->bindParam(1, $persona->nombre);
                        $sentencia->bindParam(2, $persona->apellido_paterno);
                        $sentencia->bindParam(3, $persona->apellido_materno);
                        $sentencia->bindParam(4, $persona->telefono);
                        $sentencia->bindParam(5, $persona->direccion);
                        $sentencia->bindParam(6, $persona->especialidad);
                        $sentencia->bindParam(7, $persona->tipo);
                        $sentencia->bindParam(8, $persona->status);
                        break;
                }

                // Retornar en el ultimo id insertado
                if ($sentencia->execute()) {
                    $idPersona = self::getIdPersona($persona->rfc);
                    return self::createLogin($pdo, $persona, $idPersona);
                }else{
                    $respuesta['estado'] = Constantes::ESTADO_CREACION_FALLIDA;
                    $respuesta['mensaje'] = utf8_encode("Fallo al registrar");
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


    public static function createLogin($pdo, $login = null, $idPersona)
    {
        if ($login) {
            try {
                // Sentencia INSERT
                $comando = 'INSERT INTO ' . login::NOMBRE_TABLA . '('
                    . login::USUARIO . ','
                    . login::CONTRASENIA . ','
                    . login::PERSONA_CLAVE . ') VALUES(?,?,?)';

                // Preparar la sentencia
                $sentencia = $pdo->prepare($comando);
                // Generar Pk usuario, contrasenia, persona_clave
                $sentencia->bindParam(1, $login->usuario);
                $sentencia->bindParam(2, $login->contrasenia);
                $sentencia->bindParam(3, $idPersona);

                // Retornar en el ultimo id insertado
                if ($sentencia->execute()) {
                    http_response_code(201);
                    $respuesta[login::USUARIO] = $login->usuario;
                    $respuesta['estado'] = $idPersona;
                    $respuesta['mensaje'] = utf8_encode("Registrado con Exito¡¡");
                    $pdo->commit();
                    return $respuesta;
                }
                else{
                    $respuesta['estado'] = Constantes::ESTADO_CREACION_FALLIDA;
                    $respuesta['mensaje'] = utf8_encode("Fallo al registrar");
                    return $respuesta;
                    $pdo->rollBack();
                }
            } catch (PDOException $e) {
                $pdo->rollBack();
                throw new ExcepcionApi(Constantes::ESTADO_ERROR_BD, $e->getMessage());
            }
        } else {
            throw new ExcepcionApi(
                Constantes::ESTADO_MALA_SINTAXIS,
                utf8_encode("Error en existencia o sintaxis de parámetros"));
        }
    }


    function isUniqueUser($user)
    {
        try {
            $pdo = ConexionBD::obtenerInstancia()->obtenerBD();
            $comando = "SELECT * FROM " . self::NOMBRE_TABLA .
                " WHERE " . self::RFC . "=?";
            // Preparar sentencia
            $sentencia = $pdo->prepare($comando);
            // Ligar idUsuario
            $sentencia->bindParam(1, $rfc);
            // Ejecutar sentencia preparada
            if ($sentencia->execute()) {
                $respuesta = $sentencia->fetch(PDO::FETCH_ASSOC);
                return $respuesta[self::ID_PERSONA];
            } else
                $pdo->beginTransaction();
            $pdo->rollBack();
            throw new ExcepcionApi(Constantes::ESTADO_ERROR, "Se ha producido un error");
        } catch (PDOException $e) {
            throw new ExcepcionApi(Constantes::ESTADO_ERROR_BD, $e->getMessage());
        }
    }

    private static function getIdPersona($rfc)
    {

        try {
            $pdo = ConexionBD::obtenerInstancia()->obtenerBD();
            $comando = "SELECT " . self::ID_PERSONA . " FROM " . self::NOMBRE_TABLA .
                " WHERE " . self::RFC . "=?";
            // Preparar sentencia
            $sentencia = $pdo->prepare($comando);
            // Ligar idUsuario
            $sentencia->bindParam(1, $rfc);
            // Ejecutar sentencia preparada
            if ($sentencia->execute()) {
                $respuesta = $sentencia->fetch(PDO::FETCH_ASSOC);
                return $respuesta[self::ID_PERSONA];
            } else
                $pdo->beginTransaction();
            $pdo->rollBack();
            throw new ExcepcionApi(Constantes::ESTADO_ERROR, "Se ha producido un error");
        } catch (PDOException $e) {
            throw new ExcepcionApi(Constantes::ESTADO_ERROR_BD, $e->getMessage());
        }
    }

    public static function updatePersona($persona)
    {
        if ($persona) {
            try {
                $pdo = ConexionBD::obtenerInstancia()->obtenerBD();
                $pdo->beginTransaction();
                // Sentencia INSERT clave, nombre, apellido_paterno, apellido_materno, telefono, direccion, email, cp, rfc, especialidad, tipo, status
                $comando = 'UPDATE ' . self::NOMBRE_TABLA . ' SET '
                    . self::NOMBRE . '=?,'
                    . self::A_PATERNO . '=?,'
                    . self::A_MATERNO . '=?,'
                    . self::TELEFONO . '=?,'
                    . self::DIRECCION . '=?,'
                    . self::EMAIL . '=?,'
                    . self::CODIGO_POSTAL . '=?,'
                    . self::RFC . '=?,'
                    . self::ESPECIALIDAD . '=?,'
                    . self::STATUS . '=?  WHERE ' . self::ID_PERSONA . " =?";
                // Preparar la sentencia
                $sentencia = $pdo->prepare($comando);
                // Generar Pk
                $sentencia->bindParam(1, $persona->nombre);
                $sentencia->bindParam(2, $persona->apellido_paterno);
                $sentencia->bindParam(3, $persona->apellido_materno);
                $sentencia->bindParam(4, $persona->telefono);
                $sentencia->bindParam(5, $persona->direccion);
                $sentencia->bindParam(6, $persona->email);
                $sentencia->bindParam(7, $persona->cp);
                $sentencia->bindParam(8, $persona->rfc);
                $sentencia->bindParam(9, $persona->especialidad);
                $sentencia->bindParam(10, $persona->status);
                $sentencia->bindParam(11, $persona->clave);
                // Retornar en el último id insertado

                if ($sentencia->execute()) {
                    return self::updateLogin($pdo,$persona);
                }else{
                    throw new ExcepcionApi(
                        Constantes::ESTADO_MALA_SINTAXIS,
                        utf8_encode("Error al intetar actualizar"), 403);
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

    public static function updateLogin($pdo,$login)
    {
        if ($login) {
            try {
                // Sentencia INSERT clave, nombre, apellido_paterno, apellido_materno, telefono, direccion, email, cp, rfc, especialidad, tipo, status
                $comando = 'UPDATE ' . login::NOMBRE_TABLA . ' SET '
                    . login::CONTRASENIA . ' =?, '
                    . login::USUARIO . ' =? WHERE ' . login::PERSONA_CLAVE . " =?";
                // Preparar la sentencia
                $sentencia = $pdo->prepare($comando);
                // Generar Pk
                $sentencia->bindParam(1, $login->contrasenia);
                $sentencia->bindParam(2, $login->usuario);
                $sentencia->bindParam(3, $login->clave);
                // Retornar en el último id insertado

                if ($sentencia->execute()) {
                    http_response_code(201);
                    $respuesta[login::USUARIO] = $login->usuario;
                    $respuesta['estado'] = Constantes::CODIGO_EXITO;
                    $respuesta['mensaje'] = utf8_encode("Actualizado con exito");
                    $pdo->commit();
                    return $respuesta;
                }
                $pdo->rollBack();
            } catch (PDOException $e) {
                $pdo->rollBack();
                throw new ExcepcionApi(Constantes::ESTADO_ERROR_BD, $e->getMessage());
            }
        } else {
            $pdo->rollBack();
            throw new ExcepcionApi(
                Constantes::ESTADO_MALA_SINTAXIS,
                utf8_encode("Falta Id"), 422);
        }
    }


    public static function getPersonas($idPersona = null)
    {
        try {
            if ($idPersona) {
                if ($idPersona == 'CLIENTE' | $idPersona == 'MECANICO') {
                    $comando = "SELECT * FROM " . self::NOMBRE_TABLA .
                        " WHERE " . self::TIPO . "=?";
                } else {
                    $comando = "SELECT * FROM " . self::NOMBRE_TABLA .
                        " WHERE " . self::ID_PERSONA . "=?";
                }
                // Preparar sentencia
                $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);
                // Ligar idUsuario
                $sentencia->bindParam(1, $idPersona);
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
                $respuesta['mensaje'] = utf8_encode("REcursos Obtenidos");
                return $respuesta;
            } else
                throw new ExcepcionApi(Constantes::ESTADO_ERROR, "Se ha producido un error");

        } catch (PDOException $e) {
            throw new ExcepcionApi(Constantes::ESTADO_ERROR_BD, $e->getMessage());
        }
    }

    public static function deletePersona($idPersona)
    {
        try {
            // Sentencia DELETE
            $comando = "DELETE FROM " . self::NOMBRE_TABLA .
                " WHERE " . self::ID_PERSONA . "=?";
            // Preparar la sentencia
            $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);
            $sentencia->bindParam(1, $idPersona);
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