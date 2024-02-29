<?php

namespace Controllers;

use Models\UserModel;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Core\View;

class RegisterController
{
    private UserModel $userModel;

    function __construct()
    {
        $this->userModel = new UserModel();
    }
    public function register()
    {
        $nom = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        $code = rand(100000, 999999); // Para un código numérico de 6 dígitos
    
        // Intenta crear el usuario y guardar el código de verificación
        $userId = $this->userModel->createUser($nom, $email, $password);
        if ($userId) {
            // Guarda el código de verificación para el usuario recién creado
            $this->userModel->saveVerificationCode($userId, $code);
    
            // Envía el correo electrónico con el código de verificación
            $this->sendEmail($nom, $email, $code); // Asegúrate de que sendEmail acepte el código como parámetro
    
            $_SESSION['message'] = "Usuario creado! Por favor, verifica tu correo electrónico.";
            
            // Redirige al usuario a la página de verificación
            header('Location: /verify/verification');
        } else {
            $_SESSION['message'] = "Usuario no creado";
            // Considera redirigir a una página de error o volver al formulario de registro
            header('Location: /');
        }
        exit();
    }
    

    private function sendEmail($nom, $email, $code)
    {
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);
        try {
            // Configuración del servidor
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Servidor SMTP
            $mail->SMTPAuth = true;
            $mail->Username = 'natancg17@gmail.com'; // SMTP username
            $mail->Password = 'iccp ixpd ctib wgbr'; // SMTP password
            $mail->SMTPSecure = 'tls'; // Habilita encriptación TLS; PHPMailer::ENCRYPTION_SMTPS también aceptado
            $mail->Port = 587; // Puerto TCP para conectarse
        
            // Remitentes y destinatarios
            $mail->setFrom('natancg17@gmail.com', 'CRUD');
            $mail->addAddress($email, $nom ); // Añade un destinatario, reemplaza $usuario->getEmail() y $usuario->getName() con los métodos apropiados de tu clase usuario
        
            // Contenido
            $mail->isHTML(true); // Establece el formato de email a HTML
            $mail->Subject = 'Bienvenido al crud';
            $mail->Body = "Tu código de verificación es: {$code}";
            $mail->AltBody = "Tu código de verificación es: {$code}";            
        
            $mail->send();
            echo 'El mensaje ha sido enviado';
        } catch (Exception $e) {
            echo "El mensaje no pudo ser enviado. Mailer Error: {$email->ErrorInfo}";
        }
    }
    public function verify()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['code'])) {
            $code = $_POST['code'];
    
            // Buscar el usuario por código de verificación
            $userId = $this->userModel->findUserByVerificationCode($code);
    
            if ($userId) {
                // Verificar el código
                if ($this->userModel->verifyCode($userId, $code)) {
                    // Marcar al usuario como verificado
                    $this->userModel->markUserAsVerified($userId);
    
                    // Redirigir al usuario a donde necesite ir después de la verificación
                    header('Location: /user'); // Cambiar esto según la ruta deseada
                    exit();
                } else {
                    $_SESSION['message'] = "Código de verificación incorrecto o expirado";
                }
            } else {
                $_SESSION['message'] = "Error en la verificación: Código no asociado a ningún usuario";
            }
        } else {
            $_SESSION['message'] = "Error en la verificación: Datos de verificación no recibidos";
        }
    
        // Redirigir de vuelta a la página de inicio con un mensaje de error
        header('Location: /verify/verification'); // Cambiar esto según la ruta deseada
        exit();
    }
    
    public function showVerificationForm()
{
    // Renderiza la vista de verificación. Asegúrate de tener el archivo de vista correspondiente en la carpeta de vistas.
    View::render("verify/verification");
}

    
}    