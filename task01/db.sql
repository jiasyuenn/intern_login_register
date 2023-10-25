
CREATE DATABASE IF NOT EXISTS db;
USE db;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(50) NOT NULL,
    otp INT(6) DEFAULT NULL,
    status VARCHAR(50) DEFAULT 'unverified',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);


INSERT INTO users (username, email, password, otp, status, created_at) VALUES
('user', 'user@user.com', 'password',NULL,'unverified',CURRENT_TIMESTAMP),
('test', 'latewe1340@ustorp.com', 'test',NULL,'unverified',CURRENT_TIMESTAMP);

