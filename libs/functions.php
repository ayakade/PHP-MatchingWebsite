<?php
session_start();

// connect to db
function con() {
	return mysqli_connect("localhost", "root", "root", "zoodating");
}

// login
function login($email, $password) {
	$sql = "SELECT * FROM users WHERE strEmail='".$email."' AND strPassword='".$password."'";
	$results = mysqli_query(con(), $sql);

	$userFound = mysqli_fetch_assoc($results);

	if($userFound) {
		$_SESSION["userID"] = $userFound["id"]; // save the users id for sessions 
	}

	return $userFound; // returns something if found, false it not
}

// register
function register($email, $password) {
	// check if user alrealy exists with emaill
	if(!getUserByEmail($email))
	{
		// if does not exist add a new record
		$sql = "INSERT INTO users(strEmail, strPassword, strPhoto, strNickName, strLocation, strBio) VALUES ('".$email."', '".$password."', '', '', '', '')";
		$con = con(); // open only one connection 
		
		mysqli_query($con, $sql);

		// echo $sql;
		// print_r($sql);
		// addingdie(); 

		// after resgister get the new ID
		$lastID = mysqli_insert_id($con);
		echo "last ID: ".$lastID;
		// die;
		$_SESSION["userID"] = $lastID;

		return true;
	} else {
		// already user exists
		$_SESSION["userID"] = false;
		return false;
	}
}

// check all users email
function getUserByEmail($email) {
	$sql = "SELECT * FROM users WHERE strEmail='".$email."'";
	$results = mysqli_query(con(), $sql);

	$userFound = mysqli_fetch_assoc($results);

	return $userFound;
}

// update the profile
function updateProfile($strNickName, $strLocation, $strBio, $fileFieldName, $desiredLocations) {

	//upload photo 
	$profilePhotoName = $_FILES[$fileFieldName]["name"]; // photo name

	if (!$profilePhotoName)
	{
		// if no new pic to upload show the current one 
		$currentUser = getCurrentUser();
		$profilePhotoName = $currentUser["strPrimaryPhoto"];
	} else {
		// if there is a new pic add it
		move_uploaded_file($_FILES[$fileFieldName]["tmp_name"], "assets/".$_FILES[$fileFieldName]["name"]);
	}

	// update profile
	$sql = "UPDATE users 
			SET strNickName='".$strNickName."', strLocation='".$strLocation."', strBio='".$strBio."' WHERE id='".$_SESSION["userID"]."'";
	mysqli_query(con(), $sql);

	// update primaty photo
	// step 1 :delete primary photo if there is one
	$sql = "DELETE FROM userphotos 
			WHERE nUsersID='".$_SESSION["userID"]."' AND bPrimary='1'";
	mysqli_query(con(), $sql);

	// step 2 :insert new primary photo
	$sql = "INSERT INTO userphotos (nUsersID, strPhoto, bPrimary) 
			VALUES ('".$_SESSION["userID"]."', '".$profilePhotoName."', '1')";
	mysqli_query(con(), $sql);

	// update desired locations
	// step 1: remove all the desired locations for this user
	$sql = "DELETE FROM users_desired_locations 
			WHERE nUsersID='".$_SESSION["userID"]."'";
	mysqli_query(con(), $sql);

	// setp 2: insert new desired locations
	foreach($desiredLocations as $locationName)
	{
		$sql = "INSERT INTO users_desired_locations (nUsersID, strLocation) VALUES ('".$_SESSION["userID"]."', '".$locationName."')";
		mysqli_query(con(), $sql);
	}
}

// get user info 
function getCurrentUser() {
	// $sql = "SELECT users.*, userphotos.strPhoto AS strPrimaryPhoto
	// 		FROM users
	// 		LEFT JOIN userphotos ON userphotos.nUsersID = users.id
	// 		WHERE users.id = '".$_SESSION["userID"]."' AND userphotos.bPrimary = 1";

	$sql = "SELECT users.*,
			(SELECT strPhoto FROM userphotos WHERE nUsersID='".$_SESSION["userID"]."' AND bPrimary=1) AS strPrimaryPhoto
			FROM users
			LEFT JOIN userphotos ON userphotos.nUsersID=users.id
			WHERE users.id = '".$_SESSION["userID"]."'";

	// echo $sql;
	// die();

	$results = mysqli_query(con(), $sql);
	// get the first and only record if it exists 
	$userFound = mysqli_fetch_assoc($results);

	// if user doesn't exist 
	if(!$userFound) {
		header("location: index.php");
		die();
	}

	return $userFound;
}

// get animal list
function getAnimals() {

	// filter the location 
	$desired = getDesiredLocations();
	// set default (empty)
	$filterSQL = "";

	// if any desired location is checked 
	if ($desired){
		foreach($desired as $name =>$location)
		{
			$filterSQL .= " strLocation='".$name."' OR";
		}

		// https://www.php.net/manual/en/function.substr.php
		// https://www.php.net/manual/en/function.strlen.php
		$filterSQL = " AND (".substr($filterSQL, 0, strlen($filterSQL)-2).")";
	}

	// echo $filterSQL;
	// die();

	$sql = "SELECT 
					users.*, 
					userphotos.strPhoto AS strPrimaryPhoto, 
					RAND() AS sorter
			FROM users
			LEFT JOIN userphotos ON userphotos.nUsersID=users.id
			WHERE userphotos.bPrimary = 1
			AND users.id !='".$_SESSION["userID"]."' $filterSQL
			ORDER BY sorter
			LIMIT 0,1"; // remove the current user, filter location, show them randamly, show only one card

	// echo $sql;

	$results = mysqli_query(con(), $sql);

	return processData($results);
}

// location list 
function getLocations() {
	// get location list
	$sql = 'SELECT DISTINCT strLocation 
			FROM users 
			WHERE strLocation!="" ORDER BY strLocation';

	// return an array of possible locations
	$results = mysqli_query(con(), $sql);
	return processData($results);
}

// get specific animal info
function getAnimalById($id)
{
	$sql = "SELECT users.*, userphotos.strPhoto AS strPrimaryPhoto
			FROM users
			LEFT JOIN userphotos ON userphotos.nUsersID=users.id
			WHERE users.id='".$id."' AND userphotos.bPrimary = 1";

	$results = mysqli_query(con(), $sql);

	return processData($results);
}

function processData($results)
{
	//set default (empty)
	$array = false;

	while($data = mysqli_fetch_assoc($results))
	{
		$array[] = $data;
	}
	return $array;
}

// get all desired locations
function getDesiredLocations()
{
	// set the default(when no box is checked(empty))
	// $array= array();
	$array = false;

	$sql = "SELECT *
			FROM users_desired_locations
			WHERE nUsersID='".$_SESSION["userID"]."'";

	// when box is checked 
	$results = mysqli_query(con(), $sql);

	while($data = mysqli_fetch_assoc($results))
	{
		$array[$data["strLocation"]] = true;
	}

	// print_r($array);

	return $array;
}

// save the record who liked who
function saveVote($nUsersID)
{
	$sql = "INSERT INTO userlikes (nUsersID, nLikedUserID) 
			VALUES ('".$_SESSION["userID"]."', '".$nUsersID."')";
	$con = con();

	mysqli_query($con, $sql);
}

// check if it's a match
function checkMatch($nUsersID)
{
	$sql = "SELECT * 
			FROM userlikes 
			WHERE nUsersID='".$_SESSION["userID"]."' AND nLikedUserID='".$nUsersID."'";
	$results = mysqli_query(con(), $sql);

	// get the first and only record if it exists
	$ILikedSomeone = mysqli_fetch_assoc($results);

	$sql = "SELECT * 
			FROM userlikes 
			WHERE nUsersID='".$nUsersID."' AND nLikedUserID='".$_SESSION["userID"]."'";
	$results = mysqli_query(con(), $sql);

	// get the first and only record if it exists
	$theyLikedMe= mysqli_fetch_assoc($results);

	if ($ILikedSomeone AND $theyLikedMe)
	{
		// record this match in the match table
		$sql = "INSERT INTO usermatches (nUsersID, nWhoMatchedWithID) 
			VALUES ('".$_SESSION["userID"]."', '".$nUsersID."')";
		$results = mysqli_query(con(), $sql);

		$sql = "INSERT INTO usermatches (nWhoMatchedWithID, nUsersID) 
			VALUES ('".$_SESSION["userID"]."', '".$nUsersID."')";
		$results = mysqli_query(con(), $sql);
		
		return true;
	} else {
		return false;
	}
}

// get match list
function getMatches() {

	// https://www.w3schools.com/sql/sql_distinct.asp

	// $sql = "SELECT
	// 		um.id,
	// 		um.nUsersID,
	// 		um.nWhoMatchedWithID,
	// 		u.strNickName,
	// 		up.strPhoto
	// 		FROM usermatches AS um
	// 		LEFT JOIN users u ON u.id=um.nWhoMatchedWithID
	// 		LEFT JOIN userphotos up ON (up.nUsersID=um.nWhoMatchedWithID AND up.bPrimary=1)
	// 		WHERE um.nUsersID='".$_SESSION["userID"]."'
	// 		GROUP BY um.nWhoMatchedWithID";

	// $sql = "SELECT
	// 		um.id,
	// 		um.nUsersID,
	// 		DISTINCT um.nWhoMatchedWithID,
	// 		u.strNickName,
	// 		up.strPhoto
	// 		FROM usermatches AS um
	// 		LEFT JOIN users u ON u.id=um.nWhoMatchedWithID
	// 		LEFT JOIN userphotos up ON (up.nUsersID=um.nWhoMatchedWithID AND up.bPrimary=1)
	// 		WHERE um.nUsersID='".$_SESSION["userID"]."'";

	$sql = "SELECT
			um.id,
			um.nUsersID,
			um.nWhoMatchedWithID,
			u.strNickName,
			up.strPhoto
			FROM usermatches AS um
			LEFT JOIN users u ON u.id=um.nWhoMatchedWithID
			LEFT JOIN userphotos up ON (up.nUsersID=um.nWhoMatchedWithID AND up.bPrimary=1)
			WHERE um.nUsersID='".$_SESSION["userID"]."'";

	// echo $sql;

	$results = mysqli_query(con(), $sql);

	return processData($results);
}

// record message history
function saveMessage($msg, $toWhoID)
{
	$sql = "INSERT INTO messages (strMessage, nFromWhoID, nToWhomID) 
			VALUES ('".$msg."','".$_SESSION["userID"]."', '".$toWhoID."')";
	$results = mysqli_query(con(), $sql);
}

// get message history
function getMessages($withWhomID)
{
	$sql = "SELECT *
			FROM messages
			WHERE (nFromWhoID=".$_SESSION["userID"]." AND nToWhomID = $withWhomID)
			OR (nFromWhoID = $withWhomID AND nToWhomID = ".$_SESSION["userID"].")";

	$results = mysqli_query(con(), $sql);

	return processData($results);
}

?>