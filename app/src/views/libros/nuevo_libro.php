<?php
require __DIR__ . "/../../../vendor/autoload.php";

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo libro — PrestameLo</title>
    <link rel="stylesheet" href="./../../../public/css/index.css">
</head>

<body class="min-h-screen bg-slate-100">
    <?php include __DIR__ . "/../layout/header.php"; ?>

    <?php
    $erroresLibro = $_SESSION["errores_libro"] ?? [];
    $recordarLibro = $_SESSION["recordar_libro"] ?? [];
    unset($_SESSION["errores_libro"], $_SESSION["recordar_libro"]);
    ?>

    <main class="max-w-xl mx-auto px-4 py-12">
        <h1 class="text-2xl font-bold text-slate-800 mb-2">Añadir libro</h1>
        <p class="text-sm text-slate-600 mb-8">
            Completa los datos del libro para añadirlo a tu biblioteca.
        </p>

        <?php if (!empty($erroresLibro["general"])): ?>
            <div
                class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800"
                role="alert">
                <?= htmlspecialchars($erroresLibro["general"]) ?>
            </div>
        <?php endif; ?>

        <form
            action="./../../controllers/libros/procesar-nuevo-libro.php"
            method="post"
            class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 md:p-8 space-y-6">
            <div class="space-y-2">
                <label for="titulo" class="block text-sm font-medium text-slate-700">
                    Título
                </label>
                <input
                    type="text"
                    name="titulo"
                    id="titulo"
                    required
                    autocomplete="off"
                    value="<?= htmlspecialchars($recordarLibro["titulo"] ?? "") ?>"
                    class="w-full rounded-lg border bg-white px-4 py-2.5 text-sm text-slate-900
                           placeholder:text-slate-400 shadow-sm focus:outline-none focus:ring-2 transition
                           <?= isset($erroresLibro["titulo"])
                                ? "border-red-400 focus:border-red-500 focus:ring-red-500/20"
                                : "border-slate-300 focus:border-sky-500 focus:ring-sky-500/20" ?>"
                    placeholder="Ej. Cien años de soledad">
                <?php if (!empty($erroresLibro["titulo"])): ?>
                    <p class="text-sm text-red-600"><?= htmlspecialchars($erroresLibro["titulo"]) ?></p>
                <?php endif; ?>
            </div>

            <div class="space-y-2">
                <label for="autor" class="block text-sm font-medium text-slate-700">
                    Autor
                </label>
                <input
                    type="text"
                    name="autor"
                    id="autor"
                    required
                    autocomplete="off"
                    value="<?= htmlspecialchars($recordarLibro["autor"] ?? "") ?>"
                    class="w-full rounded-lg border bg-white px-4 py-2.5 text-sm text-slate-900
                           placeholder:text-slate-400 shadow-sm focus:outline-none focus:ring-2 transition
                           <?= isset($erroresLibro["autor"])
                                ? "border-red-400 focus:border-red-500 focus:ring-red-500/20"
                                : "border-slate-300 focus:border-sky-500 focus:ring-sky-500/20" ?>"
                    placeholder="Ej. Gabriel García Márquez">
                <?php if (!empty($erroresLibro["autor"])): ?>
                    <p class="text-sm text-red-600"><?= htmlspecialchars($erroresLibro["autor"]) ?></p>
                <?php endif; ?>
            </div>

            <div class="space-y-2">
                <label for="genero" class="block text-sm font-medium text-slate-700">
                    Género
                </label>
                <input
                    type="text"
                    name="genero"
                    id="genero"
                    required
                    autocomplete="off"
                    value="<?= htmlspecialchars($recordarLibro["genero"] ?? "") ?>"
                    class="w-full rounded-lg border bg-white px-4 py-2.5 text-sm text-slate-900
                           placeholder:text-slate-400 shadow-sm focus:outline-none focus:ring-2 transition
                           <?= isset($erroresLibro["genero"])
                                ? "border-red-400 focus:border-red-500 focus:ring-red-500/20"
                                : "border-slate-300 focus:border-sky-500 focus:ring-sky-500/20" ?>"
                    placeholder="Ej. Realismo mágico">
                <?php if (!empty($erroresLibro["genero"])): ?>
                    <p class="text-sm text-red-600"><?= htmlspecialchars($erroresLibro["genero"]) ?></p>
                <?php endif; ?>
            </div>

            <div class="space-y-2">
                <label for="anyo" class="block text-sm font-medium text-slate-700">
                    Año
                </label>
                <input
                    type="number"
                    name="anyo"
                    id="anyo"
                    required
                    min="1000"
                    max="2100"
                    step="1"
                    value="<?= htmlspecialchars($recordarLibro["anyo"] ?? "") ?>"
                    class="w-full rounded-lg border bg-white px-4 py-2.5 text-sm text-slate-900
                           placeholder:text-slate-400 shadow-sm focus:outline-none focus:ring-2 transition
                           <?= isset($erroresLibro["anyo"])
                                ? "border-red-400 focus:border-red-500 focus:ring-red-500/20"
                                : "border-slate-300 focus:border-sky-500 focus:ring-sky-500/20" ?>"
                    placeholder="Ej. 1967">
                <?php if (!empty($erroresLibro["anyo"])): ?>
                    <p class="text-sm text-red-600"><?= htmlspecialchars($erroresLibro["anyo"]) ?></p>
                <?php endif; ?>
            </div>

            <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3 pt-2">
                <a
                    href="./../main.php"
                    class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2.5
                           text-sm font-medium text-slate-700 hover:bg-slate-50 focus-visible:outline-none
                           focus-visible:ring-2 focus-visible:ring-slate-400 focus-visible:ring-offset-2 transition">
                    Cancelar
                </a>
                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-lg bg-sky-600 px-4 py-2.5 text-sm font-medium
                           text-white shadow-sm hover:bg-sky-700 focus-visible:outline-none focus-visible:ring-2
                           focus-visible:ring-sky-400 focus-visible:ring-offset-2 transition">
                    Guardar libro
                </button>
            </div>
        </form>
    </main>

    <script src="./../../../public/js/tailwind.js"></script>
</body>

</html>