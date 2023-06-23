const fileInput = document.getElementById('file-upload');
const previewImg = document.getElementById('previewImg');

fileInput.addEventListener('change', function() {
    const file = this.files[0];
    const reader = new FileReader();

    reader.addEventListener('load', function() {
        previewImg.src = reader.result;
    });

    reader.readAsDataURL(file);
});