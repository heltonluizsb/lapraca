<?php 
	class padrao{

	 	public static function logado(){

			global $wpdb;

	 		if(isset($_SESSION['cliente_login']) &&  $_SESSION['cliente_password']){

		        $tb_cliente = $wpdb->prepare("SELECT * FROM `tb_clientes` WHERE `email` = %s AND `senha` = %s",
		            array(
		               $_SESSION['cliente_email'],
		               $_SESSION['cliente_password']
		            ));
		        $tb_cliente = $wpdb->get_results($tb_cliente);

		        if(count($tb_cliente) > 0){
	 				return true;
		        }else{
		        	return false;
		        }
	 		}else{
	 			return false;
	 		}
	 	}

	 	public static function logout(){
	 		session_destroy();
	 		setcookie('cliente_email','true',time()-1,'/');
	 		setcookie('cliente_password','true',time()-1,'/');
	 		header('Location:'.get_home_url());
	 	}

	 	public static function uploadFile($file){
	 		$formatoarquivo = explode('.',$file['name']);
	 		$imagemnome = uniqid().'.'.$formatoarquivo[count($formatoarquivo) - 1];
	 		$wp_upload_dir = wp_upload_dir();
	 		if(move_uploaded_file($file['tmp_name'],$wp_upload_dir['path'].'/'.$imagemnome)){
	 			return $wp_upload_dir['path'].'/'.$imagemnome;
	 		}
	 		else{
	 			return false;
	 		}
	 	}

	 	public static function deleteFile($file){
	 		@unlink($file);
	 	}
	}
 ?>