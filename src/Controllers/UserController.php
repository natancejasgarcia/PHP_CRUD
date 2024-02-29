<?php

namespace Controllers;

use Core\View;

class UserController
{
    function index()
    {
        View::render("user/index");
    }
}
