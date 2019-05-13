<?php

//Inicio del procesamiento
require_once("includes/config.php");
require_once("includes/Meme.php");
require_once("includes/usuario.php");

?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="assets/css/general.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/meme.css" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script src="./assets/js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="./assets/js/comentarios.js"></script>
    <script type="text/javascript" src="./assets/js/like.js"></script>
    <script type="text/javascript" src="./assets/js/reports.js"></script>
	<title>Meme | Asteyo</title>
</head>

<body>

<div class="contenedor">

	<?php require("includes/comun/cabecera.php"); ?>

	<div class="principal">
		<?php require("includes/comun/sidebarIzq.php");?>

		<div class="contenido-meme">
		<?php

            if(isset($_GET['userName']) && isset($_GET['id'])){

                $userName = $_GET['userName'];
                $usuario = Usuario::buscaUsuario($userName);
                $uID = $usuario->id();
                $uName = $usuario->username();
                $id_meme = $_GET['id'];
                $url = 'uploads/'.$usuario->id().'/'.$id_meme.'.jpg';

                if (file_exists($url)) {
                    //Obtiene la información relevante del meme para mostrarla.
                    $info_meme = Meme::getMeme($id_meme);
                    $title = $info_meme->titulo();
                    $num_likes = $info_meme->num_megustas();
                    $date = $info_meme->fechaSubida();
                    $comments = $info_meme->comentarios();
                    $num_comments = sizeof($comments);
                    
                    $html ="
                    <div id='container-meme'>
                    <img id='img-meme' src='$url'/>
                    </div>
                    <div id='info'>
                        <img id='user-profile-picture' src='./uploads/$uID/fotoPerfil.jpg'/>
                        <div id='meme-info'>
                            <p id='title'>$title</p>
                            <p> by <a href='perfil.php?userName=$uName'>$uName</a></p>
                        </div>
                    </div>
                    <div id='meme-data'>
                        <p>
                            <label id='num_likes'>$num_likes</label> ";
                            
                    if (isset($_SESSION['login']) && $_SESSION['esUser']) {
                    	$html .= "<button type='button' onclick='likeAMeme($id_meme)' class='like' name='like' style='color:grey;'>\u{2764}</button>";
                    }
                    else{
                    	$html .= "<span style='color:red;'>\u{2764}</span>";
                    }

                    $html .= "
                            <label id='num_comments'>$num_comments</label> <span>\u{1F4AC}</span> 
                        </p>
                        <p>Fecha de subida: $date</p>";

                    if(isset($_SESSION['login']) && ($_SESSION['esUser'] || $_SESSION['esModerador'])){
                        $html .= "<a onclick='openMenuReport(\"#menuReportMeme\")' id='reportMeme'>Reportar meme</a>
                        <div class='botones'>
                            <ul class='subMenu' id='menuReportMeme'>
                                <li><a onclick='reportarMeme(\"{$uName}\",
                                    $id_meme, 1)'>Spam</a>
                                </li>
                                <li><a onclick='reportarMeme(\"{$uName}\",
                                    $id_meme, 2)'>Ofensivo</a>
                                </li>
                            </ul>
                        </div>";
                    }

                    $html .= "<p id='mensajeReport'></p>
                    </div>
                    <h3>COMENTARIOS</h3>"; //He puesto label en num_comments para poder incrementarlo con ajax
                                            //Cuando se introduzca un nuevo comentario

                    //Solo si está logueado y es usuario podrá dejar un comentario
                    if(isset($_SESSION['login']) && $_SESSION['esUser']){
                       $html .=" 
                        <form method='post' id='commentForm'>
                            <textarea name='comment' id='comment' rows='2'></textarea>
                            <button type='button' onclick='añadirComentario($id_meme)'
                                name='submit id='submit'> Comentar </button>
                        </form>
                        <p id='mensaje'></p>";
                    }

                    //Zona de los comentarios
                    $html .= "<div id='comment-section'>";
           
                    for($i = 0; $i < sizeof($comments); $i++){
                        $id_comment = $comments[$i]['id_comment'];

                        $html .= "<div class='cajaComentario' id='$id_comment'>
                                    <p id='user'>".$comments[$i]['autor']."</p>
                                    <p id='fecha'>".$comments[$i]['fecha']."</p>
                                    <p id='comentario'>".$comments[$i]['texto']."</p>
                                    
                                    <div class='botones'>
                                    ";

                                    //Si es moderador puede eliminar un comentario
                                    if(isset($_SESSION['login']) && $_SESSION['esModerador']){
                                        $html .= "
                                        <a onclick='borrarComentario($id_comment)'>Eliminar</a>";
                                    }
                                    //Si es usuario puede reportarlo
                                    if(isset($_SESSION['login']) && ($_SESSION['esUser'] || $_SESSION['esModerador'])){

                                        $autorComentario = $comments[$i]['autor'];
                                        $html .= "
                                            <a onclick='openMenu($id_comment)' id='reportar'>Reportar</a>
                                            <ul class='subMenu'id='subMenu$id_comment'>
                                                <li><a onclick='reportarComentario(\"{$autorComentario}\",
                                                        $id_comment, 1)'>Spam</a>
                                                </li>
                                                <li><a onclick='reportarComentario(\"{$autorComentario}\",
                                                        $id_comment, 2)'>Ofensivo</a>
                                                </li>
										    </ul>";
                                    }
                            
                        $html .="
                                </div>
                            </div>";
                    }

            


                    $html .= "</div>";

                    echo $html;
                } 
                else {
                    echo "<h1 class='mensaje'> ¡No se ha encontrado el meme! </h1>";
                }
            }
            else{
                echo "<h1 class='mensaje'> ¡No se ha encontrado el meme! </h1>";
            }

		
        ?>	
		</div>

	</div>

	<?php require("includes/comun/pie.php"); ?>

</div>

</body>
</html>