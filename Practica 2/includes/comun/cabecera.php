<div class="cabecera">

	<a href="index.php"><img src="img/logoasteyonombre.png" /></a>

	<div id="link">
		<?php
			if (isset($_SESSION["login"]) && ($_SESSION["login"]===true)) {
				echo "Bienvenido, " . $_SESSION['nombre'] . "." .
				"<a href='subirMeme.php' class='subirMeme'>Subir Meme</a>
				<a href='perfil.php' class='perfil'>Perfil</a>
				<a href='logout.php' class='salir'>Salir</a>";		
			} else {
				echo "<a href='login.php' class='login'>Iniciar sesión</a> 
				<a href='registro.php' class='registro'>Registrarse</a>";
			}
		?>
	</div>
</div>
