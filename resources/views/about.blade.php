<x-app-layout title='About Page' :homepage="true">

    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/css/about.css') }}">
    @endpush

    <x-slot:firstpage>
        <!-- Hero Section -->
        <section class="hero">
            <div class="container">
                <div class="hero-content">
                    <h1 class="hero-title">About PriceFinder</h1>
                    <p class="hero-subtitle">A final-year graduation project built with purpose and innovation</p>
                </div>
            </div>
        </section>
    </x-slot:firstpage>

    <!-- Main Content -->
    <main class="main">
        <div class="container">
            <!-- Mission Section -->
            <section class="section">
                <div class="section-content">
                    <div class="text-content">
                        <h2 class="section-title">Project Overview</h2>
                        <p class="section-text">
                            PriceFinder is a web application developed as a final-year graduation project at the
                            Faculty of Technology,
                            Lebanese University. It was created to help users compare product prices across
                            different stores with ease,
                            saving them both time and money.
                        </p>
                        <p class="section-text">
                            The project was completed under the supervision of <strong>Dr. Abd Al Salam
                                Hajjar</strong>, and showcases the
                            practical application of modern web technologies, combining Laravel, MySQL, OCR, and
                            intelligent comparison algorithms.
                        </p>
                    </div>
                    <div class="image-content">
                        <div class="feature-icon">
                            <i class="fa-solid fa-bullseye"></i>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Story Section -->
            <section class="section reverse">
                <div class="section-content">
                    <div class="image-content">
                        <div class="feature-icon">
                            <i class="fa-solid fa-lightbulb"></i>
                        </div>
                    </div>
                    <div class="text-content">
                        <h2 class="section-title">How It Started</h2>
                        <p class="section-text">
                            The idea for PriceFinder came from a common struggle: finding the best price for a
                            product without manually
                            searching multiple stores. This inspired the creation of a smart platform that could do
                            the work for you.
                        </p>
                        <p class="section-text">
                            Through months of research, coding, and testing, PriceFinder evolved into a fully
                            functional price comparison
                            system tailored for the local and global market.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Values Section -->
            <section class="values-section">
                <div class="section-header">
                    <h2 class="section-title centered">What We Believe In</h2>
                    <p class="section-subtitle">Core principles behind the project</p>
                </div>
                <div class="values-grid">
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <h3 class="value-title">Transparency</h3>
                        <p class="value-text">We aim to provide fair and honest price comparisons to empower smart
                            buyers.</p>
                    </div>
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="fa-solid fa-bolt"></i>
                        </div>
                        <h3 class="value-title">Efficiency</h3>
                        <p class="value-text">The platform is built to give users fast, accurate results for their
                            shopping needs.</p>
                    </div>
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="fa-solid fa-chart-line"></i>
                        </div>
                        <h3 class="value-title">Innovation</h3>
                        <p class="value-text">Using technologies like OCR and Laravel, we explore smarter ways to
                            compare prices.</p>
                    </div>
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <h3 class="value-title">User Focus</h3>
                        <p class="value-text">The platform is designed to meet the needs of real users with a
                            simple, clear experience.</p>
                    </div>
                </div>
            </section>

            <!-- Team Section -->
            <section class="team-section">
                <div class="section-header">
                    <h2 class="section-title centered">Project Team</h2>
                    <p class="section-subtitle">The people behind the project</p>
                </div>
                <div class="team-grid">
                    <div class="team-card">
                        <div class="team-avatar">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <h3 class="team-name">Mahmoud Saifan</h3>
                        <p class="team-role">Developer & Project Owner</p>
                        <p class="team-bio">Full-stack web developer passionate about problem-solving and building
                            real-world applications.</p>
                    </div>
                    <div class="team-card">
                        <div class="team-avatar">
                            <i class="fa-solid fa-user-tie"></i>
                        </div>
                        <h3 class="team-name">Dr. Abd Al Salam Hajjar</h3>
                        <p class="team-role">Project Supervisor</p>
                        <p class="team-bio">Professor at Lebanese University, guiding and mentoring students in
                            software and systems development.</p>
                    </div>
                </div>
            </section>

            <!-- CTA Section -->
            <section class="cta-section">
                <div class="cta-content">
                    <h2 class="cta-title">Try PriceFinder Today</h2>
                    <p class="cta-text">Experience the final product and see how it can help you shop smarter.</p>
                    <div class="cta-buttons">
                        <a href="/" class="btn btn-primary">Compare Prices</a>
                        <a href="/contact" class="btn btn-secondary">Contact Us</a>
                    </div>
                </div>
            </section>
        </div>
    </main>

</x-app-layout>
