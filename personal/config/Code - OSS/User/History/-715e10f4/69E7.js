document.addEventListener("DOMContentLoaded", function () {
    document
        .getElementById("file")
        .addEventListener("change", function (event) {
            const file = event.target.files[0];
            const reader = new FileReader();
            reader.onload = function (event) {
                document
                    .getElementById("picture")
                    .setAttribute("src", event.target.result);
            };
            if (file) {
                reader.readAsDataURL(file);
            } else {
                console.error(
                    "No file selected or the file is not accessible."
                );
            }
        });
});
