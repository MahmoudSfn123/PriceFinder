document.addEventListener("DOMContentLoaded", function () {
    const config = {
        inputId: "adminImageUpload",
        previewId: "preview-area-admin-image",
        uploadAreaId: "upload-area-admin-image",
        previewImgId: "previewImageAdmin",
        removeBtnId: "removeAdminImage",
    };

    const input = document.getElementById(config.inputId);
    const preview = document.getElementById(config.previewId);
    const uploadArea = document.getElementById(config.uploadAreaId);
    const previewImg = document.getElementById(config.previewImgId);
    const removeBtn = document.getElementById(config.removeBtnId);

    if (!input || !preview || !uploadArea || !previewImg || !removeBtn) return;

    // Handle file input
    input.addEventListener("change", function () {
        const file = input.files[0];
        if (!file) return;

        const allowed = ["image/jpeg", "image/png", "image/jpg"];
        if (!allowed.includes(file.type)) {
            alert("Only JPG, JPEG, or PNG images are allowed.");
            input.value = "";
            return;
        }

        const reader = new FileReader();
        reader.onload = function (e) {
            previewImg.src = e.target.result;
            uploadArea.style.display = "none";
            preview.style.display = "block";
        };
        reader.readAsDataURL(file);
    });

    // Remove image (resets to empty)
    removeBtn.addEventListener("click", function () {
        input.value = "";
        previewImg.src = "";
        preview.style.display = "none";
        uploadArea.style.display = "flex";
    });

    // Optional drag & drop
    uploadArea.addEventListener("dragover", function (e) {
        e.preventDefault();
        uploadArea.classList.add("dragging");
    });

    uploadArea.addEventListener("dragleave", function () {
        uploadArea.classList.remove("dragging");
    });

    uploadArea.addEventListener("drop", function (e) {
        e.preventDefault();
        uploadArea.classList.remove("dragging");

        const file = e.dataTransfer.files[0];
        if (file) {
            input.files = e.dataTransfer.files;
            const event = new Event("change");
            input.dispatchEvent(event);
        }
    });
});
