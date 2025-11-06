<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Internet Plans - UltraFiberX</title>
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
                   <!-- <img src="logo.png" alt="UltraFiberX">  -->
                    <span class="logo-text">UltraFiberX</span>
                </div>
                <div class="nav-menu">
                    <a href="index.php" class="nav-item">Home</a>
                    <a href="plans.php" class="nav-item active">Internet Plans</a>
                    <a href="support.php" class="nav-item">Support</a>
                </div>
                <button class="mobile-menu-toggle" aria-label="Toggle mobile menu">☰</button>
            </div>
        </nav>
    </header>

    <main>
        <section class="page-header">
            <div class="container">
                <h1>Ultra-Fast Fiber Internet Plans</h1>
                <p>Choose the perfect fiber plan for your ultra-fast connectivity needs</p>
            </div>
        </section>

        <section class="plans-section">
            <div class="container">
                <div class="plans-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem; justify-items: center; max-width: 1400px; margin: 0 auto;">
                    <div class="plan-card">
                        <div class="plan-header">
                            <h3>Plan1000</h3>
                            <div class="plan-speed">100 Mbps</div>
                            <div class="plan-price">
                                <span class="currency">₱</span>
                                <span class="amount">1,000</span>
                                <span class="period">/month</span>
                            </div>
                        </div>
                        <div class="plan-features">
                            <ul>
                                <li><strong>100 Mbps</strong> fiber speed</li>
                                <li><strong>50 Mbps</strong> upload speed</li>
                                <li><strong>Unlimited</strong> data</li>
                                <li>Perfect for streaming & browsing</li>
                                <li>24/7 technical support</li>
                                <li>Up to 10 device connections</li>
                                <li>Free fiber installation</li>
                            </ul>
                        </div>
                        <button class="btn btn-outline" onclick="signUpForPlan('plan1000', 'Plan1000 - ₱1,000/month (100 Mbps)')">
                            Sign Up Now
                        </button>
                    </div>

                    <div class="plan-card">
                        <div class="plan-header">
                            <h3>Plan1200</h3>
                            <div class="plan-speed">150 Mbps</div>
                            <div class="plan-price">
                                <span class="currency">₱</span>
                                <span class="amount">1,200</span>
                                <span class="period">/month</span>
                            </div>
                        </div>
                        <div class="plan-features">
                            <ul>
                                <li><strong>150 Mbps</strong> fiber speed</li>
                                <li><strong>75 Mbps</strong> upload speed</li>
                                <li><strong>Unlimited</strong> data</li>
                                <li>Great for HD streaming & gaming</li>
                                <li>Priority technical support</li>
                                <li>Up to 15 device connections</li>
                                <li>Free fiber installation</li>
                            </ul>
                        </div>
                        <button class="btn btn-outline" onclick="signUpForPlan('plan1200', 'Plan1200 - ₱1,200/month (150 Mbps)')">
                            Sign Up Now
                        </button>
                    </div>

                    <div class="plan-card featured">
                        <div class="plan-badge">Most Popular</div>
                        <div class="plan-header">
                            <h3>Plan1500</h3>
                            <div class="plan-speed">200 Mbps</div>
                            <div class="plan-price">
                                <span class="currency">₱</span>
                                <span class="amount">1,500</span>
                                <span class="period">/month</span>
                            </div>
                        </div>
                        <div class="plan-features">
                            <ul>
                                <li><strong>200 Mbps</strong> fiber speed</li>
                                <li><strong>100 Mbps</strong> upload speed</li>
                                <li><strong>Unlimited</strong> data</li>
                                <li>Perfect for 4K streaming & gaming</li>
                                <li>Premium technical support</li>
                                <li>Up to 20 device connections</li>
                                <li>Free fiber installation</li>
                            </ul>
                        </div>
                        <button class="btn btn-primary" onclick="signUpForPlan('plan1500', 'Plan1500 - ₱1,500/month (200 Mbps)')">
                            Sign Up Now
                        </button>
                    </div>

                    <div class="plan-card">
                        <div class="plan-header">
                            <h3>Plan1800</h3>
                            <div class="plan-speed">300 Mbps</div>
                            <div class="plan-price">
                                <span class="currency">₱</span>
                                <span class="amount">1,800</span>
                                <span class="period">/month</span>
                            </div>
                        </div>
                        <div class="plan-features">
                            <ul>
                                <li><strong>300 Mbps</strong> fiber speed</li>
                                <li><strong>150 Mbps</strong> upload speed</li>
                                <li><strong>Unlimited</strong> data</li>
                                <li>Ultimate speed for power users</li>
                                <li>Premium technical support</li>
                                <li>Unlimited device connections</li>
                                <li>Free fiber installation</li>
                            </ul>
                        </div>
                        <button class="btn btn-outline" onclick="signUpForPlan('plan1800', 'Plan1800 - ₱1,800/month (300 Mbps)')">
                            Sign Up Now
                        </button>
                    </div>

                    <div class="plan-card">
                        <div class="plan-header">
                            <h3>Plan2200</h3>
                            <div class="plan-speed">500 Mbps</div>
                            <div class="plan-price">
                                <span class="currency">₱</span>
                                <span class="amount">2,200</span>
                                <span class="period">/month</span>
                            </div>
                        </div>
                        <div class="plan-features">
                            <ul>
                                <li><strong>500 Mbps</strong> fiber speed</li>
                                <li><strong>250 Mbps</strong> upload speed</li>
                                <li><strong>Unlimited</strong> data</li>
                                <li>Maximum speed for businesses</li>
                                <li>Dedicated account support</li>
                                <li>Unlimited device connections</li>
                                <li>Priority installation & support</li>
                            </ul>
                        </div>
                        <button class="btn btn-outline" onclick="signUpForPlan('plan2200', 'Plan2200 - ₱2,200/month (500 Mbps)')">
                            Sign Up Now
                        </button>
                    </div>
                </div>

                <div class="plans-info">
                    <h3>All UltraFiberX Plans Include:</h3>
                    <div class="info-grid">
                        <div class="info-item">
                            <h4>Free Fiber Installation</h4>
                            <p>Professional fiber optic setup at no extra cost</p>
                        </div>
                        <div class="info-item">
                            <h4>High-Speed WiFi Router</h4>
                            <p>Premium router optimized for fiber speeds</p>
                        </div>
                        <div class="info-item">
                            <h4>24/7 Network Monitoring</h4>
                            <p>Continuous monitoring for optimal performance</p>
                        </div>
                        <div class="info-item">
                            <h4>No Lock-in Period</h4>
                            <p>Flexible terms, upgrade or cancel anytime</p>
                        </div>
                    </div>
                </div>

                <div class="plan-comparison">
                    <h3>Compare All UltraFiberX Plans</h3>
                    <div class="comparison-table-container">
                        <table class="comparison-table">
                            <thead>
                                <tr>
                                    <th>Features</th>
                                    <th>Plan1000<br><span class="price">₱1,000/mo</span></th>
                                    <th>Plan1200<br><span class="price">₱1,200/mo</span></th>
                                    <th>Plan1500<br><span class="price">₱1,500/mo</span></th>
                                    <th>Plan1800<br><span class="price">₱1,800/mo</span></th>
                                    <th>Plan2200<br><span class="price">₱2,200/mo</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Fiber Speed</td>
                                    <td>100 Mbps</td>
                                    <td>150 Mbps</td>
                                    <td>200 Mbps</td>
                                    <td>300 Mbps</td>
                                    <td>500 Mbps</td>
                                </tr>
                                <tr>
                                    <td>Upload Speed</td>
                                    <td>50 Mbps</td>
                                    <td>75 Mbps</td>
                                    <td>100 Mbps</td>
                                    <td>150 Mbps</td>
                                    <td>250 Mbps</td>
                                </tr>
                                <tr>
                                    <td>Monthly Data</td>
                                    <td>Unlimited</td>
                                    <td>Unlimited</td>
                                    <td>Unlimited</td>
                                    <td>Unlimited</td>
                                    <td>Unlimited</td>
                                </tr>
                                <tr>
                                    <td>Device Connections</td>
                                    <td>Up to 10</td>
                                    <td>Up to 15</td>
                                    <td>Up to 20</td>
                                    <td>Unlimited</td>
                                    <td>Unlimited</td>
                                </tr>
                                <tr>
                                    <td>Support Level</td>
                                    <td>24/7 Technical</td>
                                    <td>Priority Support</td>
                                    <td>Premium Support</td>
                                    <td>Premium Support</td>
                                    <td>Dedicated Account</td>
                                </tr>
                                <tr>
                                    <td>Best For</td>
                                    <td>Streaming & browsing</td>
                                    <td>HD streaming & gaming</td>
                                    <td>4K streaming & gaming</td>
                                    <td>Power users</td>
                                    <td>Businesses</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
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
                        <a href="plans.html">Internet Plans</a>
                        <a href="customer-form.html">Sign Up</a>
                    </div>
                    <div class="footer-column">
                        <h4>Support</h4>
                        <a href="support.html">Customer Support</a>
                        <a href="https://fast.com" target="_blank">Speed Test</a>
                    </div>
                    <div class="footer-column">
                        <h4>Company</h4>
                        <a href="about.html">About Us</a>
                        <a href="contact.html">Contact</a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 UltraFiberX Internet Services, Inc. | Ultra-Fast Fiber Solutions</p>
            </div>
        </div>
    </footer>

    <button class="back-to-top" id="backToTop" aria-label="Back to top"></button>

    <script>
        function signUpForPlan(planId, planName) {
            localStorage.setItem('selectedPlan', planId);
            localStorage.setItem('selectedPlanName', planName);
            window.location.href = 'customer-form.html?plan=' + planId;
        }

        // Back to Top Button
        const backToTopButton = document.getElementById('backToTop');
        
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.add('visible');
            } else {
                backToTopButton.classList.remove('visible');
            }
        });
        
        backToTopButton.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const planCards = document.querySelectorAll('.plan-card');
            
            planCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px)';
                    this.style.boxShadow = '0 10px 25px rgba(0,0,0,0.15)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = '0 4px 6px rgba(0,0,0,0.1)';
                });
            });
        });
    </script>
</body>
</html>
