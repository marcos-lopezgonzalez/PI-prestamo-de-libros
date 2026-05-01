<?php

require __DIR__ . "/../../../vendor/autoload.php";

use App\models\BBDD;

session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../../views/libros/importar_csv.php");
    exit;
}

if (!isset($_SESSION["username"]) || $_SESSION["username"] === "") {
    header("Location: ../../../public/index.php");
    exit;
}

$_SESSION["import_csv_ok"] = "";
$_SESSION["import_csv_error"] = "";
$_SESSION["import_csv_resumen"] = [
    "total_filas" => 0,
    "validas" => 0,
    "insertadas" => 0,
    "rechazadas" => 0,
];
$_SESSION["import_csv_errores"] = [];

if (!isset($_FILES["csv_file"]) || !is_array($_FILES["csv_file"])) {
    $_SESSION["import_csv_error"] = "No se recibio ningun archivo.";
    header("Location: ../../views/libros/importar_csv.php");
    exit;
}

$archivo = $_FILES["csv_file"];
if (($archivo["error"] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
    $_SESSION["import_csv_error"] = "Error al subir el archivo CSV.";
    header("Location: ../../views/libros/importar_csv.php");
    exit;
}

$size = (int) ($archivo["size"] ?? 0);
if ($size <= 0 || $size > 2 * 1024 * 1024) {
    $_SESSION["import_csv_error"] = "El archivo debe pesar entre 1 byte y 2 MB.";
    header("Location: ../../views/libros/importar_csv.php");
    exit;
}

$extension = strtolower((string) pathinfo((string) ($archivo["name"] ?? ""), PATHINFO_EXTENSION));
if ($extension !== "csv") {
    $_SESSION["import_csv_error"] = "El archivo debe tener extension .csv";
    header("Location: ../../views/libros/importar_csv.php");
    exit;
}

$delimiterRaw = $_POST["delimiter"] ?? ";";
$delimiter = in_array($delimiterRaw, [";", ","], true) ? $delimiterRaw : ";";
$hasHeader = isset($_POST["has_header"]) && $_POST["has_header"] === "1";

$tmpPath = (string) ($archivo["tmp_name"] ?? "");
$handle = fopen($tmpPath, "r");
if ($handle === false) {
    $_SESSION["import_csv_error"] = "No se pudo leer el archivo CSV.";
    header("Location: ../../views/libros/importar_csv.php");
    exit;
}

$rows = [];
$errores = [];
$lineNumber = 0;

while (($data = fgetcsv($handle, 0, $delimiter)) !== false) {
    $lineNumber++;

    if ($lineNumber === 1 && $hasHeader) {
        continue;
    }
    if ($data === [null] || count($data) === 0) {
        continue;
    }

    if (count($data) < 4) {
        $errores[] = "Fila $lineNumber: se esperaban 4 columnas (titulo, autor, genero, anyo).";
        continue;
    }

    $titulo = trim((string) ($data[0] ?? ""));
    $autor = trim((string) ($data[1] ?? ""));
    $genero = trim((string) ($data[2] ?? ""));
    $anyoRaw = trim((string) ($data[3] ?? ""));

    if ($lineNumber === 1 || ($lineNumber === 2 && $hasHeader)) {
        $titulo = preg_replace('/^\xEF\xBB\xBF/', '', $titulo) ?? $titulo;
    }

    if ($titulo === "" || $autor === "" || $genero === "") {
        $errores[] = "Fila $lineNumber: titulo, autor y genero son obligatorios.";
        continue;
    }

    $anyo = filter_var($anyoRaw, FILTER_VALIDATE_INT);
    if ($anyo === false || $anyo < 1000 || $anyo > 2100) {
        $errores[] = "Fila $lineNumber: anyo invalido (1000-2100).";
        continue;
    }

    $rows[] = [
        "titulo" => $titulo,
        "autor" => $autor,
        "genero" => $genero,
        "anyo" => (int)$anyo,
    ];
}

fclose($handle);

$totalFilas = count($rows) + count($errores);
$_SESSION["import_csv_resumen"] = [
    "total_filas" => $totalFilas,
    "validas" => count($rows),
    "insertadas" => 0,
    "rechazadas" => count($errores),
];
$_SESSION["import_csv_errores"] = $errores;

if (count($rows) === 0) {
    $_SESSION["import_csv_error"] = "No hay filas validas para importar.";
    header("Location: ../../views/libros/importar_csv.php");
    exit;
}

$db = new BBDD();
$resultado = $db->addBooksBulk($rows, (string) $_SESSION["username"]);

if (($resultado["ok"] ?? false) !== true) {
    $_SESSION["import_csv_error"] = $resultado["error"] ?? "No se pudieron importar los libros.";
    header("Location: ../../views/libros/importar_csv.php");
    exit;
}

$_SESSION["import_csv_resumen"]["insertadas"] = (int)($resultado["insertadas"] ?? 0);
$_SESSION["import_csv_ok"] = "Importacion completada.";
header("Location: ../../views/libros/importar_csv.php");
exit;
