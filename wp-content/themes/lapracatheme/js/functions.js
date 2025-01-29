$(function(){

	var page = $('lapraca').attr('page-title');
	var site_url = $('lapraca').attr('get-site-url');

	/*************** MENU LOGADO ********************/

	var logado_menu = false;

	$('.logado-menu').hover(function(){
		logado_menu = true;
	},function(){
		logado_menu = false;
		$('.logado-menu').hide();
	})

	$('.header-main-btns .logado, .header-main-mobile .logado').hover(function(){
		$('.logado-menu').show();
	},function(){
		setTimeout(function(){
			if(!logado_menu){
				$('.logado-menu').hide();
			}
		},1000);
	})

	/*************** BUSCA ********************/

	$('.header-busca-submit').click(function(){
		$('.header-busca form').submit();
	})

	$('.header-busca form').submit(function(){
		var busca_form = $(this).serializeArray();
		var form_check = false;
		for(var i = 0; i < busca_form.length; i++){
			if(busca_form[i].name == 'busca-text' && busca_form[i].value.length > 0){
				form_check = true;
			}
		}
		if(!form_check){
			return false;
		}
	})

	/*************** ANIMAÇÃO CONTAGEM DE NÚMEROS ********************/

	var count_end = false;
	var count_end_02 = false;
	var home_box01_02 = $('.home-box01-02');
	var home_box01_02_top = null;
	var home_box01_02_height = home_box01_02.height();

	var home_box08 = $('.home-box08');
	var home_box08_top = null;
	var home_box08_height = home_box08.height();

	reset_numbers_count();

	if(typeof home_box01_02.offset() !== "undefined"){
		home_box01_02_top = home_box01_02.offset().top;
	}

	if(typeof home_box08.offset() !== "undefined"){
		if($(window).width() > 768){
			home_box08_top = home_box08.offset().top + 600;
		}else{
			home_box08_top = home_box08.offset().top + 400;			
		}
	}

	function reset_numbers_count(){

		$('.home-box01-02 h2').each(function () {
			$(this).attr('oldnumber',$(this).text());
			$(this).text('0');
		});
		
		$('.home-box08-single h2').each(function () {
			$(this).attr('oldnumber',$(this).text());
			$(this).text('0');
		});

	}

	function number_counter(){
		$('.home-box01-02 h2').each(function () {
		    $(this).prop('Counter',0).animate({
		        Counter: $(this).attr('oldnumber')
		    }, {
		        duration: 1000,
		        easing: 'swing',
		        step: function (now) {
		            $(this).text(formatar(Math.ceil(now)));
		        }
		    });
		});
		count_end = true;
	}

	function number_counter_02(){
		$('.home-box08-single h2').each(function () {
		    $(this).prop('Counter',0).animate({
		        Counter: $(this).attr('oldnumber')
		    }, {
		        duration: 1000,
		        easing: 'swing',
		        step: function (now) {
		            $(this).text(formatar(Math.ceil(now)));
		        }
		    });
		});
		count_end_02 = true;
	}

	function formatar(nr) {
	  return String(nr)
	    .split('').reverse().join('').split(/(\d{3})/).filter(Boolean)
	    .join('.').split('').reverse().join('');
	}

	$(window).scroll(function(){
		var windowOffY = $(window).scrollTop();
		var scrollBottom = $(window).scrollTop() + $(window).height();
		var windowHeight = $(window).height();

		if((scrollBottom >= (home_box01_02_top - home_box01_02_height)) && !count_end){
			number_counter();
		}else if((scrollBottom >= (home_box08_top)) && !count_end_02){
			number_counter_02();
		}
	})

	/*************** GALERIA DE ANÚNCIOS ********************/


	$(window).on('load',function() {

		var dots_pos = 0;
		var dots_length = $('.home-box02-dots span').length;
		var scroll_to = ($('.home-box02-galeria').width() * 0.98) + 80;

		if($(window).width() <= 375){
  			var scroll_to = $('.home-box02-galeria').width() + 76; /** 0.992 **/
		}else if($(window).width() <= 500){
  			var scroll_to = $('.home-box02-galeria').width() + 74; /** 0.992 **/
		}else if($(window).width() <= 768){
  			var scroll_to = $('.home-box02-galeria').width() + 70; /** 0.992 **/
		}

		$('.home-box02-dots span').click(function(){
	  		var leftPos = $('.home-box02-galeria').scrollLeft();
	  		var dots_goto = $(this).index() - dots_pos;

	  		$('.home-box02-galeria').animate({
	  			scrollLeft: leftPos + (scroll_to * dots_goto)
	  		}, 400);

			$('.home-box02-dots span').each(function(){
				$(this).removeClass('selected');
			})
			$(this).addClass('selected');

			dots_pos = $(this).index();
		})

		setInterval(function(){
	  		var leftPos = $('.home-box02-galeria').scrollLeft();

	  		$('.home-box02-dots span').each(function(){
				$(this).removeClass('selected');
	  		})

	  		dots_pos++;
			if(dots_pos > (dots_length - 1)){
				dots_pos = 0;
			}
	  		$('.home-box02-dots span:nth-of-type('+(dots_pos + 1)+')').addClass('selected');

			if(dots_pos == 0){
				dots_pos = 0;
		  		$('.home-box02-galeria').animate({
		  			scrollLeft: 0
		  		}, 400);
			} else{

		  		$(".home-box02-galeria").animate({
		  			scrollLeft: leftPos + scroll_to
		  		}, 1000);

			}
		},5000);

	})

	/*************** MENU COMO FUNCIONA ********************/

	var header_main_menu_como_funciona = false;

	$('.header-main-menu-como-funciona').click(function(){
		if(header_main_menu_como_funciona){
			$('.header-main-menu-como-funciona-menu').slideToggle();
			header_main_menu_como_funciona = false;
		}else{
			$('.header-main-menu-como-funciona-menu').slideToggle();
			header_main_menu_como_funciona = true;			
		}
		return false;
	})

	$('body').click(function(){
		if(header_main_menu_como_funciona){
			$('.header-main-menu-como-funciona-menu').slideToggle();
			header_main_menu_como_funciona = false;
		}
	})

	$('.header-main-menu-como-funciona-menu p, .footer01-02 .como-funciona, .header-main-mobile-menu-como-funciona-menu a').click(function(){

		if(page == 'Home'){

			var como_funciona = $('#comofunciona').offset().top + 120;

			$([document.documentElement, document.body]).animate({
				scrollTop: como_funciona
			})

			if($(this).text() == 'Para quem procura'){

				$('.home-box03-para-anunciantes').animate({
					opacity: '0'
				},200,function(){
					$('.home-box03-para-anunciantes').css('display','none');
					$('.home-box03-para-quem-procura').css('display','flex');
					$('.home-box03-para-quem-procura').animate({
						opacity: '1'
					},200);
				});

				$('.home-box03-tipos span').each(function(){

					if($(this).text() == 'Para quem procura'){
						$('.home-box03-tipos span').each(function(){
							$(this).removeClass('selected');
						});
						$(this).addClass('selected');
					}

				})

			} else if($(this).text() == 'Para anunciantes'){

				$('.home-box03-para-quem-procura').animate({
					opacity: '0'
				},200,function(){
					$('.home-box03-para-quem-procura').css('display','none');
					$('.home-box03-para-anunciantes').css('display','flex');
					$('.home-box03-para-anunciantes').animate({
						opacity: '1'
					},200);
				});

				$('.home-box03-tipos span').each(function(){

					if($(this).text() == 'Para anunciantes'){
						$('.home-box03-tipos span').each(function(){
							$(this).removeClass('selected');
						});
						$(this).addClass('selected');
					}

				})

			}

		}else{
			window.location.href = site_url+"#comofunciona";
		}

		return false;

	})

	/*************** COMO FUNCIONA ********************/

	$('.home-box03-tipos span').click(function(){

		$('.home-box03-tipos span').each(function(){
			$(this).removeClass('selected');
		})

		$(this).addClass('selected');

		if($(this).text() == 'Para anunciantes'){

			$('.home-box03-para-quem-procura').animate({
				opacity: '0'
			},200,function(){
				$('.home-box03-para-quem-procura').css('display','none');
				$('.home-box03-para-anunciantes').css('display','flex');
				$('.home-box03-saiba-mais').show();
				$('.home-box03-para-anunciantes').animate({
					opacity: '1'
				},200);
			});

		}else if($(this).text() == 'Para quem procura'){

			$('.home-box03-para-anunciantes').animate({
				opacity: '0'
			},200,function(){
				$('.home-box03-para-anunciantes').css('display','none');
				$('.home-box03-para-quem-procura').css('display','flex');
				$('.home-box03-saiba-mais').hide();
				$('.home-box03-para-quem-procura').animate({
					opacity: '1'
				},200);
			});

		}
	})

	/*************** EMPRESAS EM DESTAQUE e FIQUE POR DENTRO - GALERIA ********************/

	$('.home-box04-arrow-left div').click(function(){

		if($(this).parent().parent().hasClass('home-box04-wrapper')){
	  		var leftPos = $('.home-box04-conteudo').scrollLeft();
	  		if($(window).width() > 768){
		  		$(".home-box04-conteudo").animate({
		  			scrollLeft: leftPos - 316
		  		}, 400);
	  		}else{
	  			var box_size = $(".home-box04-conteudo").width() + 24;
		  		$(".home-box04-conteudo").animate({
		  			scrollLeft: leftPos - box_size
		  		}, 400);	   			
	  		}
		}else if($(this).parent().parent().hasClass('home-box09-wrapper')){
	  		var leftPos2 = $('.home-box09-posts').scrollLeft();
	  		if($(window).width() > 768){
		  		$('.home-box09-posts').animate({
		  			scrollLeft: leftPos2 - 478
		  		}, 400);
	  		}else{
	  			var box_size = $(".home-box04-conteudo").width() * 1.05;
		  		$('.home-box09-posts').animate({
		  			scrollLeft: leftPos2 - box_size
		  		}, 400);
	  		}
		}
	})

	$('.home-box04-arrow-right div').click(function(){

		if($(this).parent().parent().hasClass('home-box04-wrapper')){
	  		var leftPos = $('.home-box04-conteudo').scrollLeft();
	  		if($(window).width() > 768){
		  		$(".home-box04-conteudo").animate({
		  			scrollLeft: leftPos + 316
		  		}, 400);
	  		}else{
	  			var box_size = $(".home-box04-conteudo").width() + 24;
		  		$(".home-box04-conteudo").animate({
		  			scrollLeft: leftPos + box_size
		  		}, 400);	   			
	  		}
		}else if($(this).parent().parent().hasClass('home-box09-wrapper')){
  			var leftPos2 = $('.home-box09-posts').scrollLeft();
	  		if($(window).width() > 768){
		  		$('.home-box09-posts').animate({
		  			scrollLeft: leftPos2 + 478
		  		}, 400);
	  		}else{
	  			var box_size = $(".home-box04-conteudo").width() * 1.05;
		  		$('.home-box09-posts').animate({
		  			scrollLeft: leftPos2 + box_size
		  		}, 400);
	  		}
		}

	})

	setInterval(function(){
  		var leftPos = $('.home-box04-conteudo').scrollLeft();
  		var leftPos2 = $('.home-box09-posts').scrollLeft();

  		if(page == 'Home'){

	  		if((leftPos + $('.home-box04-conteudo').width()) < $('.home-box04-conteudo')[0].scrollWidth){
		  		if($(window).width() > 768){
			  		$(".home-box04-conteudo").animate({
			  			scrollLeft: leftPos + 316
			  		}, 400);
		  		}else{
		  			var box_size = $(".home-box04-conteudo").width() + 24;
			  		$(".home-box04-conteudo").animate({
			  			scrollLeft: leftPos + box_size
			  		}, 400);	  			
		  		}
	  		}else{
		  		$('.home-box04-conteudo').animate({
		  			scrollLeft: 0
		  		}, 400);  			
	  		}

	  		if((leftPos2 + $('.home-box09-posts').width()) < $('.home-box09-posts')[0].scrollWidth){
		  		if($(window).width() > 768){
			  		$('.home-box09-posts').animate({
			  			scrollLeft: leftPos2 + 478
			  		}, 400);
		  		}else{
		  			var box_size = $(".home-box04-conteudo").width() * 1.05;
			  		$('.home-box09-posts').animate({
			  			scrollLeft: leftPos2 + box_size
			  		}, 400);
		  		}
	  		}else{
		  		$('.home-box09-posts').animate({
		  			scrollLeft: 0
		  		}, 400);  			
	  		}

  		}
	},5000);

	/*************** SEGMENTOS ********************/

	var segmentos_show = false

	$('.home-box05-link a').click(function(){
		$('.home-box05-segmentos-02').slideToggle();
		if(segmentos_show){
			$(this).text('Mais segmentos');
			segmentos_show = false;
		}else{
			$(this).text('Menos segmentos');
			segmentos_show = true;
		}
		return false;
	})

	/*************** BUSQUE POR CIDADADE ********************/

	var cidade_show = false

	$('.home-box06-link a').click(function(){
		$('.home-box06-cidades-02').slideToggle();
		if(cidade_show){
			$(this).text('Mais Cidades');
			cidade_show = false;
		}else{
			$(this).text('Menos Cidades');
			cidade_show = true;
		}
		return false;
	})

	/*************** MENU MOBILE ********************/

	var menu_mobile_show = false

	$('.header-main-mobile-menu-btn').click(function(){

		if(menu_mobile_show){
			$('.header-main-mobile-menu-btn').find('span:nth-of-type(1)').css('transform','rotatez(0) translateY(0)');
			$('.header-main-mobile-menu-btn').find('span:nth-of-type(2)').css('opacity','1');
			$('.header-main-mobile-menu-btn').find('span:nth-of-type(3)').css('transform','rotatez(0) translateY(0)');
			menu_mobile_show = false;
		}else{
			$('.header-main-mobile-menu-btn').find('span:nth-of-type(1)').css('transform','rotatez(45deg) translate(4px,10px)');
			$('.header-main-mobile-menu-btn').find('span:nth-of-type(2)').css('opacity','0');
			$('.header-main-mobile-menu-btn').find('span:nth-of-type(3)').css('transform','rotatez(-45deg) translate(4px,-10px)');
			menu_mobile_show = true;
		}

		$('.header-main-mobile-menu').slideToggle();

		return false;
	})

	$('.header-main-mobile-menu-como-funciona-menu a').click(function(){

		if(menu_mobile_show){
			$('.header-main-mobile-menu-btn').find('span:nth-of-type(1)').css('transform','rotatez(0) translateY(0)');
			$('.header-main-mobile-menu-btn').find('span:nth-of-type(2)').css('opacity','1');
			$('.header-main-mobile-menu-btn').find('span:nth-of-type(3)').css('transform','rotatez(0) translateY(0)');
			menu_mobile_show = false;
		}else{
			$('.header-main-mobile-menu-btn').find('span:nth-of-type(1)').css('transform','rotatez(45deg) translate(4px,10px)');
			$('.header-main-mobile-menu-btn').find('span:nth-of-type(2)').css('opacity','0');
			$('.header-main-mobile-menu-btn').find('span:nth-of-type(3)').css('transform','rotatez(-45deg) translate(4px,-10px)');
			menu_mobile_show = true;
		}

		$('.header-main-mobile-menu').slideToggle();
		$('.header-main-mobile-menu-como-funciona-menu').slideToggle();
		

		var como_funciona = $('#comofunciona').offset().top + 120;

		$([document.documentElement, document.body]).animate({
			scrollTop: como_funciona
		})

		if($(this).text() == 'Para quem procura'){

			$('.home-box03-para-anunciantes').animate({
				opacity: '0'
			},200,function(){
				$('.home-box03-para-anunciantes').css('display','none');
				$('.home-box03-para-quem-procura').css('display','flex');
				$('.home-box03-para-quem-procura').animate({
					opacity: '1'
				},200);
			});

			$('.home-box03-tipos span').each(function(){

				if($(this).text() == 'Para quem procura'){
					$('.home-box03-tipos span').each(function(){
						$(this).removeClass('selected');
					});
					$(this).addClass('selected');
				}

			})

		} else if($(this).text() == 'Para anunciantes'){

			$('.home-box03-para-quem-procura').animate({
				opacity: '0'
			},200,function(){
				$('.home-box03-para-quem-procura').css('display','none');
				$('.home-box03-para-anunciantes').css('display','flex');
				$('.home-box03-para-anunciantes').animate({
					opacity: '1'
				},200);
			});

			$('.home-box03-tipos span').each(function(){

				if($(this).text() == 'Para anunciantes'){
					$('.home-box03-tipos span').each(function(){
						$(this).removeClass('selected');
					});
					$(this).addClass('selected');
				}

			})

		}

		return false
	})

	$('body').click(function(){

		if(menu_mobile_show){
			$('.header-main-mobile-menu-btn').find('span:nth-of-type(1)').css('transform','rotatez(0) translateY(0)');
			$('.header-main-mobile-menu-btn').find('span:nth-of-type(2)').css('opacity','1');
			$('.header-main-mobile-menu-btn').find('span:nth-of-type(3)').css('transform','rotatez(0) translateY(0)');

			$('.header-main-mobile-menu').slideToggle();
			$('.header-main-mobile-menu-como-funciona-menu').slideToggle();

			menu_mobile_show = false;
		}

	})

	/*************** MENU MOBILE - COMO FUNCIONA ********************/

	$('.header-main-mobile-menu-como-funciona').click(function(){
		$('.header-main-mobile-menu-como-funciona-menu').slideToggle();
		return false
	})

	/*************** PLANOS - LINK DESATIVADO ********************/

	$('.planos-box01-tabela-plano-desativado a').click(function(){
		return false;
	})

	$('.planos-box01-tabela-plano-desativado a').each(function(){
		$(this).text('Desativado');
	})


	/**************** WINDOW RESIZE *******************/
	var isMobile = false; //initiate as false
	// device detection
	if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) 
	    || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) { 
	    isMobile = true;
	}

	var rtime;
	var timeout = false;
	var delta = 200;
	$(window).resize(function() {
	    rtime = new Date();
	    if (!isMobile && timeout === false) {
	        timeout = true;
	        setTimeout(resizeend, delta);
	    }
	});

	function resizeend() {
	    if (new Date() - rtime < delta) {
	        setTimeout(resizeend, delta);
	    } else {
	        timeout = false;
	        location.reload();
	    }
	}
	
})