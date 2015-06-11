<?php
include 'functions.php';

session_destroy(); // log out user
redirect('index.php');
?>