<?php
	class Gallery
	{
		private $db;

		public function __construct() {
			$this->db = new Database;
		}

		public function addImage($data)
		{
			$this->db->query('INSERT INTO images (image_title, image_desc, image_path, user_id) VALUES(:image_title, :image_desc, :image_path, :user_id)');

			$this->db->bind(':image_title', $data['image_title']);
			$this->db->bind(':image_desc', $data['image_desc']);
			$this->db->bind(':image_path', $data['image_path']);
			$this->db->bind(':user_id', $data['user_id']);

			if ($this->db->execute()){
				return true;
			} else {
				return false;
			}
		}

		public function getImages()
		{
			$this->db->query('SELECT * FROM images');

			$result = $this->db->resultSet();

			return $result;
		}

		public function getImageById($id)
		{
			$this->db->query('SELECT * FROM images WHERE image_id = :image_id');
			$this->db->bind(':image_id', $id);

			$row = $this->db->single();

			return $row;
		}

		public function deleteImage($id)
		{
			$this->db->query('DELETE FROM images WHERE image_id = :image_id');
			$this->db->bind(':image_id', $id);

			if ($this->db->execute()){
				return true;
			} else {
				return false;
			}
		}

		public function likeImage($data)
		{
			$this->db->query('INSERT INTO image_likes (image_id, user_id) VALUES(:image_id, :user_id)');

			$this->db->bind(':image_id', $data['image']);
			$this->db->bind(':user_id', $data['user']);

			if ($this->db->execute()){
				return true;
			} else {
				return false;
			}
		}

		public function getImageLikes($image_id)
		{
			$this->db->query('SELECT * FROM image_likes WHERE image_id = :image_id');
			$this->db->bind(':image_id', $image_id);

			$result = $this->db->resultSet();

			return $result;
		}

		public function checkUserLike($data)
		{
			$this->db->query('SELECT image_id FROM image_likes WHERE user_id = :user_id AND image_id = :image_id');
			$this->db->bind(':image_id', $data['image']);
			$this->db->bind(':user_id', $data['user']);

			$row = $this->db->single();

			if (isset($row->image_id) && $row->image_id == $data['image']) {
				return true;
			} else {
				return false;
			}
		}

		public function deleteLike($data)
		{
			$this->db->query('DELETE FROM image_likes WHERE user_id = :user_id AND image_id = :image_id');
			$this->db->bind(':image_id', $data['image']);
			$this->db->bind(':user_id', $data['user']);

			if ($this->db->execute()){
				return true;
			} else {
				return false;
			}
		}

		public function getLikeCount($id)
		{
			$this->db->query('SELECT * FROM image_likes WHERE image_id = :image_id');
			$this->db->bind(':image_id', $id);
			$row = $this->db->single();
			
			return $this->db->rowCount();
		}
	}