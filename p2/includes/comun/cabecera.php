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
					$botones .= "<a href='addMeme.php' class='subirMeme'>"."\u{1F4E4}"."</a>";
					//Boton para moderar los reports, memes y tomar acciones
					$botones .= "<a href='moderador.php' class='subirMeme'> \u{26A0} </a>"; //alternativa {2049} "?!"
					$botones.= "<ul class='nav'>";
					$botones.= "	<li><a href=''>Ranking</a>
										<ul>
											<li><a href='ranking.php?tipo=masMg'>Top10 publicaciones</a></li>
											<li><a href='ranking.php?tipo=masSeg'>Mas seguidores</a></li>
										</ul>
									</li>
								</ul>";
				}
				else{
					
					$botones.= "<a href='addMeme.php' class='subirMeme'>"."\u{1F4E4}"."</a>";
					$botones.= "<ul class='nav'>";
					$botones.= "	<li><a href=''>Ranking</a>
										<ul>
											<li><a href='ranking.php?tipo=masMg'>Top10 publicaciones</a></li>
											<li><a href='ranking.php?tipo=masSeg'>Top5 usuarios</a></li>
										</ul>
									</li>
								</ul>";

					

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
