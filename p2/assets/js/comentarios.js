//AJAX para los comentarios:

function añadirComentario(id){

    $(document).ready(function(){

        $.ajax({
            data: { "comentario": $('#comment').val(), 
                    "id_meme" : id,
                    "accion": "añadir"
            },
            url:'./includes/comments.php',
            type:'post',
            dataType:'JSON', //Esto esta relacionado con el tipo de dato que devuelve el servidor
            success: function(response){
    
                //Se puede hacer un if de esta manera porque el servidor devuelve un JSON
                if(response.error == ''){

                    var numC =  $('#meme-data #num_comments').html();

     
                    $('#mensaje').html("Comentario añadido correctamente");
                    $('#meme-data #num_comments').html(parseInt(numC) + 1);
                    $('#comment').val("");
                    $('#comment-section').append(response.html);
                }
                else{
                    $('#mensaje').html(response.error);
                }
            }
        });

    });
}


function borrarComentario(id_comment){
    $(document).ready(function(){

        $.ajax({
            data: { "id_comment" : id_comment,
                    "accion": "borrar"
            },
            url:'./includes/comments.php',
            type:'post',
            dataType:'JSON', //Esto esta relacionado con el tipo de dato que devuelve el servidor
            success: function(response){
    
                //Se puede hacer un if de esta manera porque el servidor devuelve un JSON
                if(response.error == ''){

                    var numC =  $('#meme-data #num_comments').html();
     
                    $('#meme-data #num_comments').html(parseInt(numC) - 1);
                    $('#'+id_comment).remove();
                }
                else{
                    $('#mensaje').html(response.error);
                }
            }
        });

    });
}



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

//Comportamiento del boton de reportar
$(document).ready(function(){

    //Esconder y mostrar submenu
    $('#subMenu').hide();
    $('#reportar').on('click', function(){

        if($('#subMenu').is(':hidden')){

            $('#subMenu').show();
        }
        else{
            $('#subMenu').hide();
        }
    });
    
    $('#subMenu').click(function(){
        $('#subMenu').hide();
    });



});