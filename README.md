# ConnectPH Internet Services Website

A complete static website for ConnectPH, a Philippine internet service provider, built with HTML, CSS, and minimal JavaScript.

## File Structure

\`\`\`
├── index.html          # Homepage with hero section and service overview
├── plans.html          # Internet plans page with pricing (₱500-₱1,500)
├── inquiries.html      # Contact form and inquiry submission
├── customer-form.html  # Detailed customer signup form
├── support.html        # Technical support and customer service
├── styles.css          # Complete responsive CSS styling
└── README.md          # This documentation file
\`\`\`

## Pages Overview

### 1. Homepage (index.html)
- **Hero Section**: Main banner with call-to-action buttons
- **Service Cards**: Overview of Basic, Standard, and Premium plans
- **Help Section**: Search functionality and quick action buttons
- **Navigation**: Sticky header with mobile-responsive menu

### 2. Internet Plans (plans.html)
- **Plan Cards**: 4 tiers (Basic ₱500, Standard ₱800, Plus ₱1,100, Premium ₱1,500)
- **Features**: Speed, data caps, and inclusions clearly displayed
- **Plan Benefits**: Free installation, WiFi router, 24/7 monitoring
- **Responsive Grid**: Mobile-friendly plan comparison

### 3. Inquiries & Concerns (inquiries.html)
- **Contact Information**: Phone, email, and office address
- **Inquiry Form**: Name, email, subject, message with validation
- **FAQ Section**: Common questions and answers
- **Priority Levels**: Low, medium, high, critical issue classification

### 4. Customer Signup (customer-form.html)
- **Personal Information**: Full name, birth date, gender
- **Contact Details**: Email, mobile, alternate phone
- **Installation Address**: Complete address with landmarks
- **Plan Selection**: Choose from available plans with preferred dates
- **Terms & Conditions**: Required checkboxes for agreements

### 5. Support (support.html)
- **Technical Support**: 24/7 phone support, email, live chat
- **Customer Service**: Billing, account, and general inquiries
- **Self-Service**: Status check, bill payment, speed test, account management
- **Troubleshooting Guide**: 5-step problem resolution process

## Design Features

### Layout Structure (Based on Globe Telecom Design)
- **Header**: Two-tier navigation (top utility nav + main navigation)
- **Hero Sections**: Full-width banners with compelling messaging
- **Service Cards**: Grid layout with hover effects and pricing
- **Forms**: Comprehensive with proper validation and accessibility
- **Footer**: Multi-column with company links and copyright

### Color Scheme
- **Primary Blue**: #1e3a8a (navigation, headings, buttons)
- **Secondary Blue**: #0ea5e9 (accents, prices, links)
- **Light Blue**: #3b82f6 (gradients, hover states)
- **Neutral Gray**: #64748b (body text, secondary information)
- **Background**: #f8fafc (section backgrounds)

### Typography
- **Font Family**: System fonts (-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto)
- **Headings**: Bold weights (700) for impact
- **Body Text**: Regular (400) and medium (500) weights
- **Responsive Sizing**: Scales appropriately on mobile devices

## Technical Implementation

### HTML Structure
- **Semantic HTML5**: Proper use of header, nav, main, section, article, aside, footer
- **Accessibility**: ARIA labels, proper form labels, alt text for images
- **Form Validation**: Required fields, input types, pattern matching
- **Mobile-First**: Responsive meta viewport and structure

### CSS Features
- **CSS Grid & Flexbox**: Modern layout techniques
- **Custom Properties**: Consistent spacing and colors
- **Responsive Design**: Mobile-first approach with breakpoints
- **Hover Effects**: Smooth transitions and interactive elements
- **Print Styles**: Optimized for printing

### JavaScript (Optional)
- **Mobile Menu**: Toggle functionality for navigation
- **Smooth Scrolling**: Enhanced user experience for anchor links
- **Form Enhancement**: Date validation for installation scheduling
- **Progressive Enhancement**: Site works without JavaScript

## Responsive Breakpoints

- **Desktop**: 1200px+ (full layout)
- **Tablet**: 768px-1199px (adjusted grid columns)
- **Mobile**: 320px-767px (single column, stacked layout)

## Accessibility Features

- **WCAG 2.1 AA Compliant**: Color contrast, keyboard navigation
- **Screen Reader Support**: Proper headings, labels, alt text
- **Focus Management**: Visible focus indicators
- **Reduced Motion**: Respects user preferences
- **High Contrast**: Enhanced borders and outlines

## Browser Support

- **Modern Browsers**: Chrome 90+, Firefox 88+, Safari 14+, Edge 90+
- **Mobile Browsers**: iOS Safari, Chrome Mobile, Samsung Internet
- **Fallbacks**: Graceful degradation for older browsers

## Installation & Usage

1. **Download**: Extract all files to your web server directory
2. **No Build Process**: Static files ready to serve
3. **Local Testing**: Open index.html in any modern browser
4. **Web Server**: Upload to any hosting provider (Apache, Nginx, etc.)

## Customization

### Branding
- Replace placeholder logos with actual ConnectPH branding
- Update contact information in all forms and pages
- Modify color scheme in styles.css if needed

### Content
- Update plan pricing and features as needed
- Modify contact information and addresses
- Customize FAQ content and troubleshooting steps

### Forms
- Configure form action URLs to point to your backend
- Add additional validation as required
- Integrate with payment processing systems

## Performance Optimization

- **Optimized Images**: Use appropriate formats and sizes
- **Minified CSS**: Consider minification for production
- **Lazy Loading**: Implement for images below the fold
- **CDN**: Serve static assets from content delivery network

## SEO Considerations

- **Meta Tags**: Add appropriate title, description, keywords
- **Structured Data**: Implement schema markup for business information
- **Sitemap**: Generate XML sitemap for search engines
- **Analytics**: Add Google Analytics or similar tracking

---

**ConnectPH Internet Services** - Connecting the Philippines, one home at a time.
