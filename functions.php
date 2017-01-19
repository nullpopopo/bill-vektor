<?php 

/*-------------------------------------------*/
/*  Load Module
/*-------------------------------------------*/
/*  Theme setup
/*-------------------------------------------*/
/*  Load Theme CSS & JS
/*-------------------------------------------*/
/*  Load Admin CSS & JS
/*-------------------------------------------*/
/*  WidgetArea initiate
/*-------------------------------------------*/
/*  Add Post Type Client
/*-------------------------------------------*/
/*  Remove_post_editor_support
/*-------------------------------------------*/


$theme_opt = wp_get_theme(get_template());
define('BILLVEKTOR_THEME_VERSION', $theme_opt->Version);

/*-------------------------------------------*/
/*  Load Module
/*-------------------------------------------*/
require_once( 'inc/custom-field-builder-config.php' );
require_once( 'inc/setting-page/setting-page.php' );
require_once( 'inc/bill-custom-fields/bill-custom-fields.php' );
get_template_part('inc/template-tags');

/*-------------------------------------------*/
/*  Theme setup
/*-------------------------------------------*/
function bill_theme_title() {
    // title tag
    add_theme_support( 'title-tag' );
    // custom menu
    register_nav_menus( array( 'Header Navigation' => 'Header Navigation', ) );
}
add_action( 'after_setup_theme', 'bill_theme_title' );

/*-------------------------------------------*/
/*  Load Theme CSS & JS
/*-------------------------------------------*/
function bill_theme_scripts(){

  // 静的HTMLで読み込んでいたCSSを読み込む
  wp_enqueue_style( 'bill-css-bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css', array(), '3.3.6' );
  wp_enqueue_style( 'bill-css', get_template_directory_uri() . '/assets/css/style.css', array('bill-css-bootstrap'), BILLVEKTOR_THEME_VERSION );

  // テーマディレクトリ直下にある style.css を出力
  wp_enqueue_style( 'bill-theme-style', get_stylesheet_uri(), array( 'bill-css' ),BILLVEKTOR_THEME_VERSION );

	// テーマ用のjsを読み込む
	wp_enqueue_script( 'bill-js-bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array( 'jquery' ), BILLVEKTOR_THEME_VERSION, true );

}
add_action( 'wp_enqueue_scripts', 'bill_theme_scripts' );

/*-------------------------------------------*/
/*  Load Admin CSS & JS
/*-------------------------------------------*/
function bill_admin_scripts(){
  // 管理画面用のcss
  // CF Builder で読み込んでいる以外のCSSが無いため
  // wp_enqueue_style( 'bill-admin-css', get_template_directory_uri() . '/assets/css/admin-style.css', BILLVEKTOR_THEME_VERSION, null );
  // 管理画面用のjs
  wp_enqueue_script( 'bill-js-bootstrap', get_template_directory_uri() . '/assets/js/admin.js', array( 'jquery','jquery-ui-sortable' ), BILLVEKTOR_THEME_VERSION, true );
}
add_action( 'admin_enqueue_scripts', 'bill_admin_scripts' );

/*-------------------------------------------*/
/*  WidgetArea initiate
/*-------------------------------------------*/
function bill_widgets_init() {
  register_sidebar( array(
    'name' => 'Sidebar',
    'id' => 'sidebar-widget-area',
    'before_widget' => '<aside class="sub-section section %2$s" id="%1$s">',
    'after_widget' => '</aside>',
    'before_title' => '<h4 class="sub-section-title">',
    'after_title' => '</h4>',
  ) );
}
add_action( 'widgets_init', 'bill_widgets_init' );


/*-------------------------------------------*/
/*  Add Post Type Client
/*-------------------------------------------*/
add_action( 'init', 'bill_add_post_type_client', 0 );
function bill_add_post_type_client() {
    register_post_type( 'client', /* カスタム投稿タイプのスラッグ */
        array(
            'labels' => array(
                'name' => '請求先',
            ),
        'public'             => false,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'has_archive'        => false,
        'supports'           => array('title'),
        'menu_position'      => 5,
        )
    );
}

/*-------------------------------------------*/
/*  Remove_post_editor_support
/*-------------------------------------------*/
add_action( 'init' , 'bill_remove_post_editor_support' );
function bill_remove_post_editor_support() {
 remove_post_type_support( 'post', 'editor' );
}
