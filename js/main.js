// show background image
function processImageBackground() {
	var images = document.querySelectorAll("[imgsrc]");
	for(var i=0; i<images.length; i++)
	{
		var whichElement = images[i];
		var imagePath = images[i].getAttribute("imgsrc");
		whichElement.style.backgroundImage = "url(assets/"+imagePath+")";
	}
} // end of function processImageBackground()

// run on the first load of the page
processImageBackground();

$(function(){
	// when click like 
	$(".likeBtn").on("click", function(){
		// step 1: send like to the server
		vote(1);
		// step 2: get new random animal
		getNewRandomAnimal();
	})

	// when click match message it desappears 
	$("#matchmessage").on("click", function(){
		$("#matchmessage").hide();
	})

	// when click dislike
	$(".noBtn").on("click", function(){
		// step 1:send dislike to the server
		vote(0);
		// step 2: get new random animal
		getNewRandomAnimal();
	})
}) //end of $(function()



// get animals by ramdom order
function getNewRandomAnimal(){
	$.ajax({
		url: "getAnimal.php",
		success: function(response){
			$(".theCard").html(response);
			// re-run the background code
			processImageBackground();
		},
		error: function(){
			console.log("oops something went wrong...");
		}
	}) // end of $.ajax
} // end of function getNewRandomAnimal()


// when it's a match show #matchmessage 
function vote(vote) {
	var whichID = $(".profileCard").data("id");
	$.ajax({
		url: "sendVote.php?like="+vote+"&nUsersID="+whichID,
		success: function(response){
			console.log(response);
			if(response ==1) // match
			{
				console.log("show message");
				document.getElementById("matchmessage").style.display = "block";
			}
		},
		error: function(){
			console.log("oops something went wrong...");
		}
	}) //  end of $.ajax
} //  end of function vote(vote)