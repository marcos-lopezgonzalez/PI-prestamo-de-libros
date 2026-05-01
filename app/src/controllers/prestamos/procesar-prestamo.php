<?php

require __DIR__ . "/../../../vendor/autoload.php";

use App\models\BBDD;

session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../../views/libros/lista_libros_disponibles.php");
    exit;
}

if (!isset($_SESSION["username"]) || $_SESSION["username"] === "") {
    header("Location: ../../../public/index.php");
    exit;
}

unset($_SESSION["prestamo_exito"], $_SESSION["prestamo_error"]);

$idLibro = filter_input(INPUT_POST, "id_libro", FILTER_VALIDATE_INT);
if ($idLibro === false || $idLibro < 1) {
    $_SESSION["prestamo_error"] = "Libro no válido.";
    header("Location: ../../views/libros/lista_libros_disponibles.php");
    exit;
}

$db = new BBDD();
$resultado = $db->addPrestamo($idLibro, $_SESSION["username"]);

if ($resultado === true) {
    $_SESSION["prestamo_exito"] = true;
} elseif ($resultado === null) {
    $_SESSION["prestamo_error"] = "No se pudo procesar el préstamo. Inténtalo más tarde.";
} else {
    $_SESSION["prestamo_error"] = "Ese libro ya no está disponible o no puedes pedirlo prestado.";
}

header("Location: ../../views/libros/lista_libros_disponibles.php");
exit;
