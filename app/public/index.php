<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Proyecto Intermodular — Préstamo de libros</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/index.css">
</head>

<body class="min-h-screen bg-gradient-to-b from-sky-50 to-white flex items-center justify-center p-6">
    <main class="w-full max-w-6xl">
        <div class="bg-white shadow-lg rounded-2xl overflow-hidden grid grid-cols-1 lg:grid-cols-2">
            <!-- IZQ: Bienvenida -->
            <section class="p-10 lg:p-14 bg-gradient-to-br from-sky-600 to-indigo-600 text-white">
                <div class="max-w-xl mx-auto flex flex-col justify-center items-center text-center">
                    <img src="./img/logo.png" alt="">
                    <h2 class="text-2xl lg:text-3xl font-semibold mb-4">¡Bienvenido a la comunidad de PrestameLo!</h2>
                    <p class="text-sky-100/90 mb-6 leading-relaxed">
                        Comparte tus libros con otras personas aficionadas a la lectura. Da de alta tus títulos, pide préstamos y
                        gestiona todo desde tu perfil.
                    </p>
                </div>
            </section>

            <!-- DER: Login / Registro -->
            <aside class="p-8 lg:p-12">
                <div class="max-w-md mx-auto">
                    <!-- Tabs visuales -->
                    <div class="bg-gray-100 rounded-xl p-1 flex items-center gap-1 mb-6" role="tablist" aria-label="Autenticación">
                        <button class="flex-1 py-2 px-4 rounded-lg bg-white text-sky-700 font-semibold shadow-sm" role="tab" aria-selected="true" aria-controls="panel-login" id="tab-login">Entrar</button>
                        <button class="flex-1 py-2 px-4 rounded-lg text-gray-600 hover:text-sky-700" role="tab" aria-selected="false" aria-controls="panel-register" id="tab-register">Crear cuenta</button>
                    </div>

                    <!-- Panel: Login -->
                    <div id="panel-login" role="tabpanel" aria-labelledby="tab-login">
                        <form class="space-y-4" action="./../src/controllers/procesar-login.php" method="post">
                            <div>
                                <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Usuario</label>
                                <input id="username" name="username" type="text" placeholder="Usuario" class="block w-full rounded-lg border border-gray-200 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-sky-300" />
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
                                <input id="password" name="password" type="password" placeholder="********" class="block w-full rounded-lg border border-gray-200 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-sky-300" />
                            </div>

                            <div class="flex items-center justify-between text-sm">
                                <label class="inline-flex items-center gap-2">
                                    <input type="checkbox" name="recordar" class="h-4 w-4 text-sky-600 rounded" />
                                    <span class="text-gray-600">Recordarme</span>
                                </label>
                            </div>

                            <div class="pt-2">
                                <button type="submit" class="w-full bg-sky-600 hover:bg-sky-700 text-white font-semibold py-2 rounded-lg shadow">Entrar</button>
                            </div>

                            <!-- Para el futuro -->
                            <!-- <div class="mt-3">
                                <div class="text-center text-sm text-gray-500 mb-3">o inicia sesión con</div>
                                <div class="flex gap-3">
                                    <button type="button" class="flex-1 inline-flex items-center justify-center gap-2 rounded-lg border border-gray-200 px-3 py-2 text-sm hover:shadow">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                            <path d="M21 11.5a8.5 8.5 0 10-15.9 4.9l-1.2 3.6 3.7-1.2A8.5 8.5 0 0021 11.5z" fill="#EA4335" />
                                        </svg>
                                        Google
                                    </button>
                                </div>
                            </div> -->
                        </form>
                    </div>

                    <!-- Panel: Registro (oculto por defecto) -->
                    <div id="panel-register" role="tabpanel" aria-labelledby="tab-register" class="hidden mt-6">
                        <form class="space-y-4" action="./../src/controllers/procesar-registro.php" method="post">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                                    <input id="nombre" name="nombre" type="text" placeholder="Nombre" class="block w-full rounded-lg border border-gray-200 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-sky-300" />
                                </div>
                                <div>
                                    <label for="apellidos" class="block text-sm font-medium text-gray-700 mb-1">Apellidos</label>
                                    <input id="apellidos" name="apellidos" type="text" placeholder="Apellidos" class="block w-full rounded-lg border border-gray-200 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-sky-300" />
                                </div>
                            </div>

                            <div>
                                <label for="reg-username" class="block text-sm font-medium text-gray-700 mb-1">Usuario</label>
                                <input id="reg-username" name="username" placeholder="Usuario" class="block w-full rounded-lg border border-gray-200 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-sky-300" />
                            </div>

                            <div>
                                <label for="reg-password" class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
                                <input id="reg-password" name="password" type="password" placeholder="Mínimo 8 caracteres" class="block w-full rounded-lg border border-gray-200 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-sky-300" />
                            </div>

                            <div>
                                <button type="submit" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-semibold py-2 rounded-lg shadow">Crear cuenta</button>
                            </div>
                        </form>
                    </div>
                </div>
            </aside>
        </div>
    </main>
</body>

</html>
<script src="./js/tailwind.js"></script>
<script src="./js/index.js"></script>