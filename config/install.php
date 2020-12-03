<?php
require_once '../app/helpers/url_helper.php';
require_once '../app/helpers/session_helper.php';

	$lorem = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut vitae vestibulum mi. Donec in risus massa. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aliquam venenatis nisl eu risus efficitur, et condimentum lectus tristique. Sed eu lobortis enim. Vestibulum sed augue non purus dapibus posuere. Fusce gravida nunc nec neque tempus, in hendrerit velit tristique. Donec eu convallis neque.';

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		if (isLoggedIn()){
			unset($_SESSION['user_id']);
			unset($_SESSION['user_name']);
			session_destroy();
		}

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

		if (isset($_POST['sample-data'])&& $_POST['sample-data']){
			$i = 0;
			while($i++ < 10) {
				$db->query('INSERT INTO `users` (`user_id` ,`user_name`,`user_email`,`password`,`link`,`verified`) VALUES (NULL, :name, :email, :password, null, true)');
				$db->bind(':name', 'user'.$i);
				$db->bind(':email', 'user'.$i.'@testmail.com');
				$db->bind(':password', password_hash('?Password'.$i,PASSWORD_DEFAULT));
				$db->execute();
			}
			$i = 0;
			$j = 1;
			while($i < 30) {
				$db->query('INSERT INTO `images` (`image_id`, `image_title`, `image_desc`, `image_path`, `user_id`) VALUES (NULL, :image_title, :image_desc, :image_path, :user_id)');
				$db->bind(':image_title', 'image no '.$j);
				$db->bind(':image_desc', 'This is a image from user'.$j);
				$db->bind(':image_path', URLROOT.'/public/img/placeholder.png');
				$db->bind(':user_id', $j);
				$db->execute();
				$j = ($i % 3 != 2) ? $j : $j += 1; 
				$i++;
			}
			$i = 0;
			while($i++ < 30) {
				$db->query('INSERT INTO `comments` (`id`, `post_id`, `user_id`, `comment`) VALUES (NULL, :post_id, :user_id, :comment)');
				$db->bind(':post_id', rand(1,30));
				$db->bind(':user_id', rand(1, 10));
				$db->bind(':comment', $lorem);
				$db->execute();
			}
		}
		redirect('');
	}
