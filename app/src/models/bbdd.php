<?php

class BBDD
{
    private PDO | null $conexionPDO;
    private bool $conectado;
    public function __construct()
    {
        $configPath = __DIR__ . "/../config-db.json";
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
        try {
            $sentencia = $this->conexionPDO->prepare($sql);
            $sentencia->execute($parametros);
            return $sentencia;
        } catch (PDOException $e) {
            // echo $e->getMessage();
            return null;
        }
    }
}
