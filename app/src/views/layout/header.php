<?php

require __DIR__ . "/../../../vendor/autoload.php";

session_start();

    if(!estaUsuarioLogeado()) {
        header("Location: ./../../public/index.php");
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <link rel="stylesheet" href="./../../public/css/index.css">
    <link rel="stylesheet" href="./../../public/css/header.css">
</head>
<body>
    <header class="header">
    <div class="header__logo">
        <img src="./../../public/img/logo.png" alt="Logo">
        
    </div>

    <div class="header__search">
        <input type="text" placeholder="Buscar libros...">
        <button>🔍</button>
    </div>

    <div class="header__user">
        <span>Hola, <?= $_SESSION["username"]  ?></span>
    </div>
</header>
</body>
</html>