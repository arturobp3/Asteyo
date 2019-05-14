<?php

//Inicio del procesamiento
require_once("includes/config.php");
require_once("includes/Meme.php");

?>

<div class="sidebarIzq">
	<form id="buscador" name="buscador" method="get" action="./index.php"> 
    	<input id="buscar" name="buscar" type="search" placeholder="Introduzca un hashtag..." autofocus >
	</form>

<?php
	$result = Meme::rankHashtag();

	if($result === false){
		echo "<h1 class='mensaje'> ¡No se han encontrado hashtags! </h1>";
	}
	else{
?>

<table>
	<thead>
		<tr>
			<th>HASHTAGS MÁS POPULARES</th>
		</tr>
	</thead>

	<tbody>
		<?php
			foreach ($result as $hashtag){
				//Elimina el hashtag para utilizarlo en la url, ya que no lo pilla bien
				$name = $hashtag['name'];
				$name = substr($name,1);
				$num_likes = $hashtag['n_mg'];
				echo 
				"<tr>
					<td>
						<div id='info-hashtag'>
							<a href='./index.php?buscar=%23$name'>#$name</a>
							<div id='num_likes'>
								<span>\u{2764}</span>
								<p>$num_likes</p>
							</div>
						</div>
					</td>
				</tr>"
				;
	
			} //Final foreach
		?>
	</tbody>
</table>

<?php
		} //Final else
?>

</div>