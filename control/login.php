<?php

class login
{
    const USUARIO = "usuario";
    const NOMBRE_TABLA = "login";
    const CONTRASENIA = "contrasenia";
    const PERSONA_CLAVE = "persona_clave";

//usuario, contrasenia, persona_clave
    public static function post()
    {
        $payload = file_get_contents('php://input');
        $payload = json_decode($payload);
        return self::createLogin($payload);
    }

    public static function get($request)
    {
        $respuesta = self::getLogin(isset($request[0]) ? $request[0] : null);
        if ($respuesta != null) {
            return $respuesta[self::NOMBRE_TABLA];
        }else{
            throw new ExcepcionApi(
                Constantes::ESTADO_NO_ENCONTRADO,
                utf8_encode("Usuario no registrado"), 404);
        }
    }

    public static function put($request)
    {
        if (isset($request[0])) {
            $payload = file_get_contents('php://input');
            $payload = json_decode($payload);
            return self::createLogin($payload);
        } else {
            throw new ExcepcionApi(
                Constantes::ESTADO_MALA_SINTAXIS,
                utf8_encode("Falta Id"), 422);
        }
    }

    public static function delete($request)
    {
        if (!empty($request[0])) {
            if (self::deleteLogin($request[0]) > 0) {
                http_response_code(200);
                return [
                    "estado" => Constantes::ESTADO_EXITO,
                    "mensaje" => "Registro eliminado correctamente"
                ];
            } else {
                throw new ExcepcionApi(Constantes::ESTADO_NO_ENCONTRADO,
                    "El contacto al que intentas acceder no existe", 404);
            }
        } else {
            throw new ExcepcionApi(Constantes::ESTADO_MALA_SINTAXIS, "Falta id", 422);
        }
        //return self::getPersonas(isset($request[0]) ? $request[0] : null);
    }

    public static function createLogin($login = null)
    {
        if ($login) {
            try {
                $pdo = ConexionBD::obtenerInstancia()->obtenerBD();
                // Sentencia INSERT
                $comando = 'INSERT INTO ' . self::NOMBRE_TABLA . '('
                    . self::USUARIO . ','
                    . self::CONTRASENIA . ','
                    . self::PERSONA_CLAVE . ') VALUES(?,?,?)';

                // Preparar la sentencia
                $sentencia = $pdo->prepare($comando);
                // Generar Pk usuario, contrasenia, persona_clave
                $sentencia->bindParam(1, $login->usuario);
                $sentencia->bindParam(2, $login->contrasenia);
                $sentencia->bindParam(3, $login->persona_clave);

                // Retornar en el ultimo id insertado
                if ($sentencia->execute()) {
                    http_response_code(201);
                    $respuesta[self::USUARIO] = $login->usuario;
                    $respuesta['estado'] = Constantes::CODIGO_EXITO;
                    $respuesta['mensaje'] = utf8_encode("Creado com Exito¡¡");
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

    public static function updateLogin($login)
    {
        if ($login) {
            try {
                $pdo = ConexionBD::obtenerInstancia()->obtenerBD();
                // Sentencia INSERT clave, nombre, apellido_paterno, apellido_materno, telefono, direccion, email, cp, rfc, especialidad, tipo, status
                $comando = 'UPDATE ' . self::NOMBRE_TABLA . ' SET '
                    . self::CONTRASENIA . ' =?, '
                    . self::USUARIO . ' =? WHERE ' . self::USUARIO . " =?";
                // Preparar la sentencia
                $sentencia = $pdo->prepare($comando);
                // Generar Pk
                $sentencia->bindParam(1, $login->contrasenia);
                $sentencia->bindParam(2, $login->usuarion);
                $sentencia->bindParam(3, $login->usuario);
                // Retornar en el último id insertado

                if ($sentencia->execute()) {
                    http_response_code(201);
                    $respuesta[self::USUARIO] = $login->usuario;
                    $respuesta['estado'] = Constantes::CODIGO_EXITO;
                    $respuesta['mensaje'] = utf8_encode("Creado com Exito¡¡");
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

    function exist($user)
    {
        try {
            $pdo = ConexionBD::obtenerInstancia()->obtenerBD();
            $comando = "SELECT * FROM " . self::NOMBRE_TABLA .
                " WHERE " . self::USUARIO . "=?";
            // Preparar sentencia
            $sentencia = $pdo->prepare($comando);
            // Ligar idUsuario
            $sentencia->bindParam(1, $user);
            // Ejecutar sentencia preparada
            if ($sentencia->execute()) {
                $respuesta = $sentencia->rowCount();
                return ($respuesta > 0 ? true : false);
            } else
                throw new ExcepcionApi(Constantes::ESTADO_ERROR, "Se ha producido un error");
        } catch (PDOException $e) {
            throw new ExcepcionApi(Constantes::ESTADO_ERROR_BD, $e->getMessage());
        }
    }

    public static function getLogin($usuario = null)
    {
        try {
            if ($usuario) {
                $comando = "SELECT * FROM " . self::NOMBRE_TABLA .
                    " WHERE " . self::USUARIO . "=?";
                // Preparar sentencia
                $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);
                // Ligar idUsuario
                $sentencia->bindParam(1, $usuario);
                if ($sentencia->execute()) {
                    http_response_code(200);
                    $login = $sentencia->fetch(PDO::FETCH_ASSOC);
                    $respuesta[self::NOMBRE_TABLA] = $login;
                    $respuesta['estado'] = Constantes::CODIGO_EXITO;
                    $respuesta['mensaje'] = utf8_encode("Recursos Obtenidos");
                    // echo "count : " . count($login);
                    if ($login == null | count($login) == 0)
                        return null;
                    $respuesta['tipo'] = self::getTipo($login[self::PERSONA_CLAVE]);
                    return $respuesta;
                } else
                    throw new ExcepcionApi(Constantes::ESTADO_ERROR, "Se ha producido un error");
            } else {
                throw new ExcepcionApi(Constantes::ESTADO_URL_INCORRECTA, "Error falta Nombre de Ususario en la url");
            }


        } catch (PDOException $e) {
            throw new ExcepcionApi(Constantes::ESTADO_ERROR_BD, $e->getMessage());
        }
    }

    private static function getTipo($idPersona)
    {
        try {
            //require_once '../control/persona.php';
            //echo "id: " . $idPersona;
            $resultado = null;
            if ($idPersona) {
                $resultado = persona::getPersonas($idPersona)[persona::NOMBRE_TABLA];
            }
            // Ejecutar sentencia preparada
            if (count($resultado) > 0) {
                return $resultado[0][persona::TIPO];
            } else
                throw new ExcepcionApi(Constantes::ESTADO_ERROR, "Se ha producido un error");

        } catch (PDOException $e) {
            throw new ExcepcionApi(Constantes::ESTADO_ERROR_BD, $e->getMessage());
        }
    }

    public static function deleteLogin($idPersona)
    {
        try {
            // Sentencia DELETE
            $comando = "DELETE FROM " . self::NOMBRE_TABLA .
                " WHERE " . self::USUARIO . "=?";
            // Preparar la sentencia
            $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);
            $sentencia->bindParam(1, $idPersona);
            $sentencia->execute();
            return $sentencia->rowCount();
        } catch (PDOException $e) {
            throw new ExcepcionApi(Constantes::ESTADO_ERROR_BD, $e->getMessage());
        }
    }
}