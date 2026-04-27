<?php

namespace App\models;

require __DIR__ . "/../../vendor/autoload.php";

use PDO;
use PDOException;
use PDOStatement;

class BBDD
{
    private PDO | null $conexionPDO;
    private bool $conectado;
    public function __construct()
    {
        $configPath = __DIR__ . "/../config/config-db.json";
        $config = json_decode(file_get_contents($configPath), true);

        $dbMotor = $config["dbMotor"];
        $host = $config["mysqlHost"];
        $user = $config["mysqlUser"];
        $password = $config["mysqlPassword"];
        $database = $config["mysqlDatabase"];

        $dsn = "$dbMotor:host=$host;dbname=$database;charset=utf8mb4";

        try {
            $this->conexionPDO = new PDO($dsn, $user, $password);
            $this->conexionPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conectado = true;
        } catch (PDOException $e) {
            $this->conexionPDO = null;
            $this->conectado = false;
        }
    }

    function isConectado()
    {
        return $this->conectado;
    }

    //Metodo para realizar consultas
    //El parámetro $sql es una cadena que contiene la consulta
    //El parámetro $parametros contiene los datos que se bindearán en la consulta
    public function getData($sql, array $parametros = []): PDOStatement | null
    {
        if (!$this->isConectado() || $this->conexionPDO === null) {
            return null;
        }
        try {
            $sentencia = $this->conexionPDO->prepare($sql);
            $sentencia->execute($parametros);
            return $sentencia;
        } catch (PDOException $e) {
            // echo $e->getMessage();
            return null;
        }
    }

    public function addUser($_usuario)
    {
        if (!$this->isConectado() || $this->conexionPDO === null) {
            return null;
        }

        $sql = "INSERT INTO usuario (nombre, apellidos, email, username, password) VALUES (:nombre, :apellidos, :email, :username, :password)";
        try {
            $sentencia = $this->conexionPDO->prepare($sql);
            $sentencia->bindParam(":nombre", $_usuario->nombre);
            $sentencia->bindParam(":apellidos", $_usuario->apellidos);
            $sentencia->bindParam(":email", $_usuario->email);
            $sentencia->bindParam(":username", $_usuario->username);
            $sentencia->bindParam(":password", $_usuario->password);
            $sentencia->execute();
            return true;
        } catch (PDOException $e) {

            return null;
        }
    }

    public function addBook(string $titulo, string $autor, string $genero, int $anyo, string $username): bool|null
    {
        if (!$this->isConectado() || $this->conexionPDO === null) {
            return null;
        }
        $sql = "INSERT INTO libro (titulo, autor, genero, anyo, id_usuario)
                SELECT :titulo, :autor, :genero, :anyo, u.id
                FROM usuario u
                WHERE u.username = :username
                LIMIT 1";
        try {
            $sentencia = $this->conexionPDO->prepare($sql);
            $sentencia->execute([
                ":titulo" => $titulo,
                ":autor" => $autor,
                ":genero" => $genero,
                ":anyo" => $anyo,
                ":username" => $username,
            ]);
            return $sentencia->rowCount() > 0;
        } catch (PDOException $e) {
            return null;
        }
    }

    public function addPrestamo(int $idLibro, string $usernamePrestatario): bool|null
    {
        if (!$this->isConectado() || $this->conexionPDO === null) {
            return null;
        }
        $sql = "INSERT INTO prestamo (fecha_prestamo, fecha_devolucion, id_usuario, id_libro, devuelto)
                SELECT NOW(), NULL, u.id, l.id, 0
                FROM libro l
                INNER JOIN usuario u ON u.username = :username
                WHERE l.id = :id_libro
                AND l.id_usuario != u.id
                AND NOT EXISTS (
                    SELECT 1 FROM prestamo p
                    WHERE p.id_libro = l.id AND p.devuelto = 0
                )
                LIMIT 1";
        try {
            $sentencia = $this->conexionPDO->prepare($sql);
            $sentencia->execute([
                ":id_libro" => $idLibro,
                ":username" => $usernamePrestatario,
            ]);
            return $sentencia->rowCount() > 0;
        } catch (PDOException $e) {
            return null;
        }
    }

    public function removePrestamo(int $id):bool | null{
        if (!$this->isConectado() || $this->conexionPDO === null) {
            return null;
        }
        $sql="UPDATE prestamo SET devuelto = 1, fecha_devolucion = NOW() WHERE id_libro = :id";
        try {
            $sentencia = $this->conexionPDO->prepare($sql);
            $sentencia->execute([
                ":id" => $id
            ]);
            return $sentencia->rowCount() > 0;
        } catch (PDOException $e) {
            return null;
        }

    }
}
