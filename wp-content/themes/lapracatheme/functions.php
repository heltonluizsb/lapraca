<?php

    add_theme_support( 'post-thumbnails' );


    function my_excerpt_length($length){
        return 10;
    }

    add_filter('excerpt_length', 'my_excerpt_length');


    include('functions_include/functions_widgets.php');
    include('ajax/ajax_login.php');
    include('ajax/ajax_painel.php');

 ?>