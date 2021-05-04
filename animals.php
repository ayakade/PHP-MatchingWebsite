<?php
include("libs/functions.php");
include("includes/header.php");

// print_r($_SESSION);
$currentUser = getCurrentUser();
// print_r($currentUser);
?>
<body>
	<div class="wrapper">
		<div id="matchmessage">
			<h1>You Matched!</h1>
			<img src="https://i.pinimg.com/originals/39/6d/8c/396d8cf19235b7b437d1067045a63b5a.gif">
		</div><!-- #message -->
		
		<div class="content top-align-contents lists" id="animalList">
			<div class="theCard">
				<?php
				$animals = getAnimals();
				foreach($animals as $animal){
				?>
				<div class="profileCard">
					<a href="details.php?profileId=<?=$animal["id"]?>" class="profileLink">
					<div class="image" imgsrc="<?=$animal["strPrimaryPhoto"]?>"></div>
					<div class="details">
						<h1><?=$animal["strNickName"]?></h1>
						<span class="region"><?=$animal["strLocation"]?></span>
					</div><!-- .details -->
				</div><!-- .profileCard -->
				<?php
				}
				?>
			</div><!-- .theCard -->

			<div class="matchBtn">
				<a href="#" class="likeBtn"><i class="fas fa-heart"></i></a>
				<a href="#" class="noBtn"><i class="fas fa-times"></i></a>
			</div><!-- .matchBtn -->
			
		</div><!-- .content -->

		<?php
		$listActive = "active";
		include("includes/footer.php");
		?>
	</div><!-- .wrapper -->

	

<script src="http://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

<script type="text/javascript" src="js/main.js"></script>

</body>
</html>