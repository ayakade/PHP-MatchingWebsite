var photo = document.getElementById("thePhoto");
var upload = document.getElementById("upload");

photo.addEventListener("click", function() {
	upload.click();
})

upload.addEventListener("change", function(event) {
	var file =event.target.files[0];
	var reader = new FileReader();

	// set the pic as background
	reader.onload = function(e) {
		photo.style.backgroundImage = 'url('+e.target.result+')';
	}

	reader.readAsDataURL(file);
}); // end of upload.addEventListener("change", function(event)

var ImagePath = photo.getAttribute("imgsrc");
console.log(ImagePath);
photo.style.backgroundImage = 'url('+ImagePath+')';