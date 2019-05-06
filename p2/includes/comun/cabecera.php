<div class="cabecera">

	<div id="logo">
		<a href="index.php"><img src="assets/img/logoasteyonombre.png" /></a>
	</div>
	<div id="link">
		<?php
			if (isset($_SESSION["login"]) && ($_SESSION["login"]===true)) {


				$botones = "Bienvenido, " . $_SESSION['nombre'] . ".";
				

				if(isset($_SESSION["esAdmin"]) && $_SESSION["esAdmin"] ===true){
					$botones .= "<a href='admin.php' class='subirMeme'><span style='font-size:24px;color:green;'>"."\u{1F511}"."</span></a>";
				}
				else if(isset($_SESSION["esModerador"]) && $_SESSION["esModerador"] ===true){
					$botones .= "<a href='subirMeme.php' class='subirMeme'>"."\u{1F4E4}"."</a>";
					//Boton para moderar los reports, memes y tomar acciones
				}
				else{
					$botones.= "<a href='subirMeme.php' class='subirMeme'>"."\u{1F4E4}"."</a>";
				}

				$botones .= "<a href='perfil.php?userName=".$_SESSION['nombre']."' class='perfil'>Perfil</a>
				<a href='logout.php' class='salir'>Salir</a>";	


			} else {

				$botones =  "<a href='login.php' class='login'>Iniciar sesión</a> 
				<a href='registro.php' class='registro'>Registrarse</a>";
			}

			echo $botones;
		?>
	</div>
</div>
