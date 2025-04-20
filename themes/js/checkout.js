<<<<<<< HEAD
// Define the cart API endpoint (same as in cart.js)
const CART_API_ENDPOINT = '/themes/js/api/cart.php';

// Function to fetch cart data from the API
async function fetchCart() {
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

        const data = await response.json();
        return data.cart || [];
    } catch (error) {
        console.error('Error fetching cart:', error);
        return [];
    }
}

// Function to calculate total order amount based on cart data
async function calculateTotalAmount() {
    const cart = await fetchCart();
    return cart.reduce((total, item) => total + (item.productPrice * item.quantity), 0);
}

// Function to place an order
async function placeOrder(event) {
    event.preventDefault();

    // Get form input values
    const fullName = document.getElementById('fullName').value.trim();
    const address = document.getElementById('address').value.trim();
    const city = document.getElementById('city').value.trim();
    const postalCode = document.getElementById('postalCode').value.trim();
    const country = document.getElementById('country').value.trim();

    // Basic validation
    if (!fullName || !address || !city || !postalCode || !country) {
        alert('Please fill in all shipping information fields.');
        return;
    }

    const cart = await fetchCart();
    if (cart.length === 0) {
        alert('Your cart is empty.');
        return;
    }

    const totalAmount = await calculateTotalAmount();
    const trackingNumber = generateTrackingNumber();

    // Prepare order data
    const orderData = {
        fullName,
        address,
        city,
        postalCode,
        country,
        totalAmount,
        trackingNumber,
        items: cart
    };

    try {
        const response = await fetch('js/api/process_order.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(orderData)
        });

        const result = await response.json();

        if (result.success) {
            // Clear cart and any stored redirects before going to confirmation
            await clearCart();
            sessionStorage.removeItem('redirect_after_login');
            window.location.href = '/themes/order-confirmation.html?tracking=' + trackingNumber;
        } else {
            alert('Order processing failed: ' + result.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while processing your order.');
    }
}

// Function to clear the cart via API
async function clearCart() {
    try {
        const response = await fetch(CART_API_ENDPOINT, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                action: 'clear'
            })
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        if (!data.success) {
            throw new Error('Failed to clear cart');
        }
    } catch (error) {
        console.error('Error clearing cart:', error);
    }
}

// Function to load cart items from the API and display them
async function loadCartItems() {
    const cart = await fetchCart();
    const cartItemsContainer = document.getElementById('cartItemsContainer');
    
    cartItemsContainer.innerHTML = ''; // Clear the container
    
    if (cart && cart.length > 0) {
        cart.forEach(item => {
            const cartItem = document.createElement('div');
            cartItem.classList.add('cart-item');
            cartItem.innerHTML = `
                <img src="${item.productImage}" alt="${item.productName}" class="cart-item-image">
                <div>
                    <h3>${item.productName}</h3>
                    <p>Price: $${item.productPrice.toFixed(2)}</p>
                    <p>Quantity: ${item.quantity}</p>
                    <p>Subtotal: $${(item.productPrice * item.quantity).toFixed(2)}</p>
                </div>
            `;
            cartItemsContainer.appendChild(cartItem);
        });
    } else {
        cartItemsContainer.innerHTML = '<p>Your cart is empty.</p>';
    }
}

// Function to generate a tracking number
function generateTrackingNumber() {
    return 'TRK-' + Math.random().toString(36).substr(2, 9).toUpperCase();
}

// Add event listener when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    const orderButton = document.getElementById('orderPlacingBtn');
    if (orderButton) {
        orderButton.addEventListener('click', placeOrder);
    }
    loadCartItems();
=======
// Define the cart API endpoint (same as in cart.js)
const CART_API_ENDPOINT = '/themes/js/api/cart.php';

// Function to fetch cart data from the API
async function fetchCart() {
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

        const data = await response.json();
        return data.cart || [];
    } catch (error) {
        console.error('Error fetching cart:', error);
        return [];
    }
}

// Function to calculate total order amount based on cart data
async function calculateTotalAmount() {
    const cart = await fetchCart();
    return cart.reduce((total, item) => total + (item.productPrice * item.quantity), 0);
}

// Function to place an order
async function placeOrder(event) {
    event.preventDefault();

    // Get form input values
    const fullName = document.getElementById('fullName').value.trim();
    const address = document.getElementById('address').value.trim();
    const city = document.getElementById('city').value.trim();
    const postalCode = document.getElementById('postalCode').value.trim();
    const country = document.getElementById('country').value.trim();

    // Basic validation
    if (!fullName || !address || !city || !postalCode || !country) {
        alert('Please fill in all shipping information fields.');
        return;
    }

    const cart = await fetchCart();
    if (cart.length === 0) {
        alert('Your cart is empty.');
        return;
    }

    const totalAmount = await calculateTotalAmount();
    const trackingNumber = generateTrackingNumber();

    // Prepare order data
    const orderData = {
        fullName,
        address,
        city,
        postalCode,
        country,
        totalAmount,
        trackingNumber,
        items: cart
    };

    try {
        const response = await fetch('js/api/process_order.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(orderData)
        });

        const result = await response.json();

        if (result.success) {
            // Clear cart and any stored redirects before going to confirmation
            await clearCart();
            sessionStorage.removeItem('redirect_after_login');
            window.location.href = '/themes/order-confirmation.html?tracking=' + trackingNumber;
        } else {
            alert('Order processing failed: ' + result.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while processing your order.');
    }
}

// Function to clear the cart via API
async function clearCart() {
    try {
        const response = await fetch(CART_API_ENDPOINT, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                action: 'clear'
            })
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        if (!data.success) {
            throw new Error('Failed to clear cart');
        }
    } catch (error) {
        console.error('Error clearing cart:', error);
    }
}

// Function to load cart items from the API and display them
async function loadCartItems() {
    const cart = await fetchCart();
    const cartItemsContainer = document.getElementById('cartItemsContainer');
    
    cartItemsContainer.innerHTML = ''; // Clear the container
    
    if (cart && cart.length > 0) {
        cart.forEach(item => {
            const cartItem = document.createElement('div');
            cartItem.classList.add('cart-item');
            cartItem.innerHTML = `
                <img src="${item.productImage}" alt="${item.productName}" class="cart-item-image">
                <div>
                    <h3>${item.productName}</h3>
                    <p>Price: $${item.productPrice.toFixed(2)}</p>
                    <p>Quantity: ${item.quantity}</p>
                    <p>Subtotal: $${(item.productPrice * item.quantity).toFixed(2)}</p>
                </div>
            `;
            cartItemsContainer.appendChild(cartItem);
        });
    } else {
        cartItemsContainer.innerHTML = '<p>Your cart is empty.</p>';
    }
}

// Function to generate a tracking number
function generateTrackingNumber() {
    return 'TRK-' + Math.random().toString(36).substr(2, 9).toUpperCase();
}

// Add event listener when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    const orderButton = document.getElementById('orderPlacingBtn');
    if (orderButton) {
        orderButton.addEventListener('click', placeOrder);
    }
    loadCartItems();
>>>>>>> 97b4c39 (Initial commit: Add contact form functionality)
});