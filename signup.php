<?php
include 'functions.php';
$error = insertUser($dbh);

include 'header.php';
?>
<div class="alert alert-success">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<h4>Sign up!</h4>
	Sign up to get hold of the newest news!
</div>
<div class="row">
	<div class="span2">
		<form class="form-horizontal" action="signup.php" method="post">
			<fieldset>
				<legend>Sign up</legend>

				<div class="control-group">
					<label class="control-label" for="username">Username</label>
					<div class="controls">
						<input type="text" id="username" name="username" placeholder="Username" required>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="password">Password</label>
					<div class="controls">
						<input type="password" id="password" name="password" placeholder="Password" required>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="email">Email</label>
					<div class="controls">
						<input type="text" id="email" name="email" placeholder="Email" required>
					</div>
				</div>

				<div class="control-group">
					<div class="controls">
						<button type="submit" class="btn btn-success">Sign up</button>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div><!--End Signup row-->

<?php
if ($error) {
?>	
	<div class="alert alert-error">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<h4>Error!</h4>
		That user already exists.
	</div>
<?php } ?> 

<?php include 'footer.php'; ?>