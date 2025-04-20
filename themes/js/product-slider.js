<<<<<<< HEAD
class ProductSlider {
    constructor(trackId, apiUrl, prevButtonId, nextButtonId, placeholderImage = '../uploads/placeholder.jpg') {
        this.initialized = false;
        this.currentIndex = 0;
        this.track = document.getElementById(trackId);
        this.prevButton = document.getElementById(prevButtonId);
        this.nextButton = document.getElementById(nextButtonId);
        this.placeholderImage = placeholderImage;

        if (!this.track) {
            console.error('Product track element not found!');
            return;
        }

        this.apiUrl = apiUrl;
        this.products = [];
        this.itemsPerView = this.calculateItemsPerView();
        this.init();
    }

    calculateItemsPerView() {
        const width = window.innerWidth;
        if (width >= 1024) return 4;
        if (width >= 768) return 3;
        return 2;
    }

    async init() {
        if (this.initialized) {
            return;
        }

        try {
            const response = await fetch(this.apiUrl);

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();

            if (data.status === 'success' && Array.isArray(data.data)) {
                this.products = data.data;
                if (this.products.length === 0) {
                    this.track.innerHTML = '<div class="product-card">No products found</div>';
                    return;
                }
                this.renderProducts();
                this.setupControls();
                this.setupResizeHandler();
                this.initialized = true;
            } else {
                throw new Error(data.message || 'Invalid API response format');
            }
        } catch (error) {
            console.error('Failed to load products:', error);
            this.track.innerHTML = '<div class="product-card">Error loading products</div>';
        }
    }

    renderProducts() {
        if (!this.track) return;

        const productsHtml = this.products.map(product => {
            const imageUrl = product.image_url && product.image_url.trim()
                ? product.image_url
                : this.placeholderImage;

            return `
            <div class="product-card card">
                <a href="product.php?product_id=${encodeURIComponent(product.id)}">
                    <img 
                        src="${imageUrl}"
                        alt="${product.name}"
                        class="product-image card-img-top"
                        onerror="this.onerror=null; this.src='${this.placeholderImage}'; this.className+=' placeholder'">
                </a>
                <div class="card-body">
                <a href="product.php?product_id=${encodeURIComponent(product.id)}" style="color: black">
                    <h3 class="card-title">${product.name}</h3>
                    <div class="card-text">$${parseFloat(product.price).toFixed(2)}</div>
                </a>
                    <button class="add-to-cart btn btn-primary btn-lg mt-3" data-product-id="${product.id}">
                        Add to Cart
                    </button>
                </div>
            </div>`;
        }).join('');

        this.track.innerHTML = productsHtml;
        this.updateArrowVisibility();

        // Initialize "Add to Cart" buttons
        this.initializeAddToCartButtons();
    }

    initializeAddToCartButtons() {
        const addToCartButtons = this.track.querySelectorAll('.add-to-cart');
        addToCartButtons.forEach(button => {
            button.addEventListener('click', function () {
                const productId = this.getAttribute('data-product-id');
                const productName = this.parentElement.querySelector('.card-title').textContent;
                const productPrice = parseFloat(this.parentElement.querySelector('.card-text').textContent.replace('$', ''));
                const productImage = this.parentElement.parentElement.querySelector('.product-image').src;

                // Call the cart.js addToCart function
                addToCart(productId, productName, productPrice, productImage);
            });
        });
    }

    slide(direction) {
        if (!this.track) return;

        const maxIndex = Math.max(0, this.products.length - this.itemsPerView);

        if (direction === 'prev') {
            this.currentIndex = Math.max(0, this.currentIndex - 1);
        } else {
            this.currentIndex = Math.min(maxIndex, this.currentIndex + 1);
        }

        const offset = -(this.currentIndex * (100 / this.itemsPerView));
        this.track.style.transform = `translateX(${offset}%)`;

        this.updateArrowVisibility();
    }

    updateArrowVisibility() {
        if (this.prevButton && this.nextButton) {
            this.prevButton.style.display = this.currentIndex === 0 ? 'none' : 'block';
            this.nextButton.style.display =
                this.currentIndex >= this.products.length - this.itemsPerView ? 'none' : 'block';
        }
    }

    setupControls() {
        if (this.prevButton && this.nextButton) {
            this.slidePrev = () => this.slide('prev');
            this.slideNext = () => this.slide('next');

            this.prevButton.addEventListener('click', this.slidePrev);
            this.nextButton.addEventListener('click', this.slideNext);
            this.updateArrowVisibility();
        }
    }

    setupResizeHandler() {
        if (this.resizeHandler) {
            window.removeEventListener('resize', this.resizeHandler);
        }

        this.resizeHandler = () => {
            if (this.resizeTimeout) {
                clearTimeout(this.resizeTimeout);
            }

            this.resizeTimeout = setTimeout(() => {
                this.itemsPerView = this.calculateItemsPerView();
                this.currentIndex = 0;
                if (this.track) {
                    this.track.style.transform = 'translateX(0)';
                }
                this.updateArrowVisibility();
            }, 250);
        };

        window.addEventListener('resize', this.resizeHandler);
    }
}

// Initialize the sliders when the DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    const productSliders = [
        new ProductSlider('productTrack1', 'js/api/recent-products.php', 'prevBtn1', 'nextBtn1'),
        new ProductSlider('productTrack2', 'js/api/bundle-products.php', 'prevBtn2', 'nextBtn2')
    ];
});
=======
class ProductSlider {
    constructor(trackId, apiUrl, prevButtonId, nextButtonId, placeholderImage = '../uploads/placeholder.jpg') {
        this.initialized = false;
        this.currentIndex = 0;
        this.track = document.getElementById(trackId);
        this.prevButton = document.getElementById(prevButtonId);
        this.nextButton = document.getElementById(nextButtonId);
        this.placeholderImage = placeholderImage;

        if (!this.track) {
            console.error('Product track element not found!');
            return;
        }

        this.apiUrl = apiUrl;
        this.products = [];
        this.itemsPerView = this.calculateItemsPerView();
        this.init();
    }

    calculateItemsPerView() {
        const width = window.innerWidth;
        if (width >= 1024) return 4;
        if (width >= 768) return 3;
        return 2;
    }

    async init() {
        if (this.initialized) {
            return;
        }

        try {
            const response = await fetch(this.apiUrl);

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();

            if (data.status === 'success' && Array.isArray(data.data)) {
                this.products = data.data;
                if (this.products.length === 0) {
                    this.track.innerHTML = '<div class="product-card">No products found</div>';
                    return;
                }
                this.renderProducts();
                this.setupControls();
                this.setupResizeHandler();
                this.initialized = true;
            } else {
                throw new Error(data.message || 'Invalid API response format');
            }
        } catch (error) {
            console.error('Failed to load products:', error);
            this.track.innerHTML = '<div class="product-card">Error loading products</div>';
        }
    }

    renderProducts() {
        if (!this.track) return;

        const productsHtml = this.products.map(product => {
            const imageUrl = product.image_url && product.image_url.trim()
                ? product.image_url
                : this.placeholderImage;

            return `
            <div class="product-card card">
                <a href="product.php?product_id=${encodeURIComponent(product.id)}">
                    <img 
                        src="${imageUrl}"
                        alt="${product.name}"
                        class="product-image card-img-top"
                        onerror="this.onerror=null; this.src='${this.placeholderImage}'; this.className+=' placeholder'">
                </a>
                <div class="card-body">
                <a href="product.php?product_id=${encodeURIComponent(product.id)}" style="color: black">
                    <h3 class="card-title">${product.name}</h3>
                    <div class="card-text">$${parseFloat(product.price).toFixed(2)}</div>
                </a>
                    <button class="add-to-cart btn btn-primary btn-lg mt-3" data-product-id="${product.id}">
                        Add to Cart
                    </button>
                </div>
            </div>`;
        }).join('');

        this.track.innerHTML = productsHtml;
        this.updateArrowVisibility();

        // Initialize "Add to Cart" buttons
        this.initializeAddToCartButtons();
    }

    initializeAddToCartButtons() {
        const addToCartButtons = this.track.querySelectorAll('.add-to-cart');
        addToCartButtons.forEach(button => {
            button.addEventListener('click', function () {
                const productId = this.getAttribute('data-product-id');
                const productName = this.parentElement.querySelector('.card-title').textContent;
                const productPrice = parseFloat(this.parentElement.querySelector('.card-text').textContent.replace('$', ''));
                const productImage = this.parentElement.parentElement.querySelector('.product-image').src;

                // Call the cart.js addToCart function
                addToCart(productId, productName, productPrice, productImage);
            });
        });
    }

    slide(direction) {
        if (!this.track) return;

        const maxIndex = Math.max(0, this.products.length - this.itemsPerView);

        if (direction === 'prev') {
            this.currentIndex = Math.max(0, this.currentIndex - 1);
        } else {
            this.currentIndex = Math.min(maxIndex, this.currentIndex + 1);
        }

        const offset = -(this.currentIndex * (100 / this.itemsPerView));
        this.track.style.transform = `translateX(${offset}%)`;

        this.updateArrowVisibility();
    }

    updateArrowVisibility() {
        if (this.prevButton && this.nextButton) {
            this.prevButton.style.display = this.currentIndex === 0 ? 'none' : 'block';
            this.nextButton.style.display =
                this.currentIndex >= this.products.length - this.itemsPerView ? 'none' : 'block';
        }
    }

    setupControls() {
        if (this.prevButton && this.nextButton) {
            this.slidePrev = () => this.slide('prev');
            this.slideNext = () => this.slide('next');

            this.prevButton.addEventListener('click', this.slidePrev);
            this.nextButton.addEventListener('click', this.slideNext);
            this.updateArrowVisibility();
        }
    }

    setupResizeHandler() {
        if (this.resizeHandler) {
            window.removeEventListener('resize', this.resizeHandler);
        }

        this.resizeHandler = () => {
            if (this.resizeTimeout) {
                clearTimeout(this.resizeTimeout);
            }

            this.resizeTimeout = setTimeout(() => {
                this.itemsPerView = this.calculateItemsPerView();
                this.currentIndex = 0;
                if (this.track) {
                    this.track.style.transform = 'translateX(0)';
                }
                this.updateArrowVisibility();
            }, 250);
        };

        window.addEventListener('resize', this.resizeHandler);
    }
}

// Initialize the sliders when the DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    const productSliders = [
        new ProductSlider('productTrack1', 'js/api/recent-products.php', 'prevBtn1', 'nextBtn1'),
        new ProductSlider('productTrack2', 'js/api/bundle-products.php', 'prevBtn2', 'nextBtn2')
    ];
});
>>>>>>> 97b4c39 (Initial commit: Add contact form functionality)
