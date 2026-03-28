<?php 
require __DIR__ . "/../../../vendor/autoload.php";

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
    <?php 
    include __DIR__ . "/../layout/header.php"; 
    $libros = librosUsuario($_SESSION["username"]);

    ?>
    
    <main class="max-w-6xl mx-auto px-4 py-12">
        <h1 class="text-2xl font-bold text-slate-800 mb-6">Mis libros</h1>

        <?php if (count($libros) === 0): ?>
            <p class="text-sm text-slate-600">No has añadido ningún libro todavía.</p>
        <?php else: ?>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                <?php foreach ($libros as $libro): ?>
                    <article
                        class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col justify-between h-full
                               shadow-sm hover:shadow-lg hover:-translate-y-1 hover:border-sky-200
                               transition-all duration-200 ease-out">
                        <div>
                            <h2 class="text-lg font-semibold text-slate-800 mb-2">
                                <?= htmlspecialchars($libro["titulo"]) ?>
                            </h2>
                            <p class="text-sm text-slate-600 mb-4 leading-relaxed">
                                <?= htmlspecialchars($libro["autor"]) ?>
                            </p>
                            <p class="text-sm text-slate-600 mb-4 leading-relaxed">
                                <?= htmlspecialchars($libro["genero"]) ?>
                            </p>
                            <p class="text-sm text-slate-600 mb-4 leading-relaxed">
                                <?= htmlspecialchars($libro["anyo"]) ?>
                            </p>

                        </div>
     
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <script src="./../../../public/js/tailwind.js"></script></body>    
</body>

</html>