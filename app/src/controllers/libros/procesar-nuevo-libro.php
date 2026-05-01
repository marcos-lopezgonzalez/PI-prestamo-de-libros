<?php

require __DIR__ . "/../../../vendor/autoload.php";

use App\models\BBDD;

session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../../views/libros/nuevo_libro.php");
    exit;
}

if (!isset($_SESSION["username"]) || $_SESSION["username"] === "") {
    header("Location: ../../../public/index.php");
    exit;
}

$titulo = isset($_POST["titulo"]) ? trim((string) $_POST["titulo"]) : "";
$autor = isset($_POST["autor"]) ? trim((string) $_POST["autor"]) : "";
$genero = isset($_POST["genero"]) ? trim((string) $_POST["genero"]) : "";
$anyoRaw = $_POST["anyo"] ?? "";
$anyo = filter_var($anyoRaw, FILTER_VALIDATE_INT);

$errores = [];
$recordar = [];

if ($titulo === "") {
    $errores["titulo"] = "El título es obligatorio";
} else {
    $recordar["titulo"] = $titulo;
}

if ($autor === "") {
    $errores["autor"] = "El autor es obligatorio";
} else {
    $recordar["autor"] = $autor;
}

if ($genero === "") {
    $errores["genero"] = "El género es obligatorio";
} else {
    $recordar["genero"] = $genero;
}

if ($anyo === false || $anyo < 1000 || $anyo > 2100) {
    $errores["anyo"] = "Indica un año válido (1000–2100)";
} else {
    $recordar["anyo"] = (string) $anyo;
}

if (count($errores) !== 0) {
    $_SESSION["errores_libro"] = $errores;
    $_SESSION["recordar_libro"] = $recordar;
    header("Location: ../../views/libros/nuevo_libro.php");
    exit;
}

$db = new BBDD();
$resultado = $db->addBook($titulo, $autor, $genero, $anyo, $_SESSION["username"]);

if ($resultado === true) {
    unset($_SESSION["errores_libro"], $_SESSION["recordar_libro"]);
    $_SESSION["libro_creado"] = true;
    header("Location: ../../views/libros/lista_libros_usuario.php");
    exit;
}

$_SESSION["errores_libro"]["general"] = $resultado === null
    ? "No se pudo guardar el libro. Inténtalo más tarde."
    : "No se pudo asociar el libro a tu usuario.";
$_SESSION["recordar_libro"] = $recordar;
header("Location: ../../views/libros/nuevo_libro.php");
exit;
