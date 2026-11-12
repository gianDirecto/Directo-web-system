CREATE DATABASE IF NOT EXISTS crud_system
CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE crud_system;

CREATE TABLE IF NOT EXISTS `User` (
    user_ID INT AUTO_INCREMENT PRIMARY KEY,
    Firstname VARCHAR(100) NOT NULL,
    Lastname VARCHAR(100) NOT NULL,
    Middlename VARCHAR(100) DEFAULT NULL,
    Birthdate DATE NOT NULL,
    Gender ENUM('Male', 'Female', 'Other') NOT NULL,
    Email VARCHAR(150) NOT NULL UNIQUE,
    date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS Course (
    Course_ID INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    description TEXT,
    course_code VARCHAR(50) NOT NULL,
    status ENUM('on', 'off') NOT NULL DEFAULT 'on',
    date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS User_Course (
    user_ID INT NOT NULL,
    course_ID INT NOT NULL,
    PRIMARY KEY (user_ID, course_ID),
    CONSTRAINT fk_user_course_user
        FOREIGN KEY (user_ID) REFERENCES `User`(user_ID)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_user_course_course
        FOREIGN KEY (course_ID) REFERENCES Course(Course_ID)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

INSERT INTO Course (name, description, course_code, status)
SELECT 'Information Technology',
       'Study of computer systems, software, and technology',
       'BSIT', 'on'
WHERE NOT EXISTS (
    SELECT 1 FROM Course WHERE course_code = 'BSIT'
);

INSERT INTO Course (name, description, course_code, status)
SELECT 'Computer Science',
       'Study of computing, algorithms, and programming',
       'BSCS', 'on'
WHERE NOT EXISTS (
    SELECT 1 FROM Course WHERE course_code = 'BSCS'
);

INSERT INTO Course (name, description, course_code, status)
SELECT 'Information Systems',
       'Study of information systems and business processes',
       'BSIS', 'on'
WHERE NOT EXISTS (
    SELECT 1 FROM Course WHERE course_code = 'BSIS'
);

INSERT INTO Course (name, description, course_code, status)
SELECT 'Computer Engineering',
       'Study of computer hardware and software systems',
       'BSCpE', 'on'
WHERE NOT EXISTS (
    SELECT 1 FROM Course WHERE course_code = 'BSCpE'
);
