<?php

namespace Controllers;

use Core\View;
use Models\UserModel;

class HomeController
{
    private UserModel $userModel;

    function __construct()
    {
        $this->userModel = new UserModel();
    }

    function index()
    {
        View::render("home/index", ["title" => "Titre"]);
    }

    function login()
{
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    $user = $this->userModel->getUserByEmail($email, $password);
    if (!password_verify($password, $user['password'])) {
        $_SESSION['message'] = "Usuario no conocido";
        header('Location: /');
        exit(404);
    } else {
        if ($user['is_admin']) {
            header('Location: /admin');
        } else {
            // Si la ruta solicitada es /verify/verification, redirige a esa ubicación después de iniciar sesión.
            if ($_SERVER['REQUEST_URI'] === '/verify/verification') {
                header('Location: /verify/verification');
            } else {
                $_SESSION['user'] = $user['name'];
                header('Location: /user');
            }
        }
    }
}

    public function logout() {
        // Vaciar todas las variables de sesión
        $_SESSION = [];

        // Destruir la sesión
        session_destroy();

        // Redirigir al usuario a la página de inicio de sesión o página principal
        header('Location: /');
        exit();
    }

}
