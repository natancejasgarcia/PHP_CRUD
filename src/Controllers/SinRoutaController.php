<?php

namespace Controllers;

use Core\View;

class SinRoutaController
{
    function sinRouta()
    {
        $_SESSION['message'] = "";
        View::render('sinRouta/404', ["title" => "404"]);
    }
}
