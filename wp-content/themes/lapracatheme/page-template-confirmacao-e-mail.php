<?php 
	// Template Name: Template de Confirmação de E-mail
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Template de E-mail</title>
</head>
<style type="text/css">
		

	@font-face{
		src:url(<?php echo "'".get_stylesheet_directory_uri()."/fonts/OpenSans/OpenSans/OpenSans-Regular.ttf'"; ?>);
		font-family: "OpenSans Regular";
	}

	*{
		margin:  0;
		padding:  0;
		box-sizing: border-box;
		font-family: "OpenSans Regular";
	}

	body{
		background-color: #f1f1f1;
	}
	
	.box{
		width: 100%;
		max-width: 560px;
		margin: 40px auto;
		background-color: white;
		border:  1px solid #ccc;
		border-radius: 10px;
		text-align: center;
		padding: 50px;
		position: relative;
	}

</style>
<body>
	<div class="box">
		<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/logo2x.png">
		<h2>Favor confirmar seu e-mail no link abaixo:</h2>
		<a href="<?php echo get_home_url(); ?>/confirmaemail?codigo=<?php echo  ?>"></a>		
	</div>
</body>
</html>