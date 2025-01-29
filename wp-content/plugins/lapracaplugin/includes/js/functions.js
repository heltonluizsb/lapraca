$(function(){

	var wp_admin_ajax = $('tbbase').attr('wp-admin') + 'admin-ajax.php';
	var get_site_url = $('tbbase').attr('get-site-url');
	var base_dir = $('tbbase').attr('base-dir');
	var base_url = $('tbbase').attr('base-url');

	/*********** CATEGORIAS ************/

	$('.categoria-alterar').click(function(){
		var categoria_id = $(this).attr('categoria-id');

		$.ajax({
				dataType:'json',
				url:wp_admin_ajax,
				method:'post',
				data: {
					'acao':'categoria_alterar',
					'categoria_id':categoria_id,
					action: 'altera_categoria'}
			}).done(function(data){
				$('.table-form-planos-vc input[name=nome]').val(data.wpdb[0].nome);
				var new_path = data.wpdb[0].imagem.replace(base_dir,base_url);
				$('.table-form-planos-vc img').attr('src',new_path);
				$('.form-planos-vc input[name=imagem_antiga]').val(data.wpdb[0].imagem);
				$('.form-planos-vc input[name=categoria_id]').val(categoria_id);
				$('.form-planos-vc input[name=categoria_alterar]').val('Alterar Categoria');
			});

		return false;
	})

	$('.categoria-excluir').click(function(){
		var categoria_id = $(this).attr('categoria-id');
		var r = confirm("Você tem certeza que deseja excluir a categoria " + $(this).parent().parent().find('td:first-of-type').text() + "?");

		if(r == true){

			$.ajax({
					dataType:'json',
					url:wp_admin_ajax,
					method:'post',
					data: {
						'acao':'categoria_excluir',
						'categoria_id':categoria_id,
						action: 'altera_categoria'}
				}).done(function(data){
					location.reload();
				});

		}

		return false;
	})

	/*********** CLIENTES ************/

	$('.cliente-excluir').click(function(){
		var categoria_id = $(this).attr('categoria-id');
		var r = confirm("Você tem certeza que deseja excluir o cliente " + $(this).parent().parent().find('td:first-of-type').text() + "?");

		if(r == true){
			return true;
		}else{
			return false;
		}
	})

	$(document).on('click','.foto-empresa > div',function(){

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
				action: 'altera_cliente'},
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

	var timeoutHandle = null;

	$('.form-cliente').ajaxForm({
		dataType:'json',
		url:wp_admin_ajax,
		method:'post',
		data: {
			'acao':'cliente_atualizar',
			action: 'altera_cliente'
		},beforeSubmit:function(){
			clearTimeout(timeoutHandle);
			$('.msg-box').remove();
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

			if(data.sucesso){
				console.log(data);
				$('.form-cliente input[type=submit]').before('<div class="msg-box sucesso">' + data.mensagem[0] + '</div>');
				timeoutHandle = setTimeout(function(){
					$('.msg-box').remove();
				},10000);
			}else{

				for(i = 0; i < data.mensagem.length; i++){
					$('.form-cliente input[type=submit]').before('<div class="msg-box erro">' + data.mensagem[i] + '</div>');
				}

				var msg_time = 3000 * data.mensagem.length;

				timeoutHandle = setTimeout(function(){
					$('.msg-box').animate({
						opacity:0
					},function(){
						$('.msg-box').remove();
					});
				},msg_time);
				
			}

		},
		error: function(xhr, status, error){
	         var errorMessage = xhr.status + ': ' + xhr.statusText
	         console.log('Error - ' + errorMessage);
		}
	})

	// $('.form-cliente [name=pais]').change(function(){
	// 	if($(this).val() == 'Alemanha'){
	// 		$('.form-cliente [name=cidade]').removeAttr('disabled');
	// 	}else{
	// 		$('.form-cliente [name=cidade]').val('Não residente na Alemanha');
	// 		$('.form-cliente [name=cidade]').removeAttr('disabled');
	// 		$('.form-cliente [name=cidade]').attr('disabled','true');
	// 	}
	// })

	/*********** BANNERS e CIDADES ************/

	$('.banner-excluir, .cidade-excluir').click(function(){
		var categoria_id = $(this).attr('categoria-id');
		var r = confirm("Você tem certeza que deseja excluir?");

		if(r == true){
			return true
		}

		return false;
	})

	/******** HELPER MASK *********/

	$('[name=cep]').mask('99999');

})

// window.onbeforeunload = function() {
//   return false;
// }