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

// Dropdown functionality
document.querySelectorAll('.actions-trigger').forEach(button => {
    button.addEventListener('click', function (e) {
        e.stopPropagation();

        const dropdown = this.nextElementSibling; // the .dropdown-menu
        if (!dropdown) return;

        // Toggle dropdown visibility
        dropdown.classList.toggle('show');

        // Close other dropdowns
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            if (menu !== dropdown) {
                menu.classList.remove('show', 'drop-up');
            }
        });

        // Check if dropdown overflows viewport bottom
        const rect = dropdown.getBoundingClientRect();
        const viewportHeight = window.innerHeight || document.documentElement.clientHeight;

        if (rect.bottom > viewportHeight) {
            dropdown.classList.add('drop-up'); // open upward
        } else {
            dropdown.classList.remove('drop-up'); // open downward
        }
    });
});

// Close dropdown if clicking outside
document.addEventListener('click', () => {
    document.querySelectorAll('.dropdown-menu').forEach(menu => {
        menu.classList.remove('show', 'drop-up');
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

function confirmDeleteUser(event) {
    event.preventDefault(); // prevent immediate submit

    if (confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
        event.target.submit();  // submit the form if confirmed
    } else {
        // Do nothing if cancelled
    }

    return false;  // prevent form submit until confirmed
}
