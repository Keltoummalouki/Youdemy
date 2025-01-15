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