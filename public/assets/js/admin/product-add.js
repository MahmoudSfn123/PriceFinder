document.addEventListener("DOMContentLoaded", function () {
    const adminUploadConfigs = [
        {
            inputId: "adminImageUpload",
            previewId: "preview-area-admin-image",
            uploadAreaId: "upload-area-admin-image",
            previewImgId: "previewImageAdmin",
            removeBtnId: "removeAdminImage",
        },
        {
            inputId: "adminInvoiceUpload",
            previewId: "preview-area-admin-invoice",
            uploadAreaId: "upload-area-admin-invoice",
            previewImgId: "previewInvoiceAdmin",
            removeBtnId: "removeAdminInvoice",
        },
    ];

    adminUploadConfigs.forEach((config) => {
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

        // Remove image
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

    const productSelect = document.getElementById("productName");
    const newProductGroup = document.getElementById("new-product-name-group");
    const newProductInput = document.getElementById("name");

    if (productSelect && newProductGroup) {
        productSelect.addEventListener("change", function () {
            if (this.value === "add_new") {
                newProductGroup.style.display = "flex";
                newProductInput.required = true;
            } else {
                newProductGroup.style.display = "none";
                newProductInput.required = false;
            }
        });
    }
});


document.getElementById('removeAdminImage')?.addEventListener('click', function () {
    document.getElementById('preview-area-admin-image').style.display = 'none';
    document.getElementById('upload-area-admin-image').style.display = 'block';
});
