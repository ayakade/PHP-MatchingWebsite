<?php
	include("libs/functions.php");
	include("includes/header.php");
?>
<body>
	<div class="wrapper">

		<div class="content cv-align-contents">
			<div class="card" id="login">
				<div class="title">
					<h1>Login</h1>
				</div><!-- .title -->
				
				<form method="post" action="login.php">
					<div class="fieldgroup required">
						<label>Email</label>
						<input type="text" placeholder="enter your email" name="strEmail">
					</div><!-- .fieldgroup -->

					<div class="fieldgroup required">
						<label>Password</label>
						<input type="password" placeholder="enter your password" name="strPassword">
					</div><!-- .fieldgroup -->

					<div class="fieldgroup required">
						<input type="submit" value="Login" class="btn-primary">
					</div><!-- .fieldgroup -->
				</form>

				<p>Need an account? <strong><a href="register.php">Resister now</a></strong></p>

			</div><!-- .card -->
		</div><!-- .content -->
		
	</div><!-- .wrapper -->
</body>
</html>