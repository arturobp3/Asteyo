$(document).ready(function(){

	var liked = 0;
	resetColor();

	$('.like').on('click', function(){

		if (liked == 0) {
			changeColor();
			liked = 1;
		}
		else {
			resetColor();
			liked = 0;
		}
	});

	$('.like').mouseover(function(){

		changeColor();
	});

	$('.like').mouseleave(function(){

		if (liked == 1) {
			changeColor();
		}
		else resetColor();
	});

	/*----------------------------------------------------------------------------------------------------------------------*/

	/* change the color of the like button when clicked */
	function changeColor(){

		$('.like').css('color', 'red');
	}

	/* reset the color of the like button to grey */
	function resetColor(){

		$('.like').css('color', 'grey');
	}
});