<?php
session_start();

include 'config.php';

$dbh = new PDO('mysql:host='.DB_HOST.';'.'dbname='.DB_DATABASE, DB_USERNAME, DB_PASSWORD); // Database connection, see config.php

function htmlFilter(&$a) {
	foreach ($a as $k => $v) {
		$a[$k] = htmlentities($v);
	}
}
/* Redirect script */
function redirect($file) { 
	header("Location: $file");
}
/* Function for title-search */
function search($dbh) {
	if(!isset($_GET['term'])) {
		return;
	}

	$term = $_GET['term'];
	$query = $dbh->prepare("SELECT * FROM images WHERE title LIKE :term");
	$query->execute(array(':term' => '%'.$term.'%')); // Select all rows containing the pattern
	$result = array();
	while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
		array_push($result, $row);
	}
	if(empty($result)) { // No title matched pattern
		return false;
	}
	return $result;
}

/*-------------------------------------------------------------------------- */
/* FUNCTIONS REGARDING HANDLING OF USER CREATED DATA						*/
/*-------------------------------------------------------------------------- */


function insertImage($dbh) {
	if (!LOGGEDIN) {
		return;
	}
	if (!isset($_POST['insert-image'])) {
		return;
	}
	
	$title = $_POST['title'];
	$desc = $_POST['description'];
	$url = $_POST['url'];
	$username = $_SESSION['username'];

	$query = $dbh->prepare("INSERT INTO images (title, url, description, username) VALUES (:title, :url, :description, :username)");
		
	$query->bindParam(':title', $title);
	$query->bindParam(':url', $url);
	$query->bindParam(':description', $desc);
	$query->bindParam(':username', $username);
	$query->execute();
}

function getImages($dbh){
	$query = $dbh->prepare("SELECT * FROM images ORDER BY id DESC");
	$query->execute();
	$images = array();
	while ($row = $query->fetch(PDO::FETCH_ASSOC)) { // Fetch all rows from query 
		htmlfilter($row);
		array_push($images, $row); // Insert rows in array
	}
	return $images;
}

function getUserEntries($dbh, $username){
	$query = $dbh->prepare("SELECT * FROM images WHERE username=:user ORDER BY id DESC");
	$query->execute(array(':user' => $username));
	$entries = array();
	while ($row = $query->fetch(PDO::FETCH_ASSOC)) { 
		htmlfilter($row);
		array_push($entries, $row); 
	}
	return $entries;
}

function deleteImage($dbh) {
	if (!isset($_POST['delete-image'])) {
		return;
	}
	$id = $_POST['id'];
	$query = $dbh->prepare("DELETE FROM images WHERE id=:id");
	$query->execute(array(':id' => $id));
}


/*-------------------------------------------------------------------------- */
/* FUNCTIONS REGARDING HANDLING OF USER INFORMATION 							*/
/*-------------------------------------------------------------------------- */


function insertUser($dbh){
	if (!isset($_POST['username'])) {
		return;
	}
	$password = sha1($_POST['password']); // Hashing of password (sha1 = weak but some protecion)
	$username = $_POST['username'];
	$email = $_POST['email'];

	$query = $dbh->prepare("INSERT INTO users (username, password, email) "
	       . "VALUES (:username, :password, :email)");
	
	$query->bindParam(':username', $username);
	$query->bindParam(':password', $password);
	$query->bindParam(':email', $email);
	$query->execute();

	$error = $query->errorInfo();
	if ($error[0] === '23000') { // errorInfo returns Array ( [0] => 23000 ) when there is a dublicate primary key
		return $error;
	}
	$_SESSION['username'] = $username; // Log in user
	redirect('index.php');
}

function login($dbh) {
	if (!isset($_POST['username'])) {
		return;
	}
	$password = sha1($_POST['password']);
	$username = $_POST['username'];

	$query = $dbh->prepare("SELECT * FROM users WHERE username=:username AND password=:password");

	$query->bindParam(':username', $username);
	$query->bindParam(':password', $password);
	$query->execute();

	$rows = $query->fetch(PDO::FETCH_NUM); // Check affected rows

	if (!$rows) { // No such user
		return 'error';
	}
	$_SESSION['username'] = $_POST['username']; // Log in user
	redirect('index.php');
}

function getUser($username, $dbh) {
	$query = $dbh->prepare("SELECT * FROM users WHERE username=:username");
	$query->bindParam(':username', $username);
	$query->execute();
	return $result = $query->fetch();
}


/*-------------------------------------------------------------------------- */
/* FUNCTIONS REGARDING USERPROFILE IMAGES									*/
/*-------------------------------------------------------------------------- */


function getProfileImage($username) {
	$fh = opendir('profileimages'); // Open directory
	while ($file = readdir($fh)) { // Read files in directory
		$name = explode('.', $file)[0]; // Get name of file without extension
		if ($name === $username) { // Check if it matches with user
			return $file;
		}
	}
	return '';
}

function setProfileImage() {
	if (!isset($_FILES['profileimage'])) {
		return;
	}
	
	$file = $_FILES['profileimage'];
	if ($file['error'] > 0) { // Error check
		return 'Error occured, make sure you have a file selected.';
	}
	
	if (!preg_match("/\w+\.(png|jpeg|jpg|gif)$/", $file['name'])) { // Check file format
		return 'Incorrect file format: Only png, jpeg, jpg and gif is allowed.';
	} else {
		$extension = explode('.', $file['name'])[1]; // Get fileformat/extension
	}
	if (!move_uploaded_file($file['tmp_name'], "profileimages/$_SESSION[username].$extension")) { // Store file and name it after user with correct fileformat
		return 'File could not be moved.';
	} else {
		return 'File is successfully uploaded';
	}
}

function showProfileImage($dbh) {
	$user = getUser($_SESSION['username'], $dbh); // Get row from logged in user
	extract($user);
	$image = getProfileImage($username);
	if ($image) {
		$image = "<img src='profileimages/$image' width='200'>";
		return $image;
	} else {
		$image = 'No image';
		return $image;
	}
}