document.addEventListener("DOMContentLoaded", function() {
    const body = document.querySelector("body");
    const sidebar = document.querySelector(".sidebar");
    const modeSwitch = document.querySelector(".toggle-switch");
    const modeText = document.querySelector(".mode-text");
    const submenuParent = document.querySelector(".has-submenu");
    const mobileToggle = document.querySelector(".mobile-toggle");
    const mobileOverlay = document.querySelector(".mobile-overlay");

    // --- Theme Management ---
    // Load saved theme from localStorage or default to dark
    const savedTheme = localStorage.getItem('theme') || 'dark';
    
    if (savedTheme === 'light') {
        body.classList.remove('dark-theme');
        body.classList.add('light-theme');
        if (modeText) modeText.innerText = "Dark Mode";
    } else {
        body.classList.remove('light-theme');
        body.classList.add('dark-theme');
        if (modeText) modeText.innerText = "Light Mode";
    }

    // Theme toggle functionality
    if (modeSwitch) {
        modeSwitch.addEventListener("click", () => {
            if (body.classList.contains("dark-theme")) {
                body.classList.remove("dark-theme");
                body.classList.add("light-theme");
                if (modeText) modeText.innerText = "Dark Mode";
                localStorage.setItem('theme', 'light');
            } else {
                body.classList.remove("light-theme");
                body.classList.add("dark-theme");
                if (modeText) modeText.innerText = "Light Mode";
                localStorage.setItem('theme', 'dark');
            }
        });
    }

    // --- Submenu Management ---
    // Check if current page should keep submenu open
    function shouldSubmenuBeOpen() {
        const currentPath = window.location.pathname;
        const submenuPages = ['/Premission', '/roles', '/product', '/digitalSignature'];
        return submenuPages.some(page => currentPath.includes(page));
    }

    // Initialize submenu state
    if (submenuParent) {
        // Set initial state based on current page
        if (shouldSubmenuBeOpen()) {
            submenuParent.classList.add("open");
        }

        const submenuToggleLink = submenuParent.querySelector(".submenu-toggle");
        if (submenuToggleLink) {
            submenuToggleLink.addEventListener("click", function(event) {
                event.preventDefault();
                submenuParent.classList.toggle("open");
                
                // Save submenu state
                localStorage.setItem('submenuOpen', submenuParent.classList.contains('open'));
            });
        }

        // Load saved submenu state (but prioritize current page logic)
        const savedSubmenuState = localStorage.getItem('submenuOpen');
        if (savedSubmenuState === 'true' || shouldSubmenuBeOpen()) {
            submenuParent.classList.add("open");
        }
    }

    // --- Mobile Navigation ---
    function toggleMobileMenu() {
        sidebar.classList.toggle("mobile-open");
        mobileOverlay.classList.toggle("show");
        body.style.overflow = sidebar.classList.contains("mobile-open") ? "hidden" : "";
    }

    function closeMobileMenu() {
        sidebar.classList.remove("mobile-open");
        mobileOverlay.classList.remove("show");
        body.style.overflow = "";
    }

    // Mobile toggle button
    if (mobileToggle) {
        mobileToggle.addEventListener("click", toggleMobileMenu);
    }

    // Mobile overlay click to close
    if (mobileOverlay) {
        mobileOverlay.addEventListener("click", closeMobileMenu);
    }

    // Close mobile menu when clicking on navigation links (except submenu toggle)
    const navLinks = document.querySelectorAll(".nav-link a:not(.submenu-toggle)");
    navLinks.forEach(link => {
        link.addEventListener("click", () => {
            if (window.innerWidth <= 768) {
                closeMobileMenu();
            }
        });
    });

    // Close mobile menu when clicking on submenu links
    const submenuLinks = document.querySelectorAll(".submenu a");
    submenuLinks.forEach(link => {
        link.addEventListener("click", () => {
            if (window.innerWidth <= 768) {
                closeMobileMenu();
            }
        });
    });

    // --- Responsive Behavior ---
    function handleResize() {
        if (window.innerWidth > 768) {
            closeMobileMenu();
        }
    }

    window.addEventListener("resize", handleResize);

    // --- Keyboard Navigation Support ---
    document.addEventListener("keydown", function(event) {
        // Close mobile menu with Escape key
        if (event.key === "Escape") {
            closeMobileMenu();
        }

        // Toggle mobile menu with Alt + M
        if (event.altKey && event.key === "m") {
            event.preventDefault();
            if (window.innerWidth <= 768) {
                toggleMobileMenu();
            }
        }
    });

    // --- Smooth Scrolling for Page Content ---
    const pageContent = document.querySelector(".page-content");
    if (pageContent) {
        pageContent.style.scrollBehavior = "smooth";
    }

    // --- Performance Optimization ---
    // Debounce resize events
    let resizeTimeout;
    window.addEventListener("resize", function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(handleResize, 100);
    });

    // --- Touch Support for Mobile ---
    let touchStartX = 0;
    let touchStartY = 0;

    document.addEventListener("touchstart", function(event) {
        touchStartX = event.touches[0].clientX;
        touchStartY = event.touches[0].clientY;
    });

    document.addEventListener("touchend", function(event) {
        if (!touchStartX || !touchStartY) return;

        const touchEndX = event.changedTouches[0].clientX;
        const touchEndY = event.changedTouches[0].clientY;
        
        const diffX = touchStartX - touchEndX;
        const diffY = touchStartY - touchEndY;

        // Minimum swipe distance
        const minSwipeDistance = 100;

        // Detect horizontal swipe
        if (Math.abs(diffX) > Math.abs(diffY) && Math.abs(diffX) > minSwipeDistance) {
            if (diffX > 0) {
                // Swipe left - close menu
                closeMobileMenu();
            } else {
                // Swipe right - open menu (only if starting from left edge)
                if (touchStartX < 50 && window.innerWidth <= 768) {
                    toggleMobileMenu();
                }
            }
        }

        // Reset touch coordinates
        touchStartX = 0;
        touchStartY = 0;
    });

    // --- Notification Bell Animation ---
    const notificationBell = document.querySelector(".fa-bell");
    if (notificationBell) {
        notificationBell.addEventListener("click", function() {
            this.style.animation = "ring 0.5s ease-in-out";
            setTimeout(() => {
                this.style.animation = "";
            }, 500);
        });
    }

    // --- User Profile Dropdown (if needed) ---
    const userInfo = document.querySelector(".user-info");
    if (userInfo) {
        userInfo.addEventListener("click", function(event) {
            event.stopPropagation();
            // Add dropdown functionality here if needed
            console.log("User profile clicked");
        });
    }

    // --- Auto-hide mobile menu on orientation change ---
    window.addEventListener("orientationchange", function() {
        setTimeout(() => {
            if (window.innerWidth > 768) {
                closeMobileMenu();
            }
        }, 100);
    });

    // --- Focus management for accessibility ---
    function trapFocus(element) {
        const focusableElements = element.querySelectorAll(
            'a, button, input, textarea, select, [tabindex]:not([tabindex="-1"])'
        );
        const firstFocusable = focusableElements[0];
        const lastFocusable = focusableElements[focusableElements.length - 1];

        element.addEventListener("keydown", function(event) {
            if (event.key === "Tab") {
                if (event.shiftKey) {
                    if (document.activeElement === firstFocusable) {
                        event.preventDefault();
                        lastFocusable.focus();
                    }
                } else {
                    if (document.activeElement === lastFocusable) {
                        event.preventDefault();
                        firstFocusable.focus();
                    }
                }
            }
        });
    }

    // Apply focus trapping to sidebar when mobile menu is open
    if (sidebar) {
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.attributeName === "class") {
                    if (sidebar.classList.contains("mobile-open")) {
                        trapFocus(sidebar);
                    }
                }
            });
        });

        observer.observe(sidebar, { attributes: true });
    }

    // --- Add CSS animations via JavaScript ---
    const style = document.createElement('style');
    style.textContent = `
        @keyframes ring {
            0%, 100% { transform: rotate(0deg); }
            10%, 30%, 50%, 70%, 90% { transform: rotate(-10deg); }
            20%, 40%, 60%, 80% { transform: rotate(10deg); }
        }
        
        .sidebar.mobile-open {
            box-shadow: 2px 0 20px rgba(0, 0, 0, 0.3);
        }
        
        .nav-link a {
            position: relative;
            overflow: hidden;
        }
        
        .nav-link a::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transition: left 0.5s;
        }
        
        .nav-link a:hover::before {
            left: 100%;
        }
    `;
    document.head.appendChild(style);

    // --- Initialize tooltips for collapsed sidebar ---
    function initializeTooltips() {
        const navIcons = document.querySelectorAll('.sidebar.close .nav-link .icon');
        navIcons.forEach(icon => {
            const text = icon.parentElement.querySelector('.text');
            if (text) {
                icon.title = text.textContent;
            }
        });
    }

    // Watch for sidebar collapse state changes
    const sidebarObserver = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.attributeName === "class") {
                setTimeout(initializeTooltips, 300); // Delay for transition
            }
        });
    });

    if (sidebar) {
        sidebarObserver.observe(sidebar, { attributes: true });
        initializeTooltips(); // Initial setup
    }

    // --- Cleanup function ---
    window.addEventListener("beforeunload", function() {
        // Clean up any intervals or timeouts if needed
        clearTimeout(resizeTimeout);
    });

    console.log("Dashboard JavaScript initialized successfully");
});