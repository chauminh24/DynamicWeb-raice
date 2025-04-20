<<<<<<< HEAD
document.addEventListener('DOMContentLoaded', checkAuthStatus);

function checkAuthStatus() {
    fetch('js/api/auth_status.php')
        .then(response => response.json())
        .then(data => {
            updateNavigation(data.isLoggedIn);
        })
        .catch(error => console.error('Error:', error));
}

function updateNavigation(isLoggedIn) {
    const authContainer = document.querySelector('.auth-buttons');

    if (!authContainer) {
        console.error("Auth container not found. Ensure '.auth-buttons' exists in your HTML.");
        return;
    }

    if (isLoggedIn) {
        authContainer.innerHTML = `
            <a href="/themes/account.html" class="nav-link">Account</a>
            <button class="btn btn-outline-dark btn-block" onclick="logout()">Log Out</button>
        `;

        // Handle redirect after login
        const storedRedirect = sessionStorage.getItem('redirect_after_login');
        if (storedRedirect) {
            sessionStorage.removeItem('redirect_after_login');
            window.location.href = storedRedirect;
        }
    } else {
        authContainer.innerHTML = `
            <button class="btn btn-primary btn-block" onclick="window.location.href='/themes/register.php'">Sign Up</button>
            <button class="btn btn-outline-dark btn-block" onclick="window.location.href='/themes/login.php'">Log In</button>
        `;
    }
}

function logout() {
    fetch('js/api/logout.php', { method: 'POST' })
        .then(response => {
            if (response.ok) {
                sessionStorage.removeItem('redirect_after_login');
                window.location.href = '/themes/index.html';
            } else {
                console.error("Logout failed.");
            }
        })
        .catch(error => console.error('Error:', error));
=======
document.addEventListener('DOMContentLoaded', checkAuthStatus);

function checkAuthStatus() {
    fetch('js/api/auth_status.php')
        .then(response => response.json())
        .then(data => {
            updateNavigation(data.isLoggedIn);
        })
        .catch(error => console.error('Error:', error));
}

function updateNavigation(isLoggedIn) {
    const authContainer = document.querySelector('.auth-buttons');

    if (!authContainer) {
        console.error("Auth container not found. Ensure '.auth-buttons' exists in your HTML.");
        return;
    }

    if (isLoggedIn) {
        authContainer.innerHTML = `
            <a href="/themes/account.html" class="nav-link">Account</a>
            <button class="btn btn-outline-dark btn-block" onclick="logout()">Log Out</button>
        `;

        // Handle redirect after login
        const storedRedirect = sessionStorage.getItem('redirect_after_login');
        if (storedRedirect) {
            sessionStorage.removeItem('redirect_after_login');
            window.location.href = storedRedirect;
        }
    } else {
        authContainer.innerHTML = `
            <button class="btn btn-primary btn-block" onclick="window.location.href='/themes/register.php'">Sign Up</button>
            <button class="btn btn-outline-dark btn-block" onclick="window.location.href='/themes/login.php'">Log In</button>
        `;
    }
}

function logout() {
    fetch('js/api/logout.php', { method: 'POST' })
        .then(response => {
            if (response.ok) {
                sessionStorage.removeItem('redirect_after_login');
                window.location.href = '/themes/index.html';
            } else {
                console.error("Logout failed.");
            }
        })
        .catch(error => console.error('Error:', error));
>>>>>>> 97b4c39 (Initial commit: Add contact form functionality)
}