function deleteMeme(id){
    var txt;
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
                    location.reload();
                }
                 
            }
        });

    } 
}