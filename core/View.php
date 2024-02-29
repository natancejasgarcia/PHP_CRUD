<?php

namespace Core;

// Definición de una clase abstracta 'View'.
abstract class View
{
    // Método estático 'render' para renderizar una plantilla HTML.
    // Acepta el nombre de la plantilla y un array opcional de datos que se extraerán y se pasarán a la plantilla.
    static function render(string $template, array $data = [])
    {
        // Si el array de datos no está vacío, extrae las variables para que estén disponibles en la plantilla.
        if (!empty($data)) {
            extract($data);
        }

        // Inicia el almacenamiento en búfer de salida para capturar la salida del script.
        ob_start();

        // Incluye el archivo del encabezado común a todas las vistas.
        include './src/Views/partials/header.php';

        // Construye la ruta hacia el archivo de la plantilla basado en el nombre proporcionado y verifica si existe.
        $templatePath = './src/Views/' . $template . '.php';
        if (file_exists($templatePath)) {
            // Si la plantilla existe, la incluye. Aquí es donde los datos extraídos son utilizados.
            include $templatePath;
        }

        // Incluye el pie de página común a todas las vistas.
        include './src/Views/partials/footer.php';

        // Limpia el búfer de salida y lo imprime. Esto renderiza todo el contenido de la vista.
        echo ob_get_clean();
    }
}
