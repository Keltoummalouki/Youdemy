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


INSERT INTO USERS (username, email, password, role, account_status) VALUES
('keltoum', 'keltoum@gmail.com', '123', 'Admin', 'Activated'),
('othy', 'othy@gmail.com', '123', 'Teacher', 'Activated'),
('khaoula', 'khaoula@gmail.com', '123', 'Student', 'Activated'),
('salma', 'salma@gmail.com', '123', 'Teacher', 'Activated'),
('marwa', 'marwa@gmail.com', '123', 'Student', 'Activated'),
('john_doe', 'john.doe@gmail.com', '123', 'Student', 'Activated'),
('mary_smith', 'mary.smith@gmail.com', '123', 'Teacher', 'Activated'),
('peter_jones', 'peter.jones@gmail.com', '123', 'Student', 'Activated'),
('sarah_wilson', 'sarah.wilson@gmail.com', '123', 'Teacher', 'Activated'),
('james_brown', 'james.brown@gmail.com', '123', 'Student', 'Not Activated'),
('emma_davis', 'emma.davis@gmail.com', '123', 'Teacher', 'Activated'),
('michael_lee', 'michael.lee@gmail.com', '123', 'Student', 'Suspended'),
('lisa_taylor', 'lisa.taylor@gmail.com', '123', 'Student', 'Activated'),
('david_clark', 'david.clark@gmail.com', '123', 'Teacher', 'Deleted');

INSERT INTO CATEGORY (category) VALUES
('Web Development'),
('Data Science'),
('Mobile Development'),
('Design'),
('Business'),
('Marketing'),
('Languages'),
('Music'),
('Photography'),
('Personal Development');

INSERT INTO TAGS (tag) VALUES
('JavaScript'),
('Python'),
('Java'),
('Design'),
('Ai'),
('Machine Learning'),
('UI/UX'),
('SEO'),
('iOS'),
('Android'),
('React'),
('Digital Marketing'),
('Productivity');

INSERT INTO COURSES (title, description, content, category_id, user_id) VALUES
('Introduction to JavaScript', 'Learn JavaScript basics', 'https://www.youtube.com/watch?v=Ihy0QziLDf0&list=PLZPZq0r_RZOO1zkgO4bIdfuLpizCeHYKv&ab_channel=BroCode', 1, 2),
('Python for Data Science', 'Master Python for data analysis', 'https://www.youtube.com/watch?v=wUSDVGivd-8', 2, 20),
('Mobile App Development', 'Create your first mobile app', 'https://www.youtube.com/watch?v=yye7rSsiV6k&t=1s&ab_channel=ProgrammingwithMosh', 3, 14),
('UI Design Fundamentals', 'Learn design principles', 'https://www.youtube.com/watch?v=uwNClNmekGU&ab_channel=JesseShowalter', 4, 22),
('Digital Marketing 101', 'Basic marketing concepts', 'https://www.youtube.com/watch?v=h95cQkEWBx0&ab_channel=AdamErhart', 6, 20),
('React Masterclass', 'Advanced React development', 'http://youtube.com/watch?v=MHn66JJH5zs&list=PLSsAz5wf2lkK_ekd0J__44KG6QoXetZza&ab_channel=CodeStoic', 1, 30);