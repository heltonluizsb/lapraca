<img class="pre-footer" src="<?php echo get_stylesheet_directory_uri(); ?>/img/bg_rodape2.svg">
<footer>
    <div class="container">
		<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/logo2x.png">
        <div class="footer-01">
        	<div class="footer01-01">
                <p>Conectando você ao seu país, de onde estiver.</p>
                <p>© <?php echo date('Y'); ?> All Rights Reserved</p>
        	</div>
        	<div class="footer01-02">
        		<a href="" class="como-funciona">Como Funciona</a><span>|</span>
        		<a href="" class="como-funciona">Para quem procura</a><span>|</span>
        		<a href="" class="como-funciona">Para anunciantes</a><span>|</span>
        		<a href="<?php echo get_site_url(); ?>/novidades">Novidades</a><span>|</span>
        		<a href="<?php echo get_site_url(); ?>/login">Cadastre-se</a><span>|</span>
        	</div>
        	<div class="footer01-03">
        		<div class="footer01-03-midias">
        			<div><a href=" https://www.youtube.com/channel/UCOm-2byeew_axkbHW6irDJg" target="_blank">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/Icon_Youtube.svg">
                    </a></div>
        			<div><a href="https://www.instagram.com/lapraca_/" target="_blank">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/Icon_Instagram.svg">
                    </a></div>
        			<div><a href="https://www.facebook.com/lapracaDE" target="_blank">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/Icon_Facebook.svg">
                    </a></div>
        		</div>
                <p>Siga a gente nas redes sociais e fique por dentro de todas as novidades</p>
        	</div>
        </div>
        <div class="footer-02">
            <a href="<?php echo get_site_url(); ?>/politica-de-privacidade/">Política de Privacidade</a>
            <a href="<?php echo get_site_url(); ?>/termos-e-servicos/">Termos e Serviços</a>
            <a href="<?php echo get_site_url(); ?>/diretrizes-de-conteudo/">Diretrizes de conteúdo</a>
            <a href="<?php echo get_site_url(); ?>/impressum/">Impressum</a>
            <a href="<?php echo get_site_url(); ?>/politica-de-cookies/">Política de Cookies</a>
            <a href="<?php echo get_site_url(); ?>/termos-adicionais-para-contas-empresariais/">Termos Adicionais para Contas Empresariais</a>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>

<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/jquery.js"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/jquery.ajaxform.js"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/jquery.mask.js"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/functions.js"></script>
<?php if(get_the_title() == 'Login'){ ?>
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/js/login.js"></script>
<?php }elseif(get_the_title() == 'Painel'){ ?>
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/js/painel.js"></script>
<?php }elseif(get_the_title() == 'Anunciante'){ ?>
    <script async
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBjOZnWlp3hDR5WM6n8haCk7guL6Q3sB4g">
    </script>
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/js/anunciante.js"></script>
<?php } ?>
</body>
</html>
<?php ob_end_flush(); ?>