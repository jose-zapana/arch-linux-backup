if (document.querySelector("#body")) {
    ClassicEditor.create(document.querySelector("#body"), {
        simpleUpload: {
            uploadUrl: "{{ route('admin.ckeditor.upload') }}",
            withCredentials: true,
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
        },
    }).catch((error) => {
        console.error("Error al inicializar CKEditor:", error);
    });
}
