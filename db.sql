CREATE DATABASE IF NOT EXISTS tms;

USE tms;

-- Create 'users' table
CREATE TABLE IF NOT EXISTS users (
    userId INT AUTO_INCREMENT PRIMARY KEY,
    userName VARCHAR(255) NOT NULL
);

-- Create 'tasks' table with userId as a foreign key
CREATE TABLE IF NOT EXISTS tasks (
    taskId INT AUTO_INCREMENT PRIMARY KEY,
    taskName VARCHAR(255) NOT NULL,
    is_done BOOLEAN DEFAULT 0,
    userId INT,
    FOREIGN KEY (userId) REFERENCES users(userId)
);
