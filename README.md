# BeastModeHQ - A gym website

## Create the database here:

CREATE database beastmodehq;

CREATE TABLE users (
id INT AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(255) NOT NULL,
email VARCHAR(255) UNIQUE NOT NULL,
password_hash VARCHAR(255) NOT NULL,
date_of_birth DATE,
role ENUM('member', 'admin') DEFAULT 'member',
membership_status ENUM('active', 'inactive', 'cancelled') DEFAULT 'active',
created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
