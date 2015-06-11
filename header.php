
<!doctype html>
<html>
<head>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="style.css">
	<title>PicHunt</title>
	<meta charset="utf-8">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>
	<script src="bootstrap/js/bootstrap.js"></script>
</head>
<body>
<div class="container-narrow">
	<div>
		<form class="navbar-form form-search pull-right" action="index.php" method="get">
			<div class="input-append">
  			<input type="text" name="term" class="input-small search-query" placeholder="Search..." required>
			<button type="submit" class="btn"><i class="icon-search icon-black"></i></button>
			</div>
		</form>	
		<ul class="nav nav-pills pull-right">
			<li id="index-link">
				<a href="index.php" class="btn btn-link"><i class="icon-home icon-black"></i><strong> Home</strong></a>
			</li>
			<?php 
			if (isset($_SESSION['username'])) { // If logged in
				$user = htmlspecialchars($_SESSION['username']);
			?>
				<li id="profile-link">
					<a href="profile.php?user=<?php echo $user;?>"><i class="icon-user icon-black"></i><?php echo "<strong> $user</strong>" ?> </a>
				</li>
				<li>
					<a href="logout.php"><i class="icon-off icon-black"></i> <strong> Log out</strong></a>
				</li>
			<?php } else { // If not logged in ?>
				<li id="signup-link">
					<a href="signup.php"><i class="icon-hand-right icon-black"></i><strong> Sign up</strong></a>
				</li>
				<li id="login-link">
					<a id="login" data-toggle="popover" class="btn btn-link"><i class="icon-star icon-black"></i><strong> Log in</strong> </a>
				</li>
			<?php } ?>	
		</ul>	
		<h3 class="muted">Pic Hunt</h3>
	</div>	
	<hr>	

	<div id="loginPopover" class="hide">
	    <form action="login.php" method="post">
	        <input type="text" name="username" placeholder="Username">
	        <input type="password" name="password" placeholder="Password">
	        <input type="hidden" name="page" value="<?= $_SERVER['REQUEST_URI'] ?>">
	        <label class="checkbox"><input type="checkbox">Remember me</label>
	        <button type="submit" class="btn btn-primary" name="login">Log in</button>
	    </form>
	</div>

<script>
	(function () { // Javascript for making correct list item 'active' in navbar
		var file = document.location.href.split('/');
		file = file[file.length - 1];
		file = file.split('.');
		file = file[0];
		var e = document.getElementById(file + '-link');
		e.className += ' active';
	}());

	$('#login').popover({ 
	    'html': true,
	    'title': 'Log in',
	    'content': $('#loginPopover').html(),
	    'placement': 'bottom'
	});
</script>
