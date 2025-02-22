if (document.querySelector("#name") && document.querySelector("#slug")) {
    const nameInput = document.getElementById("name");
    const slugInput = document.getElementById("slug");

    nameInput.addEventListener("keyup", function () {
        let title = nameInput.value;

        let normalizedTitle = title
            .normalize("NFD")
            .replace(/[\u0300-\u036f]/g, "");

        let slug = normalizedTitle
            .toLowerCase()
            .replace(/[^a-z0-9\s]/g, "")
            .trim()
            .replace(/\s+/g, "-");

        slugInput.value = slug;
    });
}
