(function() {

	var width = 640;
	var height = 0;

	var streaming = false;

	var video = null;
	var camera = null;
	var canvas = null;
	var temp_canvas = null;
	var photo = null;
	var startbutton = null;
	var uploaderText = null;
	var treeSticker = null;
	var gardenSticker = null;
	var starSticker = null;
	var selected_image = null;

	var tree = false;
	var garden = false;
	var star = false;

	function startup() {
		video = document.getElementById('video');
		camera = document.getElementById('camera');
		canvas = document.getElementById('canvas');
		temp_canvas = document.getElementById('stickerCanvas')
		selected_image = document.getElementById('selected_image');
		photo = document.getElementById('photo');
		startbutton = document.getElementById('startbutton');
		uploaderText = document.getElementById('uploader-text');
		treeSticker = document.getElementById('tree');
		gardenSticker = document.getElementById('garden');
		starSticker = document.getElementById('star');

		treeSticker.addEventListener('click', event => {
			tree = (!tree) ? true : false;
		})

		gardenSticker.addEventListener('click', event => {
			garden = (!garden) ? true : false;
		})

		starSticker.addEventListener('click', event => {
			star = (!star) ? true : false;
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
		temp_canvas.setAttribute('width', width);
		temp_canvas.setAttribute('height', height);
		streaming = true;
		manipulateCanvas()
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

	function manipulateCanvas() {
		var c_tmp = temp_canvas.getContext('2d')
		c_tmp.width = width;
		c_tmp.height = height;
		setInterval(() => {
			c_tmp.drawImage(video, 0,0, width, height)
			if (tree)
				c_tmp.drawImage(treeSticker, width / 2, height / 2);
			if (garden)
				c_tmp.drawImage(gardenSticker, 0, 0);
			if (star)
				c_tmp.drawImage(starSticker, 80, 45);
		},16);
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
			var formData = new FormData();

			formData.append("photo", img.getAttribute('src'));
			formData.append("tree", tree);
			formData.append("garden", garden);
			formData.append("star", star);
			var oReq = new XMLHttpRequest();
		
			oReq.onreadystatechange = function() {
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
			oReq.open("POST", 'test')
			oReq.send(formData);

			uploaderText.style.display = 'block';
			}
				else
			{
				clearphoto();
			}
	}
	window.addEventListener('load', startup, false);
})();