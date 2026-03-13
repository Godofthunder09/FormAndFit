-- Filename: admin_users.sql
-- Run this script in your database management tool (e.g., phpMyAdmin, MySQL Workbench).

CREATE TABLE admin_users (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Default Admin User: Username 'admin', Password 'password123'
-- Hash generated using: password_hash('password123', PASSWORD_DEFAULT)
-- IMPORTANT: Change this default password immediately after logging in for the first time.
INSERT INTO admin_users (username, password_hash) VALUES 
('superadminoyash', '$2y$10$IsXjPsxOJAVb5Pc9sYXUfuj4y9nLXU0VhmMSIrf6NAuj4DLPo/H6W');