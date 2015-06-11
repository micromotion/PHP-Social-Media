<?php
include 'functions.php';
deleteImage($dbh);
include 'header.php';

if (!isset($_GET['user'])) {
	exit;
}

$user = getUser($_GET['user'], $dbh); // Get user of profile

if (!$user) { // The user doesn't exist
	echo 'User not found';
	exit;
}

extract($user);
$image = getProfileImage($username); // Get user profile image
if ($image) {
	$image = "<img src='profileimages/$image' width='300'>";
} else {
	$image = 'No image';
}
?>
<div class="user">
	<p><?php echo $image; ?></p>
	<p class="lead"><strong>Username: </strong><?php echo htmlspecialchars($username); ?></p>
	<p class="lead"><strong>Email: </strong><a href="mailto:<?php echo $email;?>"><?php echo htmlspecialchars($email);?></a></p>
	<p class="lead"><strong>Joined: </strong><?php echo date('j F Y',strtotime($timestamp)); ?></p>
	<?php if (LOGGEDIN && $_SESSION['username']===$username) { // If logged in user match with user of profile beeing watched ?>
		<a href="editprofile.php" class="btn">Edit profile</a>
	<?php } ?>
	<hr>
</div>
<p class="text-center lead text-info">My images</p>

<?php 
	foreach (getUserEntries($dbh, $username) as $entries) { // Get entries/images that the owner of the profile has posted
	extract($entries);
?>
	<hr>
	<div class="image-title">
		<p><?php echo $title;?><span id="pubDate"> Posted: <?php echo date('j F Y',strtotime($timestamp));?></span></p>
	</div>
	<div class="image">
		<img src="<?php echo $url;?>">
	</div>
	<div class="image-description">
		<p><?php echo $description;?></p>
	</div>
	<?php if (LOGGEDIN && $_SESSION['username']===$username) { // Delete-button for those logged in ?>	
		<form action="profile.php?user=<?php echo $username;?>" method="post">
			<input type="hidden" name="id" value="<?php echo $id;?>">
			<input class="btn btn-danger btn-small" type="submit" name="delete-image" value="Delete image">
		</form>
	<?php } ?>
<?php } ?>

<?php include 'footer.php'; ?>