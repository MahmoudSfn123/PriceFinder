
    <header class="admin-navbar">
        <div class="navbar-content">
            <div class="navbar-left">
                <!-- Breadcrumbs or page title can go here -->
            </div>
            <div class="navbar-right">
                <form class="search-form">
                    <div class="search-container">
                        <i class="fas fa-search search-icon"></i>
                        <input type="search" placeholder="Search..." class="search-input">
                    </div>
                </form>

                <div class="user-menu">
                    <button class="user-button" onclick="toggleUserMenu()">
                        <img src="https://i.pravatar.cc/150?u=admin" alt="Admin" class="user-avatar">
                    </button>
                    <div class="user-dropdown" id="userDropdown">
                        <div class="dropdown-header">My Account</div>
                        <a href="#" class="dropdown-item">Profile</a>
                        <a href="#" class="dropdown-item">Settings</a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <script>
        function toggleUserMenu() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('show');
        }

        // Close dropdown when clicking outside
        window.addEventListener('click', function(event) {
            if (!event.target.matches('.user-button') && !event.target.matches('.user-avatar')) {
                const dropdown = document.getElementById('userDropdown');
                if (dropdown.classList.contains('show')) {
                    dropdown.classList.remove('show');
                }
            }
        });
    </script>
