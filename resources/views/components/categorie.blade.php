@props(['category'])
<!-- Categories section -->
<section id='categories'>
    <div class="product-section mt-80 mb-90">
        <div class="container">
            <div class="row">
                <div class="categories-header">
                    <div class="categories-icon-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M12 2H2v10l9.29 9.29c.94.94 2.48.94 3.42 0l6.58-6.58c.94-.94.94-2.48 0-3.42L12 2Z"></path>
                            <path d="M7 7h.01"></path>
                        </svg>
                    </div>
                    <h2 class="categories-title">
                        <span class="highlight-text">Our </span>Categories
                    </h2>
                    <p class="categories-description">
                        Browse by Category, Save on Every Purchase!
                    </p>
                </div>
            </div>

            <div class="row">
                @foreach ($category as $categorie)
                    <div class="col-lg-4 col-md-6 text-center mb-4">
                        <div class="single-product-item">
                            <div class="product-image">
                                <a href="/products/{{ $categorie->id }}">
                                    <img
                                        style="width:100%; height:200px; object-fit:cover; border-radius:8px;"
                                        src="{{ url($categorie->imagepath) }}" alt="">
                                </a>
                            </div>
                            <h3 style="margin-top:20px; font-size:1.5rem;">{{ $categorie->name }}</h3>
                            <p style="margin: 20px auto; max-width: 90%; color: #4B5563;">
                                {{ $categorie->description }}
                            </p>
                            <a href="/products/{{ $categorie->id }}"
                                class="cart-btn" style="display:inline-block; margin-top:20px;">
                                <i class="fas fa-shopping-cart"></i> See More Details
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<style>
    .categories-header {
        max-width: 56rem;
        margin: 0 auto 4rem auto;
        text-align: center;
    }

    .categories-icon-wrapper {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 4rem;
        height: 4rem;
        margin-bottom: 1.5rem;
        border-radius: 1rem;
        background-image: linear-gradient(135deg, #F28123 0%, #E6751F 50%, #D86A1C 100%);
        box-shadow: 0 10px 40px -10px rgba(242, 129, 35, 0.3);
        color: white;
    }

    .categories-title {
        font-size: 3rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 1.5rem;
        line-height: 1.25;
    }

    .categories-title .highlight-text {
        color: #F28123;
    }

    .categories-description {
        font-size: 1.25rem;
        color: #4B5563;
        max-width: 42rem;
        margin: 0 auto;
        line-height: 1.625;
    }
</style>
