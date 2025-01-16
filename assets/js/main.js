let menuicn = document.querySelector(".menuicn");
let nav = document.querySelector(".navcontainer");

menuicn.addEventListener("click", () => {
    nav.classList.toggle("navclose");
})

function updateSelectColor(selectElement) {
    const selectedOption = selectElement.options[selectElement.selectedIndex];
    const color = selectedOption.getAttribute('data-color');
    selectElement.style.color = color;
}

const accountStatusSelect = document.getElementById('accountStatus');
updateSelectColor(accountStatusSelect);