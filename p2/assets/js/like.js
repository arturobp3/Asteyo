var liked = 0;
var disable = 0;

$(document).ready(function(){

	resetColor();

	/* check if the user has liked the meme */
	var urlParams = new URLSearchParams(window.location.search);
	var memeId = urlParams.get('id');
	likedMeme(memeId);

	/* when hovering over the button */
	$('.like').mouseover(function(){

		changeColor();
	});

	/* when leaving the button */
	$('.like').mouseleave(function(){

		if (liked == 1) {
			changeColor();
		}
		else resetColor();
	});

})

/* function that check if the user has already liked a meme */
function likedMeme(idMeme){
	$.ajax({
		url:'./includes/likes.php',
		type:'post',
		dataType: 'JSON',
		data: {
			"idMeme": idMeme,
			"accion": "search"
		},
		success: function(response){
			if (response.success == true) {
				liked = 1;
				changeColor();
			}
			else{
				liked = 0;
				resetColor();
			}
		}
	});
}

/* function that save the like of a meme from a registered user */
function likeAMeme(idMeme){
	if (disable == 0) {
		disable = 1;
		if (liked == 0) {
			$.ajax({
				url:'./includes/likes.php',
				type:'post',
				dataType: 'JSON',
				data: {
					"idMeme": idMeme,
					"accion": "add"
				},
				success: function(response){
					if (response.success == true) {
						liked = 1;
						changeColor();
						var numL = $('#meme-data #num_likes').html();
						$('#meme-data #num_likes').html(parseInt(numL) + 1);
						disable = 0;
					}
					else{
						disable = 0;
					}
				}
			});
		}
		else if (liked == 1) {
			$.ajax({
				url:'./includes/likes.php',
				type:'post',
				dataType: 'JSON',
				data: {
					"idMeme": idMeme,
					"accion": "remove"
				},
				success: function(response){
					if (response.success == true) {
						liked = 0;
						resetColor();
						var numL = $('#meme-data #num_likes').html();
						$('#meme-data #num_likes').html(parseInt(numL) - 1);
						disable = 0;
					}
					else{
						disable = 0;
					}
				}
			});
		}
	}
}

/* change the color of the like button when clicked */
function changeColor(){
	$('.like').css('color', 'red');
}

/* reset the color of the like button to grey */
function resetColor(){
	$('.like').css('color', 'grey');
}