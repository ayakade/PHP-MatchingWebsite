<?php
include("libs/functions.php");

$status = login($_POST["strEmail"], $_POST["strPassword"]);
// echo $status;

// if login success
if($status)
{
	header("location: animals.php");
} else {
	header("location: index.php?=error=1");
}
?>