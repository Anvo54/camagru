<?php
	class Core
	{
		protected $currentController = 'Pages';
		protected $currentMethod = 'index';
		protected $params = [];

		public function __construct() {

			$url = $this->getUrl();

			/**	Get url[0] as the controller */
			if (isset($url[0]) && file_exists('app/controllers/'.ucwords($url[0]).'.php')){
				$this->currentController = ucwords(($url[0]));
				unset($url[0]);
			}

			require_once 'app/controllers/'.$this->currentController. '.php';

			$this->currentController = new $this->currentController;

			/**	Get second part of url as a method	*/
			if (isset($url[1])){
				if (method_exists($this->currentController, $url[1])){
					$this->currentMethod = $url[1];
					unset($url[1]);
				}
			}

			/**	Get all the rest as array of parameters	 */

			$this->params = $url ? array_values($url) : [];

			call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
		}

		public function getUrl()
		{
			if(isset($_GET['url'])){
				$url = rtrim($_GET['url'], '/');
				$url = filter_var($_GET['url'], FILTER_SANITIZE_URL);
				$url = explode('/', $url);

				return $url;
			}
		}
	}
	