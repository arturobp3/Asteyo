<?php

//Inicio del procesamiento
require_once("includes/config.php");
require_once("includes/meme.php");

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
		
				echo "<tr>
						<td>
							<a href='./index.php?buscar=%23".$name."' >
								".$hashtag['name']."
							</a>
							<br>
						</td>
					</tr>";
	
			} //Final foreach
		?>
	</tbody>
</table>

<?php
		} //Final else
?>

</div>