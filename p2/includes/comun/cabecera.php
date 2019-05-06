<div class="cabecera">

	<div id="logo">
		<a href="index.php"><img src="assets/img/logoasteyonombre.png" /></a>
	</div>
	<div id="link">
		<?php
			if (isset($_SESSION["login"]) && ($_SESSION["login"]===true)) {
				echo "Bienvenido, " . $_SESSION['nombre'] . "." .
				"<a href='subirMeme.php' class='subirMeme'>"."\u{1F4E4}"."</a>
				<a href='perfil.php?userName=".$_SESSION['nombre']."' class='perfil'>Perfil</a>
				<a href='logout.php' class='salir'>Salir</a>";		
			} else {
				echo "<a href='login.php' class='login'>Iniciar sesión</a> 
				<a href='registro.php' class='registro'>Registrarse</a>";
			}
		?>
	</div>
</div>
