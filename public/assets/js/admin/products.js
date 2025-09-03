// Search functionality
document.getElementById("searchInput").addEventListener("input", function (e) {
    const searchTerm = e.target.value.toLowerCase();
    const rows = document.querySelectorAll(".table-row");

    rows.forEach((row) => {
        const productName = row
            .querySelector(".product-name")
            .textContent.toLowerCase();
        if (productName.includes(searchTerm)) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
});

function confirmDelete(id) {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this deletion!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it!",
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById("delete-form-" + id).submit();
        }
    });
}

function approveProduct(id) {
    console.log(`Approved product ${id}`);
    // Here you would typically update the product status in your backend
}

function rejectProduct(id) {
    console.log(`Rejected product ${id}`);
    // Here you would typically update the product status or delete it
}

function viewInvoice(url) {
    window.open(url, '_blank');
}
// Dropdown functionality
document.addEventListener("click", function (e) {
    // Close all dropdowns
    document.querySelectorAll(".dropdown-menu").forEach((menu) => {
        menu.classList.remove("show");
    });

    // Open clicked dropdown
    if (e.target.closest(".actions-trigger")) {
        e.preventDefault();
        const menu = e.target
            .closest(".actions-dropdown")
            .querySelector(".dropdown-menu");
        menu.classList.add("show");
    }
});

// Prevent dropdown from closing when clicking inside
document.querySelectorAll(".dropdown-menu").forEach((menu) => {
    menu.addEventListener("click", function (e) {
        e.stopPropagation();
    });
});

document.addEventListener("DOMContentLoaded", () => {
    const paginationContainer = document.querySelector(".pagination-container");

    if (!paginationContainer) return;

    paginationContainer.addEventListener("click", (event) => {
        const button = event.target.closest("button[data-url]");
        if (!button) return;

        const url = button.getAttribute("data-url");
        if (url) {
            // Redirect to the page URL (reload page with new data)
            window.location.href = url;
        }
    });
});
