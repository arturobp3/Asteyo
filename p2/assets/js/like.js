var liked = 0;

$(document).ready(function(){

	resetColor();

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

/* function that save the like of a meme from a registered user */
function likeAMeme(nameUser, idMeme){
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
				if (response) {
					liked = 1;
					changeColor();
					var numL = $('#meme-data #num-likes').html;
					$('#meme-data #num-likes').html(parseInt(numL) + 1);
				}
				else{
					$('.like').css('color', 'green');
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
				liked = 0;
				resetColor();
			}
		});
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