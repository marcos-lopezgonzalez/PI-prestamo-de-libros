<?php

require __DIR__ . "/../../vendor/autoload.php";

use App\models\BBDD;

function existeUsuario($_username)
{
    $db = new BBDD();
    $sql = "SELECT COUNT(*) FROM usuario WHERE username = :username";
    $parametros = [
        "username" => $_username
    ];
    $sentencia = $db->getData($sql, $parametros);
    $count = $sentencia->fetchColumn();
    return $count > 0;
}

function existeEmail($_email)
{
    $db = new BBDD();
    $sql = "SELECT COUNT(*) FROM usuario WHERE email = :email";
    $parametros = [
        "email" => $_email
    ];
    $sentencia = $db->getData($sql, $parametros);
    $count = $sentencia->fetchColumn();
    return $count > 0;
}

function procesarLogin($_username, $_password)
{
    $db = new BBDD();
    $sql = "SELECT password FROM usuario WHERE username = :username";
    $parametros = [
        "username" => $_username
    ];

    $sentencia = $db->getData($sql, $parametros);
    $hash = $sentencia->fetchColumn();

    if ($hash === false) {
        return false;
    }

    return password_verify($_password, $hash);
}
