document.addEventListener("DOMContentLoaded", function () {
    // Define config for each upload section
    const uploadConfigs = [
        {
            inputId: "file-upload",
            areaId: "upload-area-invoice",
            previewId: "file-preview-invoice",
            removeBtnId: "remove-file-invoice",
        },
        {
            inputId: "file-upload-image",
            areaId: "upload-area-image",
            previewId: "file-preview-image",
            removeBtnId: "remove-file-image",
        },
    ];

    uploadConfigs.forEach((config) => {
        const uploadArea = document.getElementById(config.areaId);
        const fileInput = document.getElementById(config.inputId);
        const filePreview = document.getElementById(config.previewId);
        const removeFileButton = document.getElementById(config.removeBtnId);
        const fileNameElement = filePreview.querySelector(".file-name");
        const fileSizeElement = filePreview.querySelector(".file-size");

        if (!uploadArea || !fileInput || !filePreview || !removeFileButton)
            return;

        // Drag and drop
        uploadArea.addEventListener("dragover", function (e) {
            e.preventDefault();
            uploadArea.classList.add("dragging");
        });

        uploadArea.addEventListener("dragleave", function (e) {
            e.preventDefault();
            uploadArea.classList.remove("dragging");
        });

        uploadArea.addEventListener("drop", function (e) {
            e.preventDefault();
            uploadArea.classList.remove("dragging");
            const files = e.dataTransfer.files;
            if (files.length) handleFile(files[0]);
        });



        // Handle file input change
        fileInput.addEventListener("change", function () {
            if (fileInput.files.length) handleFile(fileInput.files[0]);
        });

        // Remove file button
        removeFileButton.addEventListener("click", function () {
            fileInput.value = "";
            uploadArea.classList.remove("hidden");
            filePreview.classList.add("hidden");
            fileNameElement.textContent = "";
            fileSizeElement.textContent = "";
        });

        function handleFile(file) {
            const allowedTypes = [
                "image/jpeg",
                "image/png",
                "image/jpg",
                "application/pdf",
            ];

            if (!allowedTypes.includes(file.type)) {
                alert("Only PDF, PNG, JPG or JPEG files are allowed.");
                return;
            }

            fileNameElement.textContent = file.name;
            fileSizeElement.textContent = `${(file.size / 1024).toFixed(2)} KB`;
            uploadArea.classList.add("hidden");
            filePreview.classList.remove("hidden");
        }
    });
    const productSelect = document.getElementById("product-select");
    const newProductGroup = document.getElementById("new-product-name-group");
    const newProductInput = document.getElementById("name");

    if (productSelect && newProductGroup) {
        productSelect.addEventListener("change", function () {
            if (this.value === "add_new") {
                newProductGroup.style.display = "block";
                newProductInput.required = true;
            } else {
                newProductGroup.style.display = "none";
                newProductInput.required = false;
            }
        });
    }
});







