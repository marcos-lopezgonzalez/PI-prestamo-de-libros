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
    $sql = "SELECT COUNT(*) FROM usuario WHERE username = :username and password = :password";
    $parametros = [
        "username" => $_username,
        "password" => password_hash($_password, PASSWORD_DEFAULT)
    ];
    $sentencia = $db->getData($sql, $parametros);
    $count = $sentencia->fetchColumn();
    return $count > 0;
}
