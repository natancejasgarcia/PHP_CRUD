<?php

namespace Controllers;

use Core\View;
use Models\UserModel;

class AdminController
{
    private UserModel $userModel;

    function __construct()
    {
        $this->userModel = new UserModel();
    }
    public function index()
{
    $currentPage = $_GET['page'] ?? 1;
    $usersPerPage = 10; // Define cuántos usuarios quieres mostrar por página

    $totalUsers = $this->userModel->getTotalUsers();
    $totalPages = ceil($totalUsers / $usersPerPage);

    // Calcular el offset basado en la página actual
    $offset = ($currentPage - 1) * $usersPerPage;

    // Obtener usuarios paginados
    $listeUtilisateurs = $this->userModel->getUsersPaginated($usersPerPage, $offset);

    $html = '';
    foreach ($listeUtilisateurs as $utilisateur) {
        $isAdmin = $utilisateur['is_admin'] ? 'Sí' : 'No';
        $html .= "<tr>
                    <td>" . htmlspecialchars($utilisateur['name']) . "</td>
                    <td>" . htmlspecialchars($utilisateur['email']) . "</td>
                    <td>" . htmlspecialchars($isAdmin) . "</td>
                    <td><a href='/admin/edit/{$utilisateur['id']}' class='btn btn-primary btn-sm'>Editar</a></td>
                    <td><a href='/admin/delete/{$utilisateur['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"¿Estás seguro de querer eliminar este usuario?\");'>Eliminar</a></td>
                  </tr>";
    }

    // Pasar la lista de usuarios y la información de paginación a la vista
    View::render('admin/index', [
        "listeUtilisateurs" => $html,
        "totalPages" => $totalPages,
        "currentPage" => $currentPage
    ]);
}

    

    public function delete($userId)
    {
        if ($this->userModel->deleteCustomer($userId)) {
            $_SESSION['message'] = "Delete OK";
        } else {
            $_SESSION['message'] = "Delete KO";
        }

        header('Location: /admin');
    }

    public function edit($userId)
    {
        $user = $this->userModel->getUserById($userId);
        View::render('admin/edit', [
            "userId" => $userId,
            "name" => $user['name'],
            "password" => $user['password'],
            "email" => $user['email']
        ]);
    }

    public function addUserPost()
    {
        // Extraer y validar los datos del formulario
        $name = htmlspecialchars($_POST['name'] ?? '');
        $email = htmlspecialchars($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $isAdmin = isset($_POST['is_admin']) ? 1 : 0;
    
        // Validaciones adicionales pueden ser realizadas aquí (como validar formato de email, fortaleza de contraseña, etc.)
    
        // Hashear la contraseña
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    
        // Intentar crear el usuario mediante el modelo
        if ($this->userModel->createUser($name, $email, $passwordHash)) {
            // Éxito, establecer un mensaje de éxito y redirigir
            $_SESSION['message'] = "Usuario creado con éxito.";
            header('Location: /admin');
            exit();
        } else {
            // Error, establecer un mensaje de error y redirigir
            $_SESSION['message'] = "Hubo un error al crear el usuario.";
            header('Location: /admin/addUser');
            exit();
        }
    }
    
public function addUserForm()
{
    View::render('admin/addUserForm');
}

    public function editPost()
    {

        if ($this->userModel->editCustomer($_POST['name'], $_POST['password'], $_POST['email'], $_POST['currentEmail'], $_POST['is_admin'])) {
            $_SESSION['message'] = "Edit OK";
        } else {
            $_SESSION['message'] = "Edit KO";
        }

        header('Location: /admin');
    }
}
