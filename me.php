<?php
include("libs/functions.php");
include("includes/header.php");

// print_r($_SESSION);
// $currentUser = getCurrentUser();
?>
<body>
	<div class="wrapper">
		<?php

		$currentUser['strPrimaryPhoto'] = "";
		$currentUser['strNickName'] = "";
		$currentUser['strLocation'] = "";
		$currentUser['strBio'] = "";

		if(isset($_SESSION["userID"]))
		{
			$currentUser = getCurrentUser();
			// print_r($currentUser);
		}
		?>
		
		<div class="content cv-align-contents">
			<div class="card" id="edit">
				<div class="editProfilePhoto">
					<div id="thePhoto" imgsrc="assets/<?=$currentUser['strPrimaryPhoto']?>"></div><!-- end of the photo -->
				</div><!-- .editProfilePhoto -->
				
				<div class="title">
					<h1>Edit Profile</h1>
					<p>Complete your profile</p>
				</div><!-- .title -->
				
				<form method="post" action="update.php" enctype="multipart/form-data">
					<div class="fieldgroup">
						<label>Nick name</label>
						<input type="text" name="strNickName" placeholder="What name should users see" value="<?=$currentUser['strNickName']?>" />
					</div><!-- .fieldgroup-->

					<!-- <div class="fieldgroup">
						<label>What kind of animal</label>
						<select name="animals">
							<option>Select your type</option>
							<?php
							$sql = "SELECT * FROM animals ORDER BY name";
							$results = mysqli_query(con(), $sql);
							while($animals = mysqli_fetch_assoc($results)) {
								$selected = ($item['colors_id'] == $animals['id'])? "SELECTED": "";
							?>
							<option value="<?=$canimals["id"]?>" <?=$selected?> ><?=$animals["name"]?></option>
							<?php
							}
							?>
						</select>
					</div> --><!-- .fieldgroup -->

					<!-- <div class="fieldgroup">
						<label>What is your gender</label>
						<select name="gender">
							<option>Select your gender</option>
							<?php
							$sql = "SELECT * FROM genders";
							$results = mysqli_query(con(), $sql);
							while($gender = mysqli_fetch_assoc($results)) {
								$selected = ($item['colors_id'] == $gender['id'])? "SELECTED": "";
							?>
							<option value="<?=$gender["id"]?>" <?=$selected?> ><?=$gender["name"]?></option>
							<?php
							}
							?>
						</select>
					</div> --><!-- .fieldgroup -->

					<div class="fieldgroup">
						<label>Where are you located</label>
						<input type="text" name="strLocation" placeholder="Zoo Region" value="<?=$currentUser['strLocation']?>"/>
					</div><!--.fieldgroup-->

					<div class="fieldgroup">
						<label>Tell us about you</label>
						<textarea name="strBio"><?=$currentUser['strBio']?></textarea>
					</div><!-- .fieldgroup-->

					<div class="fieldgroup">
						<label>Where should your matches live?</label>
						<div class="checkList">
							<?php
							$locationOptions = getLocations();
							$myDesiredLocations = getDesiredLocations();

							//echo $myDesiredLocations["West Side"];
							//echo $myDesiredLocations["BLAH"];

							foreach($locationOptions as $location)
							{
							$checked = (isset($myDesiredLocations[$location["strLocation"]])) ? "checked" : "";
							?>
							<div class="checkBox">
								<input type="checkbox" name="desiredLocations[]" value="<?=$location["strLocation"]?>" <?=$checked?> > 
								<span><?=$location["strLocation"]?></span>
							</div><!-- .checkbox -->
							<?php
							}
							?>
						</div><!-- .checklist -->
					</div><!-- .fieldgroup -->

					<input type="file" name="strProfilePhoto" id="upload">

					<div class="fieldgroup">
						<input type="submit" value="Save Profile" class="btn-primary">
					</div><!-- .fieldgroup-->
				</form>
			</div><!-- .card -->
		</div><!-- .content -->

		<?php
		$profileActive = "active";
		include("includes/footer.php");
		?>
	</div><!-- .wrapper -->


<script type="text/javascript" src="js/profileImage.js"></script>

</body>
</html>