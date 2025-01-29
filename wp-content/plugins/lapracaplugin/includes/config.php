<?php 
	
	date_default_timezone_set('America/Sao_Paulo');

	$autoload = function($class){
		if($class == 'Mail'){
			include('classes/phpmailer/PHPMailerAutoload.php');
		}
		@include('classes/'.$class.'.php');
	};

	spl_autoload_register($autoload);

	
    global $wpdb;
    $upload_dir = wp_upload_dir();    

 ?>