$(document).ready(function(){

	var liked = 0;
	resetColor();

	/* behaviour when like button pressed */
	$('.like').on('click', function(){
		/* non-liked yet */
		if (liked == 0) {
			changeColor();
			liked = 1;
		}
		else { /* already liked */
			resetColor();
			liked = 0;
		}
	});

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

	/*----------------------------------------------------------------------------------------------------------------------*/

	/* function that save the like of a meme from a registered user */


	/* change the color of the like button when clicked */
	function changeColor(){

		$('.like').css('color', 'red');
	}

	/* reset the color of the like button to grey */
	function resetColor(){

		$('.like').css('color', 'grey');
	}
});