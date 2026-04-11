<?php

?>  
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PrestameLo — Panel principal</title>
    <!-- Tailwind y fuente (se cargan igual que en index.php, vía tu build en index.css) -->
    <link rel="stylesheet" href="./../../public/css/index.css">
</head>
<body class="min-h-screen bg-slate-100">
    <?php include __DIR__ . "/layout/header.php" ?>

    <main class="max-w-6xl mx-auto px-4 py-12">
        <!-- Grid de tarjetas principales -->
        <section class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            <!-- Mis libros -->
            <article
                class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col justify-between h-full
                       shadow-sm hover:shadow-lg hover:-translate-y-1 hover:border-sky-200
                       transition-all duration-200 ease-out">
                <div>
                    <h2 class="text-lg font-semibold text-slate-800 mb-2">
                        Mis libros
                    </h2>
                    <p class="text-sm text-slate-600 mb-4 leading-relaxed">
                        Gestiona los libros que has dado de alta. Añade nuevos títulos y revisa los que ya
                        tienes disponibles para préstamo.
                    </p>
                </div>
                <div class="space-y-2">
                    <a href="./libros/lista_libros_usuario.php"
                       class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-sky-600 px-4 py-2
                              text-sm font-medium text-white hover:bg-sky-700 focus-visible:outline-none
                              focus-visible:ring-2 focus-visible:ring-sky-400 focus-visible:ring-offset-2
                              focus-visible:ring-offset-white transition">
                        Ver mis libros
                    </a>
                    <a href="./libros/nuevo_libro.php"
                       class="inline-flex w-full items-center justify-center gap-2 rounded-lg border border-sky-600
                              px-4 py-2 text-sm font-medium text-sky-700 bg-white hover:bg-sky-50
                              focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-sky-400
                              focus-visible:ring-offset-2 focus-visible:ring-offset-white transition">
                        Añadir libro
                    </a>
                </div>
            </article>

            <!-- Explorar libros -->
            <article
                class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col justify-between h-full
                       shadow-sm hover:shadow-lg hover:-translate-y-1 hover:border-emerald-200
                       transition-all duration-200 ease-out">
                <div>
                    <h2 class="text-lg font-semibold text-slate-800 mb-2">
                        Explorar libros
                    </h2>
                    <p class="text-sm text-slate-600 mb-4 leading-relaxed">
                        Descubre libros de otros usuarios que están disponibles para préstamo.
                    </p>
                </div>
                <div>
                    <a href="./libros/lista_libros_disponibles.php"
                       class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-emerald-500
                              px-4 py-2 text-sm font-medium text-white hover:bg-emerald-600
                              focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-400
                              focus-visible:ring-offset-2 focus-visible:ring-offset-white transition">
                        Explorar libros disponibles
                    </a>
                </div>
            </article>

            <!-- Mis préstamos -->
            <article
                class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col justify-between h-full
                       shadow-sm hover:shadow-lg hover:-translate-y-1 hover:border-indigo-200
                       transition-all duration-200 ease-out">
                <div>
                    <h2 class="text-lg font-semibold text-slate-800 mb-2">
                        Mis préstamos
                    </h2>
                    <p class="text-sm text-slate-600 mb-4 leading-relaxed">
                        Consulta los libros que tienes prestados ahora mismo y los que has prestado a otros.
                        Revisa fácilmente los días que lleva cada préstamo.
                    </p>
                </div>
                <div class="space-y-2">
                    <a href="./prestamos/lista_libros_recibidos.php"
                       class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-indigo-500
                              px-4 py-2 text-sm font-medium text-white hover:bg-indigo-600
                              focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-400
                              focus-visible:ring-offset-2 focus-visible:ring-offset-white transition">
                        Libros que me han prestado
                    </a>
                    <a href="./prestamos/lista_libros_prestados.php"
                       class="inline-flex w-full items-center justify-center gap-2 rounded-lg border border-indigo-500
                              px-4 py-2 text-sm font-medium text-indigo-600 bg-white hover:bg-indigo-50
                              focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-400
                              focus-visible:ring-offset-2 focus-visible:ring-offset-white transition">
                        Libros que he prestado
                    </a>
                </div>
            </article>
        </section>
    </main>

    <script src="./../../public/js/tailwind.js"></script>
</body>
</html>