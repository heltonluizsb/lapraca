<?php
	
	add_action('tb_imagemValida','imagemValida');
	add_action('tb_uploadFile','uploadFile');
	add_action('tb_deleteFile','deleteFile');

	class padrao{

	 	public static function imagemValida($imagem){
	 		if($imagem['type'] == 'image/jpeg' ||
	 			$imagem['type'] == 'image/jpg' ||
	 			$imagem['type'] == 'image/png' ||
	 			$imagem['type'] == 'image/svg+xml'){
	 			$tamanho = intval($imagem['size']/1024);
	 			if($tamanho < 30240){
	 				return true;
	 			} else{
	 				return false;
	 			}
	 		}
	 		else{
	 			return false;
	 		}
	 	}

	 	public static function uploadFile($file, $local = null){
	 		$formatoarquivo = explode('.',$file['name']);
	 		$imagemnome = uniqid().'.'.$formatoarquivo[count($formatoarquivo) - 1];
	 		$wp_upload_dir = wp_upload_dir();
	 		if($local == null){
		 		if(move_uploaded_file($file['tmp_name'],$wp_upload_dir['path'].'/'.$imagemnome)){
		 			return $wp_upload_dir['path'].'/'.$imagemnome;
		 		}
		 		else{
		 			return false;
		 		}
	 		}
	 	}

	 	public static function deleteFile($file){
	 		@unlink($file);
	 	}

	}

 ?>