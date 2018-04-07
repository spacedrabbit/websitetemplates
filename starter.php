<?php
//create menu
add_action( 'after_switch_theme', 'tfc_make_top_menu',5 );
add_action( 'after_switch_theme', 'tfc_make_foot_menu',6 );
//manipulate blog/home pages
add_action( 'after_switch_theme', 'tfc_make_post',10 );
add_action( 'after_switch_theme', 'tfc_fix_blog',20 );
add_action( 'after_switch_theme', 'tfc_make_homepage',30 );
//make pages
add_action( 'after_switch_theme', 'tfc_make_sample_pages',40 );
add_action( 'after_switch_theme', 'tfc_make_donate_button',100 );
add_action( 'after_switch_theme', 'set_widgets',150 );

function tfc_make_post() {
    $post = get_page_by_path('hello-world',OBJECT,'post');
    if ($post){
        $my_post = array(
          'ID'           => $post->ID,
          'post_title'   => 'Everyone Loves This Candidate',
          'post_content' => 'This is a sample news story.',
          'post_status'   => 'publish',
      );

      wp_update_post( $my_post );
    }
}

function tfc_make_new_page($slug,$new_page_title,$new_page_content,$image,$menu,$foot_menu,$new_page_template){
    $page_check = get_page_by_title($new_page_title);   // Check if the page already exists
    $new_page = array(
            'post_type'     => 'page', 
            'post_title'    => $new_page_title,
            'post_content'  => $new_page_content,
            'post_status'   => 'publish',
            'post_author'   => 1,
            'post_slug'     => $slug
    );
    // If the page doesn't already exist, create it
    if(!isset($page_check->ID)){
        //make page
        $new_page_id = wp_insert_post($new_page);
        write_log($new_page_title . ' page is created ' . $new_page_id);
        //add featured image
        if(!empty($image)){
            tfc_add_image($new_page_id, $image);
        }else{
            write_log($new_page_title . ' no image'); 
        }
    }else{
        $new_page_id = $page_check->ID;
        write_log($new_page_title . ' exists, skipping'); 
    }
    //make menu item
    if($menu == 'TRUE'){
        tfc_make_menu_item($new_page_id, $new_page_title);
    }else{
        write_log($new_page_title . ' no menu'); 
    } 
    //make menu item
    if($foot_menu == 'TRUE'){
        tfc_make_foot_menu_item($new_page_id, $new_page_title);
    }else{
        write_log($new_page_title . ' no foot menu'); 
    }   
    //assign page template
    if(!empty($new_page_template)){
        update_post_meta($new_page_id, '_wp_page_template', $new_page_template);
    }
}

function tfc_make_sample_pages(){
    $file = get_stylesheet_directory() . '/assets/data/pages.csv';
    $pages = array_map('str_getcsv', file($file));
    array_walk($pages, function(&$a) use ($pages) {
      $a = array_combine($pages[0], $a);
    });
    array_shift($pages); # remove column header

    foreach ($pages as &$value) {
        $slug = $value['slug'];
        $new_page_title=$value['new_page_title'];
        $new_page_content=$value['new_page_content'];
        $image=$value['image'];
        $menu=$value['menu'];
        $foot_menu=$value['foot_menu'];
        $new_page_template=$value['new_page_template'];

        tfc_make_new_page($slug,$new_page_title,$new_page_content,$image,$menu,$foot_menu,$new_page_template);
    }
}


function tfc_make_top_menu() {
// Check if the menu exists
$menu_name = 'TFC Top Menu';
$menu_exists = wp_get_nav_menu_object( $menu_name );

// If it doesn't exist, let's create it.
if( !$menu_exists){
    write_log($menu_name . ' menu does not exist');
    $menu_id = wp_create_nav_menu($menu_name);
        write_log($menu_id . ' is menu id (created)');
    // Set up default menu items - HOME
    wp_update_nav_menu_item($menu_id, 0, array(
        'menu-item-title' =>  __('Home'),
        'menu-item-classes' => 'home',
        'menu-item-url' => home_url( '/' ), 
        'menu-item-status' => 'publish'));
    }else{
        write_log($menu_name . ' exists'); 
        $menu_header = get_term_by('name', $menu_name, 'nav_menu');
        if ( is_wp_error( $menu_header ) ) {
            // something went wrong
            write_log( $menu_header->get_error_message());
        }
        $menu_id = $menu_header->term_id;
    }
    $locations = get_theme_mod('nav_menu_locations');
    $locations['primary'] = $menu_id;
    set_theme_mod( 'nav_menu_locations', $locations );
    $locations = get_theme_mod('nav_menu_locations');
    write_log($locations);  
}

function tfc_make_foot_menu() {
// Check if the menu exists
$menu_name = 'TFC Footer Menu';
$menu_exists = wp_get_nav_menu_object( $menu_name );

// If it doesn't exist, let's create it.
if( !$menu_exists){
    write_log($menu_name . ' menu does not exist');
    $menu_id = wp_create_nav_menu($menu_name);
        write_log($menu_id . ' is menu id (created)');
    // Set up default menu items - HOME
    wp_update_nav_menu_item($menu_id, 0, array(
        'menu-item-title' =>  __('Home'),
        'menu-item-classes' => 'home',
        'menu-item-url' => home_url( '/' ), 
        'menu-item-status' => 'publish'));
    }else{
        write_log($menu_name . ' exists'); 
        $menu_header = get_term_by('name', $menu_name, 'nav_menu');
        if ( is_wp_error( $menu_header ) ) {
            // something went wrong
            write_log( $menu_header->get_error_message());
        }
        $menu_id = $menu_header->term_id;
    }
    $locations = get_theme_mod('nav_menu_locations');
    $locations['foot-menu'] = $menu_id;
    set_theme_mod( 'nav_menu_locations', $locations );
    $locations = get_theme_mod('nav_menu_locations');
    write_log($locations);  
}

function tfc_make_homepage(){

    $new_page_title     = __('Front Page',''); // Page's title
    $front_page_check = get_page_by_title($new_page_title);// Check if the page already exists

    if (!isset($front_page_check->ID)){//we don't have this page already
        $new_page_content   = '';                           // Content goes here
        $page_check = get_page_by_title('Sample Page');  //See if there's a Sample Page we can update 
        // Store the above data in an array
        $new_page = array(
                'post_type'     => 'page', 
                'post_title'    => $new_page_title,
                'post_content'  => $new_page_content,
                'post_status'   => 'publish',
                'post_author'   => 1,
        );
        // If the page doesn't already exist, create it
        if (!isset($page_check->ID)){//we don't have a Sample Page
            $new_page_id = wp_insert_post($new_page);
            write_log($new_page_title . ' page is created ' . $new_page_id);
        }else {
            wp_update_post( array( 
                'ID' => $page_check->ID, 
                'post_title'    => $new_page_title,
                'post_content'  => $new_page_content,'post_status'   => 'publish'
            )
        );
        }
    }
    $homepage = get_page_by_title( 'Front Page' ); 
    //even if Front Page already exists, let's make sure it's got the right settings
    if ( $homepage ){
        update_option( 'page_on_front', $homepage->ID );
        update_option( 'show_on_front', 'page' );
    }   
}

function tfc_fix_blog(){

    $new_page_title     = __('Latest News',''); // Page's title
    $page_check = get_page_by_title($new_page_title);// Check if the page already exists

    $blog_id = get_option( 'page_for_posts' );  //See if there's a blog page to remove 
    wp_delete_post($blog_id);

    if (!isset($page_check->ID)){//we don't have this page already
        tfc_make_new_page("news","Latest News","Page that shows posts","flag.jpg","TRUE","TRUE","");

    }
    $news = get_page_by_title($new_page_title);// get the page id
    //set the page as page for posts and make menu items
    if ( $news ){
        update_option( 'page_for_posts', $news->ID );
    } 

}

function tfc_make_menu_item($post_id, $title){
    // Check if the menu exists
    $menu_name = 'TFC Top Menu';
    $menu_exists = wp_get_nav_menu_object( $menu_name );
    $menu_header = get_term_by('name', $menu_name, 'nav_menu');
    if ( is_wp_error( $menu_header ) ) {
        // something went wrong
        write_log( $menu_header->get_error_message());
    }
    $menu_id = $menu_header->term_id;
    $css = '';
    if ($title == 'Get Involved'){
        $css="highlight2";
    }
    write_log($menu_id . ' menu id ' . $post_id);
    if( tfc_item_is_in_menu( $menu_id,$post_id ) ) {
        write_log( $menu_name . ' already has ' . $title);
        return;
    }
    if($menu_exists){
        write_log($menu_name . ' adding ' . $title);
        $page_name = $title;
        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => $title,
            'menu-item-object-id' => $post_id,
            'menu-item-object' => 'page',
            'menu-item-status' => 'publish',
            'menu-item-type' => 'post_type',
            'menu-item-classes' => $css,
        ));
    }
}

function tfc_make_foot_menu_item($post_id, $title){
    // Check if the menu exists
    $menu_name = 'TFC Footer Menu';
    $menu_exists = wp_get_nav_menu_object( $menu_name );
    $menu_header = get_term_by('name', $menu_name, 'nav_menu');
    if ( is_wp_error( $menu_header ) ) {
        // something went wrong
        write_log( $menu_header->get_error_message());
    }
    $menu_id = $menu_header->term_id;
    write_log($menu_id . ' menu id ' . $post_id);
    if( tfc_item_is_in_menu( $menu_id,$post_id ) ) {
        write_log( $menu_name . ' already has ' . $title);
        return;
    }
    if($menu_exists){
        write_log($menu_name . ' adding ' . $title);
        $page_name = $title;
        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => $title,
            'menu-item-object-id' => $post_id,
            'menu-item-object' => 'page',
            'menu-item-status' => 'publish',
            'menu-item-type' => 'post_type',
        ));
    }
}

function tfc_make_donate_button(){
    $menus = ['TFC Top Menu','TFC Footer Menu'];
    foreach ($menus as &$value) {
        $menu_name = $value;
        // Check if the menu exists
        $menu_exists = wp_get_nav_menu_object( $menu_name );
        $menu_header = get_term_by('name', $menu_name, 'nav_menu');
        if ( is_wp_error( $menu_header ) ) {
            // something went wrong
            write_log( $menu_header->get_error_message());
        }
        $menu_id = $menu_header->term_id;
        if($menu_exists){
            write_log($menu_name . ' adding donate button');
            wp_update_nav_menu_item($menu_id, 0, array(
                'menu-item-title' =>  __('Donate'),
                'menu-item-url' => '#', 
                'menu-item-classes'=> 'highlight',
                'menu-item-target' => '_new', 
                'menu-item-status' => 'publish'));


        }
    }
}
function tfc_item_is_in_menu( $menu = null, $object_id = null ) {

    // get menu object
    $menu_object = wp_get_nav_menu_items( esc_attr( $menu ) );

    // stop if there isn't a menu
    if( ! $menu_object )
        return false;

    // get the object_id field out of the menu object
    $menu_items = wp_list_pluck( $menu_object, 'object_id' );

    // use the current post if object_id is not specified
    if( !$object_id ) {
        global $post;
        $object_id = get_queried_object_id();
    }

    // test if the specified page is in the menu or not. return true or false.
    return in_array( (int) $object_id, $menu_items );

}

function tfc_add_image($post, $image){
    write_log('start image ' . $image . ' page is ' .  $post); 
    $file = get_stylesheet_directory() . '/assets/img/' . $image;
    $filename = basename($file);
    $upload_file = wp_upload_bits($filename, null, file_get_contents($file));

    if (!$upload_file['error']) {
        $wp_filetype = wp_check_filetype($filename, null );
        $attachment = array(
            'post_mime_type' => $wp_filetype['type'],
            'post_parent' => $post,
            'post_title' => preg_replace('/\.[^.]+$/', '', $filename),
            'post_content' => '',
            'post_status' => 'inherit'
        );
        $attachment_id = wp_insert_attachment( $attachment, $upload_file['file'], $post );
        set_post_thumbnail($post, $attachment_id);  
        write_log('Done ' . $image . ' page is ' .  $post);     
        if (!is_wp_error($attachment_id)) {
            require_once(ABSPATH . "wp-admin" . '/includes/image.php');
            $attachment_data = wp_generate_attachment_metadata( $attachment_id, $upload_file['file'] );
            wp_update_attachment_metadata( $attachment_id,  $attachment_data );
        }else {
            write_log('ERROR' . $post . ' page is ' . is_wp_error($attachment_id) . $upload_file['error']);
        }
    }else{
        write_log('ERROR' . $post . ' page is ' .  $upload_file['error']);
    }
}

function set_widgets(){

$active_sidebars = get_option( 'sidebars_widgets' ); //get all sidebars and widgets
write_log(print_r($active_sidebars,true));
$widget_options = get_option( 'recent-posts-1' );
$widget_options[1] = array( 'title' => '' );

if(isset($active_sidebars['footer-one-widgets']) && empty($active_sidebars['footer-one-widgets'])) { //check if sidebar exists and it is empty

    $active_sidebars['footer-one-widgets'] = array('recent-posts-1'); //add a widget to sidebar
    update_option('recent-posts-1', $widget_options); //update widget default options
    update_option('sidebars_widgets', $active_sidebars); //update sidebars
}
write_log(print_r($active_sidebars,true));
    
}
function custom_menu_order() {
    return array( 'index.php', 'edit.php', 'edit-comments.php' );
}

add_filter( 'custom_menu_order', '__return_true' );
add_filter( 'menu_order', 'custom_menu_order' );

?>