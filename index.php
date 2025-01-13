<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youdemy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="./assets/js/index.js"></script>
</head>
<body class="text-gray-800 bg-gray-100 font-sans">
<!-- Barre de navigation -->
<nav class="bg-purple-600 shadow-md p-4 flex justify-between items-center">
    <!-- Logo -->
    <a href="/" class="text-xl font-bold text-white">Youdemy</a>

    <!-- Menu navigation principal -->
    <div class="hidden md:flex items-center space-x-4 flex-1 ml-4">
        <div class="relative dropdown">
            <button id="dropdown-button" class="bg-purple-500 px-4 py-2 text-white rounded-md">Catégories</button>
            <ul id="dropdown-menu" class="absolute top-12 left-0 bg-purple-200 shadow-md rounded-md mt-2 w-40 hidden">
                <li class="p-2 hover:bg-purple-300 text-gray-800">Développement Web</li>
                <li class="p-2 hover:bg-purple-300 text-gray-800">Design</li>
                <li class="p-2 hover:bg-purple-300 text-gray-800">Marketing</li>
            </ul>
        </div>
        <input type="text" placeholder="Rechercher un cours" class="bg-purple-100 rounded-lg p-2 text-gray-800 w-full border border-purple-300 placeholder-gray-600 hidden md:block">
    </div>

    <!-- Boutons (Connexion/Inscriptions) -->
    <div class="hidden md:flex gap-4">
        <button class="bg-white text-purple-600 px-4 py-2 rounded-lg">Connexion</button>
        <button class="bg-purple-500 text-white px-4 py-2 rounded-lg">S'inscrire</button>
    </div>

    <!-- Menu Hamburger -->
    <button id="hamburger-button" class="md:hidden bg-purple-500 text-white p-2 rounded-md">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>
</nav>

<!-- Menu Mobile (Masqué par défaut) -->
<div id="mobile-menu" class="hidden flex-col md:hidden bg-purple-50 p-4 space-y-4">
    <input type="text" placeholder="Rechercher un cours" class="bg-purple-100 rounded-lg p-2 text-gray-800 w-full border border-purple-300 placeholder-gray-600">
    <button class="bg-white text-purple-600 px-4 py-2 rounded-lg w-full">Connexion</button>
    <button class="bg-purple-500 text-white px-4 py-2 rounded-lg w-full">S'inscrire</button>

    <!-- Dropdown pour mobile -->
    <div class="relative dropdown">
        <button id="mobile-dropdown-button" class="bg-purple-500 w-full px-4 py-2 text-white rounded-md">Catégories</button>
        <ul id="mobile-dropdown-menu" class="absolute top-12 left-0 bg-purple-200 shadow-md rounded-md mt-2 w-full hidden">
            <li class="p-2 hover:bg-purple-300 text-gray-800">Développement Web</li>
            <li class="p-2 hover:bg-purple-300 text-gray-800">Design</li>
            <li class="p-2 hover:bg-purple-300 text-gray-800">Marketing</li>
        </ul>
    </div>
</div>

<!-- Section Hero -->
<section class="relative bg-purple-700 py-16 px-8 text-center text-white">
    <!-- Ajout de l'effet flou -->
    <div class="absolute inset-0 bg-purple-700 opacity-80 blur-sm"></div>
    <div class="relative">
        <div class="max-w-2xl mx-auto">
            <h1 class="text-3xl md:text-5xl font-bold text-white">Apprenez avec Youdemy</h1>
            <p class="mt-4">
                La plateforme idéale pour accroître vos compétences et découvrir des connaissances avec des experts.
            </p>
            <button class="mt-6 bg-purple-600 text-white px-6 py-3 rounded-lg">Explorer les cours</button>
        </div>
    </div>
</section>

<!-- Section Cours -->
<section class="px-8 py-8 bg-white">
    <h2 class="text-xl font-bold mb-4 text-purple-600">Cours les mieux notés</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-purple-50 shadow-md p-4 rounded-lg">
            <img src="./assets/react-javascript.webp" alt="React pour Débutants" class="w-full h-32 object-cover rounded-md mb-4">
            <h3 class="text-lg font-bold">React pour Débutants</h3>
            <p class="mt-2 text-gray-600">⭐ 4.9</p>
        </div>
        <div class="bg-purple-50 shadow-md p-4 rounded-lg">
            <img src="./assets/68747470733a2f2f70726f636573732e66732e746561636861626c6563646e2e636f6d2f41444e75704d6e577952376b435752766d37364c617a2f726573697a653d77696474683a3730352f68747470733a2f2f7777772e66696c657069636b6.jpg" alt="Master Python" class="w-full h-32 object-cover rounded-md mb-4">
            <h3 class="text-lg font-bold">Master Python en 30 jours</h3>
            <p class="mt-2 text-gray-600">⭐ 4.8</p>
        </div>
        <div class="bg-purple-50 shadow-md p-4 rounded-lg">
            <img src="./assets/66f2c0ac9bf5fbd4b7d4ccf8_best-ux-course-online-learn-ux-usability-720x403.webp" alt="UI/UX Design" class="w-full h-32 object-cover rounded-md mb-4">
            <h3 class="text-lg font-bold">UI/UX Design : Les Fondations</h3>
            <p class="mt-2 text-gray-600">⭐ 4.7</p>
        </div>
    </div>
</section>

<!-- Section Partenaires -->
<section class="px-8 py-8 bg-gray-50">
    <h2 class="text-2xl font-bold mb-4 text-purple-600">Ils nous font confiance</h2>
    <div class="flex flex-wrap gap-6 items-center justify-center">
        <img src="./assets/vimeo_logo_resized-2.svg" alt="vimeo" class="h-12 p-2">
        <img src="./assets/samsung_logo.svg" alt="samsung" class="h-12 p-2">
        <img src="./assets/volkswagen_logo.svg" alt="volkswagen" class="h-12 p-2">
        <img src="./assets/ericsson_logo.svg" alt="ericsson" class="h-12 p-2">
    </div>
</section>

<!-- Section Avis des étudiants -->
<section class="px-8 py-8 bg-white">
    <h2 class="text-xl font-bold mb-4 text-purple-600">Avis des étudiants</h2>
    <div class="flex flex-col md:flex-row gap-6">
        <div class="bg-purple-50 p-4 shadow-md rounded-lg">
            <p class="text-gray-800">"Super plateforme pour apprendre React !" </p>
            <p class="mt-2 font-bold text-purple-600">- Alice</p>
        </div>
        <div class="bg-purple-50 p-4 shadow-md rounded-lg">
            <p class="text-gray-800">"Les cours sont très bien organisés."</p>
            <p class="mt-2 font-bold text-purple-600">- Bob</p>
        </div>
        <div class="bg-purple-50 p-4 shadow-md rounded-lg">
            <p class="text-gray-800">"Je recommande vivement Youdemy."</p>
            <p class="mt-2 font-bold text-purple-600">- Charlie</p>
        </div>
    </div>
</section>
</body>
</html>