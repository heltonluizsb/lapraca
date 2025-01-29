<?php 
    function wpb_widgets_init() {
 
        register_sidebar( array(
            'name'          => 'Custom Header Widget Area',
            'id'            => 'custom-header-widget',
            'before_widget' => '<div class="chw-widget">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2 class="chw-title">',
            'after_title'   => '</h2>',
        ) );
 
    }

    add_action( 'widgets_init', 'wpb_widgets_init' );


    function wpb_widgets_init_single() {
 
        register_sidebar( array(
            'name'          => 'Custom Header Widget Area Single',
            'id'            => 'custom-header-widget-single',
            'before_widget' => '<div class="chw-widget">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2 class="chw-title">',
            'after_title'   => '</h2>',
        ) );
 
    }

    add_action( 'widgets_init', 'wpb_widgets_init_single' );

    // Creating the widget 
    class hb_widget_latest_post extends WP_Widget {
      
        function __construct() {
            parent::__construct(
              
            // Base ID of your widget
            'hb_widget_latest_post', 
              
            // Widget name will appear in UI
            __('Posts Recentes - Helton Barros', 'hb_widget_latest_post_domain'), 
              
            // Widget description
            array( 'description' => __( 'Posts Recentes - Criado por Helton Barros', 'hb_widget_latest_post_domain' ), ) 
            );
        }
          
        // Creating widget front-end
          
        public function widget( $args, $instance ) {
            $title = apply_filters( 'widget_title', $instance['title'] );
              
            // before and after widget arguments are defined by themes
            echo $args['before_widget'];
            if ( ! empty( $title ) )
            echo $args['before_title'] . $title . $args['after_title'];
              
            // This is where you run the code and display the output
            $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

            $args = array(
                'post_type' => 'post',
                'posts_per_page' => $instance['qtde_posts'],
                'paged' => $paged
            );
            $the_query = new WP_Query($args);

            $temp_query = $wp_query;
            $wp_query = null;
            $wp_query = $the_query;?>

            <div class="post">

                <?php if($the_query->have_posts()) : while($the_query->have_posts()) : $the_query->the_post(); ?>

                    <a href="<?php the_permalink(); ?>" class="post-single">
                        <div class="post-single-img">
                            <?php the_post_thumbnail(); ?>
                        </div>
                        <h4><?php  the_title(); ?></h4>
                        <p><?php echo get_the_date(); ?></p>
                    </a><!-- post-single -->

                <?php endwhile; else : get_404_template(); endif; wp_reset_postdata();?>
                
            </div>
            <?php echo $args['after_widget'];
        }
                  
        // Widget Backend 
        public function form( $instance ) {
            if ( isset( $instance[ 'title' ] ) ) {
                $title = $instance[ 'title' ];
                $qtde_posts = $instance['qtde_posts'];
            }
            else {
                $title = __( 'Posts Recentes', 'wpb_widget_domain' );
                $qtde_posts = __( '5', 'wpb_widget_domain' );
            }
        // Widget admin form
        ?>
        <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p>
        <label for="<?php echo $this->get_field_id( 'qtde_posts' ); ?>"><?php _e( 'Quantidade de Posts:' ); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'qtde_posts' ); ?>" name="<?php echo $this->get_field_name( 'qtde_posts' ); ?>" type="text" value="<?php echo esc_attr( $qtde_posts ); ?>" />
        </p>
        <?php 
        }
              
        // Updating widget replacing old instances with new
        public function update( $new_instance, $old_instance ) {
            $instance = array();
            $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
            $instance['qtde_posts'] = ( ! empty( $new_instance['qtde_posts'] ) ) ? strip_tags( $new_instance['qtde_posts'] ) : '5';
            return $instance;
        }
         
        // Class wpb_widget ends here
    } 
     
     
    // Register and load the widget
    function hb_widget_latest_post_load() {
        register_widget( 'hb_widget_latest_post' );
    }
    add_action( 'widgets_init', 'hb_widget_latest_post_load' );



    // Creating the widget 
    class hb_widget_tags extends WP_Widget {
      
        function __construct() {
            parent::__construct(
              
            // Base ID of your widget
            'hb_widget_tags', 
              
            // Widget name will appear in UI
            __('Tags - Helton Barros', 'hb_widget_categories_domain'), 
              
            // Widget description
            array( 'description' => __( 'Tags - Criado por Helton Barros', 'hb_widget_categories_domain' ), ) 
            );
        }
          
        // Creating widget front-end
          
        public function widget( $args, $instance ) {
            $title = apply_filters( 'widget_title', $instance['title'] );
              
            // before and after widget arguments are defined by themes
            echo $args['before_widget'];
            if ( ! empty( $title ) )
            echo $args['before_title'] . $title . $args['after_title'];
              
            // This is where you run the code and display the output
            $tags = get_tags(array(
              'hide_empty' => false
            ));
            echo '<ul class="tag-list">';
            foreach ($tags as $tag) {
              echo '<li><a href="'.get_tag_link($tag->term_id).'">' . $tag->name . '</a></li>';
            }
            echo '</ul>';
            echo $args['after_widget'];
        }
                  
        // Widget Backend 
        public function form( $instance ) {
            if ( isset( $instance[ 'title' ] ) ) {
                $title = $instance[ 'title' ];
            }
            else {
                $title = __( 'Tags', 'wpb_widget_domain' );
            }
        // Widget admin form
        ?>
        <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <?php 
        }
              
        // Updating widget replacing old instances with new
        public function update( $new_instance, $old_instance ) {
            $instance = array();
            $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
            return $instance;
        }
         
        // Class wpb_widget ends here
    } 
     
     
    // Register and load the widget
    function hb_widget_tags_load() {
        register_widget( 'hb_widget_tags' );
    }
    add_action( 'widgets_init', 'hb_widget_tags_load' );



    // Creating the widget 
    class hb_widget_categories extends WP_Widget {
      
        function __construct() {
            parent::__construct(
              
            // Base ID of your widget
            'hb_widget_categories', 
              
            // Widget name will appear in UI
            __('Categorias - Helton Barros', 'hb_widget_categories_domain'), 
              
            // Widget description
            array( 'description' => __( 'Categorias - Criado por Helton Barros', 'hb_widget_categories_domain' ), ) 
            );
        }
          
        // Creating widget front-end
          
        public function widget( $args, $instance ) {
            $title = apply_filters( 'widget_title', $instance['title'] );
              
            // before and after widget arguments are defined by themes
            echo $args['before_widget'];
            if ( ! empty( $title ) )
            echo $args['before_title'] . $title . $args['after_title'];
              
            // This is where you run the code and display the output
            wp_list_categories(array('title_li' => __('')));
            echo $args['after_widget'];
        }
                  
        // Widget Backend 
        public function form( $instance ) {
            if ( isset( $instance[ 'title' ] ) ) {
                $title = $instance[ 'title' ];
            }
            else {
                $title = __( 'Categorias', 'wpb_widget_domain' );
            }
        // Widget admin form
        ?>
        <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <?php 
        }
              
        // Updating widget replacing old instances with new
        public function update( $new_instance, $old_instance ) {
            $instance = array();
            $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
            return $instance;
        }
         
        // Class wpb_widget ends here
    } 
     
     
    // Register and load the widget
    function hb_widget_categories_load() {
        register_widget( 'hb_widget_categories' );
    }
    add_action( 'widgets_init', 'hb_widget_categories_load' );



    // Creating the widget 
    class hb_widget_archive extends WP_Widget {
      
        function __construct() {
            parent::__construct(
              
            // Base ID of your widget
            'hb_widget_arachive', 
              
            // Widget name will appear in UI
            __('Arquivo - Helton Barros', 'hb_widget_categories_domain'), 
              
            // Widget description
            array( 'description' => __( 'Arquivo - Criado por Helton Barros', 'hb_widget_categories_domain' ), ) 
            );
        }
          
        // Creating widget front-end
          
        public function widget( $args, $instance ) {
            $title = apply_filters( 'widget_title', $instance['title'] );
              
            // before and after widget arguments are defined by themes
            echo $args['before_widget'];
            if ( ! empty( $title ) )
            echo $args['before_title'] . $title . $args['after_title'];
              
            // This is where you run the code and display the output
            echo '<ul class="archive-list">';
            wp_get_archives();
            echo '</ul>';
            echo $args['after_widget'];
        }
                  
        // Widget Backend 
        public function form( $instance ) {
            if ( isset( $instance[ 'title' ] ) ) {
                $title = $instance[ 'title' ];
            }
            else {
                $title = __( 'Arquivo', 'wpb_widget_domain' );
            }
        // Widget admin form
        ?>
        <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <?php 
        }
              
        // Updating widget replacing old instances with new
        public function update( $new_instance, $old_instance ) {
            $instance = array();
            $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
            return $instance;
        }
         
        // Class wpb_widget ends here
    } 
     
     
    // Register and load the widget
    function hb_widget_archive_load() {
        register_widget( 'hb_widget_archive' );
    }
    add_action( 'widgets_init', 'hb_widget_archive_load' );

 ?>