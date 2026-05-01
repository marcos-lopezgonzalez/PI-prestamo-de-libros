<?php
require __DIR__ . "/../../../vendor/autoload.php";

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libros disponibles — PrestameLo</title>
    <link rel="stylesheet" href="./../../../public/css/index.css">
</head>

<body class="min-h-screen bg-slate-100">
    <?php include __DIR__ . "/../layout/header.php"; ?>

    <main class="max-w-6xl mx-auto px-4 py-12">
        <h1 class="text-2xl font-bold text-slate-800 mb-2">Libros disponibles para préstamo</h1>
        <p class="text-sm text-slate-600 mb-8">
            Solo se muestran libros de otros usuarios que no están prestados en este momento.
        </p>

        <?php
        $campoFiltro = $_GET["campo"] ?? "titulo";
        $textoBusqueda = isset($_GET["q"]) ? trim((string) $_GET["q"]) : "";
        $libros = librosDisponiblesParaPrestamo($_SESSION["username"], $campoFiltro, $textoBusqueda);
        $prestamoExito = !empty($_SESSION["prestamo_exito"]);
        $prestamoError = $_SESSION["prestamo_error"] ?? "";
        unset($_SESSION["prestamo_exito"], $_SESSION["prestamo_error"]);
        ?>

        <?php if ($prestamoExito): ?>
            <div
                class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-900"
                role="status">
                Préstamo registrado correctamente.
            </div>
        <?php elseif ($prestamoError !== ""): ?>
            <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800" role="alert">
                <?= htmlspecialchars($prestamoError) ?>
            </div>
        <?php endif; ?>
        <?php include __DIR__ . "/../layout/buscador_libros.php"; ?>

        <?php if (count($libros) === 0): ?>
            <p class="text-sm text-slate-600">
                <?php if ($textoBusqueda !== ""): ?>
                    No hay resultados para tu búsqueda. Prueba con otro texto o campo.
                <?php else: ?>
                    No hay libros disponibles en este momento.
                <?php endif; ?>
            </p>
        <?php else: ?>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                <?php foreach ($libros as $libro): ?>
                    <article
                        class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col justify-between h-full
                               shadow-sm hover:shadow-lg hover:-translate-y-1 hover:border-emerald-200
                               transition-all duration-200 ease-out">
                        <div>
                            <h2 class="text-lg font-semibold text-slate-800 mb-2">
                                <?= htmlspecialchars($libro["titulo"]) ?>
                            </h2>
                            <p class="text-sm text-slate-600 mb-1 leading-relaxed">
                                <span class="font-medium text-slate-700">Autor:</span>
                                <?= htmlspecialchars($libro["autor"]) ?>
                            </p>
                            <p class="text-sm text-slate-600 mb-1 leading-relaxed">
                                <span class="font-medium text-slate-700">Género:</span>
                                <?= htmlspecialchars($libro["genero"]) ?>
                            </p>
                            <p class="text-sm text-slate-600 mb-4 leading-relaxed">
                                <span class="font-medium text-slate-700">Año:</span>
                                <?= htmlspecialchars((string) $libro["anyo"]) ?>
                            </p>
                            <p class="text-xs text-emerald-700 font-medium">
                                Propietario: <?= htmlspecialchars($libro["propietario_username"]) ?>
                            </p>
                        </div>
                        <form
                            method="post"
                            action="./../../controllers/prestamos/procesar-prestamo.php"
                            class="mt-auto pt-2 border-t border-slate-100">
                            <input type="hidden" name="id_libro" value="<?= (int) $libro["id"] ?>">
                            <button
                                type="submit"
                                class="inline-flex w-full items-center justify-center rounded-lg bg-emerald-600 px-4 py-2.5
                                       text-sm font-medium text-white shadow-sm hover:bg-emerald-700
                                       focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-400
                                       focus-visible:ring-offset-2 transition">
                                Pedir préstamo
                            </buttond>
                        </form>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>

    <script src="./../../../public/js/tailwind.js"></script>
</body>

</html>