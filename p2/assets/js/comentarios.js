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

//Esconde todos los subMenu cuando se ha añadido un comentario con ajax
$(document).ready(function(){

    $('#comment-section').on('DOMSubtreeModified', function() {
        $('.subMenu').hide();
    });
    
    $('.subMenu').hide();
});

//Comportamiento del boton de reportar
function openMenu(id_comment){
    $(document).ready(function(){

        if($('#subMenu'+id_comment).is(':hidden')){

            $('#subMenu'+id_comment).show();
        }
        else{
            $('#subMenu'+id_comment).hide();
        }
    
        $('#subMenu'+id_comment).click(function(){
            $('#subMenu'+id_comment).hide();
        });
    });
}