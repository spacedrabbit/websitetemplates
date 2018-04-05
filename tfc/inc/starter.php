<?php
//manipulate files
add_action( 'after_switch_theme', 'tfc_make_post',10 );
add_action( 'after_switch_theme', 'tfc_fix_blog',20 );
add_action( 'after_switch_theme', 'tfc_make_homepage',30 );
//pages
add_action( 'after_switch_theme', 'tfc_make_about_page',40 );
add_action( 'after_switch_theme', 'tfc_make_get_involved_page',50 );
add_action( 'after_switch_theme', 'tfc_make_priorities_page',60 );
add_action( 'after_switch_theme', 'tfc_make_events_page',70 );
//menus
add_action( 'after_switch_theme', 'tfc_make_menus',100 );

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

function tfc_make_about_page(){

    $new_page_title     = __('Meet Jill'); // Page's title
    $new_page_content   = 'She is just the best!';                           // Content goes here
    $new_page_template  = 'template-fullwidth.php';       // The template to use for the page
    $page_check = get_page_by_title($new_page_title);   // Check if the page already exists
    // Store the above data in an array
    $new_page = array(
            'post_type'     => 'page', 
            'post_title'    => $new_page_title,
            'post_content'  => $new_page_content,
            'post_status'   => 'publish',
            'post_author'   => 1,
            'post_slug'     => 'about'
    );
    // If the page doesn't already exist, create it
    if(!isset($page_check->ID)){
        $image = 'flag.jpg';
        $new_page_id = wp_insert_post($new_page);
        write_log($new_page_title . ' page is created ' . $new_page_id);
        tfc_add_image($new_page_id, $image);
        write_log($new_page_title . ' created'); 
        if(!empty($new_page_template)){
            update_post_meta($new_page_id, '_wp_page_template', $new_page_template);
        }
        }else{
            write_log($new_page_title . ' exists, skipping'); 
    }
}

function tfc_make_get_involved_page(){

    $new_page_title     = __('Get Involved'); // Page's title
    $new_page_content   = 'Add a form or other content. [fts_facebook type=events id=techforcampaigns posts=6]';                           // Content goes here
    $new_page_template  = 'template-fullwidth.php';       // The template to use for the page
    $page_check = get_page_by_title($new_page_title);   // Check if the page already exists
    // Store the above data in an array
    $new_page = array(
            'post_type'     => 'page', 
            'post_title'    => $new_page_title,
            'post_status'   => 'publish',
            'post_author'   => 1,
            'post_slug'     => 'get-involved'
    );
    // If the page doesn't already exist, create it
    if(!isset($page_check->ID)){
       $image = 'flag2.jpg';
        $new_page_id = wp_insert_post($new_page);
        write_log($new_page_title . ' page is created ' . $new_page_id);
        tfc_add_image($new_page_id, $image);
        if(!empty($new_page_template)){
            update_post_meta($new_page_id, '_wp_page_template', $new_page_template);
        }
        }else{
            write_log($new_page_title . ' exists, skipping'); 
    }
}

function tfc_make_events_page(){

    $new_page_title     = __('Events'); // Page's title
    $new_page_content   = 'Make a feed from your facebook events page, using the Feed Them Social plugin. 
    [fts_facebook type=events id=techforcampaigns posts=6]';                           // Content goes here
    $new_page_template  = 'template-fullwidth.php';       // The template to use for the page
    $page_check = get_page_by_title($new_page_title);   // Check if the page already exists
    // Store the above data in an array
    $new_page = array(
            'post_type'     => 'page', 
            'post_title'    => $new_page_title,
            'post_status'   => 'publish',
            'post_author'   => 1,
            'post_slug'     => 'events'
    );
    // If the page doesn't already exist, create it
    if(!isset($page_check->ID)){
       $image = 'flag.jpg';
        $new_page_id = wp_insert_post($new_page);
        write_log($new_page_title . ' page is created ' . $new_page_id);
        tfc_add_image($new_page_id, $image);
        if(!empty($new_page_template)){
            update_post_meta($new_page_id, '_wp_page_template', $new_page_template);
        }
        }else{
            write_log($new_page_title . ' exists, skipping'); 
    }
}

function tfc_make_priorities_page(){

    $new_page_title     = __('Priorities'); // Page's title
    $new_page_content   = 'Talk about the issues here';                           // Content goes here
    $page_check = get_page_by_title($new_page_title);   // Check if the page already exists
    // Store the above data in an array
    $new_page = array(
            'post_type'     => 'page', 
            'post_title'    => $new_page_title,
            'post_status'   => 'publish',
            'post_author'   => 1,
            'post_slug'     => 'priorities'
    );
    // If the page doesn't already exist, create it
    if(!isset($page_check->ID)){
        $image = 'vote.jpg';
        $new_page_id = wp_insert_post($new_page);
        write_log($new_page_title . ' page is created ' . $new_page_id);
        tfc_add_image($new_page_id, $image);
        write_log($new_page_title . ' created'); 
        }else{
            write_log($new_page_title . ' exists, skipping'); 
    }
}

function tfc_make_menus() {
// Check if the menu exists
$menu_name = 'TFC Top Menu';
$menu_exists = wp_get_nav_menu_object( $menu_name );

// If it doesn't exist, let's create it.
if( !$menu_exists){
    write_log($menu_name . ' menu does not exist');
    $menu_id = wp_create_nav_menu($menu_name);
    // Set up default menu items - HOME
    wp_update_nav_menu_item($menu_id, 0, array(
        'menu-item-title' =>  __('Home'),
        'menu-item-classes' => 'home',
        'menu-item-url' => home_url( '/' ), 
        'menu-item-status' => 'publish'));
    //ABOUT
    $about_name = 'Meet Jill';
    $about_page = get_page_by_title($about_name);
    if(!isset($about_page->ID)){
        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => $about_name,
            'menu-item-object-id' => $about_page->ID,
            'menu-item-object' => 'page',
            'menu-item-status' => 'publish',
            'menu-item-type' => 'post_type',
        ));
    }else{
      write_log('no about');  
    }

    //NEWS
    $news_page = 'Latest News';
    $blog_id = get_option( 'page_for_posts' );
    if(!isset($blog_id->ID)){
        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => $news_page,
            'menu-item-object-id' => $blog_id,
            'menu-item-object' => 'page',
            'menu-item-status' => 'publish',
            'menu-item-type' => 'post_type',
        ));
    }else{
      write_log('no news');  
    }

    //PRIORITIES
    $priorities_name = 'Priorities';
    $priorities_page = get_page_by_title($priorities_name);
    if(!isset($priorities_page->ID)){
        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => $priorities_name,
            'menu-item-object-id' => $priorities_page->ID,
            'menu-item-object' => 'page',
            'menu-item-status' => 'publish',
            'menu-item-type' => 'post_type',
        ));
    }else{
      write_log('no priorities');  
    }

    //EVENTS
    $events_name = 'Events';
    $events_page = get_page_by_title($events_name);
    if(!isset($events_page->ID)){
        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => $events_name,
            'menu-item-object-id' => $events_page->ID,
            'menu-item-object' => 'page',
            'menu-item-status' => 'publish',
            'menu-item-type' => 'post_type',
        ));
    }else{
      write_log('no events');  
    }

    //GET INVOLVED
    $involved_name = 'Get Involved';
    $involved_page = get_page_by_title($involved_name);
    if(!isset($involved_page->ID)){
        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => $involved_name,
            'menu-item-object' => 'page',
            'menu-item-object-id' => $involved_page->ID,
            'menu-item-classes'=> 'highlight2',
            'menu-item-status' => 'publish',
            'menu-item-type' => 'post_type',
        ));
    }else{
      write_log('no get involved');  
    }

    //DONATE
    wp_update_nav_menu_item($menu_id, 0, array(
        'menu-item-title' =>  __('Donate'),
        'menu-item-url' => '#', 
        'menu-item-classes'=> 'highlight',
        'menu-item-target' => '_new', 
        'menu-item-status' => 'publish'));

    $menu_header = get_term_by('name', 'TFC Top Menu', 'nav_menu');
    $menu_header_id = $menu_header->term_id;
    $locations = get_theme_mod('nav_menu_locations');
    $locations['primary'] = $menu_header_id;
    set_theme_mod( 'nav_menu_locations', $locations );


    }else{
       write_log($menu_name . ' exists, skipping'); 
    }

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
                'post_slug'     => 'get-involved'
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
$blog_id = get_option( 'page_for_posts' );
write_log($blog_id . ' blog page');

$blog_page = array(
        'ID' => $blog_id,
        'post_title' => 'Latest News',
        'post_slug' => 'news'
    );
$blog_page_update = wp_update_post( $blog_page );
write_log($blog_page_update . ' blog page');
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
        write_log('Done' . $image . ' page is ' .  $post);     
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

?>