function reportarComentario(autorComentario, id_comment, cause){
    $(document).ready(function(){

        if(cause === 1) causa = "Spam";
        else causa = "Ofensivo";

        $.ajax({
            data: { "id_comment" : id_comment,
                    "cause" : causa,
                    "autorComentario" : autorComentario,
                    "accion": "reportar"
            },
            url:'./includes/comments.php',
            type:'post',
            dataType:'JSON', //Esto esta relacionado con el tipo de dato que devuelve el servidor
            success: function(response){
    
                //Se puede hacer un if de esta manera porque el servidor devuelve un JSON
                if(response.error == ''){
                    $('#mensaje').html("Comentario reportado con éxito.");
                }
                else{
                    $('#mensaje').html(response.error);
                }
            }
        });

    });
}

function reportarUsuario(usr_reported, cause){
    $(document).ready(function(){

        if(cause === 1) causa = "Foto de perfil ofensiva";
        else if(cause === 2) causa = "Nombre inapropiado";
        else causa = "Bot";

        $.ajax({
            data: { 
                "usr_reported" : usr_reported,
                "cause" : cause,
                "accion" : "usuario"
            },
            url:'./includes/reports.php',
            type:'post',
            dataType:'JSON', //Esto esta relacionado con el tipo de dato que devuelve el servidor
            success: function(response){
    
                //Se puede hacer un if de esta manera porque el servidor devuelve un JSON
                if(response.error == ''){
                    $('#mensajeReport').html("Usuario reportado con éxito.");
                }
                else{
                    $('#mensajeReport').html(response.error);
                }
            }
        });

    });
}


function reportarMeme(username_meme, id_meme, cause){

    $(document).ready(function(){

        if(cause === 1) causa = "Spam";
        else causa = "Ofensivo";

        $.ajax({
            data: { 
                "id_meme" : id_meme,
                "cause" : causa,
                "usr_reported" : username_meme,
                "accion" : "meme"
            },
            url:'./includes/reports.php',
            type:'post',
            dataType:'JSON', //Esto esta relacionado con el tipo de dato que devuelve el servidor
            success: function(response){
    
                //Se puede hacer un if de esta manera porque el servidor devuelve un JSON
                if(response.error == ''){
                    $('#mensajeReport').html("Meme reportado con éxito.");
                }
                else{
                    $('#meme-data #mensajeReport').html(response.error);
                }
            }
        });

    });
}

$(document).ready(function(){

    $('.botones #menuReportUser').hide();
    
});


//Comportamiento del boton de reportar. Recibe el id del elemento a esconder y mostrar
function openMenuReport(id){
    $(document).ready(function(){


        console.log($(id).is(':hidden'));

        if($(id).is(':hidden')){

            $(id).show();
        }
        else{
            $(id).hide();
        }
    
        $(id).click(function(){
            $(id).hide();
        });
    });
}