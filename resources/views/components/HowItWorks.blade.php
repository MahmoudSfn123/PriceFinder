<section class="how-card-category how-home-style" id="howItWorks">
        <div class="how-it-works-card">
            <div class="how-it-works-header">
                <h2 class="how-it-works-title">How PriceFinder Works</h2>
                <p class="how-it-works-description">
                    Find better deals on products you've already purchased in 3 simple steps
                </p>
            </div>
            <div class="how-it-works-content">
                <div class="how-steps-grid">
                    <!-- Step 1 -->
                    <div class="how-step-item">
                        <div class="how-step-icon-wrapper">
                            <svg class="how-step-icon" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1Z"></path><path d="M16 8h-6a2 2 0 1 0 0 4h6"></path><path d="M12 14v-4"></path></svg>
                        </div>
                        <h3 class="how-step-title">Upload Your Invoice</h3>
                        <p class="how-step-description">Start by uploading a photo or PDF of your recent purchase invoice</p>
                    </div>

                    <!-- Step 2 -->
                    <div class="how-step-item">
                        <div class="how-step-icon-wrapper">
                            <svg class="how-step-icon" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2H2v10l9.29 9.29c.94.94 2.48.94 3.42 0l6.58-6.58c.94-.94.94-2.48 0-3.42L12 2Z"></path><path d="M7 7h.01"></path></svg>
                        </div>
                        <h3 class="how-step-title">Enter Product Details</h3>
                        <p class="how-step-description">Provide some basic information about the product you want to compare</p>
                    </div>

                    <!-- Step 3 -->
                    <div class="how-step-item">
                        <div class="how-step-icon-wrapper">
                            <svg class="how-step-icon" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg>
                        </div>
                        <h3 class="how-step-title">Compare Prices</h3>
                        <p class="how-step-description">Our system will search across multiple retailers to find the best deals</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
<style>
        
        /* Section container */
        .how-card-category {
            width: 100%;
            padding: 2rem 1rem;
        }

        /* Main container styling - Enhanced responsive */
        .how-it-works-card {
            max-width: 1200px;
            width: 100%;
            margin: 0 auto;
            border-radius: 16px;
            border: 1px solid #e5e7eb;
            background-color: #ffffff;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            padding: 3rem 2rem;
            position: relative;
            overflow: hidden;
        }

        /* Header styles - Enhanced responsive */
        .how-it-works-header {
            text-align: center;
            margin-bottom: 3rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .how-it-works-title {
            font-size: clamp(1.5rem, 5vw, 2.5rem);
            font-weight: 700;
            color: #051922;
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .how-it-works-description {
            font-size: clamp(0.9rem, 2.5vw, 1.125rem);
            color: #6b7280;
            line-height: 1.6;
            margin: 0;
        }

        /* Enhanced responsive grid layout */
        .how-steps-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2.5rem;
            align-items: start;
        }

        /* Individual step styling - Enhanced */
        .how-step-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 1.5rem;
            border-radius: 12px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
        }

        .how-step-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        /* Enhanced icon styling */
        .how-step-icon-wrapper {
            margin-bottom: 1.5rem;
            display: flex;
            height: 5rem;
            width: 5rem;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(242, 129, 35, 0.1) 0%, rgba(242, 129, 35, 0.2) 100%);
            border: 2px solid rgba(242, 129, 35, 0.2);
            transition: all 0.3s ease;
        }

        .how-step-item:hover .how-step-icon-wrapper {
            background: linear-gradient(135deg, rgba(242, 129, 35, 0.2) 0%, rgba(242, 129, 35, 0.3) 100%);
            border-color: rgba(242, 129, 35, 0.4);
            transform: scale(1.05);
        }

        .how-step-icon {
            height: 2.5rem;
            width: 2.5rem;
            color: #F28123;
            transition: all 0.3s ease;
        }

        .how-step-item:hover .how-step-icon {
            color: #e06b00;
        }

        /* Step title and description - Enhanced */
        .how-step-title {
            margin-bottom: 1rem;
            font-size: clamp(1.1rem, 3vw, 1.5rem);
            font-weight: 600;
            color: #1f2937;
            line-height: 1.3;
        }

        .how-step-description {
            font-size: clamp(0.85rem, 2.2vw, 1rem);
            color: #6b7280;
            max-width: 280px;
            line-height: 1.6;
            margin: 0;
        }

        /* Mobile-first responsive breakpoints */
        @media (max-width: 640px) {
            .how-card-category {
                padding: 1rem 0.5rem;
            }

            .how-it-works-card {
                padding: 2rem 1rem;
                border-radius: 12px;
                margin: 0 0.5rem;
            }

            .how-it-works-header {
                margin-bottom: 2rem;
            }

            .how-steps-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .how-step-item {
                padding: 1rem;
            }

            .how-step-icon-wrapper {
                height: 4rem;
                width: 4rem;
                margin-bottom: 1rem;
            }

            .how-step-icon {
                height: 2rem;
                width: 2rem;
            }
        }

        /* Tablet breakpoint */
        @media (min-width: 641px) and (max-width: 1024px) {
            .how-steps-grid {
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 2rem;
            }

            .how-it-works-card {
                padding: 2.5rem 1.5rem;
            }
        }

        /* Large desktop breakpoint */
        @media (min-width: 1025px) {
            .how-steps-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .how-step-item {
                padding: 2rem 1rem;
            }
        }

        /* Extra large screens */
        @media (min-width: 1440px) {
            .how-it-works-card {
                padding: 4rem 3rem;
            }

            .how-step-item {
                padding: 2.5rem 1.5rem;
            }
        }

        /* Reduced motion for accessibility */
        @media (prefers-reduced-motion: reduce) {
            .how-step-item {
                transition: none;
            }

            .how-step-icon-wrapper {
                transition: none;
            }

            .how-step-icon {
                transition: none;
            }

            .how-step-item:hover {
                transform: none;
            }

            .how-step-item:hover .how-step-icon-wrapper {
                transform: none;
            }
        }

        /* High contrast mode support */
        @media (prefers-contrast: high) {
            .how-it-works-card {
                border: 2px solid #000;
            }

            .how-step-icon-wrapper {
                border: 2px solid #F28123;
            }
        }

        /* Focus styles for accessibility */
        .how-step-item:focus-within {
            outline: 2px solid #F28123;
            outline-offset: 2px;
        }
    </style>
