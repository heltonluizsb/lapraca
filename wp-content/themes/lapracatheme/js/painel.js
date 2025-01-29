$(function(){

	var wp_admin_ajax = $('lapraca').attr('wp-admin') + 'admin-ajax.php';
	var basedir = $('lapraca').attr('basedir');
	var baseurl = $('lapraca').attr('baseurl');

	/*************** INPUT FOCUS ********************/

	$('.box-login form input, .box-login select, .box-login textarea').focus(function(){
		$(this).parent().find('label').css('color','#3C83E2');
	})

	$('.box-login form input, .box-login select, .box-login textarea').focusout(function(){
		$(this).parent().find('label').css('color','#787878');
	})

	/*************** UPLOAD DAS FOTOS - INPUT FILE ********************/

	$('#logo-file, #foto-empresa-file').change(function(){
		var file_name = $(this).val().replace(/C:\\fakepath\\/i, '');
		var file_size = $(this)[0].files[0].size;
		var cliente_id = $(this).attr('cliente-id');
		var file_extension = file_name.split('.');
		file_extension = file_extension[1].toLowerCase();

		if((file_extension != 'jpg' && file_extension != 'png' && file_extension != 'svg') || file_size > 3000000){
			$(this).parent().find('.file-stylized').css('border','2px solid #F21616');
			$(this).parent().find('.file-stylized div:nth-of-type(1) label').css('color','#F21616');
			$(this).parent().find('.file-stylized div:nth-of-type(2) label').css('background-color','#F21616');
			$(this).parent().find('.file-stylized div:nth-of-type(2) img').css('filter','invert(100%) sepia(0%) saturate(7485%) hue-rotate(250deg) brightness(111%) contrast(104%)');

			$(this).parent().find('.file-stylized div:nth-of-type(1) label').html('Arquivo <b style="color:black">"' + file_name + '"</b> não suportado ou maior que 3mb. Arquivos suportados: JPG, PNG ou SVG (tamanho máx: 3mb)');
		}else{
			if($(this).attr('id') == 'logo-file'){
				$('.box-login form input[name=acao_hidden]').val('atualizar-logo');
			}else if($(this).attr('id') == 'foto-empresa-file'){
				$('.box-login form input[name=acao_hidden]').val('atualizar-fotos');
			}
			$('.box-login form').submit();
		}
	})

	var timeoutHandle = null;

	$('.box-login form').ajaxForm({
		dataType:'json',
		url:wp_admin_ajax,
		method:'post',
		data: {
			'acao':'cliente_atualizar',
			action: 'cliente_atualizar'
		},beforeSubmit:function(){
			clearTimeout(timeoutHandle);
			$('.login-processando').show();
			$('.login-processando').animate({
				opacity: 1
			});
			$('.login-processando-box').animate({
				opacity: 1
			})
		},success:function(data){
			$('.login-processando').animate({
				opacity: 0
			},function(){
				$('.login-processando').hide();
				$('.login-processando-box').css('opacity',0);
			});
			if(data.acao_hidden == 'atualizar-logo'){
				var file_name = $('#logo-file').val().replace(/C:\\fakepath\\/i, '');

				$('#logo-file').parent().find('.file-stylized').css('border','2px solid #e2e2e2');
				$('#logo-file').parent().find('.file-stylized div:nth-of-type(1) label').css('color','#777777');
				$('#logo-file').parent().find('.file-stylized div:nth-of-type(2) label').css('background-color','#E2E2E2');
				$('#logo-file').parent().find('.file-stylized div:nth-of-type(2) img').css('filter','none');

				$('#logo-file').parent().find('.file-stylized div:nth-of-type(1) label').html(file_name);

				if($('.painel-form-logo-img').children().length < 1){
					$('.painel-form-logo-img').append('<div><img src=""></div>');
				}
				$('.painel-form-logo-img img').attr('src',data.tb_clientes[0].logo.replace(basedir,baseurl));

				$('.box-login form input[name=acao_hidden]').val('atualizar-tudo');

			}else if(data.acao_hidden == 'atualizar-fotos'){

				if(data.sucesso){
					var file_name = $('#foto-empresa-file').val().replace(/C:\\fakepath\\/i, '');

					$('#foto-empresa-file').parent().find('.file-stylized').css('border','2px solid #e2e2e2');
					$('#foto-empresa-file').parent().find('.file-stylized div:nth-of-type(1) label').css('color','#777777');
					$('#foto-empresa-file').parent().find('.file-stylized div:nth-of-type(2) label').css('background-color','#E2E2E2');
					$('#foto-empresa-file').parent().find('.file-stylized div:nth-of-type(2) img').css('filter','none');

					$('#foto-empresa-file').parent().find('.file-stylized div:nth-of-type(1) label').html(file_name);

					var new_img = '<div><img src="' + data.tb_clientes_fotos[0].foto.replace(basedir,baseurl);
					new_img += '"><div cliente-id="' + data.tb_clientes[0].id + '" foto-id="' + data.tb_clientes_fotos[0].id;
					new_img += '" foto="' + data.tb_clientes_fotos[0].foto + '"><span></span><span></span></div></div>';

					$('.painel-form-foto-empresa-img').append(new_img);
				}else{
					$('#foto-empresa-file').parent().find('.file-stylized').css('border','2px solid #F21616');
					$('#foto-empresa-file').parent().find('.file-stylized div:nth-of-type(1) label').css('color','#F21616');
					$('#foto-empresa-file').parent().find('.file-stylized div:nth-of-type(2) label').css('background-color','#F21616');
					$('#foto-empresa-file').parent().find('.file-stylized div:nth-of-type(2) img').css('filter','invert(100%) sepia(0%) saturate(7485%) hue-rotate(250deg) brightness(111%) contrast(104%)');

					$('#foto-empresa-file').parent().find('.file-stylized div:nth-of-type(1) label').html(data.mensagem[0]);

				}

				$('.box-login form input[name=acao_hidden]').val('atualizar-tudo');

			}else if(data.acao_hidden == 'atualizar-tudo' || data.acao_hidden == 'atualizar-nao-anunciante'){

				if(data.sucesso){
					$('.box-login form input[type=submit]').before('<h2 class="box-login-sucesso">' + data.mensagem[0] + '</h2>');
					timeoutHandle = setTimeout(function(){
						$('.box-login-sucesso').remove();
					},10000);
				}else{

					for(i = 0; i < data.mensagem.length; i++){
						$('.box-login form input[type=submit]').before('<h2 class="box-login-erro">' + data.mensagem[i] + '</h2>');
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

			}
		},
		error: function(xhr, status, error){
	         var errorMessage = xhr.status + ': ' + xhr.statusText
	         console.log('Error - ' + errorMessage);
		}


	})

	$(document).on('click','.painel-form-logo-img > div > div, .painel-form-foto-empresa-img > div > div',function(){

		var cliente_id = $(this).attr('cliente-id');
		var foto_id = $(this).attr('foto-id');
		var foto = $(this).attr('foto');
		var foto_btn = $(this);

		$.ajax({
			dataType:'json',
			url:wp_admin_ajax,
			method:'post',
			data: {
				'acao':'foto_excluir',
				'cliente_id':cliente_id,
				'foto_id':foto_id,
				'foto':foto,
				action: 'cliente_atualizar'},
			beforeSend:function(xhr){
				$('.login-processando').show();
				$('.login-processando').animate({
					opacity: 1
				});
				$('.login-processando-box').animate({
					opacity: 1
				})
			}
		}).done(function(data){

			$('.login-processando').animate({
				opacity: 0
			},function(){
				$('.login-processando').hide();
				$('.login-processando-box').css('opacity',0);
			});
			foto_btn.parent().remove();

		});
	})

	// $('.box-login form [name=pais]').change(function(){
	// 	if($(this).val() == 'Alemanha'){
	// 		$('.box-login form [name=cidade]').removeAttr('disabled');
	// 	}else{
	// 		$('.box-login form [name=cidade]').val('Não residente na Alemanha');
	// 		$('.box-login form [name=cidade]').removeAttr('disabled');
	// 		$('.box-login form [name=cidade]').attr('disabled','true');
	// 	}
	// })

	/******** HELPER MASK *********/

	$('[name=cep]').mask('99999');
	
})

// window.onbeforeunload = function() {
//   return false;
// }