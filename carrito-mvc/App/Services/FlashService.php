<?php

namespace App\Services;

class FlashService {

    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    public static function get($key) {

        if (!isset($_SESSION[$key])) return null;

        $value = $_SESSION[$key];
        unset($_SESSION[$key]);

        return $value;
    }
}