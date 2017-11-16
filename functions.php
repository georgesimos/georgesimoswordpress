<?php
/**
 * Georgesimos functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Georgesimos
 */

if ( ! function_exists( 'georgesimos_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function georgesimos_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Georgesimos, use a find and replace
	 * to change 'georgesimos' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'georgesimos', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
        add_image_size( 'georgesimos-full-bleed', 2000, 1200, true );
        add_image_size( 'georgesimos-index-img', 800, 450, true );
	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'menu-1' => esc_html__( 'Primary', 'georgesimos' ),
                'social' => esc_html__( 'Social Media Menu', 'georgesimos' ),
                
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'georgesimos_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
        
	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );
        
        //Add theme support for Custom Logo
        add_theme_support( 'custom-logo', array(
            'width' => 90,
            'height' => 90,
            'flex-width' => true,
        ));
        
        //Editor Styles
        add_editor_style( array( 'inc/editor-styles.css' ,'/fonts/custom-fonts.css') );
}
endif;
add_action( 'after_setup_theme', 'georgesimos_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function georgesimos_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'georgesimos_content_width', 640 );
}
add_action( 'after_setup_theme', 'georgesimos_content_width', 0 );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images.
 *
 * @origin Twenty Seventeen 1.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function georgesimos_content_image_sizes_attr( $sizes, $size ) {
	$width = $size[0];

	if ( 900 <= $width ) {
		$sizes = '(min-width: 900px) 700px, 900px';
	}

	if ( is_active_sidebar( 'sidebar-1' ) || is_active_sidebar( 'sidebar-2' ) ) {
		$sizes = '(min-width: 900px) 600px, 900px';
	}

	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'georgesimos_content_image_sizes_attr', 10, 2 );

/**
 * Filter the `sizes` value in the header image markup.
 *
 * @origin Twenty Seventeen 1.0
 *
 * @param string $html   The HTML image tag markup being filtered.
 * @param object $header The custom header object returned by 'get_custom_header()'.
 * @param array  $attr   Array of the attributes for the image tag.
 * @return string The filtered header image HTML.
 */
function georgesimos_header_image_tag( $html, $header, $attr ) {
	if ( isset( $attr['sizes'] ) ) {
		$html = str_replace( $attr['sizes'], '100vw', $html );
	}
	return $html;
}
add_filter( 'get_header_image_tag', 'georgesimos_header_image_tag', 10, 3 );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails.
 *
 * @origin Twenty Seventeen 1.0
 *
 * @param array $attr       Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size       Registered image size or flat array of height and width dimensions.
 * @return string A source size value for use in a post thumbnail 'sizes' attribute.
 */
function georgesimos_post_thumbnail_sizes_attr( $attr, $attachment, $size ) {

	if ( !is_singular() ) {
		if ( is_active_sidebar( 'sidebar-1' ) ) {
			$attr['sizes'] = '(max-width: 900px) 90vw, 800px';
		} else {
			$attr['sizes'] = '(max-width: 1000px) 90vw, 1000px';
		}
	} else {
		$attr['sizes'] = '100vw';
	}

	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'georgesimos_post_thumbnail_sizes_attr', 10, 3 );


/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function georgesimos_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'georgesimos' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'georgesimos' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
        
        register_sidebar( array(
		'name'          => esc_html__( 'Page Sidebar', 'georgesimos' ),
		'id'            => 'sidebar-2',
		'description'   => esc_html__( 'Add page sidebar widgets here.', 'georgesimos' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
        
         register_sidebar( array(
		'name'          => esc_html__( 'Footer Widgets', 'georgesimos' ),
		'id'            => 'footer-1',
		'description'   => esc_html__( 'Add footer widgets here.', 'georgesimos' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'georgesimos_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function georgesimos_scripts() {
    
    
        // Add Google fonts : Fira sans , Merriweather && Roboto
        wp_enqueue_script('georgesimos-google-fonts', 'https://fonts.googleapis.com/css?family=Fira+Sans+Condensed:400,700,700i|Merriweather:400,700,700i|Roboto:400,700,700i');
    
        //wp_enqueue_script('georgesimos-local-fonts', get_template_directory_uri() . '/fonts/custom-fonts.css');
      
	
       
        // Add Font Awesome icons (http://fontawesome.io) 
	wp_enqueue_style( 'georgesimos-fontawesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css' );


    
        wp_enqueue_style( 'georgesimos-style', get_stylesheet_uri() );
	wp_enqueue_script( 'georgesimos-navigation', get_template_directory_uri() . '/js/navigation.js', array( 'jquery' ), '20151215', true );
        wp_localize_script( 'georgesimos-navigation', 'georgesimosScreenReaderText', array(
		'expand'   => __( 'expand child menu', 'georgesimos' ),
		'collapse' =>  __( 'collapse child menu', 'georgesimos' ) ,
            ) );
        
        wp_enqueue_script( 'georgesimos-functions', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20170301', true );
        
	wp_enqueue_script( 'georgesimos-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'georgesimos_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load SVG icon function.
 */
require get_template_directory() . '/inc/icon-functions.php';


/**
 * Recent Posts Extra - Custom widgets
 */
require get_template_directory() . '/inc/custom-widgets/recent-posts-extra-widget.php';
