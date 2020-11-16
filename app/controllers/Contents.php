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
					$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

					$filename = 'public/img/'.removeSpecialChar($_POST['image_title']).uniqid().'.png';
					$data = [
						'image' => $_POST['photo'],
						'image_title' => $_POST['image_title'],
						'image_desc' => trim($_POST['image_desc']),
						'image_path' => URLROOT.'/'.$filename,
						'user_id' => trim($_SESSION['user_id']),
					];

					if ($this->galleryModel->addImage($data)){
						$img = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data['image']));
						$img = imagecreatefromstring($img);
						$sec_img = imagecreatefrompng('public/img/tree.png');
						imagecopy($img, $sec_img,imageSX($img) / 2,imageSY($img) / 2,0,0,imageSX($sec_img),imageSY($sec_img));
						imagepng($img, $filename, null);
						redirect('contents/gallery');
					} else {
						$this->view('contents/webcam', $data);
					}
				}
				$data = [
					'name' => '',
					'name_err' => '',
					'description' => '',
					'description_err' => '',
					'error_message' => ''
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
						$path = explode('http://localhost:8080/camagru/',$image->image_path);
						unlink($path[1], null);
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
			$liked = (isLoggedIn()) ? $this->galleryModel->checkUserLike(['image' => $id, 'user' => $_SESSION['user_id']]) : 0;
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
					redirect('contents/show/'.$id);
				} else {
					if ($this->galleryModel->likeImage($data)){
						$user = $this->userModel->getImageOwner($id);
						if($user->like_email) {
							sendNotificationMail($user->user_email, $id, "Like");
						}
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
							$user = $this->userModel->getImageOwner($data['post_id']);
							if($user->like_comment) {
								sendNotificationMail($user->user_email, $data['post_id'], "Comment");
							}
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

		public function delcomment($id)
		{
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				if (isLoggedIn() && $_POST['user_id'] == $_SESSION['user_id']) {
					if ($this->galleryModel->deleteComment($id)){
						redirect('contents/show/'.$_POST['image_id']);
					}
				} else {
					redirect('contents/show');
				}
			} else {
				redirect('contents/show');
			}
		}
	}