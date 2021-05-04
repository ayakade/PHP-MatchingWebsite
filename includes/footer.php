<?php
$profileActive = (isset($profileActive)) ? $profileActive : "";
$listActive = (isset($listActive)) ? $listActive : "";
$matchesActive = (isset($matchesActive)) ? $matchesActive : "";
?>

<div class="footer">
	<a href="me.php" class="<?=$profileActive?>"><i class="far fa-user-circle"></i></i></a>
	<a href="animals.php" class="<?=$listActive?>"><i class="fas fa-paw"></i></a>
	<a href="matches.php" class="<?=$matchesActive?>"><i class="fas fa-comment-dots"></i></a>
</div><!-- .footer -->
