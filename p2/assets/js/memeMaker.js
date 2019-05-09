var canvas = document.getElementById("canvas");
var textArriba;
var textAbajo;
function GenerarMeme(){
			textArriba=document.getElementById("txtTextoArriba").value;
			textAbajo=document.getElementById("txtTextoAbajo").value;
			var ctx = canvas.getContext("2d");
			var img = new Image();
				img.onload = function(){
				canvas.width = img.width * 1;
				canvas.height = img.height * 1;
                ctx.drawImage(img, 0, 0,canvas.width ,canvas.height);
				
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
				ctx.strokeText(textArriba, x, 30);
				ctx.fillText(textArriba, x, 30);
	};
	 img.src = document.getElementById("image").src; 
};


document.getElementById("fileMeme").onchange = function () {
    var reader = new FileReader();
    reader.onload = function (e) {
    document.getElementById("image").src = RedimensionarImagen(e.target.result, 568,335);
	            
	
         GenerarMeme();
	
    };reader.readAsDataURL(this.files[0]);
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