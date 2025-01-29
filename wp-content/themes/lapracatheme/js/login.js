$(function(){

	var wp_admin_ajax = $('lapraca').attr('wp-admin') + 'admin-ajax.php';

	/********************** LOGIN - MOSTRANDO O BOX DE CADASTRO **********************/

	$('.box-login:first-of-type form a').click(function(){

		$('.box-login:first-of-type').animate({
			opacity: 0,
			left: '-100px'
		},400,function(){


			if($(window).width() > 768){
				$('.box-login:last-of-type').show();
				$('.box-login:last-of-type').animate({
					opacity: 1,
					left: '25%'
				});
			}else{
				$('.box-login:last-of-type').show();
				$('.box-login:last-of-type').animate({
					opacity: 1,
					left: '0'
				});				
			}

		});
		return false;
	})

	/********************** LOGIN - VOLTANDO PARA O BOX DE LOGIN **********************/

	$('.box-login:last-of-type form a').click(function(){

		$('.box-login:last-of-type').animate({
			opacity: 0,
			left: '50%'
		},400,function(){
			$('.box-login:last-of-type').hide();

			$('.box-login:first-of-type').animate({
				opacity: 1,
				left: '0'
			});

		});
		return false;
	})

	var timeoutHandle = null;

	/********************** LOGIN - CADASTRANDO **********************/

	$('.box-login-form-cadastro').ajaxForm({
		dataType:'json',
		url:wp_admin_ajax,
		method:'post',
		data:{
			'acao':'cliente_cadastrar',
			action:'cliente_cadastro'
		},beforeSubmit:function(){
			clearTimeout(timeoutHandle);
			$('.box-login-sucesso').remove();
			$('.box-login-erro').remove();
			$('.login-processando').show();
			$('.login-processando').animate({
				opacity: 1
			});
			$('.login-processando-box').animate({
				opacity: 1
			})
		},
		success:function(data){
			$('.login-processando').animate({
				opacity: 0
			},function(){
				$('.login-processando').hide();
				$('.login-processando-box').css('opacity',0);
				if(data.sucesso){
					$('.box-login:last-of-type .box-login-btns').before('<h2 class="box-login-sucesso">Um e-mail foi enviado para você. Click no link enviado no seu e-mail para continuar seu cadastro.</h2>');
					timeoutHandle = setTimeout(function(){
						$('.box-login-sucesso').remove();
					},10000);
				}else{
					for(i = 0; i < data.mensagem.length; i++){
						$('.box-login:last-of-type .box-login-btns').before('<h2 class="box-login-erro">' + data.mensagem[i] + '</h2>');
					}

					var msg_time = 3000 * data.mensagem.length;

					timeoutHandle = setTimeout(function(){
						$('.box-login-erro').animate({
							opacity:0
						},function(){
							$('.box-login-erro').remove();
						});
					},msg_time);
				}
			});
		},
		error:function(data){
			console.log(data);
		}
	})

	/********************** LOGIN - ESQUECEU A SENHA **********************/

	$('.link-esqueceu-senha').click(function(){
		$('.box-login-esqueceu-senha-form').slideToggle();
		return false;
	})

	$('.box-login-esqueceu-senha-form').ajaxForm({
		dataType:'json',
		url:wp_admin_ajax,
		method:'post',
		data:{
			'acao':'cliente_esqueceu_senha',
			action:'cliente_cadastro'
		},beforeSubmit:function(){
			clearTimeout(timeoutHandle);
			$('.box-login-sucesso').remove();
			$('.box-login-erro').remove();
			$('.login-processando').show();
			$('.login-processando').animate({
				opacity: 1
			});
			$('.login-processando-box').animate({
				opacity: 1
			})
		},
		success:function(data){
			$('.login-processando').animate({
				opacity: 0
			},function(){
				$('.login-processando').hide();
				$('.login-processando-box').css('opacity',0);
				if(data.sucesso){
					$('.box-login-esqueceu-senha-form div').before('<h2 class="box-login-sucesso">Um e-mail foi enviado para você. Click no link enviado no seu e-mail para continuar o procedimento de alteração de senha.</h2>');
					timeoutHandle = setTimeout(function(){
						$('.box-login-sucesso').remove();
					},10000);
				}else{
					for(i = 0; i < data.mensagem.length; i++){
						$('.box-login-esqueceu-senha-form div').before('<h2 class="box-login-erro" style="margin: 0 0 40px 0;">' + data.mensagem[i] + '</h2>');
					}

					var msg_time = 30000 * data.mensagem.length;

					timeoutHandle = setTimeout(function(){
						$('.box-login-erro').animate({
							opacity:0
						},function(){
							$('.box-login-erro').remove();
						});
					},msg_time);
				}
			});
		},
		error:function(data){
			console.log(data);
		}
	})

	$('.box-login:first-of-type form [name=email]').change(function(){
		$('.box-login-esqueceu-senha-form [name=email]').val($(this).val());
	})
	
})

// window.onbeforeunload = function() {
//   return false;
// }