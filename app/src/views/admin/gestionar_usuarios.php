<?php
require __DIR__ . "/../../../vendor/autoload.php";

$usuarios = usuariosAdministracionConPrestamos();
$ok = $_SESSION["admin"] ?? "";
$error = $_SESSION["admin_error"] ?? "";
unset($_SESSION["admin"], $_SESSION["admin_error"]);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración — Usuarios</title>
    <link rel="stylesheet" href="./../../../public/css/index.css">
</head>
<body class="min-h-screen bg-slate-100">
    <?php include __DIR__ . "/../layout/header.php"; ?>

    <main class="max-w-6xl mx-auto px-4 py-12">
        <h1 class="text-2xl font-bold text-slate-800 mb-2">Gestión de usuarios</h1>
        <p class="text-sm text-slate-600 mb-8">
            Se pueden dar de baja usuarios solo si no tienen préstamos registrados.
        </p>

        <?php if ($ok !== ""): ?>
            <div class="mb-4 rounded-lg bg-emerald-100 border border-emerald-300 text-emerald-700 px-4 py-3 text-sm">
                <?= htmlspecialchars($ok) ?>
            </div>
        <?php endif; ?>

        <?php if ($error !== ""): ?>
            <div class="mb-4 rounded-lg bg-red-100 border border-red-300 text-red-700 px-4 py-3 text-sm">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <?php if (count($usuarios) === 0): ?>
            <p class="text-sm text-slate-600">No hay usuarios.</p>
        <?php else: ?>
            <div class="overflow-x-auto bg-white rounded-2xl border border-slate-200 shadow-sm">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-100 text-slate-700">
                        <tr>
                            <th class="px-4 py-3 text-left">Usuario</th>
                            <th class="px-4 py-3 text-left">Nombre</th>
                            <th class="px-4 py-3 text-left">Email</th>
                            <th class="px-4 py-3 text-left">Rol</th>
                            <th class="px-4 py-3 text-left">Préstamos</th>
                            <th class="px-4 py-3 text-left">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $u): ?>
                            <?php $bloqueado = ((int)$u["total_prestamos"] > 0); ?>
                            <tr class="border-t border-slate-200">
                                <td class="px-4 py-3"><?= htmlspecialchars($u["username"]) ?></td>
                                <td class="px-4 py-3"><?= htmlspecialchars($u["nombre"] . " " . $u["apellidos"]) ?></td>
                                <td class="px-4 py-3"><?= htmlspecialchars($u["email"]) ?></td>
                                <td class="px-4 py-3"><?= htmlspecialchars($u["role"]) ?></td>
                                <td class="px-4 py-3"><?= (int)$u["total_prestamos"] ?></td>
                                <td class="px-4 py-3">
                                    <form method="POST" action="./../../controllers/admin/procesar-baja-usuario.php">
                                        <input type="hidden" name="id_usuario" value="<?= (int)$u["id"] ?>">
                                        <button
                                            type="submit"
                                            <?= $bloqueado ? "disabled" : "" ?>
                                            class="rounded-lg px-3 py-2 text-xs font-medium text-white
                                                   <?= $bloqueado ? "bg-slate-400 cursor-not-allowed" : "bg-red-500 hover:bg-red-600" ?>">
                                            Dar de baja
                                        </button>
                                    </form>
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