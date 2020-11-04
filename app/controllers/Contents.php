<?php
	class Contents extends Controller {
		public function __construct() {
			$this->galleryModel = $this->model('Gallery');
			$this->userModel = $this->model('User');
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
						'user_id' => trim($_SESSION['user_id']),
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
			if (isLoggedIn()){
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
			} else {
				redirect('users/login');
			}
		}

		public function delete($id)
		{
			if (isLoggedIn()){
				if ($_SERVER['REQUEST_METHOD'] == 'POST'){
					$image = $this->galleryModel->getImageById($id);
					if ($image->user_id != $_SESSION['user_id']) {
						redirect('contents');
					}
					if ($this->galleryModel->deleteImage($id)){
						redirect('contents');
					} else {
						die('Something went wrong');
					}
				} else {
					redirect('contents');
				}
			} else {
				redirect('users/login');
			}
		}

		public function show($id)
		{
			if (empty($image = $this->galleryModel->getImageById($id))) {
				redirect('contents');
			}
			$user = $this->userModel->getUserById($image->user_id);
			$likes = $this->galleryModel->getLikeCount($id);
			$liked = $this->galleryModel->checkUserLike(['image' => $id, 'user' => $user->user_id]);
			$comments = $this->galleryModel->getComments($id);

			$data = [
				'image' => $image,
				'user' => $user,
				'likes' => $likes,
				'comments' => $comments,
				'liked' => $liked
			];
			
			$this->view('contents/show', $data);
		}

		public function like($id)
		{
			if (isLoggedIn()) {
				$data = [
					'image' => $id,
					'user' => trim($_SESSION['user_id'])
				];
	
				if ($this->galleryModel->checkUserLike($data)){
					redirect('contents');
				} else {
					if ($this->galleryModel->likeImage($data)){
						redirect('contents/show/'.$id);
					} else {
						die('Something went wrong!');
					}
				}
			} else {
				redirect('contents/show/'.$id);
			}
		}

		public function dislike($id)
		{
			if (isLoggedIn()) {
				$data = [
					'image' => $id,
					'user' => trim($_SESSION['user_id'])
				];
	
				if ($this->galleryModel->deleteLike($data)){
					redirect('contents/show/'.$id);
				} else {
					die('something went wrong');
				}
			} else {
				redirect('contents/show/'.$id);
			}
		}

		public function comment()
		{
			if (isLoggedIn()) {
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		
					$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
					$data = [
						'comment' => $_POST['comment'],
						'post_id' => $_POST['post_id'],
						'user_id' => trim($_SESSION['user_id']),
						'comment_err' => ''
					];
	
					/** Create add comment */
	
					if (empty($data['comment'])) {
						$data['comment_err'] = "Comment can't be empty!";
					}
	
					if (empty($data['comment_err'])) {
						if ($this->galleryModel->addComment($data)) {
							redirect('/contents/show/'.$data['post_id']);
						} else {
							die('Something went wrong');
						}
					} else {
						$this->view('contents/show/'.$data['post_id'], $data);
					}
				}
			} else {
				redirect('contents');
			}
		}

		public function delcomment()
		{
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				if (isLoggedIn() && $_POST['user_id'] == $_SESSION['user_id']) {
					if ($this->galleryModel->deleteComment($_POST['image_id'])){
						redirect('contents/show/'.$_POST['image_id']);
					}
				} else {
					redirect('contents/show');
				}
			}
		}
	}