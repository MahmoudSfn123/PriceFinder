@props(['homepage' => false])
<!--PreLoader-->
<div class="loader">
    <div class="loader-inner">
        <div class="circle"></div>
    </div>
</div>
<!--PreLoader Ends-->

<!-- header -->
<div class="top-header-area {{ $homepage ? 'home-header' : 'inner-header' }}" id="sticker">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-sm-12 text-center">
                <div class="main-menu-wrap">
                    <!-- logo -->
                    <a href="{{ route('home.index') }}" class="button" data-text="Awesome">
                        <span class="actual-text">&nbsp;PriceFinder&nbsp;</span>
                        <span aria-hidden="true" class="hover-text">&nbsp;PriceFinder&nbsp;</span>
                    </a>

                    <!-- logo -->


                    <!-- menu start -->
                    <nav class="main-menu">
                        <ul>
                            <li class="current-list-item"><a href="/">Home</a></li>
                            <li><a href="{{ route('products.show') }}">Products</a></li>
                            <li><a href="{{ route('home.index') }}#categories" onclick="smoothScrollTo('categories'); ">Categories</a></li>
                            <li><a href="/about">About</a></li>
                            <li><a href="/contact">Contact</a></li>
                            <li>
                                <div class="header-icons">
                                    @auth
                                        <span class="border-r-2-pr-2">
                                            Hi there, {{ Auth::user()->first_name }}
                                        </span>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button class="boxed-btn">Logout</button>
                                        </form>
                                    @endauth

                                    @guest
                                        <a href="{{ route('signup.show') }}" class="boxed-btn">Signup</a>
                                        <a href="{{ route('login.show') }}" class="bordered-btn">Login</a>
                                    @endguest
                                </div>
                            </li>
                        </ul>
                    </nav>


                    <div class="mobile-menu"></div>
                    <!-- menu end -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end header -->
