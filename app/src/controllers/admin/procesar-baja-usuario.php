<?php
require __DIR__ . "/../../../vendor/autoload.php";

session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ./../../views/admin/gestionar_usuarios.php");
    exit;
}

if (!isset($_SESSION["username"]) || !esAdmin($_SESSION["username"])) {
    header("Location: ./../../../public/index.php");
    exit;
}

$idUsuario = filter_input(INPUT_POST, "id_usuario", FILTER_VALIDATE_INT);
if ($idUsuario === false || $idUsuario < 1) {
    $_SESSION["admin_error"] = "Usuario no válido.";
    header("Location: ./../../views/admin/gestionar_usuarios.php");
    exit;
}

$resultado = eliminarUsuarioSiSinPrestamos($idUsuario, $_SESSION["username"]);

if ($resultado === true) {
    $_SESSION["admin_ok"] = "Usuario dado de baja correctamente.";
} elseif ($resultado === null) {
    $_SESSION["admin_error"] = "Error de base de datos. Inténtalo más tarde.";
} else {
    $_SESSION["admin_error"] = $resultado;
}

header("Location: ./../../views/admin/gestionar_usuarios.php");
exit;