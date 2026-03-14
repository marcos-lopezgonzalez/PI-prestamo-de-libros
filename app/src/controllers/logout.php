<?php
require __DIR__ . "/../../vendor/autoload.php";

use function cerrarSesion;

session_start();

cerrarSesion();