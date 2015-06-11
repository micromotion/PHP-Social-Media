<?php
include 'functions.php';

if (!LOGGEDIN) {
	redirect('login.php');
}

$response = setProfileImage();
$image = showProfileImage($dbh);
$user = getUser($_SESSION['username'], $dbh);
extract($user); // Extract array vaules

include 'header.php';

echo "<p>$response</p>"; // Response to user when changing profile image

?>

<form class="form-horizontal" action="editprofile.php" method="post" enctype="multipart/form-data">
	<fieldset>
		<legend>Edit profile</legend>
		
		<div class="controls">
			<p><?php echo $image;?></p>
		</div>
		
		<div class="control-group">
			<label class="control-label" for="profileimage">Profile image</label>
			<div class="controls">
				<input type="file" id="profileimage" name="profileimage">
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label" for="username">Username</label>
			<div class="controls">
				<input type="text" id="username" name="username" readonly="readonly" value="<?php echo $username;?>">
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="Email">Email</label>
			<div class="controls">
				<input type="text" id="email" name="email" readonly="readonly" value="<?php echo $email;?>">
			</div>
		</div>	
		
		<div class="controls">
			<input type="submit" value="Save changes" class="btn btn-primary">
		</div>
	</fieldset>
</form>

<?php include 'footer.php';?>
