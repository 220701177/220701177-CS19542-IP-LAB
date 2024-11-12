CREATE DATABASE SchoolDB;
USE SchoolDB;

CREATE TABLE Students (
    reg_no INT PRIMARY KEY,
    name VARCHAR(50),
    department VARCHAR(50),
    year INT,
    email VARCHAR(100)
);

INSERT INTO Students (reg_no, name, department, year, email) VALUES
(101, 'Alice Johnson', 'Computer Science', 3, 'alice@example.com'),
(102, 'Bob Smith', 'Mechanical Engineering', 2, 'bob@example.com'),
(103, 'Carol White', 'Electrical Engineering', 4, 'carol@example.com');
