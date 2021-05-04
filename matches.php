<?php
include("libs/functions.php");
include("includes/header.php");

// print_r($_SESSION);
$currentUser = getCurrentUser();
// print_r($currentUser);
?>
<body>
	<div class="wrapper">
		
		<div class="content top-align-contents lists" id="matchList">
			<div class="title">
				<h1>Match List</h1>
				<p>Talk and get to know each other!</p>
			</div>
			
			<?php
			$arrMatches = getMatches();

			// print_r($arrMatches);

			// loop over matches
			foreach($arrMatches as $userMatched) 
			{
			?>
			<div class="match">
				<a href="chat.php?nUsersID=<?=$userMatched["nWhoMatchedWithID"]?>">
					<div class="matchIcon" imgsrc="<?=$userMatched["strPhoto"]?>"></div>
					<h2><?=$userMatched["strNickName"]?></h2>
				</a>
			</div>
			<?php
			}
			?>
			
		</div><!-- .content -->

		<?php
		$matchesActive = "active";
		include("includes/footer.php");
		?>

	</div><!-- .wrapper -->

	

<script src="http://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

<script type="text/javascript" src="js/main.js"></script>

</body>
</html>