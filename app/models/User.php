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

		public function editUser($data)
		{
			$this->db->query('UPDATE users SET user_name = :user_name, user_email = :user_email, password = :password WHERE user_id = :user_id');

			$this->db->bind(':user_name', $data['user_name']);
			$this->db->bind(':user_email', $data['email']);
			$this->db->bind(':password', $data['new_password']);
			$this->db->bind(':user_id', $data['user_id']);

			if($this->db->execute()){
				return true;
			} else {
				return false;
			}
		}

		public function deleteUser($id)
		{
			$this->db->query('DELETE FROM users WHERE user_id = :user_id');
			$this->db->bind(':user_id', $id);
			$this->db->execute();
			$this->db->query('DELETE FROM image_likes WHERE user_id = :user_id');
			$this->db->bind(':user_id', $id);
			$this->db->execute();
			$this->db->query('DELETE FROM comments WHERE user_id = :user_id');
			$this->db->bind(':user_id', $id);
			$this->db->execute();
			$this->db->query('DELETE FROM images WHERE user_id = :user_id');
			$this->db->bind(':user_id', $id);
			$this->db->execute();
			return(1);
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

		public function addLink($data)
		{
			$this->db->query('UPDATE users SET link = :link WHERE user_name = :user_name');
			$this->db->bind(':link', $data['link']);
			$this->db->bind(':user_name', $data['user_name']);

			if ($this->db->execute()){
				return true;
			} else {
				return false;
			}
		}

		public function removeLink($data)
		{
			$this->db->query('UPDATE users SET link = :link WHERE user_name = :user_name');
			$this->db->bind(':link', null);
			$this->db->bind(':user_name', $data['user']->user_name);

			if ($this->db->execute()){
				return true;
			} else {
				return false;
			}
		}

		public function resetPassword($data)
		{
			$this->db->query('UPDATE users SET password = :password WHERE user_name = :user_name');
			$this->db->bind(':password', $data['password']);
			$this->db->bind(':user_name', $data['user']->user_name);

			if ($this->db->execute()){
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

		public function getUserByUniqueLink($link)
		{
			$this->db->query('SELECT user_name FROM users WHERE link = :link');
			$this->db->bind(':link', $link);

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