# BeastModeHQ - A gym website

## Replicate the database here:

CREATE database beastmodehq;


### USERS Table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    date_of_birth DATE,
    role ENUM('member', 'admin') DEFAULT 'member',
    membership_id INT DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (membership_id) REFERENCES memberships(id) ON DELETE SET NULL
);

### MEMBERSHIPS Table 
CREATE TABLE memberships (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    membership_type ENUM('weekly', 'monthly', 'yearly') NOT NULL,
    status ENUM('active', 'expired', 'cancelled') NOT NULL DEFAULT 'active',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);



### Creating an admin

INSERT INTO users (name, email, password_hash, date_of_birth, role, membership_id) 
VALUES ("God", "god@mail.com", "$2y$10$jd.Q35ZRbk2LxjrWlgbaaO2Wx6Zdm3nGX1Y5cdBzWCLIH.cWcOF8e", 2000-00-00, "admin", NULL);



### Classes

CREATE TABLE classes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,             -- e.g. Yoga, Zumba, HIIT
    description TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE class_sessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    class_id INT NOT NULL,
    session_date DATE NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    capacity INT DEFAULT 20,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE
);

CREATE TABLE class_enrollments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    class_session_id INT NOT NULL,
    status ENUM('enrolled', 'cancelled', 'attended', 'missed') DEFAULT 'enrolled',
    enrolled_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (class_session_id) REFERENCES class_sessions(id) ON DELETE CASCADE
);
