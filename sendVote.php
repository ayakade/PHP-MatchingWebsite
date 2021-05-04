<?php
include("libs/functions.php");

$currentUser = getCurrentUser();
if ($_GET["like"]==1)
{
	saveVote($_GET["nUsersID"]);
	$match = checkMatch($_GET["nUsersID"]); // return true if there is a match
	if ($match)
	{
		echo 1; // match
	}
}
?>