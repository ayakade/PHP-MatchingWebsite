var images = document.querySelectorAll("[imgsrc]");
for(var i=0; i<images.length; i++)
{
	var whichElement = images[i];
	var imagePath = images[i].getAttribute("imgsrc");
	whichElement.style.backgroundImage = "url(assets/"+imagePath+")";
}

