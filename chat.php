<?php
include("libs/functions.php");
include("includes/header.php");

// print_r($_SESSION);
$currentUser = getCurrentUser();
// print_r($currentUser);
$chattingWith = getAnimalById($_GET["nUsersID"])[0];
// print_r($chattingWith);
$arrMessages = getMessages($_GET["nUsersID"]);
// print_r($arrMessages);
?>
<body>
	<div class="wrapper">
		
		<div class="content top-align-contents lists" id="messageList">
			<div class="title">
				<h1>Chat with <?=$chattingWith["strNickName"]?></h1>
			</div><!-- .title -->
			
			<?php
			// if there's message show them
			if ($arrMessages) {
				foreach ($arrMessages as $message) 
				{
					$fromMe = ($message["nFromWhoID"] == $_SESSION["userID"])? "fromMe" : "";
			?>
			<div class="message <?=$fromMe?>">
				<?=$message["strMessage"]?>
			</div><!-- .message -->
			<?php
				}
			} else {
				// if there's no message 
				echo "<p>Send them a message and<br> get to know each other!</p>";
			}
			?>

			<form id="messageForm" method="post" action="saveMessage.php">
				<input type="hidden" name="nUsersID" value="<?=$_GET["nUsersID"]?>">
				<textarea name="message"></textarea>
				<input type="submit" value="send">
			</form>
			
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