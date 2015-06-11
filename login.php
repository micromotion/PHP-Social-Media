<?php
include 'functions.php';
$error = login($dbh);

include 'header.php';
?>

<?php
if ($error) {
?>
	<div class="alert alert-error">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<h4>Error!</h4>
		<strong>Could not log in. Username or password was incorrect. Please check your spelling and try again.</strong>
	</div>
<?php } ?>

<div class="row">
	<div class="span4">
		<form class="form-horizontal" action="login.php" method="post">
			<fieldset>
				<legend>Log in</legend>
				
				<div class="control-group">
					<label class="control-label" for="username">Username</label>
					<div class="controls">
						<input type="text" id="username" name="username" placeholder="Insert username..">
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="password">Password</label>
					<div class="controls">
						<input type="text" id="password" name="password" placeholder="Insert password..">
					</div>
				</div>
				
				<div class="control-group">
					<div class="controls">
						<button type="submit" class="btn btn-primary">Log in</button>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div><!--End Login row-->

<?php
include "footer.php";
?>