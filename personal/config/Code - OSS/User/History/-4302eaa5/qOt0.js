document.addEventListener("DOMContentLoaded", function () {
    const nameInput = document.getElementById("name");
    const slugInput = document.getElementById("slug");

    nameInput.addEventListener("keyup", function () {
        let title = nameInput.value;

        // Normalizar y eliminar caracteres diacríticos (tildes)
        let normalizedTitle = title
            .normalize("NFD")
            .replace(/[\u0300-\u036f]/g, "");

        // Convertir a minúsculas, reemplazar caracteres no permitidos y eliminar guiones al inicio o final
        let slug = normalizedTitle
            .toLowerCase()
            .replace(/[^a-z0-9\s]/g, "") // Elimina caracteres especiales excepto espacios
            .trim() // Elimina espacios en blanco al inicio y final
            .replace(/\s+/g, "-"); // Reemplaza espacios internos con guiones

        slugInput.value = slug;
    });

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

ClassicEditor.create(document.querySelector("#extract")).catch((error) => {
    console.error(error);
});

ClassicEditor.create(document.querySelector("#body")).catch((error) => {
    console.error(error);
});

document.getElementById("file").addEventListener("change", function (event) {
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
        console.error("No file selected or the file is not accessible.");
    }
});
