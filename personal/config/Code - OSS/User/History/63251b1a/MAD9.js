document.addEventListener("DOMContentLoaded", function () {
    if (document.querySelector("#body")) {
        ClassicEditor.create(document.querySelector("#body"), {
            simpleUpload: {
                // La URL a la que se suben las imágenes.
                uploadUrl: "{{ route('admin.ckeditor.upload') }}",
                // Habilitar la propiedad XMLHttpRequest.withCredentials.
                withCredentials: true,
                // Encabezados enviados junto con la solicitud XMLHttpRequest al servidor de carga.
                headers: {
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
            },
        }).catch((error) => {
            console.error(error);
        });
    }
});
