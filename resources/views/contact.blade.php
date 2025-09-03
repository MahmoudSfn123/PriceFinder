<x-app-layout title='Contact Us - PriceFinder' :homepage="true">

    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/css/contact.css') }}">
    @endpush

    <x-slot:firstpage>
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">Contact Us</h1>
                <p class="hero-subtitle">Have questions about our project or need support? We’re here to help you.</p>
            </div>
        </div>
    </section>
    </x-slot:firstpage>

    <!-- Main Content -->
    <main class="main">
        <div class="container">
            <!-- Contact Section -->
            <section class="contact-section">
                <div class="contact-grid">
                    <!-- Contact Form -->
                    <div class="contact-form-container">
                        <div class="form-header">
                            <h2 class="form-title">Send a Message</h2>
                            <p class="form-subtitle">We’ll get back to you as soon as possible.</p>
                        </div>
                        <form class="contact-form">
                            <div class="form-group">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" id="name" name="name" class="form-input" required>
                            </div>
                            <div class="form-group">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" id="email" name="email" class="form-input" required>
                            </div>
                            <div class="form-group">
                                <label for="subject" class="form-label">Subject</label>
                                <select id="subject" name="subject" class="form-select" required>
                                    <option value="">Select a topic</option>
                                    <option value="general">General Information</option>
                                    <option value="technical">Technical Issue</option>
                                    <option value="suggestion">Feature Suggestion</option>
                                    <option value="research">Academic/Research Inquiry</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="message" class="form-label">Message</label>
                                <textarea id="message" name="message" rows="6" class="form-textarea" placeholder="Type your message here..." required></textarea>
                            </div>
                            <button type="submit" class="submit-btn">
                                <i class="fa-solid fa-paper-plane"></i>
                                Send Message
                            </button>
                        </form>
                    </div>

                    <!-- Contact Info -->
                    <div class="contact-info">
                        <div class="info-header">
                            <h2 class="info-title">Contact Details</h2>
                            <p class="info-subtitle">Connect with the project author</p>
                        </div>

                        <div class="contact-methods">
                            <div class="contact-method">
                                <div class="method-icon">
                                    <i class="fa-solid fa-envelope"></i>
                                </div>
                                <div class="method-content">
                                    <h3 class="method-title">Email</h3>
                                    <p class="method-text">pricefinder.project@gmail.com</p>
                                    <p class="method-detail">Supervised by Dr. Abd Al Salam Hajjar</p>
                                </div>
                            </div>

                            <div class="contact-method">
                                <div class="method-icon">
                                    <i class="fa-solid fa-user-graduate"></i>
                                </div>
                                <div class="method-content">
                                    <h3 class="method-title">Student</h3>
                                    <p class="method-text">Mahmoud Saifan</p>
                                    <p class="method-detail">Mahmoud.Saifan@hotmail.com - Barja</p>
                                </div>
                            </div>

                            <div class="contact-method">
                                <div class="method-icon">
                                    <i class="fa-solid fa-location-dot"></i>
                                </div>
                                <div class="method-content">
                                    <h3 class="method-title">Location</h3>
                                    <p class="method-text">Faculty of Technology, Lebanese University</p>
                                    <p class="method-detail">Saida, Lebanon</p>
                                </div>
                            </div>
                        </div>

                        <!-- Social Links -->
                        <div class="social-section">
                            <h3 class="social-title">Follow the Project</h3>
                            <div class="social-links">
                                <a href="#" class="social-link"><i class="fa-brands fa-github"></i></a>
                                <a href="#" class="social-link"><i class="fa-brands fa-linkedin"></i></a>
                                <a href="#" class="social-link"><i class="fa-brands fa-facebook"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- FAQ Section -->
            <section class="faq-section">
                <div class="section-header">
                    <h2 class="section-title">Frequently Asked Questions</h2>
                    <p class="section-subtitle">Learn more about how PriceFinder works</p>
                </div>
                <div class="faq-grid">
                    <div class="faq-item">
                        <h3 class="faq-question">What is PriceFinder?</h3>
                        <p class="faq-answer">PriceFinder is a final-year university project developed to help users compare product prices across different stores.</p>
                    </div>
                    <div class="faq-item">
                        <h3 class="faq-question">Is the platform public?</h3>
                        <p class="faq-answer">Currently, it is a prototype created for academic purposes at the Lebanese University.</p>
                    </div>
                    <div class="faq-item">
                        <h3 class="faq-question">Who created this project?</h3>
                        <p class="faq-answer">It was created by Mahmoud Saifan, a student at the Faculty of Technology in Saida, supervised by Dr. Abd Al Salam Hajjar.</p>
                    </div>
                    <div class="faq-item">
                        <h3 class="faq-question">How can I provide feedback?</h3>
                        <p class="faq-answer">You can send suggestions or inquiries using the contact form above.</p>
                    </div>
                </div>
            </section>

            <!-- Newsletter Section -->
            <section class="newsletter-section">
                <div class="newsletter-content">
                    <div class="newsletter-text">
                        <h2 class="newsletter-title">Stay Connected</h2>
                        <p class="newsletter-subtitle">Get updates on our academic progress and future development</p>
                    </div>
                    <form class="newsletter-form">
                        <input type="email" placeholder="Your email address" class="newsletter-input" required>
                        <button type="submit" class="newsletter-btn">Subscribe</button>
                    </form>
                </div>
            </section>
        </div>
    </main>

</x-app-layout>
