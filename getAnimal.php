<?php
include("libs/functions.php");
include("includes/header.php");

$currentUser = getCurrentUser();

$animals = getAnimals();
foreach($animals as $animal){
?>
<div class="profileCard" data-id="<?=$animal["id"]?>">
	<a href="details.php?profileId=<?=$animal["id"]?>" class="profile-link">
		<div class="image" imgsrc="<?=$animal["strPrimaryPhoto"]?>"></div>

		<div class="details">
			<h1><?=$animal["strNickName"]?></h1>
			<span class="region"><?=$animal["strLocation"]?></span>
		</div><!-- .details -->
	</a>
</div><!-- .profileCard -->

<?php
}
?>