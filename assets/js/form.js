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

document.getElementById('form-edit').addEventListener('submit', function() {
    const description = quill.root.innerHTML;
    document.getElementById('description-input').value = description;
});