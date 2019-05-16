 function sendToServer(canvas) {
    var data = canvas.toDataURL('image/png');
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
      // request complete
      if (xhr.readyState == 4) {
        //window.open('http://www.lostiemposcambian.com/blog/posts/guardando-pngs-html5/snapshots/'+xhr.responseText,'_blank');
      }
    }
    xhr.open('POST','../../includes/snapshot.php',true);
    xhr.setRequestHeader('Content-Type', 'application/upload');
    xhr.send(data);
  }

  document.getElementById('btnSubir').addEventListener('click', function() {
    sendToServer('canvas');
    },
    false);