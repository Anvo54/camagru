<?php
	class Pages extends Controller {
		public function __construct() {

		}

		public function index()
		{
			if (isLoggedIn()){
				redirect('contents');
			}
			$data = [
				'title' => 'Camagru',
				'message' => 'Please register or login to view, edit and add images!',
				'description' => 'Simple website for image manipulaiton in php!'
			];
			$this->view('pages/index', $data);
		}

		public function about()
		{
			$data = [
				'title' => 'About Camagru',
				'message' => 'About',
				'description' => 'A simple webapp where users can modify their images!'
			];
			$this->view('pages/about', $data);
		}
	}
