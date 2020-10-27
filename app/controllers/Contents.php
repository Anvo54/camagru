<?php
	class Contents extends Controller {
		public function __construct() {
			$this->galleryModel = $this->model('Gallery');
		}
		public function index()
		{
			$images = $this->galleryModel->getImages();

			$data = [
				'images' => $images
			];
			$this->view('contents/index', $data);
		}

		public function add()
		{
			if (isLoggedIn()){
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
	
					$data = [
						'image_title' => trim($_POST['image_title']),
						'image_desc' => trim($_POST['image_desc']),
						'image_path' => trim($_POST['image_path']),
						'title_err' => '',
						'image_desc_err' => '',
						'image_path_err' => ''
					];
	
					if (empty($data['image_title'])){
						$data['image_err'] = 'Please enter title';
					}
	
					if (empty($data['image_desc'])){
						$data['image_desc_err'] = 'Please enter description';
					}
	
					if (empty($data['image_path'])){
						$data['image_path_err'] = 'Please upload a photo!';
					}
	
					if (empty($data['title_err']) && empty($data['image_path_err']) && empty($data['image_desc_err'])){
						if ($this->galleryModel->addImage($data)){
							redirect('contents/gallery');
						} else {
							die('Something went wrong!');
						}
					} else {
						$this->view('contents/add', $data);
					}
				} else {
					$data = [
						'image_title' => '',
						'image_desc' => '',
						'image_path' => '',
						'title_err' => '',
						'image_desc_err' => '',
						'image_path_err' => ''
					];
		
					$this->view('contents/add', $data);
				}
			} else {
				redirect('users/login');

			}
		}

		public function webcam()
		{
			if ($_SERVER['REQUEST_METHOD'] == 'POST'){
				die(print_r($_POST));
			}
			$data = [
				'name' => '',
				'name_err' => '',
				'description' => '',
				'description_err' => ''
			];
			$this->view('contents/webcam', $data);
		}

		public function saveImage()
		{
			$folder = "/public/img/";
			$destinationFolder = $_SERVER['DOCUMENT_ROOT'] . $folder;
			$maxFileSize         = 2*1024*1024;

			// Get the posted data
			$postdata = file_get_contents("php://input");

			if(!isset($postdata) || empty($postdata))
				exit(json_encode(["success"=>false, "reason"=>"Not a post data"]));

			// Extract the data
			$request = json_decode($postdata);

			// Validate
			if(trim($request->data) === "")
				exit(json_encode(["success"=>false, "reason"=>"Not a post data"]));


			$file = $request->data;

			// getimagesize is used to get the file extension
			// Only png / jpg mime types are allowed
			$size = getimagesize ($file);
			$ext  = $size['mime'];
			if($ext == 'image/jpeg')
				$ext = '.jpg';
			elseif($ext == 'image/png')
				$ext = '.png';
			else
				exit(json_encode(['success'=>false, 'reason'=>'only png and jpg mime types are allowed']));

			// Prevent the upload of large files
			if(strlen(base64_decode($file)) > $maxFileSize)
				exit(json_encode(['success'=>false, 'reason'=>"file size exceeds {$maxFileSize} Mb"]));

			// Remove inline tags and spaces
			$img = str_replace('data:image/png;base64,', '', $file);
			$img = str_replace('data:image/jpeg;base64,', '', $img);
			$img = str_replace(' ', '+', $img);

			// Read base64 encoded string as an image
			$img = base64_decode($img);

			// Give the image a unique name. Don't forget the extension
			$filename = date("d_m_Y_H_i_s")."-".time().$ext;

			// The path to the newly created file inside the upload folder
			$destinationPath = "$destinationFolder$filename";

			// Create the file or return false
			$success = file_put_contents($destinationPath, $img);

			if(!$success)
				exit(json_encode(['success'=>false, 'reason'=>'the server failed in creating the image']));

			// Inform the browser about the path to the newly created image
			exit(json_encode(['success'=>true,'path'=>"$folder$filename"]));
		}
	}