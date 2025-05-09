<?php

namespace MyApp;

class Utils
{
    public static function h(string $str): string
    {
        return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
    }
}
