<?php
include("libs/functions.php");

// session_start(); // session stars the momemt finish registration 

// true = new user and registration success, false = user already exsists
$status = register($_POST["strEmail"], $_POST["strPassword"]);

if($status)
{
	// header("location: success.php");
	header("location: me.php");
} else {
	header("location: register.php?=error=1");
}

?>