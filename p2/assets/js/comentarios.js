//AJAX para los comentarios:

function añadirComentario(id, num_comments){

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
     
                    $('#mensaje').html("Comentario añadido correctamente");
                    $('#meme-data #num_comments').html(num_comments += 1);
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
     
                    $('#meme-data #num_comments').html(num_comments -= 1);
                    $('#'+id_comment).append(response.html);
                }
                else{
                    $('#mensaje').html(response.error);
                }
            }
        });

    });
}



function reportarComentario(id_comment){

}