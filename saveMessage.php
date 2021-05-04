<?php
include("libs/functions.php");

saveMessage($_POST["message"], $_POST["nUsersID"]);

header("location: chat.php?nUsersID=".$_POST["nUsersID"]);

?>