<?php
session_start();
require __DIR__ . "/../../../vendor/autoload.php";



if (!estaUsuarioLogeado()) {
    header("Location: /pi/PI-prestamo-de-libros/app/public/index.php");
    exit();
}
?>

<header class="flex items-center justify-center px-5 py-3 bg-slate-800 text-white shadow-md">
    <!-- Logo -->
    <a href="/pi/PI-prestamo-de-libros/app/src/views/main.php" class="gap-3 flex items-center">
    <div class="flex items-center gap-3 flex-1">
        <img
            src="/pi/PI-prestamo-de-libros/app/public/img/logo.png"
            alt="Logo PrestameLo"
            class="w-9 h-9"
        >
        <span class="hidden sm:inline text-sm font-semibold tracking-wide text-slate-100">
            PRESTAMELO
        </span>
    </a>
    </div>

    <!-- Buscador centrado -->
    <!--
    <div class="flex items-center gap-2 flex-none mx-4 w-full max-w-md">
        <input
            type="text"
            placeholder="Buscar libros..."
            class="w-full rounded-full border border-slate-300/70 bg-white/90 px-4 py-2 text-sm text-slate-800
                   placeholder:text-slate-400 shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-400
                   focus:border-transparent"
        >
        <button
            class="inline-flex items-center justify-center rounded-full bg-sky-500 px-3 py-2 text-white
                   shadow-sm hover:bg-sky-600 focus-visible:outline-none focus-visible:ring-2
                   focus-visible:ring-sky-400 focus-visible:ring-offset-2 focus-visible:ring-offset-slate-800
                   transition"
        >
            🔍
        </button>
    </div>
    -->

    <!-- Usuario / Logout -->
    <div class="flex items-center justify-end gap-3 flex-1">
        <span class="hidden sm:inline text-sm text-slate-100">
            Hola, <span class="font-semibold"><?= htmlspecialchars($_SESSION["username"]) ?></span>
        </span>

        <a
            href="/pi/PI-prestamo-de-libros/app/src/controllers/auth/logout.php"
            class="inline-flex items-center justify-center rounded-lg bg-red-500 px-4 py-2 text-sm font-medium
                   text-white shadow-sm hover:bg-red-600 focus-visible:outline-none focus-visible:ring-2
                   focus-visible:ring-red-400 focus-visible:ring-offset-2 focus-visible:ring-offset-slate-800
                   transition"
        >
            Cerrar sesión
        </a>
    </div>
</header>