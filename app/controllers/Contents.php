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
			$this->view('contents/webcam', []);
		}
	}