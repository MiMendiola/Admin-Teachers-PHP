CREATE DATABASE IF NOT EXISTS VC_DB;

CREATE USER 'vc_user'@'localhost' IDENTIFIED BY 'admin3210';
GRANT CREATE, SELECT, INSERT, UPDATE, DELETE ON VC_DB . * TO 'vc_user'@'localhost';
FLUSH PRIVILEGES;

USE VC_DB;

CREATE TABLE user_types(
	type_id int AUTO_INCREMENT NOT NULL,
    type_name varchar(50) NOT NULL,
    
    PRIMARY KEY (type_id)
);

INSERT INTO user_types (type_name) VALUES("student");
INSERT INTO user_types (type_name) VALUES("admin");
INSERT INTO user_types (type_name) VALUES("teacher");

CREATE TABLE IF NOT EXISTS users(
    user_id int AUTO_INCREMENT NOT NULL,
    name varchar(100) NOT NULL,
    last_name varchar(100) NOT NULL,
    passport varchar(10) NOT NULL,
    email varchar(150) NOT NULL,
    pass varchar(255) NOT NULL,
    normal_ip varchar(15),
    hash varchar(255) NOT NULL,
    photo varchar(100) DEFAULT './assets/img/default.png',
    user_type_id int(10) DEFAULT 1,
    first_time datetime	 NOT NULL DEFAULT 0,
    
    PRIMARY KEY (user_id),
    FOREIGN KEY (user_type_id) REFERENCES user_types(type_id)

);

CREATE TABLE IF NOT EXISTS info_users(
	id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
    user_id int(10) UNSIGNED NOT NULL,
    last_session datetime NOT NULL,
    user_ip varchar(15) NOT NULL,
    
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users (user_id)
);

/*PASS - test123*/
INSERT INTO users (name, last_name,	passport, email, pass, hash, user_type_id, first_time) VALUES ("Jose Luis", "Calleja Garcia", "PAK925019", "test@test.com", "cc03e747a6afbbcbf8be7668acfebee5", "f14abd86c6bbab6d8642ec9cfec7d71daf46", 2, 1);

CREATE TABLE IF NOT EXISTS tests(
	test_id int NOT NULL AUTO_INCREMENT,
    name varchar(100) NOT NULL,
    description text NOT NULL,
    questions int DEFAULT NULL,
    date_open datetime DEFAULT "0000-00-00 00:00:00",
    time int(100) NOT NULL,
    
    PRIMARY KEY (test_id)
);

CREATE TABLE IF NOT EXISTS questions(
	question_id int NOT NULL AUTO_INCREMENT,
    question_text text NOT NULL,
    test_id int NOT NULL,
    
    FOREIGN KEY (test_id) REFERENCES tests (test_id),
    PRIMARY KEY (question_id)
);

CREATE TABLE IF NOT EXISTS answers(
	answer_id int NOT NULL AUTO_INCREMENT,
    answer_text text NOT NULL,
    answer_value boolean,
    question_id int NOT NULL,
    
    FOREIGN KEY (question_id) REFERENCES questions (question_id),
    PRIMARY KEY (answer_id)
);


CREATE TABLE IF NOT EXISTS courses(
	course_id int NOT NULL AUTO_INCREMENT,
    course_name varchar(100) NOT NULL,
    course_description text NOT NULL,
    hash varchar(100) NOT NULL,
    course_folder varchar(255), 
    course_img varchar(100) DEFAULT './assets/img/coursesImg/default.png',
    user_create int NOT NULL,
    date_create datetime NOT NULL,
    open tinyint DEFAULT 0,
       
    PRIMARY KEY (course_id),
    FOREIGN KEY(user_create) REFERENCES users(user_id)
);


CREATE TABLE IF NOT EXISTS user_course(
	relation_id int NOT NULL AUTO_INCREMENT,
    user_id int NOT NULL,
    course_id int NOT NULL,
    
    PRIMARY KEY (relation_id),
	FOREIGN KEY (user_id) REFERENCES users (user_id),
    FOREIGN KEY (course_id) REFERENCES courses(course_id)
);


CREATE TABLE IF NOT EXISTS course_test(
	relation_id INT NOT NULL AUTO_INCREMENT,
    test_id INT NOT NULL,
    course_id INT NOT NULL,
    
    PRIMARY KEY (relation_id),
    FOREIGN KEY (test_id) REFERENCES tests (test_id),
    FOREIGN KEY (course_id) REFERENCES courses (course_id)
);

CREATE TABLE IF NOT EXISTS user_test (
	relation_id int NOT NULL AUTO_INCREMENT,
    user_id int NOT NULL,
    test_id int NOT NULL,
    date_start datetime,
    date_end datetime,
    score float(5,2), 
    
    PRIMARY KEY (relation_id),
    FOREIGN KEY (user_id) REFERENCES users (user_id),
    FOREIGN KEY (test_id) REFERENCES tests (test_id)
);

CREATE TABLE IF NOT EXISTS messages(
	msg_id INT AUTO_INCREMENT NOT NULL,
    msg_text text NOT NULL,
    subject varchar(255),
    user_send int NOT NULL,
    date datetime NOT NULL,
    
    PRIMARY KEY (msg_id)
);

CREATE TABLE IF NOT EXISTS user_msg (
	relation_id INT NOT NULL AUTO_INCREMENT,
    message_id INT NOT NULL,
    user_id int NOT NULL,
    view tinyint DEFAULT 0,
    
    PRIMARY KEY (relation_id),
    FOREIGN KEY (message_id) REFERENCES messages(msg_id),
    FOREIGN KEY (user_id) REFERENCES users (user_id)
);

CREATE TABLE IF NOT EXISTS events (
    id int NOT NULL AUTO_INCREMENT,
    title varchar(100) NOT NULL,
    color varchar(100),
    start_event datetime NOT NULL,
    end_event datetime NOT NULL,
    all_day tinyint DEFAULT 0,
    user_id int NOT NULL,

    PRIMARY KEY(id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

INSERT INTO messages (msg_text, subject, user_send, date) VALUES("Welcome new Admin! This is Virtual Community 1. I hope that you enjoy it. You must not forget that this is a beta and if you discover a new bug report it to the IT department. Thank you. IT Team.", "FIRST STEP", 1, "2022-05-14 07:55:58");
INSERT INTO user_msg (message_id, user_id, view) VALUES(1,1,0);


