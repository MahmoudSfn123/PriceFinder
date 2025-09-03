<section class="secondary-options">
  <div class="container">
    <div class="section-header">
      <div class="section-icon">
        <span>💡</span>
      </div>
      <h2 class="section-title">
        Already Have Something
        <span class="section-subtitle">in Mind?</span>
      </h2>
      <p class="section-description">
        Upload your receipt or enter product details to get instant price comparisons
      </p>
    </div>

    <div class="card-container">
      <div class="product-card">
        <div class="card-icon-wrapper">
          <!-- You would place an icon SVG here, like the PenSquare icon -->
          <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#F28123" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"></path><path d="m15 5 4 4"></path></svg>
        </div>
        <h3 class="card-title">Enter Product Details</h3>
        <p class="card-description">
          Don't have a receipt? Add product info manually to find the best prices.
        </p>
        <a href="/add-product" class="card-button-link">
          <a href="{{ route('products.create') }}" class="card-button">
            Add Product Manually
          </a>
        </a>
      </div>
    </div>
  </div>
</section>
