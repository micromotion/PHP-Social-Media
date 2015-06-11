<?php
include 'config.php';

/*-------------------------------------------------------------------------- */
/* Run this script to setup database tables corresponding to this assingment */
/*-------------------------------------------------------------------------- */

try {
$dbh = new PDO('mysql:host='.DB_HOST.';'.'dbname='.DB_DATABASE, DB_USERNAME, DB_PASSWORD);

// Get database setup from sql-file
$query = file_get_contents('setup.sql');

$dbh->exec($query); // Execute multi-query

}catch(PDOException $e) {
	echo $e->getMessage();
	exit;
}
echo 'Database setup successful';
