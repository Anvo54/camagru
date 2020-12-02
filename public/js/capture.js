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
var chainSticker = null;
var capeSticker = null;
var faceMaskSticker = null;
var selected_image = null;
var droparea = null;
var selected_file = null;
var fileInput = null;


var reader = new FileReader

var tree = false;
var garden = false;
var star = false;
var chain = false;
var cape = false;
var facemask = false;
var streaming = false;
var cam = null;
var overlay = null;

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
chainSticker = document.getElementById('chain');
capeSticker = document.getElementById('cape');
faceMaskSticker = document.getElementById('facemask');
cam = document.getElementById('cam');
fileInput = document.createElement('input');


startbutton.disabled = true;
cam.disabled = true;
uploaderText.style.display = 'none';

fileInput.type = 'file';
fileInput.accept = 'image/png, image/jpeg';
fileInput.multiple = false;
temp_canvas.addEventListener('click', () => {
	fileInput.click();
})


fileInput.addEventListener("change", () => {
	var file = fileInput.files;
	if (file[0]) {
		reader.readAsDataURL(file[0]);
		reader.onloadend = () => {
			let img = document.createElement('img');
			img.src = reader.result;
			selected_file = img;
			cam.checked = false;
			canvas.setAttribute('width', width);
			canvas.setAttribute('height', height);
			temp_canvas.setAttribute('width', width);
			temp_canvas.setAttribute('height', height);
			startDisable()
			manipulateCanvas();
		}
	}
});

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
	context.fillStyle = "black";
	context.font = 15+"pt Courier ";
	context.fillText("Drag and drop Here", width / 3, height / 2);
	context.fillText("Or Click to browse files", width / 3, height / 1.5);
	startbutton.disabled = true;
}

const dropHandler = (event) => {
	event.preventDefault();
	if (event.dataTransfer.items) {
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

const startDisable = () => {
	if (cam.checked == false && selected_file)
		startbutton.disabled = false;
	else if (cam.checked == true && (star || garden || tree || chain || cape || facemask))
		startbutton.disabled = false;
	else
		startbutton.disabled = true;
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

capeSticker.addEventListener('click', () => {
	cape = (!cape) ? true : false;
	startDisable()
})

chainSticker.addEventListener('click', () => {
	chain = (!chain) ? true : false;
	startDisable()
})

faceMaskSticker.addEventListener('click', () => {
	facemask = (!facemask) ? true : false;
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
	overlay = true;
})

droparea.addEventListener('mouseout', event => {
	overlay = false;
})

navigator.mediaDevices.getUserMedia({video: true, audio: false})
	.then(function(stream) {
	video.srcObject = stream;
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
	cam.checked = true;
	cam.disabled = false;
	manipulateCanvas()
	}
}, false);

const manipulateCanvas = () => {
	var c_tmp = temp_canvas.getContext('2d')
	c_tmp.width = width;
	c_tmp.height = height;
	setInterval(() => {
		if (cam.checked){
			c_tmp.drawImage(video, 0,0, width, height)
		}
		else if (selected_file){
			startDisable()
			c_tmp.drawImage(selected_file,0,0,width, height);
		}
		else
			clearTempCanvas();
		if (tree)
			c_tmp.drawImage(treeSticker, width / 2, height / 2);
		if (garden)
			c_tmp.drawImage(gardenSticker, 0, 0);
		if (star)
			c_tmp.drawImage(starSticker, 80, 45);
		if (cape)
			c_tmp.drawImage(capeSticker, 0,0);
		if (chain)
			c_tmp.drawImage(chainSticker, 0,0);
		if (facemask)
			c_tmp.drawImage(faceMaskSticker, 0,0);
		if (overlay){
			c_tmp.globalAlpha = 0.7;
			c_tmp.fillStyle = 'rgba(238, 130, 238, 1)';
			c_tmp.fillRect(0,0, width, height);
			c_tmp.globalAlpha = 1;
			c_tmp.fillStyle = "black";
			c_tmp.font = 15+"pt Courier ";
			c_tmp.fillText("Drag and drop Here", width / 3, height / 2);
			c_tmp.fillText("Or Click to browse files", width / 3, height / 1.5);
		}
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
		formData.append("chain", chain);
		formData.append("cape", cape);
		formData.append("facemask", facemask);

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
		startDisable();
		uploaderText.style.display = 'block';
		} else {
			clearphoto();
		}
}

