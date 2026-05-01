<?php
require __DIR__ . "/../../../vendor/autoload.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$ok = $_SESSION["import_csv_ok"] ?? "";
$error = $_SESSION["import_csv_error"] ?? "";
$resumen = $_SESSION["import_csv_resumen"] ?? [
    "total_filas" => 0,
    "validas" => 0,
    "insertadas" => 0,
    "rechazadas" => 0,
];
$errores = $_SESSION["import_csv_errores"] ?? [];

unset(
    $_SESSION["import_csv_ok"],
    $_SESSION["import_csv_error"],
    $_SESSION["import_csv_resumen"],
    $_SESSION["import_csv_errores"]
);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Importar CSV — PrestameLo</title>
    <link rel="stylesheet" href="./../../../public/css/index.css">
</head>

<body class="min-h-screen bg-slate-100">
    <?php include __DIR__ . "/../layout/header.php"; ?>

    <main class="max-w-3xl mx-auto px-4 py-12">
        <h1 class="text-2xl font-bold text-slate-800 mb-2">Importar libros por CSV</h1>
        <p class="text-sm text-slate-600 mb-8">
            Formato esperado: titulo, autor, genero, anyo.
            Ejemplo: <code>El Hobbit;J.R.R. Tolkien;Fantasia;1937</code>
        </p>

        <?php if ($ok !== ""): ?>
            <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                <?= htmlspecialchars($ok) ?>
            </div>
        <?php endif; ?>

        <?php if ($error !== ""): ?>
            <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <?php if (($resumen["total_filas"] ?? 0) > 0): ?>
            <div class="mb-6 rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700">
                <p><strong>Total filas leidas:</strong> <?= (int)$resumen["total_filas"] ?></p>
                <p><strong>Filas validas:</strong> <?= (int)$resumen["validas"] ?></p>
                <p><strong>Insertadas:</strong> <?= (int)$resumen["insertadas"] ?></p>
                <p><strong>Rechazadas:</strong> <?= (int)$resumen["rechazadas"] ?></p>
            </div>
        <?php endif; ?>

        <?php if (count($errores) > 0): ?>
            <div class="mb-6 rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900">
                <p class="font-semibold mb-2">Errores encontrados:</p>
                <ul class="list-disc list-inside space-y-1">
                    <?php foreach ($errores as $mensaje): ?>
                        <li><?= htmlspecialchars((string)$mensaje) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form
            action="./../../controllers/libros/procesar-importar-csv.php"
            method="post"
            enctype="multipart/form-data"
            class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 md:p-8 space-y-6">

            <div class="space-y-2">
                <label for="csv_file" class="block text-sm font-medium text-slate-700">Archivo CSV</label>
                <input
                    id="csv_file"
                    name="csv_file"
                    type="file"
                    accept=".csv,text/csv"
                    required
                    class="block w-full text-sm text-slate-700 file:mr-4 file:rounded-lg file:border-0 file:bg-sky-600 file:px-4 file:py-2 file:text-sm file:font-medium file:text-white hover:file:bg-sky-700">
            </div>

            <div class="space-y-2">
                <label for="delimiter" class="block text-sm font-medium text-slate-700">Separador</label>
                <select
                    id="delimiter"
                    name="delimiter"
                    class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500">
                    <option value=";" selected>Punto y coma (;)</option>
                    <option value=",">Coma (,)</option>
                </select>
            </div>

            <label class="inline-flex items-center gap-2 text-sm text-slate-700">
                <input type="checkbox" name="has_header" value="1" checked class="rounded border-slate-300 text-sky-600 focus:ring-sky-500">
                La primera fila contiene cabecera
            </label>

            <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3 pt-2">
                <a
                    href="./../main.php"
                    class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-slate-400 focus-visible:ring-offset-2 transition">
                    Volver
                </a>
                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-lg bg-sky-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-sky-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-sky-400 focus-visible:ring-offset-2 transition">
                    Importar libros
                </button>
            </div>
        </form>
    </main>

    <script src="./../../../public/js/tailwind.js"></script>
</body>

</html>
