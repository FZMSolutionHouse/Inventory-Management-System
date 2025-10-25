<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Government Innovation Lab - Inventory Management</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            color: #333;
            overflow-x: hidden;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header */
        header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            padding: 1rem 0;
            position: fixed;
            width: 100%;
            height: 13%;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        header .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo img {
            width:120%;
            height: 60px;
            object-fit: contain;
        }

        nav ul {
            list-style: none;
            display: flex;
            align-items: center;
        }

        nav ul li {
            margin-left: 30px;
        }

        nav ul li a {
            text-decoration: none;
            color: #4B5563;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }

        nav ul li a:hover {
            color: #667eea;
        }

        nav ul li a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -5px;
            left: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: width 0.3s ease;
        }

        nav ul li a:hover::after {
            width: 100%;
        }

        .login-btn {
            background: rgb(77, 147, 77);
            color: #fff !important;
            padding: 12px 24px;
            border-radius: 25px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        /* Hero Section */
        .hero {
            background: url('assets/img/backgil.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            color: #fff;
            text-align: center;
            padding: 150px 0 100px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .hero-content {
            position: relative;
            z-index: 1;
            max-width: 800px;
            animation: fadeInUp 1s ease-out;
        }

        .hero h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            line-height: 1.2;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .hero p {
            font-size: 1.3rem;
            margin-bottom: 40px;
            opacity: 0.95;
            font-weight: 300;
        }

        .cta-button {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            color: #fff;
            padding: 18px 36px;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            border: 2px solid rgba(255, 255, 255, 0.3);
            display: inline-block;
        }

        .cta-button:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }

        /* Statistics Section */
        .stats-section {
            padding: 100px 0;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            position: relative;
        }

        .section-title {
            text-align: center;
            margin-bottom: 80px;
        }

        .section-title h2 {
            font-size: 3rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 20px;
        }

        .section-title p {
            font-size: 1.2rem;
            color: #64748b;
            max-width: 600px;
            margin: 0 auto;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 40px;
            margin-top: 60px;
        }

        .stat-card {
            background: white;
            padding: 50px 30px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            opacity: 0;
            transform: translateY(50px);
            border: 1px solid rgba(102, 126, 234, 0.1);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 4px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: left 0.5s ease;
        }

        .stat-card:hover::before {
            left: 0;
        }

        .stat-card.animate {
            opacity: 1;
            transform: translateY(0);
        }

        .stat-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        .stat-card .icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 25px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2.5rem;
        }

        .stat-card h3 {
            font-size: 3rem;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 15px;
        }

        .stat-card p {
            color: #64748b;
            font-weight: 500;
            font-size: 1.1rem;
        }

        /* Features Section */
        .features-section {
            padding: 100px 0;
            background: white;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 40px;
            margin-top: 60px;
        }

        .feature-card {
            padding: 40px;
            border-radius: 20px;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            transition: all 0.3s ease;
            opacity: 0;
            transform: translateX(-50px);
            border: 1px solid rgba(102, 126, 234, 0.1);
            position: relative;
            overflow: hidden;
        }

        .feature-card:nth-child(even) {
            transform: translateX(50px);
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(102, 126, 234, 0.03) 0%, transparent 70%);
            transition: all 0.5s ease;
            transform: scale(0);
        }

        .feature-card:hover::before {
            transform: scale(1);
        }

        .feature-card.animate {
            opacity: 1;
            transform: translateX(0);
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }

        .feature-card .icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            margin-bottom: 25px;
            position: relative;
            z-index: 1;
        }

        .feature-card h3 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 15px;
            position: relative;
            z-index: 1;
        }

        .feature-card p {
            color: #64748b;
            line-height: 1.7;
            position: relative;
            z-index: 1;
        }

        /* About Section */
        .about-section {
            padding: 100px 0;
            background: white;
            color: black;
        }

        .about-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: center;
        }

        .about-text h2 {
            font-size: 2.8rem;
            font-weight: 700;
            margin-bottom: 30px;
            line-height: 1.2;
        }

        .about-text p {
            font-size: 1.1rem;
            line-height: 1.8;
            opacity: 0.9;
            margin-bottom: 20px;
        }

        .video-container {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            background: #000;
        }

        .video-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }

        /* Mobile Menu */
        .mobile-menu {
            display: none;
            flex-direction: column;
            cursor: pointer;
        }

        .mobile-menu span {
            width: 25px;
            height: 3px;
            background: #4B5563;
            margin: 3px 0;
            transition: 0.3s;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }

            .hero p {
                font-size: 1.1rem;
            }

            .section-title h2 {
                font-size: 2.2rem;
            }

            .about-content {
                grid-template-columns: 1fr;
                gap: 50px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 30px;
            }

            .features-grid {
                grid-template-columns: 1fr;
                gap: 30px;
            }

            nav ul {
                display: none;
            }

            .mobile-menu {
                display: flex;
            }

            .container {
                padding: 0 15px;
            }

            .hero {
                padding: 120px 0 80px;
            }

            .stats-section, .features-section, .about-section {
                padding: 60px 0;
            }

            .stat-card {
                padding: 40px 20px;
            }

            .feature-card {
                padding: 30px;
            }
        }

        @media (max-width: 480px) {
            .hero h1 {
                font-size: 2rem;
            }

            .section-title h2 {
                font-size: 1.8rem;
            }

            .about-text h2 {
                font-size: 2.2rem;
            }

            .stat-card h3 {
                font-size: 2.5rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .logo img {
                width: 50px;
                height: 50px;
            }
        }

        /* Scroll indicator */
        .scroll-indicator {
            position: fixed;
            top: 0;
            left: 0;
            width: 0%;
            height: 4px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            z-index: 1001;
            transition: width 0.3s ease;
        }
    </style>
</head>
<body>
    <div class="scroll-indicator" id="scrollIndicator"></div>
    
    <header>
        <div class="container">
            <div class="logo">
                <img src="assets/img/gillogo.png" alt="GIL Logo">
            </div>
            <nav>
                <ul>
                    <li><a href="#home">Home</a></li>
                    <li><a href="#about">About Us</a></li>
                    <li><a href="#features">Features</a></li>
                    <li><a href="/login" class="login-btn">Login</a></li>
                </ul>
                <div class="mobile-menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </nav>
        </div>
    </header>

    <main>
        <section class="hero" id="home">
            <div class="container">
                <div class="hero-content">
                    <h1>Government Innovation Lab</h1>
                    <p>Our advanced inventory management system empowers government agencies to track, manage, and optimize their resources with unparalleled precision and ease.</p>
                    <a href="/login" class="cta-button">
                        🚀 Login to Get Started
                    </a>
                </div>
            </div>
        </section>

        <section class="stats-section">
            <div class="container">
                <div class="section-title">
                    <h2>Trusted by Government Agencies</h2>
                    <p>Join hundreds of organizations already streamlining their inventory management</p>
                </div>
                <div class="stats-grid">
                    <div class="stat-card" data-animation="left">
                        <div class="icon">🏢</div>
                        <h3>50+</h3>
                        <p>Government Departments</p>
                    </div>
                    <div class="stat-card" data-animation="up">
                        <div class="icon">📦</div>
                        <h3>10K+</h3>
                        <p>Items Tracked Daily</p>
                    </div>
                    <div class="stat-card" data-animation="right">
                        <div class="icon">📈</div>
                        <h3>95%</h3>
                        <p>Efficiency Improvement</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="features-section" id="features">
            <div class="container">
                <div class="section-title">
                    <h2>Powerful Features for Modern Inventory Management</h2>
                    <p>Everything you need to manage your government inventory efficiently and transparently</p>
                </div>
                <div class="features-grid">
                    <div class="feature-card" data-animation="left">
                        <div class="icon">🔍</div>
                        <h3>Real-time Tracking</h3>
                        <p>Track your inventory in real-time with advanced RFID and barcode scanning technology. Never lose track of important assets again.</p>
                    </div>
                    <div class="feature-card" data-animation="right">
                        <div class="icon">📊</div>
                        <h3>Advanced Analytics</h3>
                        <p>Get detailed insights into your inventory patterns, usage trends, and optimization opportunities with powerful analytics dashboard.</p>
                    </div>
                    <div class="feature-card" data-animation="left">
                        <div class="icon">🛡️</div>
                        <h3>Secure & Compliant</h3>
                        <p>Built with government-grade security standards and full compliance with regulatory requirements for data protection.</p>
                    </div>
                    <div class="feature-card" data-animation="right">
                        <div class="icon">📱</div>
                        <h3>Mobile Ready</h3>
                        <p>Access your inventory system anywhere, anytime with our responsive mobile application designed for field operations.</p>
                    </div>
                    <div class="feature-card" data-animation="left">
                        <div class="icon">⚙️</div>
                        <h3>Automated Workflows</h3>
                        <p>Streamline your processes with automated reorder points, approval workflows, and intelligent inventory management.</p>
                    </div>
                    <div class="feature-card" data-animation="right">
                        <div class="icon">👥</div>
                        <h3>Multi-user Access</h3>
                        <p>Role-based access control ensures the right people have access to the right information while maintaining security.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="about-section" id="about">
            <div class="container">
                <div class="about-content">
                    <div class="about-text">
                        <h2>Who we are?</h2>
                        <p>Government Innovation Lab (GIL) is housed at University of Balochistan, which is an initiative of P&DD, GoB and supported by UNDP. Government Innovation Lab launched in May 2019, initiated first cohort in August 2019.</p>
                        <p>GIL aims to help government departments to improve service delivery and governance through innovative solution through agile methodology and citizen centric approach.</p>
                    </div>
                    <div class="video-container">
                        <iframe 
                            src="https://www.youtube.com/embed/NZ9wTD1og4s?enablejsapi=1&origin=https://claude.ai" 
                            title="Government Innovation Lab Video"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                        </iframe>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script>
        // Scroll progress indicator
        window.addEventListener('scroll', () => {
            const scrollTop = document.documentElement.scrollTop;
            const scrollHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrollPercentage = (scrollTop / scrollHeight) * 100;
            document.getElementById('scrollIndicator').style.width = scrollPercentage + '%';
        });

        // Intersection Observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.classList.add('animate');
                    }, index * 200); // Staggered animation
                }
            });
        }, observerOptions);

        // Observe all animatable elements
        document.addEventListener('DOMContentLoaded', () => {
            const animatedElements = document.querySelectorAll('.stat-card, .feature-card');
            animatedElements.forEach(el => observer.observe(el));
        });

        // Header background change on scroll
        window.addEventListener('scroll', () => {
            const header = document.querySelector('header');
            if (window.scrollY > 100) {
                header.style.background = 'rgba(255, 255, 255, 0.98)';
                header.style.boxShadow = '0 8px 25px rgba(0,0,0,0.15)';
            } else {
                header.style.background = 'rgba(255, 255, 255, 0.95)';
                header.style.boxShadow = '0 5px 20px rgba(0,0,0,0.1)';
            }
        });

        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Mobile menu toggle
        const mobileMenu = document.querySelector('.mobile-menu');
        const navUl = document.querySelector('nav ul');
        
        if (mobileMenu) {
            mobileMenu.addEventListener('click', () => {
                navUl.style.display = navUl.style.display === 'flex' ? 'none' : 'flex';
            });
        }

        // Counter animation for stats
        const animateCounter = (element, target) => {
            let count = 0;
            const increment = target / 50;
            const timer = setInterval(() => {
                count += increment;
                if (count >= target) {
                    element.textContent = target + (element.textContent.includes('+') ? '+' : '') + (element.textContent.includes('%') ? '%' : '');
                    clearInterval(timer);
                } else {
                    element.textContent = Math.floor(count) + (element.textContent.includes('+') ? '+' : '') + (element.textContent.includes('%') ? '%' : '');
                }
            }, 20);
        };

        // Trigger counter animation when stats come into view
        const statsObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const h3 = entry.target.querySelector('h3');
                    const text = h3.textContent;
                    const number = parseInt(text.replace(/[^\d]/g, ''));
                    if (number) {
                        h3.textContent = '0' + text.replace(/[\d]/g, '');
                        animateCounter(h3, number);
                    }
                    statsObserver.unobserve(entry.target);
                }
            });
        });

        document.querySelectorAll('.stat-card').forEach(card => {
            statsObserver.observe(card);
        });
    </script>
</body>
</html>