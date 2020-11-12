(function() {

  
	var width = 640;
	var height = 0;

	var streaming = false;

	var video = null;
	var canvas = null;
	var photo = null;
	var startbutton = null;
	var savebutton = null;

	function startup() {
	  video = document.getElementById('video');
	  canvas = document.getElementById('canvas');
	  photo = document.getElementById('photo');
	  startbutton = document.getElementById('startbutton');
	  savebutton = document.getElementById('saveButton');

	  photo.style.display = 'none';
	  savebutton.disabled = true;
  
	  navigator.mediaDevices.getUserMedia({video: true, audio: false})
	  .then(function(stream) {
		video.srcObject = stream;
		video.play();
	  })
	  .catch(function(err) {
		console.log("An error occurred: " + err);
	  });
  
	  video.addEventListener('canplay', function(ev){
		if (!streaming) {
		  height = video.videoHeight / (video.videoWidth/width);

		  if (isNaN(height)) {
			height = width / (4/3);
		  }
		  video.setAttribute('width', width);
		  video.setAttribute('height', height);
		  canvas.setAttribute('width', width);
		  canvas.setAttribute('height', height);
		  streaming = true;
		}
	  }, false);

  
	  startbutton.addEventListener('click', function(ev){
		takepicture();
		ev.preventDefault();
	  }, false);
	  clearphoto();
	}
  
	function clearphoto() {
	  var context = canvas.getContext('2d');
	  context.fillStyle = "#AAA";
	  context.fillRect(0, 0, canvas.width, canvas.height);
  
	  var data = canvas.toDataURL('image/png');
	  photo.setAttribute('src', data);
	}
	
	function takepicture() {
	  var context = canvas.getContext('2d');
	  if (width && height) {
		canvas.width = width;
		canvas.height = height;
		context.drawImage(video, 0, 0, width, height);
	  
		var data = canvas.toDataURL('image/png');
		photo.setAttribute('src', data);

		if (video.style.display === 'none'){
			video.style.display = 'block';
		} else 
			video.style.display = 'none';
		if (photo.style.display === 'none') {
			photo.style.display = 'block';
			startbutton.className = 'btn btn-lg btn-danger';
			startbutton.value = 'Retake';
			savebutton.disabled = false;
			savebutton.className = 'btn btn-lg btn-success';
			document.getElementById('base64').value = data;
		} else {
			photo.style.display = 'none';
			savebutton.className = 'btn btn-lg';
			savebutton.disabled = true;
			startbutton.value = 'Take photo';
			startbutton.className = 'btn btn-lg btn-success';
		}
	} else {
		clearphoto();
	}
	}


	window.addEventListener('load', startup, false);
  })();