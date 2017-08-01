<?php

class producto
{
    const CLAVE = "clave";
    const NOMBRE = "nombre";
    const DESCRIPCCION = "descripccion";
    const PRECIO_COMPRA = "precio_compra";
    const PRECIO_VENTA = "precio_venta";
    const PROVEEDOR_CLAVE = "proveedor_clave";
    const CANTIDAD = "cantidad";
    const NOMBRE_TABLA = "producto_refaccion";

    //clave, nombre, descripccion, precio_compra, precio_venta, proveedor_clave
    public static function post()
    {
        $payload = file_get_contents('php://input');
        $payload = json_decode($payload);
        return self::createEmpresa($payload);
    }

    public static function get($request)
    {
        return self::getProducto(isset($request[0]) ? $request[0] : null);
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
            self::deleteProducto($request[0]);
        } else {
            throw new ExcepcionApi(Constantes::ESTADO_MALA_SINTAXIS, "Falta id", 422);
        }
        //return self::getPersonas(isset($request[0]) ? $request[0] : null);
    }

    public static function getProductosOrden($odren)
    {
        try {
                $comando = "select * from producto_refaccion,detalle_orden where 
producto_refaccion.clave=detalle_orden.producto_refaccion_clave and detalle_orden.orden_numero_orden=?";
                // Preparar sentencia
                $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);
                // Ligar idUsuario
                $sentencia->bindParam(1, $odren);

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

    public static function createProducto($producto = null)
    {
        if ($producto) {
            try {
                $pdo = ConexionBD::obtenerInstancia()->obtenerBD();
                // Sentencia INSERT
                $comando = 'INSERT INTO ' . self::NOMBRE_TABLA . '('
                    . self::NOMBRE . ','
                    . self::DESCRIPCCION . ','
                    . self::PRECIO_COMPRA . ','
                    . self::PRECIO_VENTA . ','
                    . self::CANTIDAD . ','
                    . self::PROVEEDOR_CLAVE . ') VALUES(?,?,?,?,?,?)';
                // Preparar la sentencia
                $sentencia = $pdo->prepare($comando);
                // Generar Pk
                $sentencia->bindParam(1, $producto->nombre);
                $sentencia->bindParam(2, $producto->descripccion);
                $sentencia->bindParam(3, $producto->precio_compra);
                $sentencia->bindParam(4, $producto->precio_venta);
                $sentencia->bindParam(5, $producto->cantidad);
                $sentencia->bindParam(6, $producto->proveedor_clave);
                // Retornar en el ultimo id insertado
                if ($sentencia->execute()) {
                    http_response_code(201);
                    $respuesta[self::NOMBRE] = $producto->nombre;
                    $respuesta['estado'] = Constantes::CODIGO_EXITO;
                    $respuesta['mensaje'] = utf8_encode("Registro creado con Exito");
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

    public static function updateProducto($producto)
    {
        if ($producto) {
            try {
                $pdo = ConexionBD::obtenerInstancia()->obtenerBD();
                // Sentencia Update clave, nombre, descripccion, precio_compra, precio_venta, proveedor_clave
                $comando = 'UPDATE ' . self::NOMBRE_TABLA . ' SET '
                    . self::NOMBRE . '=?,'
                    . self::DESCRIPCCION . '=?,'
                    . self::PRECIO_COMPRA . '=?,'
                    . self::PRECIO_VENTA . '=?,'
                    . self::PROVEEDOR_CLAVE . '=? WHERE ' . self::CLAVE . "=?";
                // Preparar la sentencia
                $sentencia = $pdo->prepare($comando);
                // Generar Pk
                $sentencia->bindParam(6, $producto->clave);
                $sentencia->bindParam(1, $producto->nombre);
                $sentencia->bindParam(2, $producto->descripccion);
                $sentencia->bindParam(3, $producto->precio_compra);
                $sentencia->bindParam(4, $producto->precio_venta);
                $sentencia->bindParam(5, $producto->proveedor_clave);
                // Retornar en el último id insertado

                if ($sentencia->execute()) {
                    http_response_code(201);
                    $respuesta[self::CLAVE] = $producto->clave;
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

    public static function getProducto($clave = null)
    {
        try {
            if ($clave) {
                $comando = "SELECT "

                    . self::NOMBRE_TABLA . "." . self::CLAVE . ','
                    . self::NOMBRE . ','
                    . self::DESCRIPCCION . ','
                    . self::PRECIO_COMPRA . ','
                    . self::PRECIO_VENTA . ','
                    . self::CANTIDAD . ','
                    . empresa::RAZON_SOCIAL . ','
                    . self::PROVEEDOR_CLAVE . " FROM " . self::NOMBRE_TABLA . ", " . empresa::NOMBRE_TABLA
                    . " WHERE " . self::NOMBRE_TABLA . "." . self::PROVEEDOR_CLAVE . " = " . empresa::NOMBRE_TABLA . "." . empresa::CLAVE
                    . " AND " . self::NOMBRE_TABLA . "." . self::CLAVE . " =?";
                // Preparar sentencia
                $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);
                // Ligar idUsuario
                $sentencia->bindParam(1, $clave);
            } else {
                $comando = "SELECT "
                    . self::NOMBRE_TABLA . "." . self::CLAVE . ','
                    . self::NOMBRE . ','
                    . self::DESCRIPCCION . ','
                    . self::PRECIO_COMPRA . ','
                    . self::PRECIO_VENTA . ','
                    . self::CANTIDAD . ','
                    . empresa::RAZON_SOCIAL . ','
                    . self::PROVEEDOR_CLAVE . " FROM " . self::NOMBRE_TABLA . ", " . empresa::NOMBRE_TABLA
                    . " WHERE " . self::NOMBRE_TABLA . "." . self::PROVEEDOR_CLAVE . " = " . empresa::NOMBRE_TABLA . "." . empresa::CLAVE;
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

    public static function deleteProducto($clave)
    {
        try {
            // Sentencia DELETE
            $comando = "DELETE FROM " . self::NOMBRE_TABLA .
                " WHERE " . self::CLAVE . "=?";
            // Preparar la sentencia
            $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);
            $sentencia->bindParam(1, $clave);
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