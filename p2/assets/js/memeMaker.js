var canvas = document.getElementById("canvas");
var textArriba;
var textAbajo;
function GenerarMeme(){
			textArriba=document.getElementById("txtTextoArriba").value;
			textAbajo=document.getElementById("txtTextoAbajo").value;
			var ctx = canvas.getContext("2d");
			var img = new Image();
				img.onload = function(){
        
        
				canvas.width = 568;
        canvas.height = 335;
        var scale = Math.min(canvas.width / img.width, canvas.height / img.height);
        var x = (canvas.width / 2) - (img.width / 2) * scale;
        var y = (canvas.height / 2) - (img.height / 2) * scale;
                ctx.drawImage(img, x, y,img.width*scale ,img.height*scale);
				
                // Datos texto Meme (font)
				ctx.lineWidth  = 5;
				ctx.font = '20pt impact';
				ctx.strokeStyle = 'black';
				ctx.fillStyle = 'white';
				ctx.textAlign = 'center';
				ctx.lineJoin = 'round';
			
				textAbajo = textAbajo.toUpperCase(); 
				x = canvas.width/2;
				y = canvas.height - canvas.height/7.4;
				
				ctx.strokeText(textAbajo, x, y);
				ctx.fillText(textAbajo, x, y);
			
				textArriba = textArriba.toUpperCase();
				ctx.strokeText(textArriba, x, 40);
				ctx.fillText(textArriba, x, 40);
	};
	 img.src = document.getElementById("image").src; 
};


document.getElementById("fileMeme").onchange = function () {
    var reader = new FileReader();
    var input = event.target;
   
    reader.onload = function () {

      var dataURL = reader.result;
      var output = document.getElementById('image');
      output.src = dataURL;

      //output.src = RedimensionarImagen(dataURL, 568,335);
	      
	
         GenerarMeme();
	
    };reader.readAsDataURL(input.files[0]);
    
};


function RedimensionarImagen(base64, maxWidth, maxHeight) {
  if(typeof(maxWidth) === 'undefined') var maxWidth = 500;
  if(typeof(maxHeight) === 'undefined') var maxHeight = 500;
  var canvas = document.createElement("canvas");
  var ctx = canvas.getContext("2d");
  var copiaCanvas = document.createElement("canvas");
  var copyContext = copiaCanvas.getContext("2d");
  var ImgenTemporal = new Image();
  ImgenTemporal.src = base64;
  var ratio = 1;
  if(ImgenTemporal.width > maxWidth)
    ratio = maxWidth / ImgenTemporal.width;
  else if(ImgenTemporal.height > maxHeight)
    ratio = maxHeight / ImgenTemporal.height;
  copiaCanvas.width = ImgenTemporal.width;
  copiaCanvas.height = ImgenTemporal.height;
  copyContext.drawImage(ImgenTemporal, 0, 0);
  canvas.width = ImgenTemporal.width * ratio;
  canvas.height = ImgenTemporal.height * ratio;
  ctx.drawImage(copiaCanvas, 0, 0, copiaCanvas.width, copiaCanvas.height, 0, 0, canvas.width, canvas.height);
  return canvas.toDataURL();
}
 GenerarMeme();

var imagen=document.getElementsByClassName("imgthumbnail");
for(i=0;i<imagen.length;i++){
	imagen[i].onclick = function() { document.getElementById("image").src=this.src;GenerarMeme(); };
}