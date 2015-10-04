<?php
/**
 * Created by PhpStorm.
 * User: Evgeni
 * Date: 4.10.2015 ã.
 * Time: 11:39 ÷.
 */

namespace Framework\Helpers;


class Csfr
{
    public static function generate() {
        $token = uniqid(mt_rand(), true);
        $_SESSION['_token'] = $token;
    }

    public static function validate($token) {
        if (isset($_SESSION['_token'])) {
            return $_SESSION['_token'] == $token;
        }
    }
}