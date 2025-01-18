const quill = new Quill('#editor', {
    theme: 'snow',
    modules: {
        toolbar: [
            ['bold', 'italic', 'underline'],
            [{ 'header': [1, 2, 3, false] }],
            ['link', 'image'],
            ['clean']
        ]
    }
});

document.getElementById('form-add').onsubmit = function () {
    var editor = document.getElementById('editor');
    var descriptionInput = document.getElementById('description-input');
    descriptionInput.value = editor.innerHTML; 
};