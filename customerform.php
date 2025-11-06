<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Signup - UltraFiberX</title>
    <link rel="stylesheet" href="styles.css">
    <style>
            /* Back to Top Button */
.back-to-top {
  position: fixed;
  bottom: 25px;
  right: 25px;
  width: 50px;
  height: 50px;
  background: #4caf50;
  border: none;
  border-radius: 50%;
  cursor: pointer;
  opacity: 0;
  visibility: hidden;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  z-index: 1000;
  box-shadow: 0 2px 12px rgba(76, 175, 80, 0.25);
  display: flex;
  align-items: center;
  justify-content: center;
}

/* Arrow Shape */
.back-to-top::before {
  content: "";
  border: solid white;
  border-width: 0 3px 3px 0;
  display: block;         /* ensures it behaves like a block */
  width: 10px;            /* size control */
  height: 10px;
  transform: rotate(-135deg); /* points UP */
}

/* Visible state */
.back-to-top.visible {
  opacity: 1;
  visibility: visible;
}

.back-to-top:hover {
  background: #2e7d32;
  transform: translateY(-2px) scale(1.05);
  box-shadow: 0 4px 16px rgba(46, 125, 50, 0.3);
}

.back-to-top:active {
  transform: translateY(0) scale(0.95);
}
    </style>
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
                   <!-- <img src="logo.png" alt="UltraFiberX" width="50" height="50"> -->
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
        <section class="page-header">
            <div class="container">
                <h1>Customer Signup</h1>
                <p>Join UltraFiberX today and experience ultra-fast fiber internet</p>
            </div>
        </section>

        <section class="signup-section">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-info">
                        <h2>Why Choose UltraFiberX?</h2>
                        <ul class="benefits-list">
                            <li>✓ Ultra-fast fiber optic internet</li>
                            <li>✓ 24/7 customer support</li>
                            <li>✓ Free professional installation</li>
                            <li>✓ No hidden fees</li>
                            <li>✓ Unlimited data on all plans</li>
                            <li>✓ No lock-in contracts</li>
                        </ul>
                        
                        <div class="contact-support">
                            <h3>Need Help?</h3>
                            <p>Call us at <strong>09605232388</strong></p>
                            <p>Or email <strong>signup@ultrafiberx.com</strong></p>
                        </div>
                    </div>

                    <div class="signup-form-container">
                        <h2>Application Form</h2>
                        <form class="signup-form" action="process_customer.php" method="POST">
                            <fieldset>
                                <legend>Personal Information</legend>
                                
                                <div class="form-group">
                                    <label for="firstName">First Name *</label>
                                    <input type="text" id="firstName" name="firstName" required>
                                </div>

                                <div class="form-group">
                                    <label for="lastName">Last Name *</label>
                                    <input type="text" id="lastName" name="lastName" required>
                                </div>

                                <div class="form-group">
                                    <label for="middleName">Middle Name</label>
                                    <input type="text" id="middleName" name="middleName">
                                </div>

                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="birthDate">Date of Birth *</label>
                                        <input type="date" id="birthDate" name="birthDate" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="gender">Gender</label>
                                        <select id="gender" name="gender">
                                            <option value="">Select gender</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="other">Other</option>
                                            <option value="prefer-not-to-say">Prefer not to say</option>
                                        </select>
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset>
                                <legend>Contact Information</legend>
                                
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="email">Email Address *</label>
                                        <input type="email" id="email" name="email" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Mobile Number *</label>
                                        <input type="tel" id="phone" name="phone" required placeholder="+63 9XX XXX XXXX">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="alternatePhone">Alternate Phone Number</label>
                                    <input type="tel" id="alternatePhone" name="alternatePhone" placeholder="Landline or other mobile">
                                </div>
                            </fieldset>

                            <fieldset>
                                <legend>Installation Address</legend>
                                
                                <div class="form-group">
                                    <label for="streetAddress">Street Address *</label>
                                    <input type="text" id="streetAddress" name="streetAddress" required placeholder="House/Unit No., Street Name">
                                </div>

                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="barangay">Barangay *</label>
                                        <input type="text" id="barangay" name="barangay" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="city">City/Municipality *</label>
                                        <input type="text" id="city" name="city" required>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="province">Province *</label>
                                        <input type="text" id="province" name="province" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="zipCode">ZIP Code *</label>
                                        <input type="text" id="zipCode" name="zipCode" required pattern="[0-9]{4}" placeholder="1234">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="landmarks">Nearby Landmarks</label>
                                    <textarea id="landmarks" name="landmarks" rows="2" placeholder="Help our technicians find your location easily"></textarea>
                                </div>
                            </fieldset>

                            <fieldset>
                                <legend>Plan Selection</legend>
                                
                                <div class="form-group">
                                    <label for="preferredPlan">Preferred Internet Plan *</label>
                                    <select id="preferredPlan" name="preferredPlan" required>
                                        <option value="">Select a plan</option>
                                        <option value="plan1000">Plan1000 - ₱1,000/month (100 Mbps)</option>
                                        <option value="plan1200">Plan1200 - ₱1,200/month (150 Mbps)</option>
                                        <option value="plan1500">Plan1500 - ₱1,500/month (200 Mbps)</option>
                                        <option value="plan1800">Plan1800 - ₱1,800/month (300 Mbps)</option>
                                        <option value="plan2200">Plan2200 - ₱2,200/month (500 Mbps)</option>
                                    </select>
                                </div>

                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="installDate">Preferred Installation Date *</label>
                                        <input type="date" id="installDate" name="installDate" required min="">
                                    </div>
                                    <div class="form-group">
                                        <label for="installTime">Preferred Time</label>
                                        <select id="installTime" name="installTime">
                                            <option value="">Any time</option>
                                            <option value="morning">Morning (8AM-12PM)</option>
                                            <option value="afternoon">Afternoon (1PM-5PM)</option>
                                            <option value="evening">Evening (6PM-8PM)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="paymentMethod">Preferred Payment Method</label>
                                    <select id="paymentMethod" name="paymentMethod">
                                        <option value="">Select payment method</option>
                                        <option value="cash">Cash</option>
                                        <option value="bank-transfer">Bank Transfer</option>
                                        <option value="credit-card">Credit Card</option>
                                        <option value="gcash">GCash</option>
                                        <option value="paymaya">PayMaya</option>
                                        <option value="otc">Over-the-Counter</option>
                                    </select>
                                </div>
                            </fieldset>

                            <fieldset>
                                <legend>Additional Information</legend>
                                
                                <div class="form-group">
                                    <label for="referralSource">How did you hear about us?</label>
                                    <select id="referralSource" name="referralSource">
                                        <option value="">Select source</option>
                                        <option value="friend">Friend/Family Referral</option>
                                        <option value="social-media">Social Media</option>
                                        <option value="google">Google Search</option>
                                        <option value="advertisement">Advertisement</option>
                                        <option value="flyer">Flyer/Brochure</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="specialRequests">Special Requests or Notes</label>
                                    <textarea id="specialRequests" name="specialRequests" rows="3" placeholder="Any special installation requirements, access instructions, or other notes..."></textarea>
                                </div>
                            </fieldset>

                            <div class="form-agreements">
                                <div class="checkbox-group">
                                    <input type="checkbox" id="terms" name="terms" required>
                                    <label for="terms">I agree to the <a href="#terms" target="_blank">Terms and Conditions</a> and <a href="#privacy" target="_blank">Privacy Policy</a> *</label>
                                </div>

                                <div class="checkbox-group">
                                    <input type="checkbox" id="dataConsent" name="dataConsent" required>
                                    <label for="dataConsent">I consent to the collection and processing of my personal data for service provision *</label>
                                </div>

                                <div class="checkbox-group">
                                    <input type="checkbox" id="marketing" name="marketing">
                                    <label for="marketing">I would like to receive promotional offers and updates via email/SMS</label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-large">Submit Application</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Updated footer to have consistent 6-item navigation structure and professional compact design -->
    <footer class="footer footer-compact">
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">
                    <img src="logo.png" alt="UltraFiberX" >
                    <span class="footer-logo-text">UltraFiberX</span>
                </div>
                <div class="footer-links">
                    <div class="footer-column">
                        <h4>Services</h4>
                        <a href="plans.php">Internet Plans</a>
                        <a href="customerform.php">Sign Up</a>
                    </div>
                    <div class="footer-column">
                        <h4>Support</h4>
                        <a href="support.php">Customer Support</a>
                        <a href="https://fast.com" target="_blank">Speed Test</a>
                    </div>
                    <div class="footer-column">
                        <h4>Company</h4>
                        <a href="about.php">About Us</a>
                        <a href="support.php">Contact</a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 UltraFiberX Internet Services, Inc. | Ultra-Fast Fiber Internet</p>
            </div>
        </div>
    </footer>

    <!-- Updated back-to-top button to use blue design with upward chevron -->
    <button class="back-to-top" id="backToTop" aria-label="Back to top"></button>

    <script>
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

        // Set minimum date to tomorrow for installation
        document.addEventListener('DOMContentLoaded', function() {
            const installDateInput = document.getElementById('installDate');
            const tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() + 1);
            installDateInput.min = tomorrow.toISOString().split('T')[0];

            const urlParams = new URLSearchParams(window.location.search);
            const planFromUrl = urlParams.get('plan');
            const planFromStorage = localStorage.getItem('selectedPlan');
            
            const selectedPlan = planFromUrl || planFromStorage;
            
            if (selectedPlan) {
                const planSelect = document.getElementById('preferredPlan');
                const option = planSelect.querySelector(`option[value="${selectedPlan}"]`);
                
                if (option) {
                    planSelect.value = selectedPlan;
                    // Highlight the selected plan
                    planSelect.style.borderColor = '#1976d2';
                    planSelect.style.backgroundColor = '#f8f9ff';
                    
                    // Show a notification
                    showPlanSelectedNotification(option.textContent);
                }
                
                // Clear localStorage after use
                localStorage.removeItem('selectedPlan');
                localStorage.removeItem('selectedPlanName');
            }
        });

        function showPlanSelectedNotification(planName) {
            const notification = document.createElement('div');
            notification.className = 'plan-notification';
            notification.innerHTML = `
                <div style="background: #e3f2fd; border: 1px solid #1976d2; border-radius: 5px; padding: 1rem; margin-bottom: 1rem; color: #1976d2;">
                    <strong>✓ Plan Selected:</strong> ${planName}
                    <button onclick="this.parentElement.parentElement.remove()" style="float: right; background: none; border: none; color: #1976d2; cursor: pointer; font-size: 1.2rem;">&times;</button>
                </div>
            `;
            
            const form = document.querySelector('.signup-form');
            form.insertBefore(notification, form.firstChild);
            
            // Auto-remove after 10 seconds
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.remove();
                }
            }, 10000);
        }
    </script>
</body>
</html>
