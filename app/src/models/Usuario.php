<?php

namespace App\models;

require __DIR__ . "/../../vendor/autoload.php";

class Usuario
{
    //Propiedades
    private int | null $id;
    private string $nombre;
    private string $apellidos;
    private string $email;
    private string $username;
    private string | null $password;

    //Constructor
    public function __construct(int | null $id, string $nombre, string $apellidos, string $email, string $username, string | null $password)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
    }

    public function &__get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function &__set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }
}
