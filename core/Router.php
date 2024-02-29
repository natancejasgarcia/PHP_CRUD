<?php

namespace Core;

class Router
{
    // Array asociativo para almacenar las rutas. Cada método HTTP (GET, POST, etc.) tiene su propio sub-array de rutas.
    protected $routes = [];

    // Función para añadir una ruta al array de rutas.
    // $method es el método HTTP, $url es la ruta de la URL y $target es el controlador y el método que se debe llamar.
    public function addRoute(string $method, string $url, $target)
    {
        $this->routes[$method][$url] = $target;
    }

    // Función para buscar y ejecutar la lógica del controlador asociada con la URL y el método HTTP de la solicitud actual.
    public function matchRoute()
    {
        $method = $_SERVER['REQUEST_METHOD']; // Obtiene el método HTTP de la solicitud actual.
        $urlComponents = parse_url($_SERVER['REQUEST_URI']); // Parsea la URL para separar los componentes.
        $urlPath = $urlComponents['path']; // Obtiene solo la parte de la ruta de la URL.
    

        // Verifica si existen rutas definidas para el método HTTP de la solicitud.
        if (isset($this->routes[$method])) {
            // Itera sobre las rutas definidas para el método HTTP.
            foreach ($this->routes[$method] as $routeUrl => $target) {
                // Convierte la ruta definida a una expresión regular para permitir parámetros dinámicos.
                $pattern = preg_replace('/\/:([^\/]+)/', '/(?P<$1>[^/]+)', $routeUrl);

                // Comprueba si la URL de la solicitud coincide con la expresión regular de la ruta.
                if (preg_match('#^' . $pattern . '$#', $urlPath, $matches)) {
                    // Filtra los parámetros capturados en la URL.
                    $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                    // Si el objetivo es un array y contiene exactamente 2 elementos, se asume que es [nombre del controlador, método]
                    if (is_array($target) && count($target) === 2) {
                        [$controllerName, $methodName] = $target;

                        // Verifica si la clase del controlador y el método existen.
                        if (class_exists($controllerName) && method_exists($controllerName, $methodName)) {
                            // Crea una instancia del controlador y llama al método con los parámetros.
                            $controllerInstance = new $controllerName();
                            call_user_func_array([$controllerInstance, $methodName], $params);
                        } else {
                            // Lanza una excepción si la clase o el método no existen.
                            throw new \Exception("Método $methodName no esta dentro del controlador $controllerName");
                        }
                    } elseif (is_callable($target)) {
                        // Si el objetivo es una función anónima o un callable, lo llama directamente.
                        call_user_func_array($target, $params);
                    } else {
                        // Lanza una excepción si el objetivo no es válido.
                        throw new \Exception("Routa equivocada");
                    }
                    return;
                }
            }
        }
        // Lanza una excepción si ninguna ruta coincide.
        //throw new \Exception('Routa equivocada');
        header('Location: /404');
        exit(404);
    }
}
