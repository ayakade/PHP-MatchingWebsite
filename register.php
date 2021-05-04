<?php
	include("libs/functions.php");
	include("includes/header.php");
?>
<body>
	<div class="wrapper">

		<div class="content cv-align-contents">
			<div class="card" id="register">
				<div class="title">
					<h1>Register</h1>
					<p>Complete the form today and find your puuurfect match!</p>
				</div><!-- .title -->
				
				<form method="post" action="processRegister.php">
					<div class="fieldgroup required">
						<label>Email</label>
						<input type="text" placeholder="enter your email" name="strEmail" />
					</div><!-- .fieldgroup -->

					<div class="fieldgroup required">
						<label>Password</label>
						<input type="password" placeholder="enter your password" name="strPassword" />
					</div><!-- .fieldgroup -->

					<div class="fieldgroup required">
						<input type="submit" value="Register" class="btn-primary" />
					</div><!-- .fieldgroup -->
				</form>

				<p>Have an account now? <a href="index.php"><strong>Login Now</strong></a></p>

			</div><!-- .card -->
		</div><!-- .content -->
		
	</div><!-- .wrapper -->
</body>
</html>