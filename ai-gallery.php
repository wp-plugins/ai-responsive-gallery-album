<?php

/*

Plugin Name: AI Responsive Gallery Album (Gallery shortcode)

Plugin URI: http://www.augustinfotech.com

Description: AI Responsive Gallery Album for WordPress

Version: 1.2

Text Domain: aigallery

Author: August Infotech

Author URI: http://www.augustinfotech.com

*/

define('AI_DIR_PATH',plugin_dir_path(__FILE__ ));

define('AI_URL_PATH',plugin_dir_url(__FILE__ ));



$upload = wp_upload_dir();



define('AI_GALLERY_DIR_PATH',$upload['basedir']."/al_gallery_files");

define('AI_GALLERY_URL_PATH',$upload['baseurl']."/al_gallery_files");



define('AI_GALLERY_THUMB_DIR_PATH',$upload['basedir']."/al_gallery_files/al_gallery_thumb_files");

define('AI_GALLERY_THUMB_URL_PATH',$upload['baseurl']."/al_gallery_files/al_gallery_thumb_files");



define('AI_PHOTO_DIR_PATH',AI_GALLERY_DIR_PATH."/ai_photo_files");

define('AI_PHOTO_URL_PATH',AI_GALLERY_URL_PATH."/ai_photo_files");



define('AI_PHOTO_THUMB_DIR_PATH',AI_GALLERY_DIR_PATH."/ai_photo_files/al_photo_thumb_files");

define('AI_PHOTO_THUMB_URL_PATH',AI_GALLERY_URL_PATH."/ai_photo_files/al_photo_thumb_files");



add_action('plugins_loaded', 'ai_gallery_init');

/** Start Upgrade Notice **/
global $pagenow;
if ( 'plugins.php' === $pagenow )
{
    // Better update message
    $file   = basename( __FILE__ );
    $folder = basename( dirname( __FILE__ ) );
    $hook = "in_plugin_update_message-{$folder}/{$file}";
    add_action( $hook, 'update_gallery_notification_message', 20, 2 );
}
function update_gallery_notification_message( $plugin_data, $r )
{
    $data = file_get_contents( 'http://plugins.trac.wordpress.org/browser/ai-responsive-gallery-album/trunk/readme.txt?format=txt' );
	$upgradetext = stristr( $data, '== Upgrade Notice ==' );	
	$upgradenotice = stristr( $upgradetext, '*' );	
	$output = "<div style='color:#EEC2C1;font-weight: normal;background: #C92727;padding: 10px;border: 1px solid #eed3d7;border-radius: 4px;'><strong style='color:rgb(253, 230, 61)'>Update Notice : </strong> ".$upgradenotice."</div>";

    return print $output;
}
/** End Upgrade Notice **/


/* Activate Hook Plugin */

register_activation_hook(__FILE__,'ai_add_gallery_table');



/*Uninstall Hook Plugin */

if ( function_exists('register_uninstall_hook') )

  register_uninstall_hook(__FILE__,'ai_drop_gallery_table');   



require_once(AI_DIR_PATH.'album-shortcode.php');

/* Make Gallery in Admin Menu Item*/

add_action('admin_menu','ai_gallery_setting');



/* Make for changing order of album using drag and drop */

add_action('wp_ajax_ai_album_ajax_updateOrder', 'ai_ajax_albumupdateOrder_callback');



/* Make for changing order of photo using drag and drop */

add_action('wp_ajax_ai_photo_ajax_updateOrder', 'ai_ajax_photoupdateOrder_callback');





# Load the language files

function ai_gallery_init() 

{

	load_plugin_textdomain( 'aigallery', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

}

/*

 * Setup Admin menu item

*/

function ai_gallery_setting()

{

	add_menu_page('AI Gallery','AI Gallery','edit_plugins','ai_gallery','ai_listing_album',AI_URL_PATH.'images/augustinfotech.jpg',12);

	add_submenu_page('ai_gallery', 'Add Album', 'Add New Album','edit_plugins', 'ai_album', 'ai_add_new_album');

	add_submenu_page('', 'Photos', 'Photos','edit_plugins', 'ai_listing_photos', 'ai_listing_photos');

	add_submenu_page('', 'Add Photos', 'Add New Photos','edit_plugins', 'ai_new_photos', 'ai_add_new_photos');
	
	add_action( 'admin_enqueue_scripts', 'ai_admin_enqueue_scripts' );

	

	$al_gallery_files = AI_GALLERY_DIR_PATH;

	$al_gallery_thumb_files = AI_GALLERY_THUMB_DIR_PATH;

	$al_photo_files = AI_PHOTO_DIR_PATH;

	$al_photo_thumb_files = AI_PHOTO_THUMB_DIR_PATH;

	

	/* Create a directory for our gallery files */

	if (!file_exists($al_gallery_files))

    {

		umask(0); 

		mkdir($al_gallery_files, 0777, true) or die("error creating the folder" . $al_gallery_files . "check folder permissions");

		

		/* creating sub directory for our gallery thumb files */

		

		if (!file_exists($al_gallery_thumb_files))

		{

			umask(0); 

			mkdir($al_gallery_thumb_files, 0777, true) or die("error creating the folder" . $al_gallery_thumb_files . "check folder permissions");

			

		}

		if (!file_exists($al_photo_files))

		{

			umask(0); 

			mkdir($al_photo_files, 0777, true) or die("error creating the folder" . $al_photo_files . "check folder permissions");

			

		}

		if (!file_exists($al_photo_thumb_files))

		{

			umask(0); 

			mkdir($al_photo_thumb_files, 0777, true) or die("error creating the folder" . $al_photo_thumb_files . "check folder permissions");

			

		}

	}

}

function ai_add_gallery_table()

{

	global $wpdb;



	$ai_table_album = $wpdb->prefix . "ai_album";

	

	$ai_table_photos = $wpdb->prefix . "ai_photos";

	

	// upgrade function changed in WordPress 2.3

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');



    $ai_sql_album =  "CREATE TABLE IF NOT EXISTS $ai_table_album (

					  album_id tinyint NOT NULL AUTO_INCREMENT,

					  album_title varchar(50) NULL,

					  album_date date NULL,

					  album_cover_image varchar(255) NULL,

					  album_slug varchar(50) NULL,

					  album_visible int(4) NOT NULL DEFAULT '1',

					  album_order int(4) NOT NULL,

					  PRIMARY KEY (`album_id`)

					) ";

		

   dbDelta($ai_sql_album);

	

   $ai_sql_photos =  "CREATE TABLE IF NOT EXISTS $ai_table_photos (

					  photo_id int(4) NOT NULL AUTO_INCREMENT,

					  photo_album_id  int(4) NOT NULL,

					  photo_title varchar(50) NULL,

					  photo_date date NULL,

					  photo_filename varchar(255) NULL,

					  photo_slug varchar(50) NULL,

					  photo_visible int(4) NOT NULL DEFAULT '1',

					  photo_order int(4) NOT NULL,

					  PRIMARY KEY (`photo_id`)

					) ";



    dbDelta($ai_sql_photos);

}

function ai_drop_gallery_table()

{

    global $wpdb;

	

	$ai_table_album_drop = $wpdb->prefix . "ai_album";

	$ai_table_photos_drop = $wpdb->prefix . "ai_photos";

     

	$wpdb->query("DROP TABLE IF EXISTS ".$ai_table_album_drop);

	$wpdb->query("DROP TABLE IF EXISTS ".$ai_table_photos_drop);	

}

function ai_listing_album()

{

	include AI_DIR_PATH."/albumlist.php";

}

function ai_add_new_album()

{

	include AI_DIR_PATH."/newalbum.php";

}

function ai_listing_photos()

{

	include AI_DIR_PATH."/photolist.php";

}

function ai_add_new_photos()

{

	include AI_DIR_PATH."/newphoto.php";

}

function ai_ajax_albumupdateOrder_callback()

{

	global $wpdb;

	$ai_table_album = $wpdb->prefix . "ai_album";

	$ai_album_array_order = $_POST['recordsArray'];

	$ai_aibum_countr = count($ai_album_array_order);

	for($i=0;$i<$ai_aibum_countr; $i++)

	{

		$ai_album_orderid = $ai_album_array_order[$i];

		$ai_album_order= $i+1;

		$wpdb->query($wpdb->prepare("UPDATE $ai_table_album SET album_order='".$ai_album_order."' WHERE album_id = '".$ai_album_orderid."'"));

	}	

}

function ai_ajax_photoupdateOrder_callback()

{

	global $wpdb;

	$ai_table_photo = $wpdb->prefix . "ai_photos";

	$ai_photo_array_order = $_POST['recordsArray'];

	$ai_photo_countr = count($ai_photo_array_order);

	for($j=0;$j<$ai_photo_countr; $j++)

	{

		$ai_photo_orderid = $ai_photo_array_order[$j];

		$ai_photo_order= $j+1;

		$wpdb->query($wpdb->prepare("UPDATE $ai_table_photo SET photo_order='".$ai_photo_order."' WHERE photo_id = '".$ai_photo_orderid."'"));

	}	

}

function ai_admin_enqueue_scripts()
{
		
    $screen = get_current_screen();
	if($screen->id == 'toplevel_page_ai_gallery')
    {
		wp_register_script( 'jquery.validate', AI_URL_PATH.'js/jquery.validate.js');

        wp_enqueue_script( 'jquery.validate' ); 
	
	   wp_register_script( 'jquery.microgallery', AI_URL_PATH.'js/jquery.microgallery.js');

       wp_enqueue_script( 'jquery.microgallery' );
		
	}

}
?>