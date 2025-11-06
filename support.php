<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support & Contact - UltraFiberX</title>
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
                  <!--  <img src="logo.png" alt="UltraFiberX" width="50" height="50"> -->
                    <span class="logo-text">UltraFiberX</span>
                </div>
                <div class="nav-menu">
                    <a href="index.php" class="nav-item">Home</a>
                    <a href="plans.php" class="nav-item">Internet Plans</a>
                    <a href="support.php" class="nav-item active">Support</a>
                </div>
                <button class="mobile-menu-toggle" aria-label="Toggle mobile menu">☰</button>
            </div>
        </nav>
    </header>

    <main>
        <section class="page-header">
            <div class="container">
                <h1>UltraFiberX Support & Contact</h1>
                <p>We're here to help you 24/7 with ultra-fast fiber internet support and technical assistance.</p>
            </div>
        </section>

        <section class="contact-info-section">
            <div class="container">
                <h2>Get in Touch</h2>
                <div class="contact-methods">
                    <div class="contact-method">
                        <h3>📞 Call Us</h3>
                        <p><strong>Customer Service:</strong> 09605232388</p>
                        <p><strong>Technical Support:</strong> 09602920661</p>
                        <p><strong>Business Sales:</strong> 09081983203</p>
                        <p><em>Mon-Sun: 6AM-10PM</em></p>
                    </div>
                    <div class="contact-method">
                        <h3>✉️ Email Us</h3>
                        <p><strong>General:</strong> info@ultrafiberx.com</p>
                        <p><strong>Support:</strong> support@ultrafiberx.com</p>
                        <p><strong>Business:</strong> business@ultrafiberx.com</p>
                        <p><em>Response within 4 hours</em></p>
                    </div>
                    <div class="contact-method">
                        <h3>📍 Visit Us</h3>
                        <p><strong>Main Office:</strong><br>
                        123 Fiber Technology Avenue<br>
                        Makati City, Metro Manila 1200<br>
                        Philippines</p>
                        <p><em>Mon-Fri: 8AM-6PM, Sat: 9AM-3PM</em></p>
                    </div>
                    <div class="contact-method">
                        <h3>💬 Live Chat</h3>
                        <p>Chat with our fiber internet support team in real-time for immediate assistance.</p>
                        <button class="btn btn-primary">Start Live Chat</button>
                        <p><em>Available 24/7</em></p>
                    </div>
                </div>
            </div>
        </section>

        <section class="unified-form-section">
            <div class="container">
                <div class="form-container">
                    <h2>Send Us a Message</h2>
                     Updated form to handle both contact and support inquiries 
                    <form class="unified-form" action="process_inquiry.php" method="POST" style="background: linear-gradient(135deg, #f8f9fa 0%, #e8f5e9 100%); padding: 2rem; border-radius: 15px; border: 2px solid #4caf50;">
                        <div class="form-group">
                            <label for="fullName" style="color: #2e7d32; font-weight: 600;">Full Name *</label>
                            <input type="text" id="fullName" name="fullName" required style="border: 2px solid #4caf50; border-radius: 8px; padding: 0.75rem; transition: all 0.3s ease;">
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="email" style="color: #2e7d32; font-weight: 600;">Email Address *</label>
                                <input type="email" id="email" name="email" required style="border: 2px solid #4caf50; border-radius: 8px; padding: 0.75rem; transition: all 0.3s ease;">
                            </div>
                            <div class="form-group">
                                <label for="phone" style="color: #2e7d32; font-weight: 600;">Phone Number</label>
                                <input type="tel" id="phone" name="phone" style="border: 2px solid #4caf50; border-radius: 8px; padding: 0.75rem; transition: all 0.3s ease;">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="accountNumber" style="color: #2e7d32; font-weight: 600;">Account Number (if applicable)</label>
                            <input type="text" id="accountNumber" name="accountNumber" placeholder="Enter your UltraFiberX account number" style="border: 2px solid #4caf50; border-radius: 8px; padding: 0.75rem; transition: all 0.3s ease;">
                        </div>

                        <div class="form-group">
                            <label for="inquiryType" style="color: #2e7d32; font-weight: 600;">Type of Inquiry *</label>
                            <select id="inquiryType" name="inquiryType" required style="border: 2px solid #4caf50; border-radius: 8px; padding: 0.75rem; transition: all 0.3s ease; background: white;">
                                <option value="">Select inquiry type</option>
                                <optgroup label="Technical Support">
                                    <option value="no-connection">No Fiber Connection</option>
                                    <option value="slow-speed">Slow Fiber Speed</option>
                                    <option value="intermittent">Intermittent Connection</option>
                                    <option value="wifi-issues">WiFi Problems</option>
                                    <option value="equipment">Fiber Equipment Issues</option>
                                    <option value="technical-other">Other Technical Issue</option>
                                </optgroup>
                                <optgroup label="Customer Service">
                                    <option value="billing">Billing Question</option>
                                    <option value="plan-change">Plan Upgrade/Downgrade</option>
                                    <option value="account">Account Information</option>
                                    <option value="payment">Payment Issues</option>
                                    <option value="service-info">Service Information</option>
                                    <option value="cancellation">Service Cancellation</option>
                                </optgroup>
                                <optgroup label="General">
                                    <option value="general">General Information</option>
                                    <option value="business">Business Partnership</option>
                                    <option value="complaint">Service Complaint</option>
                                    <option value="feedback">Feedback/Suggestion</option>
                                    <option value="other">Other</option>
                                </optgroup>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="subject" style="color: #2e7d32; font-weight: 600;">Subject *</label>
                            <input type="text" id="subject" name="subject" required placeholder="Brief description of your inquiry" style="border: 2px solid #4caf50; border-radius: 8px; padding: 0.75rem; transition: all 0.3s ease;">
                        </div>

                        <div class="form-group">
                            <label for="message" style="color: #2e7d32; font-weight: 600;">Message *</label>
                            <textarea id="message" name="message" rows="6" required placeholder="Please describe your inquiry, concern, or technical issue in detail..." style="border: 2px solid #4caf50; border-radius: 8px; padding: 0.75rem; transition: all 0.3s ease; resize: vertical;"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="priority" style="color: #2e7d32; font-weight: 600;">Priority Level</label>
                            <select id="priority" name="priority" style="border: 2px solid #4caf50; border-radius: 8px; padding: 0.75rem; transition: all 0.3s ease; background: white;">
                                <option value="low">Low - General inquiry</option>
                                <option value="medium" selected>Medium - Standard request</option>
                                <option value="high">High - Urgent issue</option>
                                <option value="critical">Critical - Service outage</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="checkbox-label" style="display: flex; align-items: center; gap: 0.5rem; color: #2e7d32;">
                                <input type="checkbox" name="newsletter" value="yes" style="accent-color: #4caf50;">
                                <span>Subscribe to our newsletter for updates and promotions</span>
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary btn-large" style="background: linear-gradient(135deg, #4caf50 0%, #2e7d32 100%); color: white; border: none; padding: 1rem 2rem; border-radius: 25px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s ease; width: 100%; box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);">Send Message</button>
                    </form>
                </div>
            </div>
        </section>
        <section class="map-section">
            <div class="container">
                <h2>Find Us</h2>
                <div class="map-container">
                    <div class="map-placeholder">
                        <div class="map-content">
                            <h3>📍 UltraFiberX Main Office</h3>
                            <p>123 Fiber Technology Avenue, Makati City</p>
                            <p>Metro Manila 1200, Philippines</p>
                            <div class="map-actions">
                                <a href="https://maps.google.com/?q=Makati+City+Philippines" target="_blank" class="btn btn-outline">View on Google Maps</a>
                                <a href="https://waze.com/ul?q=Makati+City+Philippines" target="_blank" class="btn btn-outline">Open in Waze</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="self-service">
            <div class="container">
                <h2>Self-Service Options</h2>
                <div class="self-service-grid">
                    <div class="self-service-item">
                        <div class="service-icon">📊</div>
                        <h3>Check Service Status</h3>
                        <p>View current fiber network status and maintenance schedules in your area.</p>
                        <button class="btn btn-outline" onclick="checkServiceStatus()">Check Status</button>
                    </div>
                    
                    <div class="self-service-item">
                        <div class="service-icon">💳</div>
                        <h3>Pay Your Bill</h3>
                        <p>Make payments online quickly and securely through our payment portal.</p>
                        <button class="btn btn-outline" onclick="openBillPayment()">Pay Now</button>
                    </div>
                    
                    <div class="self-service-item">
                        <div class="service-icon">📱</div>
                        <h3>Speed Test</h3>
                        <p>Test your current fiber internet speed and connection quality.</p>
                        <a href="https://fast.com" target="_blank" class="btn btn-outline">Run Speed Test</a>
                    </div>

                    <div class="self-service-item">
                        <div class="service-icon">🔧</div>
                        <h3>Troubleshooting Guide</h3>
                        <p>Step-by-step solutions for common fiber internet issues.</p>
                        <button class="btn btn-outline" onclick="showTroubleshooting()">View Guide</button>
                    </div>

                    <div class="self-service-item">
                        <div class="service-icon">📋</div>
                        <h3>Account Management</h3>
                        <p>Manage your UltraFiberX account, view usage, and update information.</p>
                        <button class="btn btn-outline" onclick="openAccountPortal()">Manage Account</button>
                    </div>

                    <div class="self-service-item">
                        <div class="service-icon">📞</div>
                        <h3>Schedule Callback</h3>
                        <p>Request a callback from our technical support team at your convenience.</p>
                        <button class="btn btn-outline" onclick="scheduleCallback()">Schedule Call</button>
                    </div>
                </div>
            </div>
        </section>

        <section class="troubleshooting">
            <div class="container">
                <h2>Quick Fiber Troubleshooting Guide</h2>
                <div class="troubleshooting-steps">
                    <div class="step">
                        <div class="step-number">1</div>
                        <div class="step-content">
                            <h3>Check Fiber Equipment</h3>
                            <p>Ensure all fiber cables are properly connected and your ONT (Optical Network Terminal) is powered on with solid green lights.</p>
                        </div>
                    </div>
                    
                    <div class="step">
                        <div class="step-number">2</div>
                        <div class="step-content">
                            <h3>Restart Your Equipment</h3>
                            <p>Unplug your ONT and router for 30 seconds, then plug back the ONT first, wait 2 minutes, then plug in your router.</p>
                        </div>
                    </div>
                    
                    <div class="step">
                        <div class="step-number">3</div>
                        <div class="step-content">
                            <h3>Test Multiple Devices</h3>
                            <p>Test the fiber connection on different devices (phone, laptop, tablet) to isolate the issue.</p>
                        </div>
                    </div>
                    
                    <div class="step">
                        <div class="step-number">4</div>
                        <div class="step-content">
                            <h3>Run Fiber Speed Test</h3>
                            <p>Use our speed test tool to check if you're getting your subscribed fiber speeds.</p>
                        </div>
                    </div>
                    
                    <div class="step">
                        <div class="step-number">5</div>
                        <div class="step-content">
                            <h3>Contact UltraFiberX Support</h3>
                            <p>If issues persist, contact our 24/7 fiber technical support team for expert assistance.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="faq-section">
            <div class="container">
                <h2>Frequently Asked Questions</h2>
                <div class="faq-grid">
                    <div class="faq-item">
                        <h3>What are your business hours?</h3>
                        <p>Our customer service is available Mon-Sun from 6AM to 10PM. Technical support is available 24/7. Our physical office is open Mon-Fri 8AM-6PM, Saturday 9AM-3PM.</p>
                    </div>
                    <div class="faq-item">
                        <h3>How quickly do you respond to inquiries?</h3>
                        <p>We aim to respond to all email inquiries within 4 hours during business hours. Live chat and phone support provide immediate assistance.</p>
                    </div>
                    <div class="faq-item">
                        <h3>How long does fiber installation take?</h3>
                        <p>Fiber installation typically takes 3-4 hours and is scheduled within 3-5 business days of your application approval. Our certified technicians ensure optimal fiber performance.</p>
                    </div>
                    <div class="faq-item">
                        <h3>What if I experience fiber connection issues?</h3>
                        <p>Contact our 24/7 technical support at 09602920661 or email support@ultrafiberx.com for immediate fiber technical assistance.</p>
                    </div>
                    <div class="faq-item">
                        <h3>Can I upgrade or downgrade my fiber plan?</h3>
                        <p>Yes, you can change your UltraFiberX plan anytime. Plan changes take effect on your next billing cycle with no additional fees.</p>
                    </div>
                    <div class="faq-item">
                        <h3>Do you offer business partnerships?</h3>
                        <p>Yes! We're always looking for strategic partnerships. Contact our business development team at business@ultrafiberx.com for partnership opportunities.</p>
                    </div>
                    <div class="faq-item">
                        <h3>What payment methods do you accept?</h3>
                        <p>We accept cash, bank transfer, credit/debit cards, GCash, PayMaya, and over-the-counter payments at partner locations nationwide.</p>
                    </div>
                    <div class="faq-item">
                        <h3>Is there a contract or lock-in period?</h3>
                        <p>No, all UltraFiberX plans are flexible with no lock-in period. You can cancel anytime with 30 days notice.</p>
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
                         Updated support link to point to unified support.html 
                        <a href="support.html">Customer Support</a>
                        <a href="https://fast.com" target="_blank">Speed Test</a>
                    </div>
                    <div class="footer-column">
                        <h4>Company</h4>
                        <a href="about.html">About Us</a>
                         Updated contact link to point to support.html 
                        <a href="support.html">Contact</a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 UltraFiberX Internet Services, Inc. | Ultra-Fast Fiber Solutions</p>
            </div>
        </div>
    </footer>

    <button class="back-to-top" id="backToTop" aria-label="Back to top">↑</button>

    <script>
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

        document.querySelector('.unified-form').addEventListener('submit', function(e) {
            const requiredFields = this.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.style.borderColor = '#dc3545';
                    field.style.boxShadow = '0 0 0 0.2rem rgba(220, 53, 69, 0.25)';
                    isValid = false;
                } else {
                    field.style.borderColor = '#4caf50';
                    field.style.boxShadow = '0 0 0 0.2rem rgba(76, 175, 80, 0.25)';
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('Please fill in all required fields.');
            }
        });

        document.querySelectorAll('.unified-form input, .unified-form select, .unified-form textarea').forEach(field => {
            field.addEventListener('focus', function() {
                this.style.borderColor = '#2e7d32';
                this.style.boxShadow = '0 0 0 0.2rem rgba(46, 125, 50, 0.25)';
            });
            
            field.addEventListener('blur', function() {
                this.style.borderColor = '#4caf50';
                this.style.boxShadow = 'none';
            });
        });

        function checkServiceStatus() {
            alert('Service Status Portal: All UltraFiberX fiber networks are currently operational. No scheduled maintenance in your area.');
        }

        function openBillPayment() {
            alert('Bill Payment Portal: Redirecting to secure payment gateway. You can pay using GCash, PayMaya, credit cards, or bank transfer.');
        }

        function showTroubleshooting() {
            document.querySelector('.troubleshooting').scrollIntoView({ behavior: 'smooth' });
        }

        function openAccountPortal() {
            alert('Account Management Portal: Access your UltraFiberX account to view usage, update information, and manage your fiber service.');
        }

        function scheduleCallback() {
            const time = prompt('When would you like us to call you back? (Please specify date and time)');
            if (time) {
                alert(`Callback scheduled for ${time}. Our technical support team will contact you at your registered number.`);
            }
        }
    </script>
</body>
</html>
