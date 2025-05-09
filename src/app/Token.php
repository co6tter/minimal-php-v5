<?php

namespace MyApp;

class Token
{
    public static function create(): void
    {
        if (!isset($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
    }

    public static function validate(): void
    {
        if (empty($_POST['token']) || $_SESSION['token'] !== filter_input(INPUT_POST, 'token')) {
            exit('Invalid post request');
        }
    }
}
