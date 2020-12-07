<?php
	class Contents extends Controller {
		public function __construct() {
			$this->galleryModel = $this->model('Gallery');
			$this->userModel = $this->model('User');
		}
		public function index($pageno)
		{
			$pages = $this->galleryModel->getPages();
			if ($pages == 0) {
				$no_of_records_per_page = 0;
			} else {
				$no_of_records_per_page = 5;
			}
			$total_pages = ($pages == 0) ? 0 : ceil($pages / $no_of_records_per_page);

			if (empty($pageno) || !is_numeric($pageno)) {
				$pageno = 1;
			}
			
			if ($pageno >= $total_pages){
				$pageno = intval($total_pages);
			}

			$offset = ($pageno-1) * $no_of_records_per_page; 

			$images = $this->galleryModel->getImages($offset, $no_of_records_per_page);
			
			$data = [
				'images' => $images,
				'total_pages' => $total_pages,
				'pageno' => $pageno
			];
			$this->view('contents/index', $data);
		}

		public function add_temp_photo()
		{
			if (isLoggedIn() && $_SERVER['REQUEST_METHOD'] == 'POST') {
				$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
				if (!file_exists('public/img/tmp/'.$_SESSION['user_name']))
				{
					mkdir('public/img/tmp/'.$_SESSION['user_name']);
				}
				$data = [
					'image' => $_POST['photo'],
					'tree' => $_POST['tree'],
					'garden' => $_POST['garden'],
					'star' => $_POST['star'],
					'chain' => $_POST['chain'],
					'cape' => $_POST['cape'],
					'facemask' => $_POST['facemask'],
					'filename' => 'public/img/tmp/'.$_SESSION['user_name'].'/' . uniqid() . '_tmp.png'
				];
				$img = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data['image']));
				$img = imagecreatefromstring($img);

				if ($data['tree'] == 'true') {
					$sec_img = imagecreatefrompng('public/img/Stickers/tree.png');
					imagecopy($img, $sec_img,imageSX($img) / 2,imageSY($img) / 2,0,0,imageSX($sec_img),imageSY($sec_img));
				}
				if ($data['garden'] == 'true') {
					$sec_img = imagecreatefrompng('public/img/Stickers/garden.png');
					imagecopy($img, $sec_img,0,0,0,0,imageSX($sec_img),imageSY($sec_img));
				}
				if ($data['star'] == 'true') {
					$sec_img = imagecreatefrompng('public/img/Stickers/star.png');
					imagecopy($img, $sec_img,80,45,0,0,imageSX($sec_img),imageSY($sec_img));
				}
				if ($data['cape'] == 'true') {
					$sec_img = imagecreatefrompng('public/img/Stickers/cape.png');
					imagecopy($img, $sec_img,0,0,0,0,imageSX($sec_img),imageSY($sec_img));
				}
				if ($data['chain'] == 'true') {
					$sec_img = imagecreatefrompng('public/img/Stickers/chain.png');
					imagecopy($img, $sec_img,0,0,0,0,imageSX($sec_img),imageSY($sec_img));
				}
				if ($data['facemask'] == 'true') {
					$sec_img = imagecreatefrompng('public/img/Stickers/face_mask.png');
					imagecopy($img, $sec_img,0,0,0,0,imageSX($sec_img),imageSY($sec_img));
				}
				imagealphablending( $img, false );
				imagesavealpha( $img, true );

				imagepng($img, $data['filename']);
				echo URLROOT.'/'.$data['filename'];
			}
		}

		public function add()
		{
			if (isLoggedIn()){
				if ($_SERVER['REQUEST_METHOD'] == 'POST'){
					$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
					$filename = 'public/img/'.removeSpecialChar($_POST['image_title']).uniqid().'.png';
					$tmp = explode(URLROOT.'/',$_POST['selected_image']);
					rename($tmp[1], $filename);
					$data = [
						'image_title' => $_POST['image_title'],
						'image_desc' => trim($_POST['image_desc']),
						'image_path' => URLROOT.'/'.$filename,
						'user_id' => trim($_SESSION['user_id']),
					];
					if ($this->galleryModel->addImage($data)){
		
						array_map('unlink' ,glob(dirname($tmp[1]).'/*.png'));
						rmdir(dirname($tmp[1].'/'));
						redirect('contents/gallery');
					} else {
						$this->view('contents/add', $data);
					}
				}
				$user_images = $this->galleryModel->getImagesByUser($_SESSION['user_id']);
				$data = [
					'name' => '',
					'name_err' => '',
					'description' => '',
					'description_err' => '',
					'error_message' => '',
					'user_images' => $user_images
				];
				$this->view('contents/add', $data);
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
						$path = explode('http://localhost:8080/',$image->image_path);
						unlink($path[1], null);
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
				if ($this->galleryModel->getImageById($id)) {
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
							if($user->comment_email) {
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