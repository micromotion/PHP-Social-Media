/*-------------------------------------------------------------------------- */
/* SQL statements for setting up correct database tables - call setup.php	*/
/*-------------------------------------------------------------------------- */

DROP TABLE IF EXISTS users;
CREATE TABLE users (
	username CHAR(30) NOT NULL PRIMARY KEY,
	password CHAR(40) NOT NULL,
	email CHAR(50) NOT NULL,
	timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS images;
CREATE TABLE images (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	title CHAR(30) NOT NULL,
	url CHAR (100) NOT NULL,
	description TEXT NOT NULL,
	username CHAR(30) NOT NULL,
	timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
