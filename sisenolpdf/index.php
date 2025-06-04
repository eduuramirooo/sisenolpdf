<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sisenol Solutions</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 pt-16 pb-28">
    <!-- Header -->
    <header class="bg-white text-[#292727] w-full fixed top-0 left-0 z-50 shadow">
    <div class="px-6 py-4 flex justify-between items-center max-w-7xl mx-auto">
        <!-- Logo -->
        <div class="flex items-center space-x-3">
            <a href="/">
                <img src="img/logo.png" alt="Sisenol Solutions" class="h-8" onerror="this.onerror=null; this.src='img/default-logo.png';">
            </a>
        </div>

        <!-- Botón hamburguesa móvil -->
        <button class="sm:hidden text-[#216869] focus:outline-none" onclick="document.getElementById('nav-menu').classList.toggle('hidden')">
            ☰
        </button>

        <!-- Navegación -->
        <nav id="nav-menu" class="hidden sm:flex sm:space-x-6 sm:items-center text-sm absolute sm:static top-full left-0 w-full sm:w-auto bg-white sm:bg-transparent shadow sm:shadow-none px-6 sm:px-0 py-4 sm:py-0 z-40">
            <a href="#" class="block py-2 sm:py-0 hover:text-[#9CC5A1]">Soluciones</a>
            <a href="#" class="block py-2 sm:py-0 hover:text-[#9CC5A1]">Proyectos</a>
            <a href="#" class="block py-2 sm:py-0 hover:text-[#9CC5A1]">Contáctanos</a>
        </nav>
    </div>
</header>

    <!-- Contenido -->
    <main class="min-h-[calc(100vh-7rem)]">
        <div class="max-w-7xl mx-auto px-6 py-10">
    <?php include 'form.php'; ?>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white text-gray-600 border-t w-full fixed bottom-0 left-0 z-40">
    <div class="px-6 py-4 flex flex-col md:flex-row justify-between items-center text-sm max-w-7xl mx-auto space-y-4 md:space-y-0">
        <!-- Logo y enlaces -->
        <div class="flex flex-col md:flex-row md:items-center space-y-4 md:space-y-0 md:space-x-6 text-center md:text-left">
            <img src="img/icon.png" alt="Logo Sisenol" class="h-8 md:h-10 mx-auto md:mx-0">
            <div class="flex flex-col sm:flex-row sm:space-x-4 space-y-2 sm:space-y-0">
                <a href="#" class="hover:underline">Quiénes somos</a>
                <a href="#" class="hover:underline">Soluciones</a>
                <a href="#" class="hover:underline">Contáctanos</a>
            </div>
        </div>

        <!-- Información legal -->
        <div class="text-center md:text-right text-xs text-gray-400">
            Diseñado por Sisenol Solutions © 2023. Todos los derechos reservados. <br>
            <a href="#" class="hover:underline">Política de calidad y medio ambiente</a> |
            <a href="#" class="hover:underline">Política de privacidad</a>
        </div>
    </div>
</footer>
</body>
</html>
