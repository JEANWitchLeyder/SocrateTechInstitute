SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE IF NOT EXISTS users (
  user_id     INT AUTO_INCREMENT PRIMARY KEY,
  email       VARCHAR(100) NOT NULL UNIQUE,
  password    VARCHAR(255) NOT NULL,
  role        VARCHAR(30)  NOT NULL,
  created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  last_login  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS classes (
  class_id             INT AUTO_INCREMENT PRIMARY KEY,
  class_name           VARCHAR(100) NOT NULL UNIQUE,
  classroom            INT NULL,
  start_academic_year  INT NULL,
  end_academic_year    INT NULL,
  capacity             INT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS majors (
  major_id     INT AUTO_INCREMENT PRIMARY KEY,
  major_name   VARCHAR(100) NOT NULL,
  description  VARCHAR(255) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS teachers (
  teacher_id   INT AUTO_INCREMENT PRIMARY KEY,
  user_id      INT NULL,
  first_name   VARCHAR(150) NOT NULL,
  last_name    VARCHAR(150) NOT NULL,
  email        VARCHAR(200) NOT NULL,
  phone        VARCHAR(80)  NOT NULL,
  degree       VARCHAR(255) NULL,
  experience   VARCHAR(500) NULL,
  major_id     INT NULL,
  CONSTRAINT fk_teachers_user   FOREIGN KEY (user_id)  REFERENCES users(user_id),
  CONSTRAINT fk_teachers_major  FOREIGN KEY (major_id) REFERENCES majors(major_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS tutors (
  tutor_id   INT AUTO_INCREMENT PRIMARY KEY,
  teacher_id INT NOT NULL,
  major_id   INT NOT NULL,
  class_id   INT NOT NULL,
  CONSTRAINT fk_tutors_teacher FOREIGN KEY (teacher_id) REFERENCES teachers(teacher_id),
  CONSTRAINT fk_tutors_major   FOREIGN KEY (major_id)   REFERENCES majors(major_id),
  CONSTRAINT fk_tutors_class   FOREIGN KEY (class_id)   REFERENCES classes(class_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS gender (
  gender_id   INT AUTO_INCREMENT PRIMARY KEY,
  gender_name VARCHAR(50) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS relation (
  relation_id   INT AUTO_INCREMENT PRIMARY KEY,
  relation_name VARCHAR(50) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS parents (
  parent_id   INT AUTO_INCREMENT PRIMARY KEY,
  user_id     INT NULL,
  first_name  VARCHAR(150) NOT NULL,
  last_name   VARCHAR(150) NOT NULL,
  phone       VARCHAR(80)  NOT NULL,
  email       VARCHAR(200) NOT NULL,
  address     VARCHAR(255) NULL,
  CONSTRAINT fk_parents_user FOREIGN KEY (user_id) REFERENCES users(user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS students (
  student_id       INT AUTO_INCREMENT PRIMARY KEY,
  user_id          INT NULL,
  class_id         INT NOT NULL,
  first_name       VARCHAR(150) NOT NULL,
  last_name        VARCHAR(150) NOT NULL,
  date_of_birth    DATE NOT NULL,
  phone            VARCHAR(50) NOT NULL,
  email            VARCHAR(200) NOT NULL,
  place_of_birth   VARCHAR(100) NOT NULL,
  address          VARCHAR(200) NOT NULL,
  age              INT NULL,
  gender_id        INT NULL,
  created_at       TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_students_user   FOREIGN KEY (user_id)   REFERENCES users(user_id),
  CONSTRAINT fk_students_class  FOREIGN KEY (class_id)  REFERENCES classes(class_id),
  CONSTRAINT fk_students_gender FOREIGN KEY (gender_id) REFERENCES gender(gender_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS student_parents (
  student_parents_id INT AUTO_INCREMENT PRIMARY KEY,
  parent_id          INT NOT NULL,
  student_id         INT NOT NULL,
  relation_id        INT NOT NULL,
  CONSTRAINT fk_sp_parent   FOREIGN KEY (parent_id)   REFERENCES parents(parent_id),
  CONSTRAINT fk_sp_student  FOREIGN KEY (student_id)  REFERENCES students(student_id),
  CONSTRAINT fk_sp_relation FOREIGN KEY (relation_id) REFERENCES relation(relation_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DELIMITER //
CREATE TRIGGER trg_students_before_insert
BEFORE INSERT ON students
FOR EACH ROW
BEGIN
  IF NEW.date_of_birth IS NOT NULL THEN
    SET NEW.age = TIMESTAMPDIFF(YEAR, NEW.date_of_birth, CURDATE());
  ELSE
    SET NEW.age = NULL;
  END IF;
END//
DELIMITER ;

DELIMITER //
CREATE TRIGGER trg_students_before_update
BEFORE UPDATE ON students
FOR EACH ROW
BEGIN
  IF NEW.date_of_birth IS NOT NULL THEN
    SET NEW.age = TIMESTAMPDIFF(YEAR, NEW.date_of_birth, CURDATE());
  ELSE
    SET NEW.age = NULL;
  END IF;
END//
DELIMITER ;

CREATE TABLE IF NOT EXISTS time_slots (
  time_id     INT AUTO_INCREMENT PRIMARY KEY,
  start_time  TIME,
  end_time    TIME
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS days (
  day_id INT AUTO_INCREMENT PRIMARY KEY,
  day    VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS courses (
  course_id    INT AUTO_INCREMENT PRIMARY KEY,
  course_name  VARCHAR(150) NOT NULL,
  coefficient  TINYINT NOT NULL,
  description  VARCHAR(255) NULL,
  class_id     INT NULL,
  teacher_id   INT NULL,
  course_code  VARCHAR(20) NULL,
  CONSTRAINT fk_courses_class   FOREIGN KEY (class_id)   REFERENCES classes(class_id),
  CONSTRAINT fk_courses_teacher FOREIGN KEY (teacher_id) REFERENCES teachers(teacher_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DELIMITER $$
CREATE TRIGGER trg_generate_course_code
AFTER INSERT ON courses
FOR EACH ROW
BEGIN
  UPDATE courses
  SET course_code = CONCAT(UPPER(SUBSTRING(NEW.course_name, 1, 3)), NEW.course_id)
  WHERE course_id = NEW.course_id;
END $$
DELIMITER ;

CREATE TABLE IF NOT EXISTS schedule (
  schedule_id INT AUTO_INCREMENT PRIMARY KEY,
  class_id    INT NOT NULL,
  day_id      INT NOT NULL,
  time_id     INT NOT NULL,
  course_id   INT NOT NULL,
  CONSTRAINT fk_schedule_class  FOREIGN KEY (class_id)  REFERENCES classes(class_id),
  CONSTRAINT fk_schedule_day    FOREIGN KEY (day_id)    REFERENCES days(day_id),
  CONSTRAINT fk_schedule_time   FOREIGN KEY (time_id)   REFERENCES time_slots(time_id),
  CONSTRAINT fk_schedule_course FOREIGN KEY (course_id) REFERENCES courses(course_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE IF NOT EXISTS attendance (
  attendance_id INT AUTO_INCREMENT PRIMARY KEY,
  student_id    INT NOT NULL,
  course_id     INT NOT NULL,
  date          DATE NOT NULL,
  status        ENUM('Present','Absent','Late') NOT NULL,
  remarks       VARCHAR(200) NULL,
  INDEX(student_id),
  INDEX(course_id),
  CONSTRAINT fk_att_student FOREIGN KEY (student_id) REFERENCES students(student_id),
  CONSTRAINT fk_att_course  FOREIGN KEY (course_id)  REFERENCES courses(course_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS grades (
  grade_id         INT AUTO_INCREMENT PRIMARY KEY,
  student_id       INT NOT NULL,
  course_id        INT NOT NULL,
  assessment_name  VARCHAR(100) NULL,
  term             VARCHAR(50)  NULL,
  score            DECIMAL(5,2) NULL,
  comments         VARCHAR(200) NULL,
  created_at       DATETIME DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_gr_student FOREIGN KEY (student_id) REFERENCES students(student_id),
  CONSTRAINT fk_gr_course  FOREIGN KEY (course_id)  REFERENCES courses(course_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS materials (
  material_id INT AUTO_INCREMENT PRIMARY KEY,
  course_id   INT NOT NULL,
  teacher_id  INT NOT NULL,
  title       VARCHAR(150),
  file_path   VARCHAR(255),
  created_at  DATETIME DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_mat_course  FOREIGN KEY (course_id)  REFERENCES courses(course_id),
  CONSTRAINT fk_mat_teacher FOREIGN KEY (teacher_id) REFERENCES teachers(teacher_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE IF NOT EXISTS modern (
  modern_id          INT AUTO_INCREMENT PRIMARY KEY,
  modern_course_name VARCHAR(200)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS application (
  application_id INT AUTO_INCREMENT PRIMARY KEY,
  photo_passport VARCHAR(255) NOT NULL,
  last_name      VARCHAR(100) NOT NULL,
  first_name     VARCHAR(100) NOT NULL,
  date_of_birth  DATE NOT NULL,
  sex            CHAR(10) NOT NULL,
  birthplace     VARCHAR(100) NOT NULL,
  phone          VARCHAR(80) NOT NULL,
  email          VARCHAR(200) NOT NULL,
  address        VARCHAR(255) NOT NULL,
  last_class     CHAR(20) NOT NULL,
  modern_id      INT NULL,
  CONSTRAINT fk_app_modern FOREIGN KEY (modern_id) REFERENCES modern(modern_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS quiz (
  quiz_id            INT AUTO_INCREMENT PRIMARY KEY,
  application_id     INT NULL,
  start_time         DATETIME NOT NULL,
  end_time           DATETIME NOT NULL,
  correct_questions  INT NOT NULL,
  incorrect_questions INT NOT NULL,
  score              INT NOT NULL,
  CONSTRAINT fk_quiz_app FOREIGN KEY (application_id) REFERENCES application(application_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS final_admission_decision (
  final_admission_decision_id INT AUTO_INCREMENT PRIMARY KEY,
  quiz_id        INT NOT NULL,
  application_id INT NOT NULL,
  CONSTRAINT fk_fad_quiz FOREIGN KEY (quiz_id) REFERENCES quiz(quiz_id),
  CONSTRAINT fk_fad_app  FOREIGN KEY (application_id) REFERENCES application(application_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS quiz_question_category (
  category_id   INT AUTO_INCREMENT PRIMARY KEY,
  category_name VARCHAR(180) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS question_answers (
  question_id   INT AUTO_INCREMENT PRIMARY KEY,
  class_id      INT NOT NULL,
  category_id   INT NOT NULL,
  question_text VARCHAR(255) NOT NULL,
  optionA       VARCHAR(255) NOT NULL,
  optionB       VARCHAR(255) NOT NULL,
  optionC       VARCHAR(255) NOT NULL,
  optionD       VARCHAR(255) NOT NULL,
  correct_answer CHAR(1) NULL,
  CONSTRAINT fk_qa_class    FOREIGN KEY (class_id)    REFERENCES classes(class_id),
  CONSTRAINT fk_qa_category FOREIGN KEY (category_id) REFERENCES quiz_question_category(category_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS quiz_user_answers (
  quiz_user_answers_id INT AUTO_INCREMENT PRIMARY KEY,
  quiz_id      INT NOT NULL,
  question_id  INT NOT NULL,
  is_correct   TINYINT NOT NULL,
  created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_qua_quiz     FOREIGN KEY (quiz_id)     REFERENCES quiz(quiz_id),
  CONSTRAINT fk_qua_question FOREIGN KEY (question_id) REFERENCES question_answers(question_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS quiz_results (
  result_id        INT NOT NULL AUTO_INCREMENT,
  application_id   INT NOT NULL,
  score            INT NOT NULL CHECK (score BETWEEN 0 AND 100),
  status           VARCHAR(50) NOT NULL,
  completed_at     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (result_id),
  UNIQUE KEY unique_application_result (application_id),
  CONSTRAINT fk_qr_app FOREIGN KEY (application_id) REFERENCES application(application_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE IF NOT EXISTS admin (
  admin_id        INT AUTO_INCREMENT PRIMARY KEY,
  admin_firstname VARCHAR(100) NOT NULL,
  admin_lastname  VARCHAR(100) NOT NULL,
  admin_age       INT NOT NULL,
  admin_function  VARCHAR(100) NULL,
  phone           VARCHAR(80)  NULL,
  email           VARCHAR(200) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO users (email, password, role) VALUES
('jeanpaul@gmail.com', 'pass123', 'parent'),
('sophie.charles@gmail.com', 'secret789', 'student'),
('mdesir@sti.edu', 'teach456', 'teacher'),
('admin@sti.edu', 'admin321', 'admin'),
('marc.martelly@sti.edu', 'teacher123', 'teacher'),
('stephanie.benoit@sti.edu', 'teacher123', 'teacher');


INSERT INTO classes (class_name) VALUES
('7e'),('8e'),('9e'),('NS1'),('NS2'),('NS3'),('NS4');


UPDATE classes SET classroom=701,  start_academic_year=2025, end_academic_year=2026, capacity=62 WHERE class_name='7e';
UPDATE classes SET classroom=801,  start_academic_year=2025, end_academic_year=2026, capacity=65 WHERE class_name='8e';
UPDATE classes SET classroom=901,  start_academic_year=2025, end_academic_year=2026, capacity=68 WHERE class_name='9e';
UPDATE classes SET classroom=1001, start_academic_year=2025, end_academic_year=2026, capacity=72 WHERE class_name='NS1';
UPDATE classes SET classroom=1100, start_academic_year=2025, end_academic_year=2026, capacity=75 WHERE class_name='NS2';
UPDATE classes SET classroom=1200, start_academic_year=2025, end_academic_year=2026, capacity=80 WHERE class_name='NS3';
UPDATE classes SET classroom=1300, start_academic_year=2025, end_academic_year=2026, capacity=85 WHERE class_name='NS4';


INSERT INTO majors (major_name, description) VALUES
('Mathematics & Science', 'Math, physics, chemistry, and general science teaching.'),
('Humanities & Languages', 'French, English, Creole, history, philosophy, and literature.'),
('Social Sciences', 'Geography, sociology, civic education, and social studies.'),
('Economics & Management', 'Economics, business, management, and entrepreneurship.'),
('Computer Science & ICT', 'Programming, databases, networking, and ICT skills.'),
('Arts & Music', 'Visual arts, creative expression, and music.'),
('Physical Education & Sports', 'Physical education, training, and school sports.');


INSERT INTO teachers (user_id, first_name, last_name, email, phone) VALUES
(3, 'Marie', 'Desir', 'mdesir@sti.edu', '+509-3456-7890'),
(5, 'Marc', 'Martelly', 'marc.martelly@sti.edu', '+509-3312-9988'),
(6, 'Stephanie', 'Benoit', 'stephanie.benoit@sti.edu', '+509-4412-0000');


UPDATE teachers
SET degree='BSc in Mathematics and Physics',
    experience='Over 8 years teaching mathematics and physics with a focus on problem solving and clear explanations.',
    major_id=1
WHERE teacher_id=1;

UPDATE teachers
SET degree='BA in Social Sciences',
    experience='Experienced in history, geography, and social studies, helping students connect lessons to real life.',
    major_id=3
WHERE teacher_id=2;

UPDATE teachers
SET degree='MA in French Language and Literature',
    experience='Specialized in French grammar and writing, guiding students to communicate clearly and confidently.',
    major_id=2
WHERE teacher_id=3;


INSERT INTO tutors (teacher_id, major_id, class_id)
SELECT 1, 1, c.class_id FROM classes c WHERE c.class_name='NS1' LIMIT 1;


INSERT INTO gender (gender_name) VALUES ('Male'),('Female');


INSERT INTO relation (relation_name) VALUES
('Mother'),('Father'),('Legal Guardian'),('Uncle'),('Aunt'),('GrandMother'),('GrandFather'),('Cousin');


INSERT INTO parents (parent_id, user_id, first_name, last_name, phone, email, address) VALUES
(1, NULL, 'David',   'Charles', '50936234501', 'david.charles@sti.ht',  NULL),
(2, NULL, 'Eliane',  'Charles', '50936234502', 'eliane.charles@sti.ht', NULL),
(3, NULL, 'Jean',    'Pierre',  '50936234503', 'jean.pierre@sti.ht',   NULL),
(4, NULL, 'Marie',   'Pierre',  '50936234504', 'marie.pierre@sti.ht',  NULL),
(5, NULL, 'Michel',  'Benoit',  '50936234505', 'michel.benoit@sti.ht', NULL),
(6, NULL, 'Claire',  'Benoit',  '50936234506', 'claire.benoit@sti.ht', NULL),
(7, NULL, 'Paul',    'Louis',   '50936234507', 'paul.louis@sti.ht',    NULL),
(8, NULL, 'Sandra',  'Louis',   '50936234508', 'sandra.louis@sti.ht',  NULL),
(9, NULL, 'Richard', 'Jean',    '50936234509', 'richard.jean@sti.ht',  NULL),
(10,NULL, 'Nadine',  'Jean',    '50936234510', 'nadine.jean@sti.ht',   NULL);


INSERT INTO students
(student_id, first_name, last_name, date_of_birth, phone, email, place_of_birth, address, gender_id, user_id, class_id)
VALUES
(1, 'Sophie',  'Charles', '2012-08-12', '50931234501', 'sophie.charles@sti.ht', 'Port-au-Prince', 'Carrefour', 2, 2, 1),
(2, 'Samuel',  'Pierre',  '2012-04-03', '50931234502', 'samuel.pierre@sti.ht',  'Cap-Haïtien',    'Delmas',    1, NULL, 1),
(3, 'Laura',   'Benoit',  '2011-11-30', '50931234503', 'laura.benoit@sti.ht',   'Jacmel',         'Pétion-Ville',2, NULL, 1),
(4, 'Kevin',   'Louis',   '2012-02-18', '50931234504', 'kevin.louis@sti.ht',    'Gonaïves',       'Croix-des-Bouquets',1, NULL, 1),
(5, 'Ruth',    'Jean',    '2011-09-09', '50931234505', 'ruth.jean@sti.ht',      'Léogâne',        'Carrefour',  2, NULL, 1);


INSERT INTO student_parents (student_parents_id, parent_id, student_id, relation_id) VALUES
(1, 1, 1, 2),
(2, 2, 1, 1),
(3, 3, 2, 2),
(4, 4, 2, 1),
(5, 5, 3, 2),
(6, 6, 3, 1),
(7, 7, 4, 2),
(8, 8, 4, 1),
(9, 9, 5, 2),
(10,10,5, 1);


INSERT INTO time_slots (start_time, end_time) VALUES
('08:00:00','10:00:00'),
('10:00:00','12:00:00'),
('12:00:00','13:00:00'),
('13:00:00','15:00:00'),
('15:00:00','15:30:00'),
('15:30:00','17:00:00');

INSERT INTO days (day) VALUES
('Monday'),('Tuesday'),('Wednesday'),('Thursday'),('Friday'),('Saturday');


INSERT INTO courses (course_name, coefficient, description, class_id, teacher_id) VALUES
('Haitian Creole', 3, 'Reading and writing in Haitian Creole.', 1, 3),
('French', 3, 'Basic French grammar and vocabulary.', 1, 3),
('English', 2, 'Simple English communication.', 1, 3),
('Mathematics', 4, 'Arithmetic and problem-solving.', 1, 1),
('Integrated Science', 3, 'Life and physical science basics.', 1, 1),
('Social Sciences', 2, 'Haitian history and geography.', 1, 2),
('Civic & Moral Education', 2, 'Values, respect, and citizenship.', 1, 2),
('Visual Arts', 1, 'Drawing and creative expression.', 1, 3),
('Physical Education', 1, 'Fitness and team sports.', 1, 2),
('Introduction to Computers', 2, 'Keyboard, mouse and basic software.', 1, 1);


INSERT INTO courses (course_name, coefficient, description, class_id, teacher_id) VALUES
('Break', 0, 'Midday break', NULL, NULL),
('Short Break', 0, 'Afternoon short break', NULL, NULL);


UPDATE courses
SET course_code = CONCAT(UPPER(SUBSTRING(course_name, 1, 3)), course_id)
WHERE course_code IS NULL OR course_code = '';


INSERT INTO schedule (class_id, day_id, time_id, course_id) VALUES

(1, 1, 2, (SELECT course_id FROM courses WHERE course_name='English' AND class_id=1 LIMIT 1)),
(1, 1, 4, (SELECT course_id FROM courses WHERE course_name='French'  AND class_id=1 LIMIT 1)),
(1, 1, 6, (SELECT course_id FROM courses WHERE course_name='Mathematics' AND class_id=1 LIMIT 1)),


(1, 2, 2, (SELECT course_id FROM courses WHERE course_name='Haitian Creole' AND class_id=1 LIMIT 1)),
(1, 2, 4, (SELECT course_id FROM courses WHERE course_name='Integrated Science' AND class_id=1 LIMIT 1)),
(1, 2, 6, (SELECT course_id FROM courses WHERE course_name='Social Sciences' AND class_id=1 LIMIT 1)),


(1, 3, 2, (SELECT course_id FROM courses WHERE course_name='English' AND class_id=1 LIMIT 1)),
(1, 3, 4, (SELECT course_id FROM courses WHERE course_name='Mathematics' AND class_id=1 LIMIT 1)),
(1, 3, 6, (SELECT course_id FROM courses WHERE course_name='Visual Arts' AND class_id=1 LIMIT 1)),


(1, 4, 2, (SELECT course_id FROM courses WHERE course_name='French' AND class_id=1 LIMIT 1)),
(1, 4, 4, (SELECT course_id FROM courses WHERE course_name='Civic & Moral Education' AND class_id=1 LIMIT 1)),
(1, 4, 6, (SELECT course_id FROM courses WHERE course_name='Physical Education' AND class_id=1 LIMIT 1)),


(1, 5, 2, (SELECT course_id FROM courses WHERE course_name='Haitian Creole' AND class_id=1 LIMIT 1)),
(1, 5, 4, (SELECT course_id FROM courses WHERE course_name='Introduction to Computers' AND class_id=1 LIMIT 1)),
(1, 5, 6, (SELECT course_id FROM courses WHERE course_name='English' AND class_id=1 LIMIT 1));


INSERT INTO schedule (class_id, day_id, time_id, course_id)
SELECT 1, d.day_id, 3, c.course_id
FROM days d
JOIN courses c ON c.course_name='Break'
WHERE d.day IN ('Monday','Tuesday','Wednesday','Thursday','Friday');


INSERT INTO schedule (class_id, day_id, time_id, course_id)
SELECT 1, d.day_id, 5, c.course_id
FROM days d
JOIN courses c ON c.course_name='Short Break'
WHERE d.day IN ('Monday','Tuesday','Wednesday','Thursday','Friday');


INSERT INTO admin (admin_firstname, admin_lastname, admin_age, admin_function, phone, email) VALUES
('Marie','Desir',32,'Registrar','+509-4412-0001','marie.desir@sti.edu'),
('Marc','Martelly',40,'HR','+509-4412-0002','marc.martelly@sti.edu'),
('Stephanie','Benoit',29,'Discipline','+509-4412-0003','stephanie.benoit@sti.edu'),
('Wilna','Charles',35,'Finance','+509-4412-0004','wilna.charles@sti.edu');


INSERT INTO quiz_question_category (category_name) VALUES
('Mathematics'),('IT'),('Science'),('General Knowledge');


INSERT INTO question_answers (class_id, category_id, question_text, optionA, optionB, optionC, optionD) VALUES
(1, 1, 'What is 5 + 7?', '10', '11', '12', '13'),
(1, 1, 'What is 9 − 4?', '3', '4', '5', '6'),
(1, 1, 'What is 6 × 3?', '9', '12', '18', '21'),
(1, 2, 'Which device is used to move the cursor?', 'Keyboard', 'Mouse', 'Speaker', 'Printer'),
(1, 2, 'Which of these is a computer?', 'Table', 'Laptop', 'Chair', 'Window'),
(1, 2, 'Which part shows the output?', 'Mouse', 'Monitor', 'Keyboard', 'USB'),
(1, 3, 'Which one is a liquid at room temperature?', 'Ice', 'Water', 'Steam', 'Stone'),
(1, 3, 'Which sense organ helps us see?', 'Nose', 'Eyes', 'Ears', 'Tongue'),
(1, 3, 'Which animal can fly?', 'Dog', 'Cat', 'Bird', 'Fish'),
(1, 4, 'What day comes after Monday?', 'Friday', 'Tuesday', 'Sunday', 'Thursday'),
(1, 4, 'Which color is the sky on a clear day?', 'Green', 'Blue', 'Red', 'Yellow'),
(1, 4, 'How many legs does a human have?', '1', '2', '3', '4');

