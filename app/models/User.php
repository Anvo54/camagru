<?php
	class User {
		private $db;

		public function __construct() {
			$this->db = new Database();
		}

		public function RegisterUser($data)
		{
			$this->db->query('INSERT INTO users (user_name, user_email, password) values (:user_name, :user_email, :password)');

			$this->db->bind(':user_name', $data['user_name']);
			$this->db->bind(':user_email', $data['email']);
			$this->db->bind(':password', $data['password']);

			if($this->db->execute()){
				return true;
			} else {
				return false;
			}
		}


		public function findUserByUsername($user_name)
		{
			$this->db->query('SELECT * FROM users WHERE user_name = :user_name');
			$this->db->bind(':user_name', $user_name);

			$row = $this->db->single();

			if($this->db->rowCount() > 0){
				return true;
			} else {
				return false;
			}
		}
		/**	Get user by id */
		public function getUserById($id)
		{
			$this->db->query('SELECT * FROM users WHERE user_id = :user_id');
			$this->db->bind(':user_id', $id);

			$row =  $this->db->single();

			return $row;
		}

		public function login($user_name, $password)
		{
			$this->db->query('SELECT * FROM users WHERE user_name = :user_name');
			$this->db->bind(':user_name', $user_name);

			$row = $this->db->single();

			$hashed_pass = $row->password;
			if(password_verify($password, $hashed_pass)){
				return $row;
			} else {
				return false;
			}
		}
	}