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
		?>
		<tr>

			
			
			<td align="center">
			<a href='./index.php?buscar=<?php echo $hashtag['name']; ?>' >
				<?php echo $hashtag['name']; ?> 
			</a>
			<br>
			</td>
				
			
		</tr>
		<?php
			} //Final foreach
		?>
	</tbody>
</table>

<?php
		} //Final else
?>

</div>