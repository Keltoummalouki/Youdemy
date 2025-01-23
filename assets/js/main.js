function setColor(selectElement) {
    const selectedOption = selectElement.options[selectElement.selectedIndex];
    const color = selectedOption.getAttribute('data-color');
    selectElement.style.color = color;
}

function submitStatus(selectElement) {
    setColor(selectElement);
    selectElement.closest('form').submit();
}

document.addEventListener('DOMContentLoaded', ()=>{

    document.getElementsByName('new_status').forEach((item)=>{
        setColor(item);
    });
})
