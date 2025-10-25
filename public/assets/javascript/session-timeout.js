/**
 * Auto Logout Functionality
 * Monitors user inactivity and logs out after specified timeout
 */

(function() {
    // Configuration
    const TIMEOUT_DURATION = 15 * 60 * 1000; // 15 minutes in milliseconds
    const WARNING_DURATION = 2 * 60 * 1000; // Show warning 2 minutes before logout
    const CHECK_INTERVAL = 30 * 1000; // Check every 30 seconds
    
    let lastActivityTime = Date.now();
    let warningShown = false;
    let checkInterval;
    let warningTimeout;
    
    // Events that indicate user activity
    const activityEvents = [
        'mousedown',
        'mousemove',
        'keypress',
        'scroll',
        'touchstart',
        'click'
    ];
    
    /**
     * Reset the inactivity timer
     */
    function resetTimer() {
        lastActivityTime = Date.now();
        warningShown = false;
        hideWarning();
    }
    
    /**
     * Show warning modal
     */
    function showWarning() {
        if (warningShown) return;
        warningShown = true;
        
        // Create warning modal
        const modal = document.createElement('div');
        modal.id = 'inactivity-warning';
        modal.innerHTML = `
            <div style="
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.7);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 9999;
            ">
                <div style="
                    background: white;
                    padding: 30px;
                    border-radius: 10px;
                    box-shadow: 0 4px 20px rgba(0,0,0,0.3);
                    max-width: 400px;
                    text-align: center;
                ">
                    <h2 style="margin: 0 0 15px 0; color: #e74c3c;">Session Timeout Warning</h2>
                    <p style="margin: 0 0 20px 0; color: #555;">
                        You will be logged out due to inactivity in <span id="countdown">2:00</span> minutes.
                    </p>
                    <button id="stay-logged-in" style="
                        background: #3498db;
                        color: white;
                        border: none;
                        padding: 12px 30px;
                        border-radius: 5px;
                        cursor: pointer;
                        font-size: 16px;
                        font-weight: bold;
                    ">
                        Stay Logged In
                    </button>
                </div>
            </div>
        `;
        
        document.body.appendChild(modal);
        
        // Start countdown
        startCountdown();
        
        // Handle stay logged in button
        document.getElementById('stay-logged-in').addEventListener('click', function() {
            resetTimer();
            checkSession();
        });
    }
    
    /**
     * Hide warning modal
     */
    function hideWarning() {
        const modal = document.getElementById('inactivity-warning');
        if (modal) {
            modal.remove();
        }
        if (warningTimeout) {
            clearTimeout(warningTimeout);
        }
    }
    
    /**
     * Start countdown timer in warning modal
     */
    function startCountdown() {
        let remainingTime = WARNING_DURATION / 1000; // Convert to seconds
        
        const countdownInterval = setInterval(function() {
            remainingTime--;
            const minutes = Math.floor(remainingTime / 60);
            const seconds = remainingTime % 60;
            
            const countdownEl = document.getElementById('countdown');
            if (countdownEl) {
                countdownEl.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
            }
            
            if (remainingTime <= 0) {
                clearInterval(countdownInterval);
            }
        }, 1000);
    }
    
    /**
     * Logout user
     */
    function logout() {
        // Show logout message
        alert('You have been logged out due to inactivity.');
        
        // Redirect to logout route
        window.location.href = '/login';
    }
    
    /**
     * Check session status with server
     */
    function checkSession() {
        fetch('/check-session', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'expired' || data.status === 'unauthenticated') {
                logout();
            }
        })
        .catch(error => {
            console.error('Session check failed:', error);
        });
    }
    
    /**
     * Monitor user inactivity
     */
    function monitorInactivity() {
        const currentTime = Date.now();
        const inactiveTime = currentTime - lastActivityTime;
        
        // Show warning before timeout
        if (inactiveTime >= (TIMEOUT_DURATION - WARNING_DURATION) && !warningShown) {
            showWarning();
        }
        
        // Logout if timeout reached
        if (inactiveTime >= TIMEOUT_DURATION) {
            logout();
        }
    }
    
    /**
     * Initialize the auto-logout functionality
     */
    function init() {
        // Only run on authenticated pages (not on login page)
        if (window.location.pathname === '/login' || window.location.pathname === '/registration') {
            return;
        }
        
        // Listen for user activity
        activityEvents.forEach(function(event) {
            document.addEventListener(event, resetTimer, true);
        });
        
        // Check inactivity periodically
        checkInterval = setInterval(function() {
            monitorInactivity();
            checkSession();
        }, CHECK_INTERVAL);
        
        // Initial timer setup
        resetTimer();
    }
    
    // Start monitoring when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();