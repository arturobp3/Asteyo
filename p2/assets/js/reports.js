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

function reportarUsuario(user, id_comment, cause){
    
}


function reportarMeme(username_meme, id_meme, cause){

    $(document).ready(function(){

        if(cause === 1) causa = "Spam";
        else causa = "Ofensivo";

        $.ajax({
            data: { 
                "id_meme" : id_meme,
                "cause" : causa,
                "username_meme" : username_meme,
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
                    $('#mensajeReport').html(response.error);
                }
            }
        });

    });
}

//Comportamiento del boton de reportar
function openMenuReport(id){
    $(document).ready(function(){

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