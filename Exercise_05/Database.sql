CREATE DATABASE IF NOT EXISTS book_db;
CREATE TABLE book(
	book_id VARCHAR(3) NOT NULL,
	title VARCHAR(100) NOT NULL,
	price INT(9) NOT NULL,
	publisher VARCHAR(100),
	year_published VARCHAR(4),
	image_of_book TEXT);
INSERT INTO book VALUES ('001', 'Introduction to Statistics', '56', '', '', '');
INSERT INTO book VALUES ('002', 'Big Java', '102', '', '', '');
INSERT INTO book VALUES ('019', 'ASP.NET', '89', '', '', '');
INSERT INTO book VALUES ('134', 'Programming to WWW', '125', '', '', '');
INSERT INTO book VALUES ('139', 'Information Systems', '76', '', '', '');
INSERT INTO book VALUES ('200', 'Calculus', '74', '', '', '');
INSERT INTO book VALUES ('267', 'Quantitative Analysis for Management', '84', '', '', '');