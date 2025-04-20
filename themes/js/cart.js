<<<<<<< HEAD
const cartIcon = document.querySelector('.cart-container');
const cartSidebar = document.getElementById('cartSidebar');
const closeCartBtn = document.querySelector('.close-cart');
const cartItems = document.getElementById('cartItems');
const cartTotal = document.getElementById('cartTotal');
const cartCount = document.querySelector('.cart-count');

// Define the cart API endpoint
const CART_API_ENDPOINT = '/themes/js/api/cart.php'; // Update this path to match your server structure

// Load cart when page loads
document.addEventListener('DOMContentLoaded', loadCart);

// Toggle cart sidebar
cartIcon.addEventListener('click', function() {
    cartSidebar.classList.toggle('open');
});

// Close cart button
closeCartBtn.addEventListener('click', function() {
    cartSidebar.classList.remove('open');
});

// Handle "Add to Cart" button clicks
document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', function() {
        const productId = this.getAttribute('data-product-id');
        const productName = this.parentElement.querySelector('.card-title').textContent;
        const productPrice = parseFloat(this.parentElement.querySelector('.card-text').textContent.replace('$', ''));
        const productImage = this.parentElement.parentElement.querySelector('.product-image').src;
        
        addToCart(productId, productName, productPrice, productImage);
    });
});

async function addToCart(productId, productName, productPrice, productImage) {
    try {
        const response = await fetch(CART_API_ENDPOINT, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                action: 'add',
                productId,
                productName,
                productPrice,
                productImage
            })
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            throw new TypeError("Received non-JSON response from server");
        }

        const data = await response.json();
        if (data.success) {
            updateCartDisplay(data);
        } else {
            console.error('Server returned error:', data.error);
        }
    } catch (error) {
        console.error('Error adding to cart:', error);
        // Optionally show user-friendly error message
        alert('Unable to add item to cart. Please try again later.');
    }
}

async function removeFromCart(productId) {
    try {
        const response = await fetch(CART_API_ENDPOINT, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                action: 'remove',
                productId
            })
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        if (data.success) {
            updateCartDisplay(data);
        }
    } catch (error) {
        console.error('Error removing from cart:', error);
        alert('Unable to remove item from cart. Please try again later.');
    }
}

async function updateQuantity(productId, quantity) {
    try {
        const response = await fetch(CART_API_ENDPOINT, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                action: 'update',
                productId,
                quantity
            })
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        if (data.success) {
            updateCartDisplay(data);
        }
    } catch (error) {
        console.error('Error updating quantity:', error);
        alert('Unable to update quantity. Please try again later.');
    }
}

async function loadCart() {
    try {
        const response = await fetch(CART_API_ENDPOINT, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                action: 'get'
            })
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            throw new TypeError("Received non-JSON response from server");
        }

        const data = await response.json();
        updateCartDisplay(data);
    } catch (error) {
        console.error('Error loading cart:', error);
        // Optionally show a user-friendly error message
        cartItems.innerHTML = '<p class="cart-error">Unable to load cart. Please refresh the page.</p>';
    }
}

function updateCartDisplay(data) {
    cartItems.innerHTML = '';
    
    if (!data.cart || data.cart.length === 0) {
        cartItems.innerHTML = '<p class="cart-empty">Your cart is empty</p>';
        cartTotal.textContent = '$0.00';
        cartCount.textContent = '0';
        return;
    }
    
    data.cart.forEach(item => {
        const cartItem = document.createElement('div');
        cartItem.classList.add('cart-item');
        cartItem.setAttribute('data-product-id', item.productId);
        cartItem.innerHTML = `
            <img src="${item.productImage}" class="cart-item-image" alt="${item.productName}">
            <span class="cart-item-name">${item.productName}</span>
            <span class="cart-item-price">$${item.productPrice}</span>
            <div class="cart-item-controls">
                <button class="decrease-quantity" data-product-id="${item.productId}">-</button>
                <span class="cart-item-quantity">${item.quantity}</span>
                <button class="increase-quantity" data-product-id="${item.productId}">+</button>
            </div>
            <button class="remove-from-cart" data-product-id="${item.productId}">&times;</button>
        `;
        cartItems.appendChild(cartItem);
    });

    cartTotal.textContent = `$${data.cartTotal}`;
    cartCount.textContent = data.cartCount;
}

// Event delegation for cart item controls
cartItems.addEventListener('click', function(e) {
    const productId = e.target.getAttribute('data-product-id');
    const cartItem = e.target.closest('.cart-item');
    
    if (!productId || !cartItem) return;
    
    if (e.target.classList.contains('remove-from-cart')) {
        removeFromCart(productId);
    } else if (e.target.classList.contains('increase-quantity')) {
        const quantityElem = cartItem.querySelector('.cart-item-quantity');
        const newQuantity = parseInt(quantityElem.textContent) + 1;
        updateQuantity(productId, newQuantity);
    } else if (e.target.classList.contains('decrease-quantity')) {
        const quantityElem = cartItem.querySelector('.cart-item-quantity');
        const newQuantity = parseInt(quantityElem.textContent) - 1;
        if (newQuantity > 0) {
            updateQuantity(productId, newQuantity);
        } else {
            removeFromCart(productId);
        }
    }
});

function addLoginModal() {
    const modalHTML = `
        <div class="modal fade" id="loginCheckoutModal" tabindex="-1" aria-labelledby="loginCheckoutModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="loginCheckoutModalLabel">Login Required</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Please log in to proceed with checkout.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" onclick="redirectToLogin()">Continue</button>
                    </div>
                </div>
            </div>
        </div>`;

    if (!document.getElementById('loginCheckoutModal')) {
        document.body.insertAdjacentHTML('beforeend', modalHTML);
    }
}

function checkAuthStatusForCheckout() {
    fetch('js/api/auth_status.php')
        .then(response => response.json())
        .then(data => {
            if (data.isLoggedIn) {
                window.location.href = '/themes/checkout.html';
            } else {
                // Store the checkout page URL in sessionStorage
                sessionStorage.setItem('redirect_after_login', '/themes/checkout.html');

                // Show the login modal using Bootstrap's native JS API
                addLoginModal();
                const modal = new bootstrap.Modal(document.getElementById('loginCheckoutModal'));
                modal.show();
            }
        })
        .catch(error => console.error('Error:', error));
}


function redirectToLogin() {
    window.location.href = '/themes/login.php';
}
=======
const cartIcon = document.querySelector('.cart-container');
const cartSidebar = document.getElementById('cartSidebar');
const closeCartBtn = document.querySelector('.close-cart');
const cartItems = document.getElementById('cartItems');
const cartTotal = document.getElementById('cartTotal');
const cartCount = document.querySelector('.cart-count');

// Define the cart API endpoint
const CART_API_ENDPOINT = '/themes/js/api/cart.php'; // Update this path to match your server structure

// Load cart when page loads
document.addEventListener('DOMContentLoaded', loadCart);

// Toggle cart sidebar
cartIcon.addEventListener('click', function() {
    cartSidebar.classList.toggle('open');
});

// Close cart button
closeCartBtn.addEventListener('click', function() {
    cartSidebar.classList.remove('open');
});

// Handle "Add to Cart" button clicks
document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', function() {
        const productId = this.getAttribute('data-product-id');
        const productName = this.parentElement.querySelector('.card-title').textContent;
        const productPrice = parseFloat(this.parentElement.querySelector('.card-text').textContent.replace('$', ''));
        const productImage = this.parentElement.parentElement.querySelector('.product-image').src;
        
        addToCart(productId, productName, productPrice, productImage);
    });
});

async function addToCart(productId, productName, productPrice, productImage) {
    try {
        const response = await fetch(CART_API_ENDPOINT, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                action: 'add',
                productId,
                productName,
                productPrice,
                productImage
            })
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            throw new TypeError("Received non-JSON response from server");
        }

        const data = await response.json();
        if (data.success) {
            updateCartDisplay(data);
        } else {
            console.error('Server returned error:', data.error);
        }
    } catch (error) {
        console.error('Error adding to cart:', error);
        // Optionally show user-friendly error message
        alert('Unable to add item to cart. Please try again later.');
    }
}

async function removeFromCart(productId) {
    try {
        const response = await fetch(CART_API_ENDPOINT, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                action: 'remove',
                productId
            })
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        if (data.success) {
            updateCartDisplay(data);
        }
    } catch (error) {
        console.error('Error removing from cart:', error);
        alert('Unable to remove item from cart. Please try again later.');
    }
}

async function updateQuantity(productId, quantity) {
    try {
        const response = await fetch(CART_API_ENDPOINT, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                action: 'update',
                productId,
                quantity
            })
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        if (data.success) {
            updateCartDisplay(data);
        }
    } catch (error) {
        console.error('Error updating quantity:', error);
        alert('Unable to update quantity. Please try again later.');
    }
}

async function loadCart() {
    try {
        const response = await fetch(CART_API_ENDPOINT, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                action: 'get'
            })
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            throw new TypeError("Received non-JSON response from server");
        }

        const data = await response.json();
        updateCartDisplay(data);
    } catch (error) {
        console.error('Error loading cart:', error);
        // Optionally show a user-friendly error message
        cartItems.innerHTML = '<p class="cart-error">Unable to load cart. Please refresh the page.</p>';
    }
}

function updateCartDisplay(data) {
    cartItems.innerHTML = '';
    
    if (!data.cart || data.cart.length === 0) {
        cartItems.innerHTML = '<p class="cart-empty">Your cart is empty</p>';
        cartTotal.textContent = '$0.00';
        cartCount.textContent = '0';
        return;
    }
    
    data.cart.forEach(item => {
        const cartItem = document.createElement('div');
        cartItem.classList.add('cart-item');
        cartItem.setAttribute('data-product-id', item.productId);
        cartItem.innerHTML = `
            <img src="${item.productImage}" class="cart-item-image" alt="${item.productName}">
            <span class="cart-item-name">${item.productName}</span>
            <span class="cart-item-price">$${item.productPrice}</span>
            <div class="cart-item-controls">
                <button class="decrease-quantity" data-product-id="${item.productId}">-</button>
                <span class="cart-item-quantity">${item.quantity}</span>
                <button class="increase-quantity" data-product-id="${item.productId}">+</button>
            </div>
            <button class="remove-from-cart" data-product-id="${item.productId}">&times;</button>
        `;
        cartItems.appendChild(cartItem);
    });

    cartTotal.textContent = `$${data.cartTotal}`;
    cartCount.textContent = data.cartCount;
}

// Event delegation for cart item controls
cartItems.addEventListener('click', function(e) {
    const productId = e.target.getAttribute('data-product-id');
    const cartItem = e.target.closest('.cart-item');
    
    if (!productId || !cartItem) return;
    
    if (e.target.classList.contains('remove-from-cart')) {
        removeFromCart(productId);
    } else if (e.target.classList.contains('increase-quantity')) {
        const quantityElem = cartItem.querySelector('.cart-item-quantity');
        const newQuantity = parseInt(quantityElem.textContent) + 1;
        updateQuantity(productId, newQuantity);
    } else if (e.target.classList.contains('decrease-quantity')) {
        const quantityElem = cartItem.querySelector('.cart-item-quantity');
        const newQuantity = parseInt(quantityElem.textContent) - 1;
        if (newQuantity > 0) {
            updateQuantity(productId, newQuantity);
        } else {
            removeFromCart(productId);
        }
    }
});

function addLoginModal() {
    const modalHTML = `
        <div class="modal fade" id="loginCheckoutModal" tabindex="-1" aria-labelledby="loginCheckoutModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="loginCheckoutModalLabel">Login Required</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Please log in to proceed with checkout.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" onclick="redirectToLogin()">Continue</button>
                    </div>
                </div>
            </div>
        </div>`;

    if (!document.getElementById('loginCheckoutModal')) {
        document.body.insertAdjacentHTML('beforeend', modalHTML);
    }
}

function checkAuthStatusForCheckout() {
    fetch('js/api/auth_status.php')
        .then(response => response.json())
        .then(data => {
            if (data.isLoggedIn) {
                window.location.href = '/themes/checkout.html';
            } else {
                // Store the checkout page URL in sessionStorage
                sessionStorage.setItem('redirect_after_login', '/themes/checkout.html');

                // Show the login modal using Bootstrap's native JS API
                addLoginModal();
                const modal = new bootstrap.Modal(document.getElementById('loginCheckoutModal'));
                modal.show();
            }
        })
        .catch(error => console.error('Error:', error));
}


function redirectToLogin() {
    window.location.href = '/themes/login.php';
}
>>>>>>> 97b4c39 (Initial commit: Add contact form functionality)
