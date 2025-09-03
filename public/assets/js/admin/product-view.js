document.addEventListener("DOMContentLoaded", function () {
        const container = document.querySelector(".pagination");

        if (container) {
            container.addEventListener("click", function (e) {
                const target = e.target.closest("button[data-url]");
                if (target && !target.disabled) {
                    const url = target.getAttribute("data-url");
                    if (url) {
                        window.location.href = url;
                    }
                }
            });

        }
    });
    // Dropdown functionality
        document.addEventListener('click', function(e) {
            // Close all dropdowns
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.classList.remove('show');
            });

            // Open clicked dropdown
            if (e.target.closest('.actions-trigger')) {
                e.preventDefault();
                const menu = e.target.closest('.actions-dropdown').querySelector('.dropdown-menu');
                menu.classList.add('show');
            }
        });

        // Prevent dropdown from closing when clicking inside
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            menu.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });
