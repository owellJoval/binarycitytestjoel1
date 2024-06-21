-- Create database
CREATE DATABASE IF NOT EXISTS project_database;

-- Use the database
USE project_database;

-- Create clients table
CREATE TABLE IF NOT EXISTS clients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    client_code VARCHAR(10) UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create contacts table
CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    surname VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create table to link contacts and clients (many-to-many relationship)
CREATE TABLE IF NOT EXISTS client_contact (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT,
    contact_id INT,
    FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE CASCADE,
    FOREIGN KEY (contact_id) REFERENCES contacts(id) ON DELETE CASCADE
);

-- Insert sample data (optional)
INSERT INTO clients (name, client_code) VALUES
    ('First National Bank', 'FNB001'),
    ('Protea', 'PRO123');
    
INSERT INTO contacts (name, surname, email) VALUES
    ('John', 'Doe', 'john.doe@example.com'),
    ('Jane', 'Smith', 'jane.smith@example.com');

-- Insert sample linking data (optional)
INSERT INTO client_contact (client_id, contact_id) VALUES
    (1, 1),
    (1, 2),
    (2, 1);

-- Create a user for accessing the database
CREATE USER IF NOT EXISTS 'your_username'@'localhost' IDENTIFIED BY 'your_password';
GRANT ALL PRIVILEGES ON project_database.* TO 'your_username'@'localhost';
FLUSH PRIVILEGES;
