-- <CHANGE> Adding 14 more clients to the admin dashboard
-- ConnectPH - Additional Customer Data for Admin Dashboard
-- This script adds 14 more diverse customers to populate the admin dashboard

USE networkdb;

-- Insert 14 additional customers with varied data
INSERT INTO customers (
    name, email, phone, plan, message, first_name, last_name, middle_name, 
    birth_date, gender, alternate_phone, street_address, barangay, city, province, 
    zip_code, landmarks, install_date, install_time, payment_method, referral_source, 
    special_requests, marketing_consent, status, date
) VALUES 

('Carlos Mendoza', 'carlos.mendoza@email.com', '+63 917 234 5678', 
 'Premium Plan', 'Need high-speed for work from home', 
 'Carlos', 'Mendoza', 'Rivera', '1985-03-15', 'male', 
 '(02) 8-555-0101', '456', 'San Isidro', 'Quezon City', 
 'Metro Manila', '1100', 'Near Church', '2025-08-26', '10:00:00', 
 'Credit Card', 'Friend Referral', 'No special requests', 
 1, 'Pending', '2025-08-26'),

('Maria Lopez', 'maria.lopez@email.com', '+63 918 765 4321',
 'Standard Plan', 'For kids online classes', 
 'Maria', 'Lopez', 'Santos', '1990-07-22', 'female',
 '(02) 8-333-2020', '789', 'Poblacion', 'Makati', 
 'Metro Manila', '1200', 'Near School', '2025-08-25', '09:30:00',
 'GCash', 'Online Ad', 'Request technician on weekends',
 1, 'Approved', '2025-08-25'),

('John Reyes', 'john.reyes@email.com', '+63 919 345 6789',
 'Basic Plan', 'Just for browsing and social media',
 'John', 'Reyes', 'Cruz', '1988-12-05', 'male',
 '(02) 8-444-6060', '12-A', 'Barangay Mabini', 'Caloocan', 
 'Metro Manila', '1400', 'Near Barangay Hall', '2025-08-24', '14:15:00',
 'Cash', 'Walk-in', 'No requests',
 0, 'Pending', '2025-08-24'),

('Angela Santos', 'angela.santos@email.com', '+63 920 654 3210',
 'Premium Plan', 'Need stable internet for business',
 'Angela', 'Santos', 'Lim', '1995-02-18', 'female',
 '(02) 8-777-9999', '88', 'Barangay Malinis', 'Pasig', 
 'Metro Manila', '1600', 'Beside Bakery', '2025-08-26', '08:45:00',
 'Credit Card', 'Friend Referral', 'Install router upstairs',
 1, 'Resolved', '2025-08-26'),

('Mark Dela Cruz', 'mark.dc@email.com', '+63 921 555 1212',
 'Fiber Plan', 'High speed for gaming and streaming',
 'Mark', 'Dela Cruz', 'Torres', '1993-04-11', 'male',
 '(02) 8-321-4321', '999', 'Barangay Pag-asa', 'Manila', 
 'Metro Manila', '1000', 'Near Market', '2025-08-23', '16:20:00',
 'PayMaya', 'Promo Booth', 'Request evening installation',
 1, 'Approved', '2025-08-23'),

('Sophia Ramirez', 'sophia.ramirez@email.com', '+63 922 234 9988',
 'Standard Plan', 'For work and Netflix',
 'Sophia', 'Ramirez', 'Ferrer', '1987-11-30', 'female',
 '(02) 8-999-0101', '34-B', 'Barangay Bagong Silang', 'Las Piñas', 
 'Metro Manila', '1740', 'Near Gym', '2025-08-22', '12:00:00',
 'Bank Transfer', 'Facebook Ad', 'No requests',
 1, 'Pending', '2025-08-22'),

('Michael Tan', 'michael.tan@email.com', '+63 923 765 2345',
 'Basic Plan', 'Occasional use only',
 'Michael', 'Tan', 'Uy', '1979-06-09', 'male',
 '(02) 8-212-3030', '22', 'Barangay Kalayaan', 'Marikina', 
 'Metro Manila', '1800', 'Near Park', '2025-08-21', '13:45:00',
 'Cash', 'Flyer', 'No requests',
 0, 'Pending', '2025-08-21'),

('Isabella Cruz', 'isabella.cruz@email.com', '+63 924 876 5432',
 'Fiber Plan', 'Fast internet for online shop',
 'Isabella', 'Cruz', 'Manalo', '1996-01-27', 'female',
 '(02) 8-555-8888', '123', 'Barangay San Roque', 'Taguig', 
 'Metro Manila', '1630', 'Near Mall', '2025-08-20', '11:10:00',
 'GCash', 'Billboard', 'Request modem replacement',
 1, 'Approved', '2025-08-20'),

('James Villanueva', 'james.v@email.com', '+63 925 111 2222',
 'Standard Plan', 'Home and small office use',
 'James', 'Villanueva', 'Bautista', '1982-05-13', 'male',
 '(02) 8-333-5656', '75', 'Barangay Santo Niño', 'Valenzuela', 
 'Metro Manila', '1440', 'Corner Street', '2025-08-19', '15:30:00',
 'Credit Card', 'Friend Referral', 'Evening visits only',
 1, 'Resolved', '2025-08-19'),

('Emma Flores', 'emma.flores@email.com', '+63 926 543 2109',
 'Premium Plan', 'For remote work & video calls',
 'Emma', 'Flores', 'David', '1991-08-08', 'female',
 '(02) 8-232-4545', '42', 'Barangay Maligaya', 'Parañaque', 
 'Metro Manila', '1700', 'Across Pharmacy', '2025-08-18', '10:20:00',
 'PayMaya', 'Website', 'Request free WiFi booster',
 1, 'Approved', '2025-08-18'),

('Anthony Bautista', 'anthony.b@email.com', '+63 927 321 9876',
 'Basic Plan', 'Mostly for social media use',
 'Anthony', 'Bautista', 'Soriano', '1980-09-15', 'male',
 '(02) 8-898-1234', '18', 'Barangay San Jose', 'Malabon', 
 'Metro Manila', '1470', 'Near Fire Station', '2025-08-17', '17:45:00',
 'Cash', 'Radio Ad', 'No requests',
 0, 'Pending', '2025-08-17'),

('Olivia Navarro', 'olivia.n@email.com', '+63 928 456 7890',
 'Fiber Plan', 'Needed for family online schooling',
 'Olivia', 'Navarro', 'Martinez', '1994-03-25', 'female',
 '(02) 8-777-1212', '67', 'Barangay Santa Lucia', 'Pasay', 
 'Metro Manila', '1300', 'Near Wet Market', '2025-08-16', '09:00:00',
 'Bank Transfer', 'Friend Referral', 'Morning schedule preferred',
 1, 'Approved', '2025-08-16'),

('Daniel Ramos', 'daniel.r@email.com', '+63 929 222 3344',
 'Standard Plan', 'Family use, browsing and video calls',
 'Daniel', 'Ramos', 'Aguilar', '1986-10-02', 'male',
 '(02) 8-888-7676', '81', 'Barangay San Pedro', 'Mandaluyong', 
 'Metro Manila', '1550', 'Near Hospital', '2025-08-15', '14:10:00',
 'Credit Card', 'Flyer', 'Request fast installation',
 1, 'Resolved', '2025-08-15'),

('Grace Castillo', 'grace.castillo@email.com', '+63 930 111 4455',
 'Premium Plan', 'Stable internet for graphic design work',
 'Grace', 'Castillo', 'Lopez', '1992-12-12', 'female',
 '(02) 8-111-9090', '59', 'Barangay Mabuhay', 'San Juan', 
 'Metro Manila', '1500', 'Beside Convenience Store', '2025-08-14', '08:30:00',
 'GCash', 'Social Media', 'Needs extra LAN cable',
 1, 'Approved', '2025-08-14');
