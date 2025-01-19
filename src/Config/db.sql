CREATE DATABASE youdemy;

USE youdemy;

CREATE TABLE USERS (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(200),
    email VARCHAR(200) UNIQUE,
    password VARCHAR(200),
    role ENUM('Student', 'Teacher', 'Admin'),
    account_status ENUM('Not Activated', 'Activated', 'Suspended', 'Deleted')
);

CREATE TABLE CATEGORY (
    id INT PRIMARY KEY AUTO_INCREMENT,
    category VARCHAR(200)
);

CREATE TABLE TAGS (
    id INT PRIMARY KEY AUTO_INCREMENT,
    tag VARCHAR(200)
);

CREATE TABLE COURSES (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(200),
    description VARCHAR(200),
    content TEXT,
    category_id INT,
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES USERS(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (category_id) REFERENCES CATEGORY(id) ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE CourseTag (
    id INT PRIMARY KEY AUTO_INCREMENT,
    course_id INT,
    tag_id INT,
    FOREIGN KEY (course_id) REFERENCES COURSES(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES TAGS(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE CourseEnrollments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    course_id INT NOT NULL,
    enrollment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES Users(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (course_id) REFERENCES Courses(id) ON DELETE CASCADE ON UPDATE CASCADE,
    UNIQUE KEY unique_enrollment (user_id, course_id)
);