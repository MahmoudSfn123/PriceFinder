    <aside class="admin-sidebar">
        <div class="sidebar-header">
            <span class="brand-name">Price</span><span class="half-brand-name">Finder</span>
        </div>

        <nav class="sidebar-nav">
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="/admin/dashboard" class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt nav-icon"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/admin/products"
                        class="nav-link {{ request()->is('admin/products') || request()->is('admin/products/*') ? 'active' : '' }}">
                        <i class="fas fa-database nav-icon"></i>
                        <span class="nav-text">Products</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/admin/categories"
                        class="nav-link {{ request()->is('admin/categories') || request()->is('admin/categories/*') ? 'active' : '' }}">
                        <i class="fas fa-tag nav-icon"></i>
                        <span class="nav-text">Categories</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/admin/users" class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                        <i class="fas fa-users nav-icon"></i>
                        <span class="nav-text">Users</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/admin/verifications"
                        class="nav-link {{ request()->is('admin/verifications') ? 'active' : '' }}">
                        <i class="fas fa-shield-alt nav-icon"></i>
                        <span class="nav-text">Verification</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/admin/discussions"
                        class="nav-link {{ request()->is('admin/discussions') || request()->is('admin/discussions/*') ? 'active' : '' }}">
                        <i class="fas fa-comments nav-icon"></i>
                        <span class="nav-text">Discussions</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/admin/reviews"
                        class="nav-link {{ request()->is('admin/reviews') || request()->is('admin/reviews/*') ? 'active' : '' }}">
                        <i class="fas fa-solid fa-star nav-icon"></i>
                        <span class="nav-text">Reviews & Ratings</span>
                    </a>
                </li>
            </ul>
        </nav>

        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button class="back-to-site"><i class="fas fa-arrow-left"></i>Logout</button>

            </form>
        </div>
    </aside>
