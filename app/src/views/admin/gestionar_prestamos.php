<?php
require __DIR__ . "/../../../vendor/autoload.php";

$prestamos = prestamosAdministracion();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración — Préstamos</title>
    <link rel="stylesheet" href="./../../../public/css/index.css">
</head>
<body class="min-h-screen bg-slate-100">
    <?php include __DIR__ . "/../layout/header.php"; ?>

    <main class="max-w-6xl mx-auto px-4 py-12">
        <h1 class="text-2xl font-bold text-slate-800 mb-2">Gestión de préstamos</h1>
        <p class="text-sm text-slate-600 mb-8">Aquí se muestran todos los préstamos realizados.</p>

        <?php if (count($prestamos) === 0): ?>
            <p class="text-sm text-slate-600">No hay préstamos registrados.</p>
        <?php else: ?>
            <div class="overflow-x-auto bg-white rounded-2xl border border-slate-200 shadow-sm">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-100 text-slate-700">
                        <tr>
                            <th class="px-4 py-3 text-left">ID</th>
                            <th class="px-4 py-3 text-left">Libro</th>
                            <th class="px-4 py-3 text-left">Solicitante</th>
                            <th class="px-4 py-3 text-left">Propietario</th>
                            <th class="px-4 py-3 text-left">Fecha préstamo</th>
                            <th class="px-4 py-3 text-left">Fecha devolución</th>
                            <th class="px-4 py-3 text-left">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($prestamos as $p): ?>
                            <tr class="border-t border-slate-200">
                                <td class="px-4 py-3"><?= (int)$p["id"] ?></td>
                                <td class="px-4 py-3">
                                    <strong><?= htmlspecialchars($p["titulo"]) ?></strong><br>
                                    <span class="text-slate-500"><?= htmlspecialchars($p["autor"]) ?></span>
                                </td>
                                <td class="px-4 py-3"><?= htmlspecialchars($p["solicitante_username"]) ?></td>
                                <td class="px-4 py-3"><?= htmlspecialchars($p["dueno_username"]) ?></td>
                                <td class="px-4 py-3"><?= htmlspecialchars($p["fecha_prestamo"]) ?></td>
                                <td class="px-4 py-3">
                                    <?= $p["fecha_devolucion"] ? htmlspecialchars($p["fecha_devolucion"]) : "-" ?>
                                </td>
                                <td class="px-4 py-3">
                                    <?= ((int)$p["devuelto"] === 1) ? "Devuelto" : "En préstamo" ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </main>

    <script src="./../../../public/js/tailwind.js"></script>
</body>
</html>