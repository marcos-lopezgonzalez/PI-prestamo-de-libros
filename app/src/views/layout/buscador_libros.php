<?php
$campoActual = $_GET["campo"] ?? "titulo";
$qActual = isset($_GET["q"]) ? trim((string) $_GET["q"]) : "";
$allowedCampos = ["titulo" => "Título", "autor" => "Autor", "genero" => "Género"];
if (!array_key_exists($campoActual, $allowedCampos)) {
    $campoActual = "titulo";
}
?>
<section
    class="mb-8 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm md:p-6"
    aria-label="Buscar libros disponibles">
    <h2 class="text-sm font-semibold text-slate-800 mb-4">Buscar por</h2>
    <form method="get" action="" class="flex flex-col gap-4 md:flex-row md:items-end">
        <div class="w-full md:max-w-[200px]">
            <label for="campo" class="mb-1 block text-xs font-medium text-slate-600">Filtrar por</label>
            <select
                name="campo"
                id="campo"
                class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900
                       shadow-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/20">
                <?php foreach ($allowedCampos as $valor => $etiqueta): ?>
                    <option value="<?= htmlspecialchars($valor) ?>" <?= $campoActual === $valor ? " selected" : "" ?>>
                        <?= htmlspecialchars($etiqueta) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="min-w-0 flex-1">
            <label for="q" class="mb-1 block text-xs font-medium text-slate-600">Texto</label>
            <input
                type="search"
                name="q"
                id="q"
                value="<?= htmlspecialchars($qActual) ?>"
                autocomplete="off"
                placeholder="Escribe para filtrar (vacío = todos los disponibles)"
                class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900
                       placeholder:text-slate-400 shadow-sm focus:border-sky-500 focus:outline-none focus:ring-2
                       focus:ring-sky-500/20">
        </div>
        <div class="flex gap-2 shrink-0">
            <button
                type="submit"
                class="inline-flex items-center justify-center rounded-lg bg-emerald-600 px-5 py-2.5 text-sm font-medium
                       text-white shadow-sm hover:bg-emerald-700 focus-visible:outline-none focus-visible:ring-2
                       focus-visible:ring-emerald-400 focus-visible:ring-offset-2 transition">
                Buscar
            </button>
            <?php if ($qActual !== ""): ?>
                <a
                    href="./lista_libros_disponibles.php"
                    class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2.5
                           text-sm font-medium text-slate-700 hover:bg-slate-50 focus-visible:outline-none
                           focus-visible:ring-2 focus-visible:ring-slate-400 focus-visible:ring-offset-2 transition">
                    Limpiar
                </a>
            <?php endif; ?>
        </div>
    </form>
</section>