<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youdemy</title>
    <link rel="stylesheet" href="./assets/styles/style.css" >
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="text-gray-800 bg-gray-100 font-sans">
<header>
        <div class="logosec">
        <div class="logo">You<span>demy</span></div>
        </div>

        <div class="searchbar">
            <input type="text"
                placeholder="Search">
            <div class="searchbtn">
                <img src="./assets/media/image/search.png"
                    class="icn srchicn"
                    alt="search-icon">
            </div>
        </div>

        <div class="message">
            <div class="circle"></div>
            <img src="https://media.geeksforgeeks.org/wp-content/uploads/20221210183322/8.png"
                class="icn"
                alt="">
            <div class="dp">
                <img src="./assets/media/image/Profil.png"
                    class="dpicn"
                    alt="dp">
                    <a href="../pages/profil.php"></a>
            </div>
        </div>
    </header>

<div id="mobile-menu" class="hidden flex-col md:hidden bg-purple-50 p-4 space-y-4">
    <input type="text" placeholder="Rechercher un cours" class="bg-purple-100 rounded-lg p-2 text-gray-800 w-full border border-purple-300 placeholder-gray-600">
    <button class="bg-white text-purple-600 px-4 py-2 rounded-lg w-full">Connexion</button>
    <button class="bg-purple-500 text-white px-4 py-2 rounded-lg w-full">S'inscrire</button>


    <div class="relative dropdown">
        <button id="mobile-dropdown-button" class="bg-purple-500 w-full px-4 py-2 text-white rounded-md">Catégories</button>
        <ul id="mobile-dropdown-menu" class="absolute top-12 left-0 bg-purple-200 shadow-md rounded-md mt-2 w-full hidden">
            <li class="p-2 hover:bg-purple-300 text-gray-800">Développement Web</li>
            <li class="p-2 hover:bg-purple-300 text-gray-800">Design</li>
            <li class="p-2 hover:bg-purple-300 text-gray-800">Marketing</li>
        </ul>
    </div>
</div>

<section class="relative bg-purple-700 py-16 px-8 text-center text-white">
    <div class="absolute inset-0 bg-purple-700 opacity-80 blur-sm"></div>
    <div class="relative">
        <div class="max-w-2xl mx-auto">
            <h1 class="text-3xl md:text-5xl font-bold text-white mt-[50px]">Apprenez avec Youdemy</h1>
            <p class="mt-4">
                La plateforme idéale pour accroître vos compétences et découvrir des connaissances avec des experts.
            </p>
            <button class="mt-6 bg-purple-600 text-white px-6 py-3 rounded-lg">Explorer les cours</button>
        </div>
    </div>
</section>

<section class="px-8 py-8 bg-white">
    <h2 class="text-xl font-bold mb-4 text-purple-600">Cours les mieux notés</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-purple-50 shadow-md p-4 rounded-lg">
            <img src="./assets/media/image/React-JS.png" alt="React pour Débutants" class="w-full h-32 object-cover rounded-md mb-4">
            <h3 class="text-lg font-bold">React pour Débutants</h3>
            <p class="mt-2 text-gray-600">⭐ 4.9</p>
        </div>
        <div class="bg-purple-50 shadow-md p-4 rounded-lg">
            <img src="./assets/media/image/python.png" alt="Master Python" class="w-full h-32 object-cover rounded-md mb-4">
            <h3 class="text-lg font-bold">Master Python en 30 jours</h3>
            <p class="mt-2 text-gray-600">⭐ 4.8</p>
        </div>
        <div class="bg-purple-50 shadow-md p-4 rounded-lg">
            <img src="./assets/media/image/UX-UI-design-les-besoins-du-marc.png" alt="UI/UX Design" class="w-full h-32 object-cover rounded-md mb-4">
            <h3 class="text-lg font-bold">UI/UX Design : Les Fondations</h3>
            <p class="mt-2 text-gray-600">⭐ 4.7</p>
        </div>
    </div>
</section>

<section class="px-8 py-8 bg-gray-50">
    <h2 class="text-2xl font-bold mb-4 text-purple-600">Ils nous font confiance</h2>
    <div class="flex flex-wrap gap-6 items-center justify-center">
        <img src="./assets/media/image/Vimeo_icon_block.png" alt="vimeo" class="h-12 p-2">
        <img src="./assets/media/image/882747.png" alt="samsung" class="h-12 p-2">
        <img src="./assets/media/image/microsoft.png" alt="volkswagen" class="h-12 p-2">
        <img src="./assets/media/image/png-transparent-google-logo-goog.png" alt="ericsson" class="h-12 p-2">
    </div>
</section>

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
<script>
    document.addEventListener("DOMContentLoaded", () => {
    const dropdownButton = document.getElementById("dropdown-button");
    const dropdownMenu = document.getElementById("dropdown-menu");

    dropdownButton.addEventListener("click", () => {
        dropdownMenu.classList.toggle("hidden");
    });

    document.addEventListener("click", (event) => {
        if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
            dropdownMenu.classList.add("hidden");
        }
    });

    const hamburgerButton = document.getElementById("hamburger-button");
    const mobileMenu = document.getElementById("mobile-menu");

    hamburgerButton.addEventListener("click", () => {
        mobileMenu.classList.toggle("hidden");
    });

    const mobileDropdownButton = document.getElementById("mobile-dropdown-button");
    const mobileDropdownMenu = document.getElementById("mobile-dropdown-menu");

    mobileDropdownButton.addEventListener("click", () => {
        mobileDropdownMenu.classList.toggle("hidden");
    });
    });
</script>
</body>
</html>