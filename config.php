<?php
/* Define your database credantials */
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');
define('DB_DATABASE', 'pichunt');

/* Define logged in for cleaner code */
if (isset($_SESSION['username'])) {
	define('LOGGEDIN', true);
} else {
	define('LOGGEDIN', false);
}
?>
