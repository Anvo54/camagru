<?php
	class Users extends Controller {
		public function __construct() {
			$this->userModel = $this->model('User');
		}

		public function index()
		{
			$data = [
				'user_name' => '',
				'email' => '',
				'password' => '',
				'confirm_password' => '',
				'name_err' => '',
				'email_err' => '',
				'password_err' => '',
				'confirm_password_err' => '',
			];
			$this->view('users/register', $data);
		}

		public function register()
		{
			if ($_SERVER['REQUEST_METHOD'] == 'POST'){

				$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

				$data = [
					'user_name' => trim($_POST['user_name']),
					'email' => trim($_POST['email']),
					'password' => trim($_POST['password']),
					'confirm_password' => trim($_POST['confirm_password']),
					'name_err' => '',
					'email_err' => '',
					'password_err' => '',
					'confirm_password_err' => '',
				];
				$data = $this->validateUserData($data);

				if (empty($data['email_err']) && empty($data['name_err']) && empty($data['password_err'])){

					$data['password'] = password_hash($data['password'],PASSWORD_DEFAULT);
					if ($this->userModel->registerUser($data)){
						mail($data['email'], 'Confirm account', 'Confirm me');
						redirect('users/login');
					} else {
						die('Something went wrong');
					}
				} else {
					$this->view('users/register', $data);
				}
			} else {
				$data = [
					'user_name' => '',
					'email' => '',
					'password' => '',
					'confirm_password' => '',
					'name_err' => '',
					'email_err' => '',
					'password_err' => '',
					'confirm_password_err' => '',
				];
				$this->view('/users/register', $data);
			}
		}

		public function login()
		{
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			
				$data = [
					'user_name' => trim($_POST['user_name']),
					'password' => trim($_POST['password']),
					'name_err' => '',
					'password_err' => '',
				];
				
				if (empty($data['user_name'])) {
					$data['name_err'] = "Insert username";
				}

				if (empty($data['password'])) {
					$data['password_err'] = "Please insert password";
				}

				if (!$this->userModel->findUserByUsername($data['user_name'])) {
					$data['name_err'] = 'No user found';
				}

				if (empty($data['name_err']) && empty($data['password_err'])){
					$loggedInUser = $this->userModel->login($data['user_name'], $data['password']);
					if ($loggedInUser) {
						$this->createUserSession($loggedInUser);
						redirect('contents');
					} else {
						$data['password_err'] = 'Password incorrect';
						$this->view('users/login', $data);
					}
				} else {
					$this->view('users/login', $data);
				}
			} else {
				$data = [
					'user_name' => '',
					'password' => '',
					'name_err' => '',
					'password_err' => '',
				];
				$this->view('users/login', $data);
			}
		}

		private function validateUserData($data)
		{
			if (empty($data['user_name'])){
				$data['name_err'] = 'Please insert valid username!';
			}
			if (empty($data['email'])){
				$data['email_err'] = 'Please insert valid email!';
			}
			if (empty($data['password'])){
				$data['password_err'] = 'Please insert valid password!';
			} else if (strlen($data['password']) < 6) {
				$data['password_err'] = 'Password has to be at least 6 characters!';
			}
			if (($data['confirm_password']) != $data['password']){
				$data['password_err'] = "Passwords don't match!";
			}
			return $data;
		}

		public function edit($id)
		{
			$user = $this->userModel->getUserById($id);

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
				
				$data = [
					'user_name' => trim($_POST['user_name']),
					'email' => trim($_POST['email']),
					'password' => trim($_POST['password']),
					'new_password' => trim($_POST['new_password']),
					'user_id' => $id
				];
				//** CREATE hashed new password AND Old password */
				$data['new_password'] = password_hash($data['new_password'],PASSWORD_DEFAULT);
				$loginSuccess = $this->userModel->login($_SESSION['user_name'], $data['password']);
				if ($loginSuccess) {
					if ($this->userModel->editUser($data)) {
						$data = [
							'user' => $user,
							'success_message' => 'Password changed successfully!'
						];
						$this->view('users/edit', $data);
					} else {
						die('Something went wrong');
					}
				} else {
					$data = [
						'user' => $user,
						'error_message' => 'Invalid password!'
					];
					$this->view('users/edit', $data);
				}
			} else {
				$data = [
					'user' => $user,
					'message' => ''
				];
				$this->view('users/edit', $data);
			}
		}

		public function delete($id)
		{
			if($this->userModel->deleteUser($id)) {
				$this->logout();
			} else {
				die('User delete not successful');
			}
		}

		public function createUserSession($user)
		{
			$_SESSION['user_id'] = $user->user_id;
			$_SESSION['user_name'] = $user->user_name;
		}

		public function logout()
		{
			unset($_SESSION['user_id']);
			unset($_SESSION['user_name']);
			session_destroy();
			redirect('user/login');
		}
	}