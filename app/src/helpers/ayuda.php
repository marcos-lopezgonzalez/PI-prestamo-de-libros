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
    if ($sentencia === null) {
        return false; // BD caída => tratamos como "no existe" para no reventar
    }
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
    if ($sentencia === null) {
        return false; // BD caída => no reventar
    }
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
    if ($sentencia === null) {
        return null; // MySQL apagado => que el controller muestre "Inténtelo en un rato"
    }

    $hash = $sentencia->fetchColumn();
    if ($hash === false) {
        return false;
    }

    return password_verify($_password, $hash);
}

function estaUsuarioLogeado()
{
    return $_SESSION["username"];
}

function cerrarSesion()
{
    if (isset($_SESSION["username"])) {
        unset($_SESSION["username"]);
    }

    session_unset();
    session_destroy();
    header("Location: ./../../../public/index.php");
    exit();
}

function librosUsuario($_username)
{
    $db = new BBDD();
    $sql = "SELECT * FROM libro INNER JOIN usuario ON id_usuario = usuario.id WHERE usuario.username = :username";
    $parametros = [
        "username" => $_username
    ];

    $sentencia = $db->getData($sql, $parametros);
    if ($sentencia === null) {
        return [];
    }

    return $sentencia->fetchAll(PDO::FETCH_ASSOC);
}

function librosDisponiblesParaPrestamo(string $usernameViewer, string $campoFiltro, string $texto): array
{
    $db = new BBDD();
    $allowed = ["titulo", "autor", "genero"];
    $campo = in_array($campoFiltro, $allowed, true) ? $campoFiltro : "titulo";
    $texto = trim($texto);
    $sql = "SELECT libro.id, libro.titulo, libro.autor, libro.genero, libro.anyo,
                   usuario.username AS propietario_username
            FROM libro
            INNER JOIN usuario ON libro.id_usuario = usuario.id
            WHERE NOT EXISTS (
                SELECT 1 FROM prestamo p
                WHERE p.id_libro = libro.id AND p.devuelto = 0
            )
            AND usuario.username != :viewer";
    $parametros = [
        "viewer" => $usernameViewer,
    ];
    if ($texto !== "") {
        $sql .= " AND libro.$campo LIKE :like";
        $parametros["like"] = "%" . $texto . "%";
    }
    $sql .= " ORDER BY libro.titulo ASC";
    $sentencia = $db->getData($sql, $parametros);
    if ($sentencia === null) {
        return [];
    }
    return $sentencia->fetchAll(PDO::FETCH_ASSOC);
}
function librosRecibidos($username)
{
    $db = new BBDD();
    $sql = "SELECT 
    libro.*, 
    usuario.username AS propietario_username,
    DATE(prestamo.fecha_prestamo) AS fecha_prestamo,
    DATEDIFF(CURDATE(), prestamo.fecha_prestamo) AS dias_prestados
FROM libro
INNER JOIN prestamo ON libro.id = prestamo.id_libro
INNER JOIN usuario ON prestamo.id_usuario = usuario.id
WHERE usuario.username = :username 
  AND prestamo.devuelto = 0;";
    $parametros = [
        "username" => $username
    ];
    $sentencia = $db->getData($sql, $parametros);
    if ($sentencia === null) {
        return [];
    }
    return $sentencia->fetchAll(PDO::FETCH_ASSOC);
}
function librosPrestados($username)
{
    $db = new BBDD();
    $sql = "SELECT 
            libro.*, 
            usuario.username,
            DATE(prestamo.fecha_prestamo) AS fecha_prestamo,
            DATEDIFF(CURDATE(), prestamo.fecha_prestamo) AS dias_prestados
        FROM libro 
        INNER JOIN prestamo ON libro.id = prestamo.id_libro
        INNER JOIN usuario ON prestamo.id_usuario = usuario.id 
        WHERE libro.id_usuario = (
            SELECT id FROM usuario WHERE username = :username
        ) 
        AND prestamo.devuelto = 0";
    $parametros = [
        ":username" => $username
    ];
    $sentencia = $db->getData($sql, $parametros);
    if ($sentencia === null) {
        return [];
    }
    return $sentencia->fetchAll(PDO::FETCH_ASSOC);
}
