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
    $sql = "SELECT libro.*, usuario.username AS propietario_username
            FROM libro
            INNER JOIN prestamo ON libro.id = prestamo.id_libro
            INNER JOIN usuario ON prestamo.id_usuario = usuario.id
            WHERE usuario.username = :username AND prestamo.devuelto = 0";
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
    $sql = "SELECT libro.*, usuario.username AS receptor_username
    FROM libro INNER JOIN prestamo ON libro.id = prestamo.id_libro
     INNER JOIN usuario ON prestamo.id_usuario = usuario.id WHERE 
     libro.id_usuario = ( SELECT id FROM usuario WHERE username = :username ) 
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

function historialPrestamos(string $username): array
{
    $db = new BBDD();
    $sql = "SELECT 
                p.id,
                p.fecha_prestamo,
                p.fecha_devolucion,
                p.devuelto,
                libro.titulo,
                libro.autor,
                libro.genero,
                u_dueno.username AS propietario_username
            FROM prestamo p
            INNER JOIN libro ON libro.id = p.id_libro
            INNER JOIN usuario u_yo ON u_yo.username = :username
            INNER JOIN usuario u_dueno ON u_dueno.id = libro.id_usuario
            WHERE p.id_usuario = u_yo.id
            ORDER BY p.fecha_prestamo DESC";
    $sentencia = $db->getData($sql, ["username" => $username]);
    if ($sentencia === null) {
        return [];
    }
    return $sentencia->fetchAll(PDO::FETCH_ASSOC);
}

function esAdmin($username)
{
    $db = new BBDD();
    $sql = "SELECT role FROM usuario WHERE username = :username";
    $parametros = [
        "username" => $_SESSION["username"]
    ];
    $sentencia = $db->getData($sql, $parametros);
    if ($sentencia === null) {
        return false;
    }
    return $sentencia->fetchColumn() === "admin";
}

function prestamosAdministracion(): array
{
    $db = new BBDD();
    $sql = "SELECT p.id, p.fecha_prestamo, p.fecha_devolucion, p.devuelto,
                   libro.titulo, libro.autor,
                   u_pide.username AS solicitante_username,
                   u_dueno.username AS dueno_username
            FROM prestamo p
            INNER JOIN libro ON libro.id = p.id_libro
            INNER JOIN usuario u_pide ON u_pide.id = p.id_usuario
            INNER JOIN usuario u_dueno ON u_dueno.id = libro.id_usuario
            ORDER BY p.fecha_prestamo DESC";
    $sentencia = $db->getData($sql);
    if ($sentencia === null) {
        return [];
    }
    return $sentencia->fetchAll(PDO::FETCH_ASSOC);
}

function usuariosAdministracionConPrestamos(): array
{
    $db = new BBDD();
    $sql = "SELECT u.id, u.nombre, u.apellidos, u.email, u.username, u.role,
               (
                   SELECT COUNT(*)
                   FROM prestamo p1
                   WHERE p1.id_usuario = u.id
                     AND p1.devuelto = 0
               ) +
               (
                   SELECT COUNT(*)
                   FROM prestamo p2
                   INNER JOIN libro l2 ON l2.id = p2.id_libro
                   WHERE l2.id_usuario = u.id
                     AND p2.devuelto = 0
               ) AS total_prestamos
        FROM usuario u
        ORDER BY u.username ASC";
    $sentencia = $db->getData($sql);
    if ($sentencia === null) {
        return [];
    }
    return $sentencia->fetchAll(PDO::FETCH_ASSOC);
}

function eliminarUsuarioSiSinPrestamos(int $idUsuario, string $adminUsername): bool|null|string
{
    $db = new BBDD();

    $sqlSelf = "SELECT id FROM usuario WHERE username = :username LIMIT 1";
    $sSelf = $db->getData($sqlSelf, ["username" => $adminUsername]);
    if ($sSelf === null) {
        return null;
    }

    $idAdmin = (int)$sSelf->fetchColumn();
    if ($idAdmin === $idUsuario) {
        return "No puedes darte de baja a ti mismo.";
    }

    $sqlCount = "SELECT
                (
                    SELECT COUNT(*)
                    FROM prestamo p1
                    WHERE p1.id_usuario = :id_usuario
                      AND p1.devuelto = 0
                ) +
                (
                    SELECT COUNT(*)
                    FROM prestamo p2
                    INNER JOIN libro l2 ON l2.id = p2.id_libro
                    WHERE l2.id_usuario = :id_usuario
                      AND p2.devuelto = 0
                ) AS total";
    $sCount = $db->getData($sqlCount, ["id_usuario" => $idUsuario]);
    if ($sCount === null) {
        return null;
    }

    $totalPrestamos = (int)$sCount->fetchColumn();
    if ($totalPrestamos > 0) {
        return "No se puede dar de baja: el usuario tiene préstamos activos (como solicitante o propietario).";
    }

    // Bloquear baja si el usuario tiene libros registrados (FK libro.id_usuario -> usuario.id)
    $sqlLibros = "SELECT COUNT(*) FROM libro WHERE id_usuario = :id_usuario";
    $sLibros = $db->getData($sqlLibros, ["id_usuario" => $idUsuario]);
    if ($sLibros === null) {
        return null;
    }
    $totalLibros = (int)$sLibros->fetchColumn();
    if ($totalLibros > 0) {
        return "No se puede dar de baja: el usuario tiene libros registrados.";
    }

    $sqlDelete = "DELETE FROM usuario WHERE id = :id_usuario";
    $sDelete = $db->getData($sqlDelete, ["id_usuario" => $idUsuario]);
    if ($sDelete === null) {
        return null;
    }

    return true;
}