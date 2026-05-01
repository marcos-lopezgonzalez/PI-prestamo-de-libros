<?php
require __DIR__ . "/../../../vendor/autoload.php";

session_start();
if (!isset($_SESSION["username"])) {
    header("Location: ./../../../public/index.php");
    exit;
}

$historial = historialPrestamos($_SESSION["username"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./../../../public/css/index.css">
</head>
<body class="min-h-screen bg-slate-100">
    <?php include __DIR__ . "/../layout/header.php" ?>

    <main class="max-w-6xl mx-auto px-4 py-10">
        <h1 class="text-2xl font-semibold text-slate-800 mb-6">Historial de préstamos</h1>

        <?php if (empty($historial)): ?>
            <p class="text-slate-500">Todavía no has solicitado ningún préstamo.</p>
        <?php else: ?>
        <div class="overflow-x-auto rounded-2xl border border-slate-200 shadow-sm">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-800 text-white">
                    <tr>
                        <th class="px-4 py-3">Título</th>
                        <th class="px-4 py-3">Autor</th>
                        <th class="px-4 py-3">Propietario</th>
                        <th class="px-4 py-3">Fecha préstamo</th>
                        <th class="px-4 py-3">Fecha devolución</th>
                        <th class="px-4 py-3">Estado</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    <?php foreach ($historial as $row): ?>
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-4 py-3 font-medium text-slate-800">
                            <?= htmlspecialchars($row["titulo"]) ?>
                        </td>
                        <td class="px-4 py-3 text-slate-600">
                            <?= htmlspecialchars($row["autor"]) ?>
                        </td>
                        <td class="px-4 py-3 text-slate-600">
                            <?= htmlspecialchars($row["propietario_username"]) ?>
                        </td>
                        <td class="px-4 py-3 text-slate-500">
                            <?= htmlspecialchars($row["fecha_prestamo"]) ?>
                        </td>
                        <td class="px-4 py-3 text-slate-500">
                            <?= $row["fecha_devolucion"] 
                                ? htmlspecialchars($row["fecha_devolucion"]) 
                                : "—" ?>
                        </td>
                        <td class="px-4 py-3">
                            <?php if ($row["devuelto"]): ?>
                                <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                                    Devuelto
                                </span>
                            <?php else: ?>
                                <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-700">
                                    En préstamo
                                </span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </main>

</body>

<script src="./../../../public/js/tailwind.js"></script>
</html>