<?php


require __DIR__ . "/../../../vendor/autoload.php";

use App\models\BBDD;

session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../../views/libros/lista_libros_usuario.php");
    exit;
}

$idLibro = filter_input(INPUT_POST, "id_libro", FILTER_VALIDATE_INT);
if ($idLibro === false || $idLibro < 1) {
    header("Location: ../../views/prestamos/lista_libros_recibidos.php");
    exit;
}

$db = new BBDD();

$resultado=$db->removePrestamo($idLibro);

header("Location: ../../views/prestamos/lista_libros_recibidos.php");
exit;