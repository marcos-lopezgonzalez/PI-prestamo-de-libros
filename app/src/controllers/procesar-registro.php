<?php

require __DIR__ . "/../../vendor/autoload.php";

use App\models\BBDD;
use App\models\Usuario;

session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ./../../public/index.php");
    die;
}

$nombre = trim($_POST["nombre"]) ?? "";
$apellidos = trim($_POST["apellidos"]) ?? "";
$email = trim($_POST["email"]) ?? "";
$username = trim($_POST["username"]) ?? "";
$password = trim($_POST["password"]) ?? "";

$errores = [];

$db = new BBDD();

if ($nombre === "") {
    $errores["nombreRegistro"] = "Nombre vacío";
} else {
    $recordar["nombre"] = $nombre;
}

if ($apellidos === "") {
    $errores["apellidosRegistro"] = "Apellidos vacíos";
} else {
    $recordar["apellidos"] = $apellidos;
}

if ($email === "") {
    $errores["emailRegistro"] = "Email vacío";
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errores["emailRegistro"] = "Email no válido";
} else if (existeEmail($email)) {
    $errores["emailRegistro"] = "El email $email ya está registrado";
} else {
    $recordar["email"] = $email;
}

if ($username === "") {
    $errores["usernameRegistro"] = "Usuario vacío";
} else if (existeUsuario($username)) {
    $errores["usernameRegistro"] = "El usuario $username no está disponible";
} else {
    $recordar["username"] = $username;
}

if ($password === "") {
    $errores["passwordRegistro"] = "Contraseña vacía";
} else if (strlen($password) < 8) {
    $errores["passwordRegistro"] = "Contraseña inferior a 8 caracteres";
} else {
    $recordar["password"] = $password;
}

if (count($errores) !== 0) {
    $_SESSION["errores"] = $errores;
    $_SESSION["recordar"] = $recordar;
    header("Location: ./../../public/index.php");
    die;
} else {
    $usuario = new Usuario(null, $nombre, $apellidos, $email, $username, password_hash($password, PASSWORD_DEFAULT));
    if ($db->addUser($usuario)) {
        $_SESSION["creacion"] = true;
        header("Location: ./../../public/index.php");
        die;
    } else {
        $_SESSION["errores"]["creacion"] = "Error al crear registro";
        $_SESSION["recordar"] = $recordar;
        header("Location: ./../../public/index.php");
        die;
    }
}
