
CREATE DATABASE IF NOT EXISTS db;
USE db;

CREATE TABLE IF NOT EXISTS users (
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(50) NOT NULL,
    otp INT(6)
);


INSERT INTO users (username, email, password) VALUES
('user', 'user@user.com', 'password'),
('test', 'latewe1340@ustorp.com', 'test');

