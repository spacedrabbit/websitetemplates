<?php
include_once( 'inc/actblue.php' );
include_once( 'inc/customizer.php' );
include_once( 'inc/tfc-cta-section.php' );
include_once( 'inc/feature-cta-section.php' );
include_once( 'inc/features.php' );
include_once( 'inc/starter.php' );

function tfc_widget_init(){

  /**
   * Array of all the main sidebars registered in the theme
   */
  $sidebars_array = array(
    'sidebar-1'              => esc_html__( 'Sidebar', 'hestia' ),
    'subscribe-widgets'      => esc_html__( 'Subscribe', 'hestia' ),
    'blog-subscribe-widgets' => esc_html__( 'Blog Subscribe Section', 'hestia' ),
    'sidebar-woocommerce'    => esc_html__( 'WooCommerce Sidebar', 'hestia' ),
    'sidebar-top-bar'        => esc_html__( 'Very Top Bar', 'hestia' ),
    'header-sidebar'         => esc_html__( 'Navigation', 'hestia' ),
    'cta_right_widgets'      => esc_html__( 'Call to Action Right', 'hestia' ),
    'cta_left_widgets'       => esc_html__( 'Call to Action Left', 'hestia' ),
    'footer-bottom-widgets'  => esc_html__( 'Footer Bottom Bar', 'hestia' ),
    'footer-top-widgets'     => esc_html__( 'Footer Top Bar', 'hestia' ),
  );

  /**
   * Array of sidebars registered in the footer area.
   * The hestia_footer_widget_areas_array filter is used in the PRO version to add the extra forth sidebar.
   */
  $footer_sidebars_array = apply_filters(
    'hestia_footer_widget_areas_array', array(
      'footer-one-widgets'   => esc_html__( 'Footer One', 'hestia' ),
      'footer-two-widgets'   => esc_html__( 'Footer Two', 'hestia' ),
      'footer-three-widgets' => esc_html__( 'Footer Three', 'hestia' ),
      'footer-four-widgets' => esc_html__( 'Footer Four', 'hestia' ),

    )
  );

  /**
   * Number of footer sidebars that need to be registered.
   * This option is available only in the PRO version. In Hestia, the value is always 3.
   */
  $hestia_nr_footer_widgets = 4;


}
add_action( 'widgets_init', 'tfc_widget_init' );


function mychildtheme_enqueue_styles() {
    $parent_style = 'parent-style';

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style )
    );
    wp_enqueue_style( 'custom-theme-modmult',get_stylesheet_directory_uri() . '/modmult.css');
    wp_enqueue_style( 'custom-theme-blue',get_stylesheet_directory_uri() . '/modblue.css');   
    wp_enqueue_style( 'custom-theme-podium',get_stylesheet_directory_uri() . '/podium.css'); 
}
add_action( 'wp_enqueue_scripts', 'mychildtheme_enqueue_styles' );

add_action( 'hestia_before_features_section_hook', 'tfc_cta' );

add_action( 'hestia_before_footer_hook', 'tfc_footer_top' );

add_action( 'hestia_after_footer_hook', 'tfc_footer_bar' );

if (function_exists('register_sidebar')) {
register_sidebar(array(
'name' => 'CTA Left Widgets',
'id'   => 'cta-left-widgets',
'description'   => 'Left Widget in CTA Area',
));
register_sidebar(array(
'name' => 'CTA Right Widgets',
'id'   => 'cta-right-widgets',
'description'   => 'Right Widget in CTA Area',
));
register_sidebar(array(
'name' => 'Footer Bottom Bar',
'id'   => 'footer-bottom-widgets',
'description'   => 'Bottom Bar in Footer Area',
));
register_sidebar(array(
'name' => 'Footer Top Bar',
'id'   => 'footer-top-widgets',
'description'   => 'Top Bar in Footer Area',
));
register_sidebar(array(
'name' => 'Footer Four',
'id'   => 'footer-four-widgets',
'description'   => 'Widgets in Footer Area',
));

}

function tfc_scripts_method() {
    wp_enqueue_script(
        'custom-script',
        get_stylesheet_directory_uri() . '/js/tfc.js',
        array( 'jquery' )
    );
}

add_action( 'wp_enqueue_scripts', 'tfc_scripts_method' );

function tfc_footer_bar() {
  if ( is_active_sidebar( 'footer-bottom-widgets' ) ) : ?>
    <div class="footer-bar">
      <div class="container">
        <div class="widget-container">
        <?php dynamic_sidebar( 'footer-bottom-widgets' ); ?>
        </div>
      </div>
    </div>
  <?php endif; 
}

function tfc_footer_top() {
  if ( is_active_sidebar( 'footer-top-widgets' ) ) : ?>
    <div class="footer-top-bar">
      <div class="container">
        <div class="widget-container">
        <?php dynamic_sidebar( 'footer-top-widgets' ); ?>
        </div>
      </div>
    </div>
  <?php endif; 
}


function tfc_gtm_head(){
  ?>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-5RZSKM8');</script>
<!-- End Google Tag Manager -->
<?php }


add_action('wp_head', 'tfc_gtm_head');

function tfc_gtm_body(){
  ?>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5RZSKM8"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<?php }

add_action('hestia_before_header_hook', 'tfc_gtm_body');


function tfc_body_classes( $classes ) {
$tfc_color_setting  = get_theme_mod( 'tfc_color','tfc' );
    $classes[] = $tfc_color_setting;
  return $classes;
}

add_filter( 'body_class', 'tfc_body_classes' );

function tfc_customize_preview_js() {
    wp_enqueue_script( 'tfc_customizer_preview', get_stylesheet_directory_uri() . '/js/customizer-preview.js', array( 'customize-preview' ), null, true );
}
add_action( 'customize_preview_init', 'tfc_customize_preview_js' );
 

function tfc_customize_control_js() {
    wp_enqueue_script( 'tfc_customizer_control', get_stylesheet_directory_uri() . '/js/customizer-control.js', array( 'customize-controls', 'jquery' ), null, true );
}
add_action( 'customize_controls_enqueue_scripts', 'tfc_customize_control_js' );


function tfc_plugin_manager() {
  if ( ! is_admin() ) {
    return;
  }
require_once(ABSPATH . 'wp-admin/includes/plugin.php');
require_once(ABSPATH . 'wp-admin/includes/file.php');
if (file_exists(WP_PLUGIN_DIR . '/hello.php')){
  delete_plugins(array('hello.php'));
}
  /**
   * Include plugin manager class.
   *
   * No other includes are needed. The Tech_for_Campaigns_Plugin_Manager
   * class will handle including any other files needed.
   *
   * If you want to move the "plugin-manager" directory to
   * a different location within your child theme, that's
   * totally fine; just make sure you adjust this include
   * path to the plugin manager class accordingly.
   */
  require_once( get_theme_file_path( '/plugin-manager/class-tech-for-campaigns-plugin-manager.php' ) );

  // Setup suggested plugins.
  $plugins = array(
    array(
      'name'    => 'Content Views',
      'slug'    => 'content-views-query-and-display-post-page',
      'version' => '1.9+',
    ),
    array(
      'name'    => 'JetPack',
      'slug'    => 'jetpack',
      'version' => '5.0+',
    ),
    array(
      'name'    => 'Feed Them Social',
      'slug'    => 'feed-them-social',
      'version' => '2.2+',
    ),
    array(
      'name'    => 'Lightweight Social Icons',
      'slug'    => 'lightweight-social-icons',
      'version' => '1.0+',
    ),
    array(
      'name'    => 'Pixel Your Site',
      'slug'    => 'pixelyoursite',
      'version' => '5.0+',
    ),
  );

  /*
   * Setup optional arguments for plugin manager interface.
   *
   * See the set_args() method of the Tech_for_Campaigns_Plugin_Manager
   * class for full documentation on what you can pass in here.
   */
  $args = array(
    'page_title'  => __( 'Tech For Campaigns Suggested Plugins', 'tfc' ),
    'menu_slug'   => 'tfc-suggested-plugins',
    'child_theme' => true,
  );

  /*
   * Create plugin manager object, passing in the suggested
   * plugins and optional arguments.
   */
  $manager = new Tech_for_Campaigns_Plugin_Manager( $plugins, $args );

}
add_action( 'after_setup_theme', 'tfc_plugin_manager' );


if (!function_exists('write_log')) {
    function write_log ( $log )  {
        if ( true === WP_DEBUG ) {
            if ( is_array( $log ) || is_object( $log ) ) {
                error_log( print_r( $log, true ) );
            } else {
                error_log( $log );
            }
        }
    }
}

?>