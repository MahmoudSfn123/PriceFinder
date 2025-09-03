<x-app-layout title='Home Page' :homepage="true">


        <x-slot:firstpage>



            <section class="hero-section">
                <!-- Animated Background -->
                <div class="hero-background"></div>
                <div class="hero-overlay"></div>

                <!-- Floating Elements -->
                <div class="floating-element floating-1"></div>
                <div class="floating-element floating-2"></div>
                <div class="floating-element floating-3"></div>


                <div class="hero-content">
                    <div class="container">
                        <div class="hero-inner">
                            <!-- Main Heading -->
                            <div class="hero-text">
                                <h1 class="hero-title">
                                    <span class="title-line">Compare</span>
                                    <span class="title-line accent-1">Save</span>
                                    <span class="title-line accent-2">Win</span>
                                </h1>
                                <div class="title-divider"></div>
                                <p class="hero-description">
                                    Discover the best deals across thousands of products and retailers.
                                    <span class="description-highlight">Save money on every purchase, instantly.</span>
                                </p>
                            </div>

                            <!-- Enhanced Search Area -->
                            <div class="search-container">
                                <div class="search-glow"></div>
                                <div class="search-card">
                                    <div class="search-header">
                                        <h2 class="search-title">
                                            🔍 Start Your Search
                                        </h2>
                                        <p class="search-subtitle">
                                            Find the best prices in seconds
                                        </p>
                                    </div>
                                    <div id="search-component">
                                        <x-search-product :category="$category" :products="$products" :searchQuery="$searchQuery"
                                            :searchResults="$searchResults" />
                                    </div>
                                </div>
                            </div>

                            <!-- Quick Stats -->
                            <div class="stats-grid">
                                <div class="stat-item">
                                    <div class="stat-number">50K+</div>
                                    <div class="stat-label">Products Tracked</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-number">$2M+</div>
                                    <div class="stat-label">Money Saved</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-number">25%</div>
                                    <div class="stat-label">Average Savings</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


        </x-slot:firstpage>

        <!-- Something -->
        <x-Add />




        <!-- Categories section -->
        <x-categorie :category="$category" />

        <x-conversation />

        <!-- How it work section -->
        <x-HowItWorks :home="true" />

         {{-- <!-- Recent Searches Section -->
        <x-recent-searches/> --}}




    </div>
</x-app-layout>
