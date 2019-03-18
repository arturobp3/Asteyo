<div id="cabecera">

	<div class="logo">

		<!-- Imagen del logo con enlace a index.php -->

	</div> 

	<div class="headerMenu">
		<?php
			if (isset($_SESSION["login"]) && ($_SESSION["login"]===true)) {
				echo "Bienvenido, " . $_SESSION['nombre'] .
				". <a href='perfil.php' class='perfil'>Perfil</a>
				<a href='logout.php' class='salir'>Salir</a>";
				
			} else {
				//Poner class para los enlaces?? y enlazarlo con CSS
				echo "<a href='login.php' class='login'>Login</a> 
				<a href='registro.php' class='registro'>Registro</a>";
			}
		?>
	</div>
</div>
