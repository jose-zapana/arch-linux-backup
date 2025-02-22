// Generar el slug al escribir en el campo de nombre
const nameInput = document.getElementById("name");
const slugInput = document.getElementById("slug");

if (nameInput && slugInput) {
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
}
