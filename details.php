<?php
include("libs/functions.php");
include("includes/header.php");

$currentUser = getCurrentUser();
// echo $_GET["profileId"];
?>

	<div class="wrapper">
		
		<div class="content top-align-contents lists">
			<?php

			$animals = getAnimalById($_GET["profileId"]);

			foreach($animals as $animal)
			{
			?>
			<div class="profileCard">
				
					<div class="image" imgsrc="<?=$animal["strPrimaryPhoto"]?>">
					</div>

					<div class="details">
						<h1><?=$animal["strNickName"]?></h1>
						<span class="region"><?=$animal["strLocation"]?></span>
						<h2>Introduction</h2>
						<p><?=$animal["strBio"]?></p>
					</div><!-- .details -->

					<div class="actions">
						<a href="#" class="btn-primary">Message</a>
						<a href="#" class="btn-neg">Block</a>
					</div><!-- .actions -->
				
			</div><!-- .profileCard -->
			<?php
			}
			?>
		</div><!-- .content -->

	</div><!-- .wrapper -->

<?php
$listActive = "active";
include("includes/footer.php");
?>

<script type="text/javascript" src="js/details.js"></script>

</body>
</html>