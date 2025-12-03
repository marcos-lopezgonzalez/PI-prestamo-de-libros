<?php

require __DIR__ . "/../../vendor/autoload.php";

session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ./../../public/index.php");
    die;
}

$username = trim($_POST["username"]) ?? "";
$password = trim($_POST["password"]) ?? "";
$noRecordarLogin = $_POST["recordar"] ?? true;

$errores = [];

if ($username === "") {
    $errores["usernameLogin"] = "Usuario vacío";
} else {
    $recordar["usernameLogin"] = $username;
}

if ($password === "") {
    $errores["passwordLogin"] = "Contraseña vacía";
} else {
    $recordar["passwordLogin"] = $password;
}

if (count($errores) !== 0) {
    $_SESSION["errores"] = $errores;
    $_SESSION["recordar"] = $recordar;
    header("Location: ./../../public/index.php");
    die;
} else {
    $login = procesarLogin($username, $password);
    if ($login) {
        $_SESSION["login"] = true;
        if (!$noRecordarLogin) {
            setcookie("usernameLogin", $username, time() + (7 * 24 * 60 * 60), "/");
            setcookie("passwordLogin", $password, time() + (7 * 24 * 60 * 60), "/");
        }
        // header("Location: ./../../public/index.php");
        // die;
    } else if ($login === null) {
        $_SESSION["errores"]["login"] = "Error al procesar login. Inténtelo en un rato de nuevo.";
        $_SESSION["recordar"] = $recordar;
        // header("Location: ./../../public/index.php");
        // die;
    } else {
        $_SESSION["errores"]["login"] = "Error. Verifica las credenciales.";
        $_SESSION["recordar"] = $recordar;
        // header("Location: ./../../public/index.php");
        // die;
    }

    echo ($_SESSION["login"]);
    var_dump($_SESSION["errores"]);
    var_dump($_SESSION["recordar"]);
    die;
}
