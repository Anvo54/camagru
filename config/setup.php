<?php
require_once 'app/helpers/session_helper.php';

class Install {
		public function __construct() {
			if (isLoggedIn()){
				unset($_SESSION['user_id']);
				unset($_SESSION['user_name']);
				session_destroy();
			}
		}

		public function createTables()
		{
			$db = new Database;
			$db->query('DROP TABLE IF EXISTS `users`, `comments`, `image_likes`, `images`');
			$db->execute();
			echo "Creating user table<br>";
			$db->query('CREATE TABLE `users` (`user_id` INT NOT NULL AUTO_INCREMENT,`user_name` varchar(32) NOT NULL,`user_email` varchar(64) NOT NULL,`password` varchar(255) NOT NULL,`link` varchar(32) DEFAULT NULL,`verified` tinyint(1) DEFAULT NULL, `comment_email` tinyint(1) DEFAULT NULL, `like_email` tinyint(1) DEFAULT NULL, PRIMARY KEY (`user_id`))');
			$db->execute();
			echo "Creating comments table<br>";
			$db->query('CREATE TABLE `comments` ( `id` INT NOT NULL AUTO_INCREMENT , `post_id` INT NOT NULL , `user_id` INT NOT NULL , `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , `comment` TEXT NOT NULL , PRIMARY KEY (`id`))');
			$db->execute();
			echo "Creating likes table<br>";
			$db->query('CREATE TABLE `image_likes` ( `id` INT NOT NULL AUTO_INCREMENT , `image_id` INT NOT NULL , `user_id` INT NOT NULL , PRIMARY KEY (`id`))');
			$db->execute();
			echo "Creating images table<br>";
			$db->query('CREATE TABLE `images` (`image_id` int NOT NULL AUTO_INCREMENT, `image_title` varchar(255) NOT NULL, `image_desc` varchar(255) NOT NULL,`image_path` varchar(255) NOT NULL, `user_id` int DEFAULT NULL, `created_at` datetime DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (`image_id`))');
			$db->execute();
		}
	}
