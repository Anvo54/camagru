<?php
	class Gallery
	{
		private $db;

		public function __construct() {
			$this->db = new Database;
		}

		public function addImage($data)
		{
			$this->db->query('INSERT INTO images (image_title, image_desc, image_path) VALUES(:image_title, :image_desc, :image_path)');

			$this->db->bind(':image_title', $data['image_title']);
			$this->db->bind(':image_desc', $data['image_desc']);
			$this->db->bind(':image_path', $data['image_path']);

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
	}