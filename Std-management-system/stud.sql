CREATE DATABASE IF NOT EXISTS stud;
USE stud;

 
DROP TABLE IF EXISTS academic_details, report, attendance, course_grades, courses, students, users;

 
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    department VARCHAR(255) NOT NULL
);

 
CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,      
    student_name VARCHAR(100),
    student_id VARCHAR(50) UNIQUE NOT NULL,  
    year_of_study INT,
    program VARCHAR(255)
);

 
CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_code VARCHAR(20) NOT NULL,
    course_name VARCHAR(100) NOT NULL,
    instructor VARCHAR(100) NOT NULL,
    department VARCHAR(100) NOT NULL
);

 
CREATE TABLE course_grades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,          
    course_id INT NOT NULL,
    assignment_grade DECIMAL(5,2) NOT NULL,
    midterm_grade DECIMAL(5,2) NOT NULL,
    final_exam_grade DECIMAL(5,2) NOT NULL,
    final_grade DECIMAL(5,2) NOT NULL,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

 
CREATE TABLE attendance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    course_id INT NOT NULL,
    date DATE NOT NULL,
    status ENUM('Present', 'Absent') NOT NULL,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

 
CREATE TABLE report (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    report_details TEXT,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE
);

 
CREATE TABLE academic_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,    
    student_name VARCHAR(255) NOT NULL,
    program VARCHAR(255) NOT NULL,
    year_of_study INT NOT NULL,
    course VARCHAR(255),
    gpa DECIMAL(3, 2),
    attendance INT,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE
);

 
INSERT INTO users (username, password, department) 
VALUES 
('int.fufa', 'password123', 'CCI'),
('inst. Galata', 'password456', 'CCI');

INSERT INTO students (student_name, student_id, year_of_study, program) 
VALUES 
('MUKTAR ABDULKADER', '0794/15', 3, 'Software Engineering'),
('MINASE GIRMA', '0746/15',3 , 'SOFTWARE ENGINEERING'),
('NAOL DANEIL', '0820/15', 3, 'Software Engineering'),
('MUAZ KEDIR', '0784/15', 3, 'SOFTWARE ENGINEERING');


INSERT INTO courses (course_code, course_name, instructor, department) 
VALUES 
('CS101', 'Intro to Computer Science', 'GADIS', 'Computer Science'),
('SE101', 'Intro to Software Engineering', 'KADIR', 'Software Engineering');

INSERT INTO course_grades (student_id, course_id, assignment_grade, midterm_grade, final_exam_grade, final_grade) 
VALUES 
(1, 1, 80, 85, 90, 87),
(2, 2, 88, 90, 92, 91);

INSERT INTO attendance (student_id, course_id, date, status) 
VALUES 
(1, 1, '2025-01-01', 'Present'),
(2, 2, '2025-01-01', 'Absent');

INSERT INTO report (student_id, report_details) 
VALUES 
(1, 'Good progress in software engineering courses.'),
(2, 'Excellent performance in computer science courses.');

INSERT INTO academic_details (student_id, student_name, program, year_of_study, course, gpa, attendance) 
VALUES 
(1, 'KADIR', 'Software Engineering', 2, 'SE101', 3.5, 85),
(2, 'QASIM', 'Computer Science', 3, 'CS101', 3.8, 90);