<?php
// UltraFiberX main homepage
// You can add PHP logic here later (e.g., dynamic content, includes, etc.)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UltraFiberX - Internet Plans</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="header">
        <div class="top-nav">
            <div class="container">
                <div class="nav-links">
                    <a href="https://www.facebook.com/ultrafiberx.ncc" target="_blank" class="nav-link">Personal</a>
                    <a href="#" class="nav-link">Business</a>
                </div>
                <div class="nav-links">
                    <a href="about.php" class="nav-link">About Us</a>
                    <a href="customerform.php" class="nav-link">Sign Up</a>
                </div>
            </div>
        </div>
        <nav class="main-nav">
            <div class="container">
                <div class="logo">
                    <span class="logo-text">UltraFiberX</span>
                </div>
                <div class="nav-menu">
                    <a href="index.php" class="nav-item">Home</a>
                    <a href="plans.php" class="nav-item">Internet Plans</a>
                    <a href="support.php" class="nav-item">Support</a>
                </div>
                <button class="mobile-menu-toggle" aria-label="Toggle mobile menu">☰</button>
            </div>
        </nav>
    </header>

    <main>
        <section class="hero-carousel">
            <div class="carousel-container">
                <div class="carousel-slides">
                    <div class="carousel-slide active" style="background-image: url('https://images.unsplash.com/photo-1451187580459-43490279c0fa?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');">
                        <div class="slide-overlay">
                            <div class="slide-content">
                                <div class="container">
                                    <div class="hero-content-centered">
                                        <h1 class="hero-title">Ultra-Fast Fiber Internet</h1>
                                        <p class="hero-subtitle">Experience lightning-speed connectivity with UltraFiberX's premium fiber optic internet services</p>
                                        <div class="hero-buttons">
                                            <a href="plans.php" class="btn btn-primary">View Plans</a>
                                            <a href="customer-form.php" class="btn btn-secondary">Get Started</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="carousel-slide" style="background-image: url('https://images.unsplash.com/photo-1516321318423-f06f85e504b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');">
                        <div class="slide-overlay">
                            <div class="slide-content">
                                <div class="container">
                                    <div class="hero-content-centered">
                                        <h1 class="hero-title">Connect Your Entire Family</h1>
                                        <p class="hero-subtitle">Bring everyone together with seamless fiber internet that works for the whole household</p>
                                        <div class="hero-buttons">
                                            <a href="plans.php" class="btn btn-primary">Family Plans</a>
                                            <a href="support.php" class="btn btn-secondary">Learn More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="carousel-slide" style="background-image: url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');">
                        <div class="slide-overlay">
                            <div class="slide-content">
                                <div class="container">
                                    <div class="hero-content-centered">
                                        <h1 class="hero-title">Power Your Business</h1>
                                        <p class="hero-subtitle">Reliable fiber internet solutions for businesses, schools, and professional environments</p>
                                        <div class="hero-buttons">
                                            <a href="plans.php" class="btn btn-primary">Business Plans</a>
                                            <a href="support.php" class="btn btn-secondary">Contact Us</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <button class="carousel-btn carousel-prev" aria-label="Previous slide">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="15,18 9,12 15,6"></polyline>
                    </svg>
                </button>
                <button class="carousel-btn carousel-next" aria-label="Next slide">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9,6 15,12 9,18"></polyline>
                    </svg>
                </button>
                
                <div class="carousel-indicators">
                    <button class="indicator active" data-slide="0" aria-label="Go to slide 1"></button>
                    <button class="indicator" data-slide="1" aria-label="Go to slide 2"></button>
                    <button class="indicator" data-slide="2" aria-label="Go to slide 3"></button>
                </div>
            </div>
        </section>

        <section class="services">
            <div class="container">
                <h2 class="section-title">Kasama Mo ang UltraFiberX, Sa Bahay o Sa Negosyo</h2>
                <p class="section-subtitle">Choose the perfect fiber internet plan for your needs</p>
                
                <div class="service-cards">
                    <div class="service-card">
                        <div class="card-image">
                            <img src="https://i.pinimg.com/1200x/ff/bf/5c/ffbf5cb8eb96b311d23b33d24975e5b9.jpg" alt="Basic Plan" width="300" height="200">
                        </div>
                        <div class="card-content">
                            <h3>Plan1000 - 100Mbps</h3>
                            <p>Perfect for light browsing and social media. Get reliable fiber internet connection for everyday use at an affordable price.</p>
                            <div class="card-price">₱1,000/month</div>
                            <a href="plans.php" class="card-link" aria-label="Learn more about Plan1000">→</a>
                        </div>
                    </div>

                    <div class="service-card">
                        <div class="card-image">
                            <img src="https://i.pinimg.com/1200x/5c/86/cb/5c86cbbba4993638724cebb1646f38c4.jpg" alt="Standard Plan" width="300" height="200">
                        </div>
                        <div class="card-content">
                            <h3>Plan1500 - 200Mbps</h3>
                            <p>Ideal for streaming and video calls. Enhanced speed for families who need more bandwidth for multiple devices.</p>
                            <div class="card-price">₱1,500/month</div>
                            <a href="plans.php" class="card-link" aria-label="Learn more about Plan1500">→</a>
                        </div>
                    </div>

                    <div class="service-card">
                        <div class="card-image">
                            <img src="https://i.pinimg.com/736x/75/19/0f/75190f21fcdfd8ac5cca422f1d7b1c60.jpg" alt="Premium Plan" width="300" height="200">
                        </div>
                        <div class="card-content">
                            <h3>Plan2200 - 500Mbps</h3>
                            <p>Ultimate speed for power users. Perfect for gaming, 4K streaming, and heavy downloads with unlimited data.</p>
                            <div class="card-price">₱2,200/month</div>
                            <a href="plans.php" class="card-link" aria-label="Learn more about Plan2200">→</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="help-section">
            <div class="container">
                <div class="help-content">
                    <div class="help-text">
                        <h2 class="help-greeting">Kumusta?</h2>
                        <h3 class="help-main-title">How can we help you get connected with ultra-fast fiber internet today?</h3>
                    </div>
                    
                    <div class="help-search-container">
                        <form class="help-search-form" action="support.php" method="GET">
                            <div class="search-input-wrapper">
                                <svg class="search-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <path d="m21 21-4.35-4.35"></path>
                                </svg>
                                <input type="search" name="q" placeholder="Search for help topics, internet plans, or technical support..." class="help-search-input">
                            </div>
                        </form>
                    </div>
                </div>

                <div class="help-quick-actions">
                    <a href="customer-form.php" class="help-action-btn">Sign Up Now</a>
                    <a href="support.php" class="help-action-btn">Technical Support</a>
                    <a href="plans.php" class="help-action-btn">View Plans</a>
                    <a href="support.php" class="help-action-btn">Speed Test</a>
                    <a href="support.php" class="help-action-btn">Installation</a>
                    <a href="support.php" class="help-action-btn">Report Issue</a>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer footer-compact">
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">
                    <img src="logo.png" alt="UltraFiberX">
                    <span class="footer-logo-text">UltraFiberX</span>
                </div>
                <div class="footer-links">
                    <div class="footer-column">
                        <h4>Services</h4>
                        <a href="plans.php">Internet Plans</a>
                        <a href="customer-form.php">Sign Up</a>
                    </div>
                    <div class="footer-column">
                        <h4>Support</h4>
                        <a href="support.php">Customer Support</a>
                        <a href="https://fast.com" target="_blank">Speed Test</a>
                    </div>
                    <div class="footer-column">
                        <h4>Company</h4>
                        <a href="about.php">About Us</a>
                        <a href="contact.php">Contact</a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> UltraFiberX Internet Services, Inc. | Ultra-Fast Fiber Solutions</p>
            </div>
        </div>
    </footer>

    <button class="back-to-top" id="backToTop" aria-label="Back to top"></button>

    <script>
        class HeroCarousel {
            constructor() {
                this.currentSlide = 0;
                this.slides = document.querySelectorAll('.carousel-slide');
                this.indicators = document.querySelectorAll('.indicator');
                this.prevBtn = document.querySelector('.carousel-prev');
                this.nextBtn = document.querySelector('.carousel-next');
                this.autoPlayInterval = null;
                this.init();
            }
            init() {
                this.prevBtn.addEventListener('click', () => this.prevSlide());
                this.nextBtn.addEventListener('click', () => this.nextSlide());
                this.indicators.forEach((indicator, index) => {
                    indicator.addEventListener('click', () => this.goToSlide(index));
                });
                this.startAutoPlay();
                const carousel = document.querySelector('.hero-carousel');
                carousel.addEventListener('mouseenter', () => this.stopAutoPlay());
                carousel.addEventListener('mouseleave', () => this.startAutoPlay());
            }
            goToSlide(slideIndex) {
                this.slides[this.currentSlide].classList.remove('active');
                this.indicators[this.currentSlide].classList.remove('active');
                this.currentSlide = slideIndex;
                this.slides[this.currentSlide].classList.add('active');
                this.indicators[this.currentSlide].classList.add('active');
            }
            nextSlide() {
                const nextIndex = (this.currentSlide + 1) % this.slides.length;
                this.goToSlide(nextIndex);
            }
            prevSlide() {
                const prevIndex = (this.currentSlide - 1 + this.slides.length) % this.slides.length;
                this.goToSlide(prevIndex);
            }
            startAutoPlay() {
                this.autoPlayInterval = setInterval(() => {
                    this.nextSlide();
                }, 5000);
            }
            stopAutoPlay() {
                if (this.autoPlayInterval) {
                    clearInterval(this.autoPlayInterval);
                    this.autoPlayInterval = null;
                }
            }
        }

        const backToTopButton = document.getElementById('backToTop');
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.add('visible');
            } else {
                backToTopButton.classList.remove('visible');
            }
        });
        backToTopButton.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
        document.addEventListener('DOMContentLoaded', () => {
            new HeroCarousel();
        });
        document.querySelector('.mobile-menu-toggle')?.addEventListener('click', function() {
            document.querySelector('.nav-menu').classList.toggle('active');
        });
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
    </script>
</body>
</html>
