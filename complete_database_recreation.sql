-- UltraFiberX Network Database Complete Recreation Script
-- Run this script to recreate the entire database from scratch

-- Create database
CREATE DATABASE IF NOT EXISTS networkdb;
USE networkdb;

-- Drop existing tables if they exist (for clean recreation)
DROP TABLE IF EXISTS invoices;
DROP TABLE IF EXISTS inquiries;
DROP TABLE IF EXISTS customers;
DROP TABLE IF EXISTS admin_users;

-- 1. Customers table
CREATE TABLE customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    plan VARCHAR(50) NOT NULL,
    message TEXT,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    middle_name VARCHAR(50),
    birth_date DATE,
    gender VARCHAR(20),
    alternate_phone VARCHAR(20),
    street_address VARCHAR(200),
    barangay VARCHAR(100),
    city VARCHAR(100),
    province VARCHAR(100),
    zip_code VARCHAR(10),
    landmarks TEXT,
    install_date DATE,
    install_time VARCHAR(20),
    payment_method VARCHAR(50),
    referral_source VARCHAR(50),
    special_requests TEXT,
    marketing_consent BOOLEAN DEFAULT FALSE,
    status ENUM('Pending', 'Approved', 'Rejected', 'Active') DEFAULT 'Pending',
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    approved_date DATE NULL
);

-- 2. Inquiries table
CREATE TABLE inquiries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    phone VARCHAR(20),
    account_number VARCHAR(50),
    priority VARCHAR(20) DEFAULT 'medium',
    newsletter_consent BOOLEAN DEFAULT FALSE,
    status ENUM('Pending', 'In Progress', 'Resolved', 'Closed') DEFAULT 'Pending',
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3. Admin users table
CREATE TABLE admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    role VARCHAR(20) DEFAULT 'admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL
);

-- 4. Invoices table
CREATE TABLE invoices (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    due_date DATE NOT NULL,
    status ENUM('Pending', 'Paid', 'Overdue') DEFAULT 'Pending',
    created_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    paid_date DATETIME NULL,
    FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE
);

-- Default admin user (password: admin123)
INSERT INTO admin_users (username, password, email) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@ultrafiberx.com');

-- Sample inquiries
INSERT INTO inquiries (name, email, subject, message, status) VALUES 
('Maria Santos', 'maria@example.com', 'Technical Support', 'Internet connection is slow', 'Pending'),
('John Doe', 'john@example.com', 'Billing Inquiry', 'Question about my monthly bill', 'In Progress');

-- Insert 14 customers (all still PENDING)
INSERT INTO customers (
    name, email, phone, plan, message, first_name, last_name, middle_name, 
    birth_date, gender, alternate_phone, street_address, barangay, city, province, 
    zip_code, landmarks, install_date, install_time, payment_method, referral_source, 
    special_requests, marketing_consent, status, date
) VALUES
('Carlos Mendoza', 'carlos.mendoza@email.com', '+63 917 234 5678', 'Plan2200', 'Need high-speed for work from home', 'Carlos', 'Mendoza', 'Rivera', '1985-03-15', 'male', '(02) 8-555-0101', '456', 'San Isidro', 'Quezon City', 'Metro Manila', '1100', 'Near Church', '2025-08-26', '10:00:00', 'Credit Card', 'Friend Referral', 'No special requests', 1, 'Pending', '2025-08-26'),
('Maria Lopez', 'maria.lopez@email.com', '+63 918 765 4321', 'Plan1200', 'For kids online classes', 'Maria', 'Lopez', 'Santos', '1990-07-22', 'female', '(02) 8-333-2020', '789', 'Poblacion', 'Makati', 'Metro Manila', '1200', 'Near School', '2025-08-25', '09:30:00', 'GCash', 'Online Ad', 'Request technician on weekends', 1, 'Pending', '2025-08-25'),
('John Reyes', 'john.reyes@email.com', '+63 919 345 6789', 'Plan1000', 'Just for browsing and social media', 'John', 'Reyes', 'Cruz', '1988-12-05', 'male', '(02) 8-444-6060', '12-A', 'Barangay Mabini', 'Caloocan', 'Metro Manila', '1400', 'Near Barangay Hall', '2025-08-24', '14:15:00', 'Cash', 'Walk-in', 'No requests', 0, 'Pending', '2025-08-24'),
('Angela Santos', 'angela.santos@email.com', '+63 920 654 3210', 'Plan1800', 'Need stable internet for business', 'Angela', 'Santos', 'Lim', '1995-02-18', 'female', '(02) 8-777-9999', '88', 'Barangay Malinis', 'Pasig', 'Metro Manila', '1600', 'Beside Bakery', '2025-08-26', '08:45:00', 'Credit Card', 'Friend Referral', 'Install router upstairs', 1, 'Pending', '2025-08-26'),
('Mark Dela Cruz', 'mark.dc@email.com', '+63 921 555 1212', 'Plan2200', 'High speed for gaming and streaming', 'Mark', 'Dela Cruz', 'Torres', '1993-04-11', 'male', '(02) 8-321-4321', '999', 'Barangay Pag-asa', 'Manila', 'Metro Manila', '1000', 'Near Market', '2025-08-23', '16:20:00', 'PayMaya', 'Promo Booth', 'Request evening installation', 1, 'Pending', '2025-08-23'),
('Sophia Ramirez', 'sophia.ramirez@email.com', '+63 922 234 9988', 'Plan1500', 'For work and Netflix', 'Sophia', 'Ramirez', 'Ferrer', '1987-11-30', 'female', '(02) 8-999-0101', '34-B', 'Barangay Bagong Silang', 'Las Piñas', 'Metro Manila', '1740', 'Near Gym', '2025-08-22', '12:00:00', 'Bank Transfer', 'Facebook Ad', 'No requests', 1, 'Pending', '2025-08-22'),
('Michael Tan', 'michael.tan@email.com', '+63 923 765 2345', 'Plan1000', 'Occasional use only', 'Michael', 'Tan', 'Uy', '1979-06-09', 'male', '(02) 8-212-3030', '22', 'Barangay Kalayaan', 'Marikina', 'Metro Manila', '1800', 'Near Park', '2025-08-21', '13:45:00', 'Cash', 'Flyer', 'No requests', 0, 'Pending', '2025-08-21'),
('Isabella Cruz', 'isabella.cruz@email.com', '+63 924 876 5432', 'Plan2200', 'Fast internet for online shop', 'Isabella', 'Cruz', 'Manalo', '1996-01-27', 'female', '(02) 8-555-8888', '123', 'Barangay San Roque', 'Taguig', 'Metro Manila', '1630', 'Near Mall', '2025-08-20', '11:10:00', 'GCash', 'Billboard', 'Request modem replacement', 1, 'Pending', '2025-08-20'),
('James Villanueva', 'james.v@email.com', '+63 925 111 2222', 'Plan1200', 'Home and small office use', 'James', 'Villanueva', 'Bautista', '1982-05-13', 'male', '(02) 8-333-5656', '75', 'Barangay Santo Niño', 'Valenzuela', 'Metro Manila', '1440', 'Corner Street', '2025-08-19', '15:30:00', 'Credit Card', 'Friend Referral', 'Evening visits only', 1, 'Pending', '2025-08-19'),
('Emma Flores', 'emma.flores@email.com', '+63 926 543 2109', 'Plan1800', 'For remote work & video calls', 'Emma', 'Flores', 'David', '1991-08-08', 'female', '(02) 8-232-4545', '42', 'Barangay Maligaya', 'Parañaque', 'Metro Manila', '1700', 'Across Pharmacy', '2025-08-18', '10:20:00', 'PayMaya', 'Website', 'Request free WiFi booster', 1, 'Pending', '2025-08-18'),
('Anthony Bautista', 'anthony.b@email.com', '+63 927 321 9876', 'Plan1000', 'Mostly for social media use', 'Anthony', 'Bautista', 'Soriano', '1980-09-15', 'male', '(02) 8-898-1234', '18', 'Barangay San Jose', 'Malabon', 'Metro Manila', '1470', 'Near Fire Station', '2025-08-17', '17:45:00', 'Cash', 'Radio Ad', 'No requests', 0, 'Pending', '2025-08-17'),
('Olivia Navarro', 'olivia.n@email.com', '+63 928 456 7890', 'Plan2200', 'Needed for family online schooling', 'Olivia', 'Navarro', 'Martinez', '1994-03-25', 'female', '(02) 8-777-1212', '67', 'Barangay Santa Lucia', 'Pasay', 'Metro Manila', '1300', 'Near Wet Market', '2025-08-16', '09:00:00', 'Bank Transfer', 'Friend Referral', 'Morning schedule preferred', 1, 'Pending', '2025-08-16'),
('Daniel Ramos', 'daniel.r@email.com', '+63 929 222 3344', 'Plan1200', 'Family use, browsing and video calls', 'Daniel', 'Ramos', 'Aguilar', '1986-10-02', 'male', '(02) 8-888-7676', '81', 'Barangay San Pedro', 'Mandaluyong', 'Metro Manila', '1550', 'Near Hospital', '2025-08-15', '14:10:00', 'Credit Card', 'Flyer', 'Request fast installation', 1, 'Pending', '2025-08-15'),
('Grace Castillo', 'grace.castillo@email.com', '+63 930 111 4455', 'Plan1500', 'Stable internet for graphic design work', 'Grace', 'Castillo', 'Lopez', '1992-12-12', 'female', '(02) 8-111-9090', '59', 'Barangay Mabuhay', 'San Juan', 'Metro Manila', '1500', 'Beside Convenience Store', '2025-08-14', '08:30:00', 'GCash', 'Social Media', 'Needs extra LAN cable', 1, 'Pending', '2025-08-14');

-- ✅ No invoices are created now since all are pending
-- Billing will start when admin activates them
