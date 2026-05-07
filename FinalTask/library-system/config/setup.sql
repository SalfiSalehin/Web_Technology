-- config/setup.sql — Run this once in phpMyAdmin

CREATE DATABASE IF NOT EXISTS university_library;

USE university_library;

CREATE TABLE IF NOT EXISTS books (
    id         INT          NOT NULL AUTO_INCREMENT,
    title      VARCHAR(255) NOT NULL,
    author     VARCHAR(255) NOT NULL,
    category   VARCHAR(100) NOT NULL,
    status     VARCHAR(50)  NOT NULL DEFAULT 'Available',
    PRIMARY KEY (id)
);

INSERT INTO books (title, author, category, status) VALUES
('Clean Code',                 'Robert C. Martin',    'Computer Science', 'Available'),
('The Great Gatsby',           'F. Scott Fitzgerald', 'Literature',       'Checked Out'),
('A Brief History of Time',    'Stephen Hawking',     'Physics',          'Available'),
('Introduction to Algorithms', 'Thomas H. Cormen',    'Computer Science', 'Reserved');
