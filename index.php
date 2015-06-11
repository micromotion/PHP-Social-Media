<?php
include 'functions.php';
insertImage($dbh);
deleteImage($dbh);
search($dbh);
include 'header.php';
?>
<?php if (LOGGEDIN) { // Create insert-image-form for those logged in ?>
	
  	<div id="header" class="hero-unit">
    <h1>Welcome!</h1>
		<form action="index.php" method="post">
			<label>Title</label>
			<input type="text" name="title" placeholder="Insert title.."> <i class="icon-hand-left"></i> <strong>Insert fitting title for your picture here.</strong>

			<label>URL</label>
			<input type="text" name="url" placeholder="Insert url"> <i class="icon-hand-left"></i> <strong>Insert url to your picture here.</strong>

			<label>Description</label>
			<textarea name="description" placeholder="Insert description"></textarea> <i class="icon-hand-left"></i> <strong>Say something appropriate here.</strong>

			<p><input class="btn btn-large btn-primary" type="submit" value="Post image" name="insert-image"></p>
		</form>
	</div>

<?php } else { // If not logged in ?>
	<div class="jumbotron">
		<h1>The Coolest pictures in one place!</h1>
		<p class="lead">Wanna have a look at the funniest, most awesome and most interresting pictures there is? Look no further, Pic Hunt got it all stored in one single place. Sign up today and share your pictures with the world.</p>
		<a class="btn btn-large btn-success" href="signup.php">Sign up today</a>
	</div>
<?php } ?>

<div class="row" id="images">
	<div class="span8">
		
		<?php if(!isset($_GET['term'])) { // If there has not been a search
			foreach (getImages($dbh) as $image) { // Get all image-entries
				extract($image);
		?>	
				<hr>
				<div class="image-title">
					<p><?php echo $title;?><small> by <a href="profile.php?user=<?php echo $username;?>"><?php echo $username;?></a></small>
					<span id="pubDate">Posted: <?php echo date('j F Y',strtotime($timestamp));?></span></p>
				</div>
				<div class="image">
					<img src="<?php echo $url;?>">
				</div>
				<div class="image-description">
					<p><?php echo $description;?></p>
				</div>

				<?php if (LOGGEDIN && $_SESSION['username']===$username) { // Delete-button for those logged in ?>	
					<form action="index.php" method="post">
						<input type="hidden" name="id" value="<?php echo $id;?>">
						<input class="btn btn-danger btn-small" type="submit" name="delete-image" value="Delete image">
					</form>
				<?php } ?>
			<?php } ?>
		<?php } 
		
		else if(isset($_GET['term']) && search($dbh) != false) { // If there has been a search and it returned true 

			foreach (search($dbh) as $result) { // Get all image-entries searched for
				extract($result);
		?>	
				<hr>
				<div class="image-title">
					<p><?php echo $title;?><small> by <a href="profile.php?user=<?php echo $username;?>"><?php echo $username;?></a></small></p>
				</div>
				<div class="image">
					<img src="<?php echo $url;?>">
				</div>
				<div class="image-description">
					<p><?php echo $description;?></p>
				</div>

				<?php if (LOGGEDIN && $_SESSION['username']===$username) { // Delete-button for those logged in ?>	
					<form action="index.php" method="post">
						<input type="hidden" name="id" value="<?php echo $id;?>">
						<input class="btn btn-danger btn-small" type="submit" name="delete-image" value="Delete image">
					</form>
				<?php } ?>
			<?php } ?>
		<?php } else { // The search returned false ?>
			<div class="alert alert-info">
				<h4>Sorry!</h4>
  				No title matched your search.
			</div> 
			<?php } ?>
	</div><!--End image span-->
</div><!--End image row-->

<script>
	$("#learn-more").popover()
</script>

<?php
include 'footer.php';
?>