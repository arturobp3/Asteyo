var disable = 0;
function deleteMeme(id){
 if (disable == 0) {
        disable = 1;
        var r = confirm("¿Seguro que quiere borrar su meme?");
        if (r == true) {
            $.ajax({
                url:'./includes/memeActions.php',
                type:'post',
                dataType: 'JSON',
                data: {
                    "idMeme": id,
                    "accion": "delete"
                },
                success: function(response){
                    if (response.success == true) {
                        window.location.href = window.location.href;
                        disable = 0;
                    }
                     else{
                        disable = 0;
                     }
                }
                 
            });
        }

    } 
}