<?php

	/*	Load Config files	*/

	require_once 'config/config.php';

	/*	Load helper files	*/
	

	require_once 'helpers/url_helper.php';
	require_once 'helpers/session_helper.php';
	require_once 'helpers/email_helper.php';
	require_once 'helpers/string_helpers.php';
	
	/*	Autoload Core Libraries	*/
	
	require_once 'config/Database.php';

	spl_autoload_register(function($className){
		require_once 'libraries/'.$className.'.php';
	});