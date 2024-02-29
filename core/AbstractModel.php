<?php

namespace Core;

// Definición de una clase abstracta llamada 'AbstractModel'.
abstract class AbstractModel
{
    // Propiedad privada y estática que almacenará la instancia de PDO.
    static private $pdo;

    // Método estático para asignar la instancia de PDO a la propiedad estática.
    // Se utiliza para configurar la conexión a la base de datos para todos los modelos que hereden de esta clase.
    static function setPdo(\Pdo $pdo)
    {
        self::$pdo = $pdo;
    }

    // Método estático para obtener la instancia de PDO.
    // Este método permite a los modelos que hereden acceder a la conexión de la base de datos para realizar operaciones.
    static function getPdo(): \Pdo
    {
        return self::$pdo;
    }
}
