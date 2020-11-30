var width = 640;
var height = 480;

var video = null;
var canvas = null;
var temp_canvas = null;
var photo = null;
var startbutton = null;
var uploaderText = null;
var treeSticker = null;
var gardenSticker = null;
var starSticker = null;
var selected_image = null;
var droparea = null;
var selected_file = null;
var reader = new FileReader

var tree = false;
var garden = false;
var star = false;
var streaming = false;
var cam = null;

droparea = document.getElementById('stickerCanvas')
video = document.getElementById('video');
canvas = document.getElementById('canvas');
temp_canvas = document.getElementById('stickerCanvas')
selected_image = document.getElementById('selected_image');
photo = document.getElementById('photo');
startbutton = document.getElementById('startbutton');
uploaderText = document.getElementById('uploader-text');
treeSticker = document.getElementById('tree');
gardenSticker = document.getElementById('garden');
starSticker = document.getElementById('star');
cam = document.getElementById('cam');

startbutton.disabled = true;
uploaderText.style.display = 'none';

const clearphoto = () => {
	var context = canvas.getContext('2d');
	context.fillStyle = "#AAA";
	context.fillRect(0, 0, canvas.width, canvas.height);
	var data = canvas.toDataURL('image/png');
	photo.setAttribute('src', data);
}

const clearTempCanvas = () => {
	temp_canvas.setAttribute('width', width);
	temp_canvas.setAttribute('height', height);
	var context = temp_canvas.getContext('2d');
	context.fillStyle = "#AAA";
	context.fillRect(0, 0, temp_canvas.width, temp_canvas.height);
	startbutton.disabled = true;
}

const dropHandler = (event) => {
	console.log('File(s) dropped');
	event.preventDefault();
	if (event.dataTransfer.items) {
		// Use DataTransferItemList interface to access the file(s)
		if (event.dataTransfer.items[0].kind === 'file') {
		  var file = event.dataTransfer.items[0].getAsFile();
		  if (file.type.match('^image/')) {
			  reader.readAsDataURL(file);
			  reader.onloadend = function() {
				let img = document.createElement('img');
				img.src = reader.result;
				selected_file = img;
				cam.checked = false;
				canvas.setAttribute('width', width);
				canvas.setAttribute('height', height);
				temp_canvas.setAttribute('width', width);
				temp_canvas.setAttribute('height', height);
				manipulateCanvas();
			  }
		  }
		}
	}
}

const startDisable = () =>{
	if (!star && !garden && !tree)
		startbutton.disabled = true;
	else
		startbutton.disabled = false;
}

startbutton.addEventListener('click', (ev) => {
	takepicture();
	ev.preventDefault();
}, false);

const dragOverHandler = (event) => {
	// ADD CSS HERE TO DRAG AND DROP INFO!!!!
	event.preventDefault()
}

treeSticker.addEventListener('click', () => {
	tree = (!tree) ? true : false;
	startDisable()
})

gardenSticker.addEventListener('click', () => {
	garden = (!garden) ? true : false;
	startDisable()
})

starSticker.addEventListener('click', () => {
	star = (!star) ? true : false;
	startDisable()
})

cam.addEventListener('change', event => {
	if (event.target.checked) {
		startDisable()
		cam.checked = true;
	} else{
		startDisable()
		cam.checked = false;
	}
})

droparea.addEventListener('mouseover', event => {
	console.log(event);
})


navigator.mediaDevices.getUserMedia({video: true, audio: false})
	.then(function(stream) {
	video.srcObject = stream;
	cam.checked = true;
	video.play();
	})
	.catch(function(err) {
		cam.checked = false;
		cam.disabled = true;
		manipulateCanvas();
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

const manipulateCanvas = () => {
	var c_tmp = temp_canvas.getContext('2d')
	c_tmp.width = width;
	c_tmp.height = height;
	setInterval(() => {
		if (selected_file){
			startDisable()
			c_tmp.drawImage(selected_file,0,0,width, height);
		}
		else if (cam.checked)
			c_tmp.drawImage(video, 0,0, width, height)
		else
			clearTempCanvas();
		if (tree)
			c_tmp.drawImage(treeSticker, width / 2, height / 2);
		if (garden)
			c_tmp.drawImage(gardenSticker, 0, 0);
		if (star)
			c_tmp.drawImage(starSticker, 80, 45);
		
	},16);
}

const takepicture = () => {
	var context = canvas.getContext('2d');
	if (width && height) {
		canvas.width = width;
		canvas.height = height;
		if (cam.checked)
			context.drawImage(video, 0, 0, width, height);
		else
			context.drawImage(selected_file, 0,0, width, height);
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
		oReq.open("POST", 'add_temp_photo')
		oReq.send(formData);
		selected_file = null;
		clearTempCanvas();
		uploaderText.style.display = 'block';
		} else {
			clearphoto();
		}
}

