<<<<<<< HEAD
const navbar = document.getElementById("header");
const menuToggle = document.querySelector('.menu-toggle');
const toggleText = document.querySelector('.toggle-text');
const navMenu = document.querySelector('.nav-menu');
const searchToggle = document.querySelector('.search-toggle');
const searchInputContainer = document.querySelector('.search-input-container');
const searchInput = document.querySelector('.search-input');
const searchClose = document.querySelector('.search-close');
const body = document.body;

// Get the current page filename only
const currentPage = window.location.pathname.split('/').pop().toLowerCase();

// Handle scroll event with both vanilla JS and jQuery
function handleScroll() {
    if (window.scrollY > window.innerHeight) {
        navbar.classList.add("navbar-dark");
    } else {
        navbar.classList.remove("navbar-dark");
    }
}

$(window).on("scroll", function () {
    if ($(this).scrollTop() > 100) {
        $("#header").addClass("navbar-dark");
    } else {
        $("#header").removeClass("navbar-dark");
    }
});

window.addEventListener("scroll", handleScroll);

// Function to determine toggle text based on page
function getToggleText(isActive) {
    switch (currentPage) {
        case 'shop_main.html':
            return isActive ? 'Back' : 'Shop';
        case 'event.html':
            return isActive ? 'Exit' : 'Event';
        case 'contact.html':
            return isActive ? 'Close' : 'Contact';
        default:
            return isActive ? 'Close' : 'Menu';
    }
}

// Menu toggle event
menuToggle.addEventListener('click', () => {
    menuToggle.classList.toggle('active');
    navMenu.classList.toggle('active');
    body.classList.toggle('no-scroll');
    toggleText.textContent = getToggleText(menuToggle.classList.contains('active'));
});

// Search functionality
searchToggle.addEventListener('click', () => {
    searchInputContainer.classList.add('active');
    searchInput.focus();
});

searchClose.addEventListener('click', () => {
    searchInputContainer.classList.remove('active');
});

// Close search on Escape key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        searchInputContainer.classList.remove('active');
    }
});



=======
console.log("styling.js loaded")

const navbar = document.getElementById("header");
const menuToggle = document.querySelector('.menu-toggle');
const toggleText = document.querySelector('.toggle-text');
const navMenu = document.querySelector('.nav-menu');
const searchToggle = document.querySelector('.search-toggle');
const searchInputContainer = document.querySelector('.search-input-container');
const searchInput = document.querySelector('.search-input');
const searchClose = document.querySelector('.search-close');
const body = document.body;

// Get the current page filename only
const currentPage = window.location.pathname.split('/').pop().toLowerCase();

// Handle scroll event with both vanilla JS and jQuery
function handleScroll() {
    if (window.scrollY > window.innerHeight) {
        navbar.classList.add("navbar-dark");
    } else {
        navbar.classList.remove("navbar-dark");
    }
}

$(window).on("scroll", function () {
    if ($(this).scrollTop() > 100) {
        $("#header").addClass("navbar-dark");
    } else {
        $("#header").removeClass("navbar-dark");
    }
});

window.addEventListener("scroll", handleScroll);

// Function to determine toggle text based on page
function getToggleText(isActive) {
    switch (currentPage) {
        case 'shop_main.html':
            return isActive ? 'Back' : 'Shop';
        case 'event.html':
            return isActive ? 'Exit' : 'Event';
        case 'contact.html':
            return isActive ? 'Close' : 'Contact';
        default:
            return isActive ? 'Close' : 'Menu';
    }
}

// Menu toggle event
menuToggle.addEventListener('click', () => {
    menuToggle.classList.toggle('active');
    navMenu.classList.toggle('active');
    body.classList.toggle('no-scroll');
    toggleText.textContent = getToggleText(menuToggle.classList.contains('active'));
});

// Search functionality
searchToggle.addEventListener('click', () => {
    searchInputContainer.classList.add('active');
    searchInput.focus();
});

searchClose.addEventListener('click', () => {
    searchInputContainer.classList.remove('active');
});

// Close search on Escape key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        searchInputContainer.classList.remove('active');
    }
});

//IMAGE PLACEHOLDER
function handleImageError(img) {
    console.error("Image failed to load:", img.src);
    img.src = "../uploads/placeholder.jpg"; // Provide a fallback image
}



>>>>>>> 97b4c39 (Initial commit: Add contact form functionality)
