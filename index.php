<?php
session_start(); // Iniciar una nueva sesión o reanudar la existente

require 'vendor/autoload.php'; // Cargar todas las bibliotecas de Composer

// Utilizar los espacios de nombres de las clases que se utilizarán a continuación
use Controllers\AdminController;
use Controllers\HomeController;
use Controllers\RegisterController;
use Controllers\SinRoutaController;
use Controllers\UserController;
use Core\AbstractModel;
use Core\Router;
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Configuración de la base de datos
$pdo = new \PDO("mysql:host=localhost;dbname=proyectophp;charset=utf8mb4", "root", "");
AbstractModel::setPdo($pdo); // Establecer la conexión PDO en el modelo abstracto para que puedan usarla todos los modelos

$router = new Router(); // Crear una nueva instancia del enrutador

// Añadir rutas al enrutador: método, ruta y el controlador con su acción correspondiente
$router->addRoute('GET', '/', [HomeController::class, 'index']); // Ruta para la página de inicio
$router->addRoute('GET', '/user', [UserController::class, 'index']); // Ruta para users no admin
$router->addRoute('GET', '/404', [SinRoutaController::class, 'sinRouta']); // Ruta para la página de inicio
$router->addRoute('POST', '/login', [HomeController::class, 'login']); // Ruta para el proceso de inicio de sesión
$router->addRoute('GET', '/admin', [AdminController::class, 'index']); // Ruta para la página de administración
$router->addRoute('GET', '/admin/delete/:userId', [AdminController::class, 'delete']); // Ruta para eliminar un usuario (se espera un ID de usuario)
$router->addRoute('GET', '/admin/edit/:userId', [AdminController::class, 'edit']); // Ruta para editar un usuario (se espera un ID de usuario)
$router->addRoute('POST', '/admin/edit', [AdminController::class, 'editPost']); // Ruta para procesar la edición de un usuario
$router->addRoute('POST', '/register', [RegisterController::class, 'register']); // Ruta para registrar un nuevo usuario
$router->addRoute('GET', '/admin/addUserForm', [AdminController::class, 'addUserForm']);
$router->addRoute('POST', '/admin/addUserPost', [AdminController::class, 'addUserPost']);
$router->addRoute('GET', '/logout', [HomeController::class, 'logout']);
$router->addRoute('GET', '/verify/verification', [RegisterController::class, 'showVerificationForm']);
$router->addRoute('POST', '/verify/verification', [RegisterController::class, 'verify']);


$router->matchRoute(); // Procesar la solicitud actual y ejecutar la acción del controlador correspondiente a la ruta

