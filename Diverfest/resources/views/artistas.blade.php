<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artistas | Diver Fest</title>
    <!-- Incluyendo Tailwind CSS via CDN para la prueba, idealmente configúralo con Vite en Laravel -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Colores personalizados basados en la imagen */
        .bg-navbar { background-color: #d62259; }
        .bg-body { background-color: #faebd7; } /* Un tono pastel similar al fondo de la imagen */
    </style>
</head>
<body class="bg-body font-sans text-gray-800">

    <!-- Navbar -->
    <nav class="bg-navbar text-white flex justify-between items-center px-6 py-3">
        <!-- Icono Casa -->
        <div class="flex items-center cursor-pointer">
            <svg class="w-8 h-8 text-gray-800" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
            </svg>
        </div>

        <!-- Enlaces del menú -->
        <div class="flex space-x-6 text-lg font-medium">
            <a href="#" class="hover:text-gray-300 flex items-center">Festival <span class="ml-1 text-xs">▼</span></a>
            <a href="#" class="hover:text-gray-300 flex items-center">Entradas <span class="ml-1 text-xs">▼</span></a>
            <a href="#" class="hover:text-gray-300 flex items-center">Información <span class="ml-1 text-xs">▼</span></a>
        </div>

        <!-- Icono Usuario -->
        <div class="cursor-pointer">
            <svg class="w-8 h-8 text-gray-800" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
            </svg>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <main class="container mx-auto px-4 py-8 max-w-5xl">
        
        <!-- Título -->
        <h1 class="text-6xl font-bold text-center text-gray-800 mb-8 font-serif">Artistas</h1>

        <!-- Filtros y Búsqueda -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-10 space-y-4 md:space-y-0 md:space-x-4">
            
            <div class="flex space-x-4 w-full md:w-1/2">
                <!-- Select Día -->
                <div class="relative w-1/2 border-2 border-black bg-white">
                    <select class="w-full p-2 appearance-none bg-transparent outline-none cursor-pointer">
                        <option value="">día</option>
                        <option value="1">Viernes</option>
                        <option value="2">Sábado</option>
                        <option value="3">Domingo</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" viewBox="0 0 20 20"><path d="M5 8h10l-5 5-5-5z"/></svg>
                    </div>
                </div>

                <!-- Select Género -->
                <div class="relative w-1/2 border-2 border-black bg-white">
                    <select class="w-full p-2 appearance-none bg-transparent outline-none cursor-pointer">
                        <option value="">género</option>
                        <option value="infantil">Infantil</option>
                        <option value="magia">Magia</option>
                        <option value="humor">Humor</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" viewBox="0 0 20 20"><path d="M5 8h10l-5 5-5-5z"/></svg>
                    </div>
                </div>
            </div>

            <!-- Barra de búsqueda -->
            <div class="w-full md:w-1/2 flex border-2 border-black bg-white">
                <input type="text" placeholder="Buscar" class="w-full p-2 outline-none">
                <button class="px-3 bg-gray-100 hover:bg-gray-200 border-l-2 border-black">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </button>
            </div>
        </div>

        <!-- Cuadrícula de Artistas -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            
            <!-- Tarjeta Artista 1 -->
            <div class="relative group cursor-pointer aspect-square bg-gray-300 border border-gray-400 overflow-hidden shadow-lg">
                <!-- HUECO PARA IMAGEN: Reemplaza el src con la ruta de tu imagen -->
                <img src="/img/artistas/placeholder.jpg" alt="Los Lunnis" class="w-full h-full object-cover">
                <div class="absolute bottom-0 w-full bg-black bg-opacity-60 py-2 text-center">
                    <h2 class="text-xl font-bold text-red-400">Los Lunnis</h2>
                </div>
            </div>

            <!-- Tarjeta Artista 2 -->
            <div class="relative group cursor-pointer aspect-square bg-gray-300 border border-gray-400 overflow-hidden shadow-lg">
                <!-- HUECO PARA IMAGEN -->
                <img src="/img/artistas/placeholder.jpg" alt="Cantajuegos" class="w-full h-full object-cover">
                <div class="absolute bottom-0 w-full bg-black bg-opacity-60 py-2 text-center">
                    <h2 class="text-xl font-bold text-red-400">Cantajuegos</h2>
                </div>
            </div>

            <!-- Tarjeta Artista 3 -->
            <div class="relative group cursor-pointer aspect-square bg-gray-300 border border-gray-400 overflow-hidden shadow-lg">
                <!-- HUECO PARA IMAGEN -->
                <img src="/img/artistas/placeholder.jpg" alt="Un payaso" class="w-full h-full object-cover">
                <div class="absolute bottom-0 w-full bg-black bg-opacity-60 py-2 text-center">
                    <h2 class="text-xl font-bold text-red-400">Un payaso</h2>
                </div>
            </div>

            <!-- Tarjeta Artista 4 -->
            <div class="relative group cursor-pointer aspect-square bg-gray-300 border border-gray-400 overflow-hidden shadow-lg">
                <!-- HUECO PARA IMAGEN -->
                <img src="/img/artistas/placeholder.jpg" alt="Pocoyó" class="w-full h-full object-cover">
                <div class="absolute bottom-0 w-full bg-black bg-opacity-60 py-2 text-center">
                    <h2 class="text-xl font-bold text-red-400">Pocoyó</h2>
                </div>
            </div>

            <!-- Tarjeta Artista 5 -->
            <div class="relative group cursor-pointer aspect-square bg-gray-300 border border-gray-400 overflow-hidden shadow-lg">
                <!-- HUECO PARA IMAGEN -->
                <img src="/img/artistas/placeholder.jpg" alt="Mr. X" class="w-full h-full object-cover">
                <div class="absolute bottom-0 w-full bg-black bg-opacity-60 py-2 text-center">
                    <h2 class="text-xl font-bold text-red-400">Mr. X</h2>
                </div>
            </div>

            <!-- Tarjeta Artista 6 -->
            <div class="relative group cursor-pointer aspect-square bg-gray-300 border border-gray-400 overflow-hidden shadow-lg">
                <!-- HUECO PARA IMAGEN -->
                <img src="/img/artistas/placeholder.jpg" alt="Los tubo" class="w-full h-full object-cover">
                <div class="absolute bottom-0 w-full bg-black bg-opacity-60 py-2 text-center">
                    <h2 class="text-xl font-bold text-red-400">Los tubo</h2>
                </div>
            </div>

            <!-- Tarjeta Artista 7 -->
            <div class="relative group cursor-pointer aspect-square bg-gray-300 border border-gray-400 overflow-hidden shadow-lg">
                <!-- HUECO PARA IMAGEN -->
                <img src="/img/artistas/placeholder.jpg" alt="Un pez" class="w-full h-full object-cover">
                <div class="absolute bottom-0 w-full bg-black bg-opacity-60 py-2 text-center">
                    <h2 class="text-xl font-bold text-red-400">Un pez</h2>
                </div>
            </div>

            <!-- Tarjeta Artista 8 -->
            <div class="relative group cursor-pointer aspect-square bg-gray-300 border border-gray-400 overflow-hidden shadow-lg">
                <!-- HUECO PARA IMAGEN -->
                <img src="/img/artistas/placeholder.jpg" alt="¡Otro payaso!" class="w-full h-full object-cover">
                <div class="absolute bottom-0 w-full bg-black bg-opacity-60 py-2 text-center">
                    <h2 class="text-xl font-bold text-red-400">¡Otro payaso!</h2>
                </div>
            </div>

        </div>
    </main>

</body>
</html>