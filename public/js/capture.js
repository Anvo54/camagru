(function() {

	var width = 640;
	var height = 0;

	var streaming = false;

	var video = null;
	var camera = null;
	var canvas = null;
	var photo = null;
	var startbutton = null;
	var uploaderText = null;
	var treeSticker = null;
	var selected_image = null;

	function startup() {
		video = document.getElementById('video');
		camera = document.getElementById('camera');
		canvas = document.getElementById('canvas');
		selected_image = document.getElementById('selected_image');
		photo = document.getElementById('photo');
		startbutton = document.getElementById('startbutton');
		uploaderText = document.getElementById('uploader-text');
		treeSticker = document.getElementById('tree');

		treeSticker.addEventListener('click', event => {
			addSticker();
		})

	uploaderText.style.display = 'none';

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

	function addSticker() {
		var img = document.createElement('img');

		img.setAttribute('src', 'http://localhost:8080/camagru/public/img/tree.png');
		img.className = 'tree';
		camera.appendChild(img);
		img.style.left = width / 2 + 'px';
		img.style.top = height / 2 + 'px';
	}

	function takepicture() {
		var context = canvas.getContext('2d');
		if (width && height) {
			canvas.width = width;
			canvas.height = height;
			context.drawImage(video, 0, 0, width, height);

			var imgURL = canvas.toDataURL('image/png');
			var img = document.createElement('input');
			img.type = 'image';

			img.setAttribute('src', imgURL);
			img.addEventListener('click', event => {
				document.getElementById('base64').value = event.target.getAttribute('src');
			})
			/***TESTING BELOW. REMOVE!! */
			var formData = new FormData();

			formData.append("photo", img.getAttribute('src'));
	
			var ajatus = new XMLHttpRequest();
		
			ajatus.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					var newImg = document.createElement('input');
					newImg.type = 'image'
					newImg.src = this.response;
					newImg.addEventListener('click', event => {
						selected_image.value = event.target.getAttribute('src');
					})
					newImg.className = 'photo';
					photo.appendChild(newImg);
				}
			};
			ajatus.open("POST", 'test')
			ajatus.send(formData);

			uploaderText.style.display = 'block';
			}
				else
			{
				clearphoto();
			}
	}
	window.addEventListener('load', startup, false);
})();