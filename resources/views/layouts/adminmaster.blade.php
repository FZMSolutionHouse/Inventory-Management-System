<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>IMS Dashboard</title>
    <link rel="stylesheet" href="assets/css/adminmaster.css">
    <link rel="stylesheet" href="assets/css/recordstyle.css">
    <link rel="stylesheet" href="assets/css/createstyle.css">
    <link rel="stylesheet" href="assets/css/usermanagement.css">
    <link rel="stylesheet" href="assets/css/premission.css">
    <link rel="stylesheet" href="assets/css/rolestyle.css">
    <link rel="stylesheet" href="assets/css/createrole.css">
    <link rel="stylesheet" href="assets/css/digitalSignature.css">
    <link rel="stylesheet" href="assets/css/uploadfile.css">
    <link rel="stylesheet" href="assets/css/admindashboard.css">
    <link rel="stylesheet" href="assets/css/recognitionstyle.css">
    <link rel="stylesheet" href="assets/css/recognitionform.css">
    <link rel="stylesheet" href="assets/css/adminrequisitionrecored.css">
    <link rel="stylesheet" href="assets/css/submission.css">
    <link rel="stylesheet" href="assets/css/setting.css">
    <link rel="stylesheet" href="assets/css/locationproduct.css">

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
   <link href="https://fonts.googleapis.com/css2?family=Segoe+UI:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="dark-theme">

    <!-- Mobile Toggle Button -->
    <button class="mobile-toggle" onclick="toggleMobileSidebar()">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Mobile Overlay -->
    <div class="mobile-overlay" onclick="closeMobileSidebar()"></div>

    <!-- ========= Sidebar ========== -->
    <nav class="sidebar" id="sidebar">
        <header class="sidebar-header">
            <div class="logo">
                <h3>Government Innovation Lab</h3>
                <p>Inventory Management System</p>
            </div>
        </header>

        <div class="menu-bar">
            <div class="menu">
                <ul class="menu-links">
                    <li class="nav-link">
                        <a href="/admindashboard" class="{{ request()->is('admindashboard') ? 'active' : '' }}">
                            <i class="fa-solid fa-tachograph-digital icon"></i>
                            <span class="text nav-text">Dashboard</span>
                        </a>
                    </li>

                    <!-- ================= USER MANAGEMENT SUBMENU ================= -->
                    <li class="nav-link has-submenu {{ in_array(request()->path(), ['Premission', 'roles', 'product', 'digitalSignature']) ? 'open' : '' }}">
                        <a href="#" class="submenu-toggle">
                            <i class="fa-solid fa-users-gear icon"></i>
                            <span class="text nav-text">User Management</span>
                            <i class="fas fa-chevron-down submenu-arrow"></i>
                        </a>
                        
                        <ul class="submenu">
                            <li>
                                <a href="/Premission" class="{{ request()->is('Premission') ? 'active' : '' }}">
                                    <i class="fa-solid fa-user-plus icon"></i>
                                    <span class="text nav-text">Create User</span>
                                </a>
                            </li>
                            <li>
                                <a href="/roles" class="{{ request()->is('roles') ? 'active' : '' }}">
                                    <i class="fa-solid fa-user-shield icon"></i>
                                    <span class="text nav-text">Assign Role</span>
                                </a>
                            </li>
                            <li>
                                <a href="/product" class="{{ request()->is('product') ? 'active' : '' }}">
                                    <i class="fa-solid fa-box icon"></i>
                                    <span class="text nav-text">Product</span>
                                </a>
                            </li>
                            <li>
                                <a href="/digitalSignature" class="{{ request()->is('digitalSignature') ? 'active' : '' }}">
                                    <i class="fa-solid fa-pen-nib icon"></i>
                                    <span class="text nav-text">Digital Sign</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-link">
                        <a href="/records" class="{{ request()->is('records') ? 'active' : '' }}">
                            <i class="fa-solid fa-warehouse icon"></i>
                            <span class="text nav-text">Inventory Management</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="/RecognitionPage" class="{{ request()->is('RecognitionPage') ? 'active' : '' }}">
                            <i class="fa-solid fa-file-lines icon"></i>
                            <span class="text nav-text">Requisition</span>
                        </a>
                    </li>
                       <li class="nav-link">
                         <a href="/loactionproduct" class="{{ request()->is('ProjectLocation') ? 'active' : '' }}">
                            <i class="fa-solid fa-location-dot icon"></i>
                     <span class="text nav-text">Project location</span>
                        </a>
                           </li>

                    <li class="nav-link">
                        <a href="/setting" class="{{ request()->is('setting') ? 'active' : '' }}">
                            <i class="fa-solid fa-gear icon"></i>
                            <span class="text nav-text">Settings</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="bottom-content">
                <li class="mode" onclick="toggleTheme()">
                    <div class="moon-sun">
                        <i class="fa-solid fa-moon icon moon"></i>
                        <i class="fa-solid fa-sun icon sun"></i>
                    </div>
                    <span class="mode-text text">Dark Mode</span>
                    <div class="toggle-switch">
                        <span class="switch"></span>
                    </div>
                </li>
                <li class="nav-link logout">
                    <a href="/login">
                        <i class="fa-solid fa-right-from-bracket icon"></i>
                        <span class="text nav-text">Logout</span>
                    </a>
                    
                </li>
            </div>
        </div>
    </nav>

<!-- ========= Main Content Area with Top Bar ========== -->
<main class="main-content">
 <!-- Updated Top Bar Section -->
<header class="top-bar">
    <div class="user-profile">
        <!-- Notification Bell -->
        <div class="notification-container">
            <i class="fa-regular fa-bell notification-bell" id="notificationBell" title="Notifications"></i>
            <span class="notification-badge" id="notificationBadge" style="display: none;">0</span>
            
            <!-- Notification Dropdown -->
            <div class="notification-dropdown" id="notificationDropdown">
                <div class="notification-header">
                    <span>Notifications</span>
                    <button class="clear-all-btn" onclick="clearAllNotifications()">Clear All</button>
                </div>
                <div id="notificationList">
                    <div class="no-notifications">No notifications yet</div>
                </div>
            </div>
        </div>
        
        <div class="user-info">
            @if(Auth::check())
                @php
                    // Get user data - fallback chain
                    $displayName = 'User';
                    $displayRole = 'No Role';
                    $displayImage = 'https://i.pravatar.cc/40';
                    
                    if (isset($userData)) {
                        $displayName = $userData['name'] ?? Auth::user()->name ?? 'User';
                        $displayRole = $userData['role'] ?? 'No Role';
                        $displayImage = $userData['image'] ?? 'https://i.pravatar.cc/40';
                    } else {
                        // Direct database query as fallback
                        $userProfile = DB::table('userprofile')->where('user_id', Auth::id())->first();
                        if ($userProfile) {
                            $displayName = $userProfile->name ?? Auth::user()->name ?? 'User';
                            $displayRole = $userProfile->role ?? 'No Role';
                            // Key part: Check if image exists and create proper URL
                            if (!empty($userProfile->image)) {
                                $displayImage = asset('storage/' . $userProfile->image);
                            }
                        } else {
                            $displayName = Auth::user()->name ?? 'User';
                        }
                    }
                @endphp
                
                <!-- User Image with fallback handling -->
                <img src="{{ $displayImage }}" 
                     alt="User Avatar" 
                     class="user-avatar"
                     onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($displayName) }}&background=random'"
                     style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                
                <div class="user-details">
                    <!-- User Name -->
                    <span class="user-name">{{ $displayName }}</span>
                    
                    <!-- User Role -->
                    <span class="user-role">{{ $displayRole }}</span>
                </div>
                
                <!-- Debug info (remove after testing) -->
                @if(config('app.debug'))
                    <small style="display: none;" id="debug-info">
                        Image URL: {{ $displayImage }}
                    </small>
                @endif
                
            @else
                <!-- Guest Display -->
                <img src="https://i.pravatar.cc/40" alt="Guest Avatar" class="user-avatar">
                <div class="user-details">
                    <span class="user-name">Guest User</span>
                    <span class="user-role">Guest</span>
                </div>
            @endif
            <i class="fa-solid fa-chevron-down"></i>
        </div>
    </div>
</header>

    <div class="page-content">
        @yield('content')
    </div>
</main>
    <script>
        // All JavaScript in one place - Simple and Easy!

        // Theme toggle functionality
        function toggleTheme() {
            const body = document.body;
            const modeText = document.querySelector('.mode-text');
            
            if (body.classList.contains('dark-theme')) {
                body.classList.remove('dark-theme');
                body.classList.add('light-theme');
                modeText.textContent = 'Light Mode';
                localStorage.setItem('theme', 'light');
            } else {
                body.classList.remove('light-theme');
                body.classList.add('dark-theme');
                modeText.textContent = 'Dark Mode';
                localStorage.setItem('theme', 'dark');
            }
        }

        // Mobile sidebar functionality
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.querySelector('.mobile-overlay');
            
            sidebar.classList.toggle('mobile-open');
            overlay.classList.toggle('show');
            
            if (sidebar.classList.contains('mobile-open')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }
        }

        function closeMobileSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.querySelector('.mobile-overlay');
            
            sidebar.classList.remove('mobile-open');
            overlay.classList.remove('show');
            document.body.style.overflow = '';
        }

        // Notification functionality
        let notificationDropdownOpen = false;

        function toggleNotificationDropdown() {
            const dropdown = document.getElementById('notificationDropdown');
            notificationDropdownOpen = !notificationDropdownOpen;
            dropdown.style.display = notificationDropdownOpen ? 'block' : 'none';
            
            if (notificationDropdownOpen) {
                loadNotifications();
            }
        }

        function loadNotifications() {
            fetch('/notifications')
                .then(response => response.json())
                .then(notifications => {
                    updateNotificationUI(notifications);
                })
                .catch(error => {
                    console.error('Error loading notifications:', error);
                });
        }

        function updateNotificationUI(notifications) {
            const badge = document.getElementById('notificationBadge');
            const list = document.getElementById('notificationList');
            
            // Update badge
            const unreadCount = notifications.filter(n => !n.read).length;
            if (unreadCount > 0) {
                badge.textContent = unreadCount;
                badge.style.display = 'flex';
            } else {
                badge.style.display = 'none';
            }
            
            // Update notification list
            if (notifications.length === 0) {
                list.innerHTML = '<div class="no-notifications">No notifications yet</div>';
            } else {
                list.innerHTML = notifications.map(notification => `
                    <div class="notification-item ${!notification.read ? 'unread' : ''}" 
                         onclick="markAsRead('${notification.id}')">
                        <div class="notification-message">${notification.message}</div>
                        <div class="notification-time">${notification.time}</div>
                    </div>
                `).join('');
            }
        }

        function markAsRead(notificationId) {
            fetch('/notifications/mark-read', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ id: notificationId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadNotifications();
                }
            });
        }

        function clearAllNotifications() {
            fetch('/notifications/clear', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadNotifications();
                }
            });
        }

        // When page loads
        document.addEventListener('DOMContentLoaded', function() {
            // Load saved theme
            const savedTheme = localStorage.getItem('theme') || 'dark';
            const body = document.body;
            const modeText = document.querySelector('.mode-text');
            
            body.className = savedTheme + '-theme';
            modeText.textContent = savedTheme === 'dark' ? 'Dark Mode' : 'Light Mode';

            // Handle submenu clicks
            const submenuToggles = document.querySelectorAll('.submenu-toggle');
            
            submenuToggles.forEach(toggle => {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    const parentLi = this.closest('.has-submenu');
                    const isOpen = parentLi.classList.contains('open');
                    
                    // Close all other submenus
                    document.querySelectorAll('.has-submenu').forEach(item => {
                        if (item !== parentLi) {
                            item.classList.remove('open');
                        }
                    });
                    
                    // Toggle current submenu
                    if (isOpen) {
                        parentLi.classList.remove('open');
                    } else {
                        parentLi.classList.add('open');
                    }
                });
            });

            // Close submenu when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.has-submenu')) {
                    document.querySelectorAll('.has-submenu').forEach(item => {
                        item.classList.remove('open');
                    });
                }
                
                // Close notification dropdown when clicking outside
                if (!e.target.closest('.notification-container')) {
                    document.getElementById('notificationDropdown').style.display = 'none';
                    notificationDropdownOpen = false;
                }
            });

            // Notification bell click handler
            document.getElementById('notificationBell').addEventListener('click', toggleNotificationDropdown);
            
            // Load initial notifications
            loadNotifications();
            
            // Auto-refresh notifications every 30 seconds
            setInterval(loadNotifications, 30000);
        });

        // Close mobile sidebar when window is resized
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                closeMobileSidebar();
            }
        });
    </script>
</body>
</html>