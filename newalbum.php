<?php

global $wpdb;

$ai_show_table_album = $wpdb->prefix . "ai_album";

$ai_check_album_nonce=$_REQUEST['_wpnonce'];



if($_REQUEST['action'] == 'Edit')

{

	$ai_edit_res=$wpdb->get_results("select * from $ai_show_table_album where album_id='".$_REQUEST['id']."'",ARRAY_A);

	if(!empty($ai_edit_res[0]['album_cover_image']))
	{
		$ai_file_thumb=AI_GALLERY_THUMB_URL_PATH.'/';
	
		$ai_album_cover =$ai_edit_res[0]['album_cover_image'];
	
		$album_name= explode('.',$ai_edit_res[0]['album_cover_image']);
	
		$thub_album_name=$album_name[0].'-thumb'.'.'.$album_name[1];
	}
	else
	{
		$ai_file_thumb=AI_URL_PATH.'/images/';
		$thub_album_name='no_photo.jpg';
	}

}



if(isset($_REQUEST['Submit']) && $_REQUEST['Submit']=='Cancel')

{

	$location=admin_url().'admin.php?page=ai_gallery';

	echo'<script> window.location="'.$location.'"; </script> ';

}



if(wp_verify_nonce( $ai_check_album_nonce, 'add-album' ))

{

	if(isset($_REQUEST['Submit']) && $_REQUEST['Submit']=='Save' && $_REQUEST['Action']=='Add' )

	{

		if(isset($_FILES['album_image']) && ($_FILES['album_image']['size'] > 0)) 

		{

			// image upload

			if ( ! function_exists( 'wp_handle_upload' ) )

			  require_once( ABSPATH . 'wp-admin/includes/file.php' );

			

			//replace non-word to - in file name

			$ai_with_space_album= explode('.',$_FILES['album_image']['name']);

		    $ai_without_space_album = trim(preg_replace("/\W+/", "-", $ai_with_space_album[0]), "-");// \W = any "non-word" character

		    $_FILES['album_image']['name']= $ai_without_space_album.'.'.$ai_with_space_album[1];

			

			//checking file exsit in uploaded folder or not.

			if(file_exists(AI_GALLERY_DIR_PATH.'/'.$_FILES['album_image']['name']))

			{

			  $ai_album_name = explode('.',$_FILES['album_image']['name']);

			  $_FILES['album_image']['name']=$ai_album_name[0].'_'.generate_random_string().'.'.$ai_album_name[1];

			}

			

            // Get the type of the uploaded file. This is returned as "type/extension"

			$ai_arr_file_type = wp_check_filetype(basename($_FILES['album_image']['name']));

			$ai_uploaded_file_type = $ai_arr_file_type['type'];

			

			$ai_uploadedfile = $_FILES['album_image'];

			$ai_allowed_file_types = array('image/jpg','image/jpeg','image/gif','image/png');

			

			 // If the uploaded file is the right format

			if(in_array($ai_uploaded_file_type, $ai_allowed_file_types)) {

				$ai_upload_overrides = array( 'test_form' => false );

				add_filter('upload_dir', 'ai_upload_dir');

				$ai_add_movefile = wp_handle_upload( $ai_uploadedfile, $ai_upload_overrides );

			}

		}

		$ai_add_file = $ai_add_movefile['file'];

		$ai_add_file_thumb=AI_GALLERY_THUMB_DIR_PATH.'/';

		$ai_add_image = wp_get_image_editor($ai_add_file);

		

		//Resize Image for generate thymbnails.

		if ( ! is_wp_error( $ai_add_image ) ) {

			$ai_add_image->resize( 200, 200, false );

			$ai_add_image->set_quality( 100 );

			$ai_add_filename = $ai_add_image->generate_filename( 'thumb',$ai_add_file_thumb, NULL );

			$ai_saved_thumb=$ai_add_image->save($ai_add_filename);

			

		}		

		// creating album slug using it's title

		$ai_album_slug = strtolower(strtolower($_REQUEST['album_title']));

		$ai_album_slug = preg_replace("/\W+/", "-", $ai_album_slug); // \W = any "non-word" character

		$ai_album_slug = trim($ai_album_slug, "-");

        
		// checking album title exsit or not

		$res=$wpdb->get_results("select * from $ai_show_table_album where album_title='".$_REQUEST['album_title']."'");

		if(count($res) > 0)

		  $_REQUEST['album_title'] = $_REQUEST['album_title'].'-'.generate_random_string();
		
		
		
		// checking album slug exsit or not

		$res=$wpdb->get_results("select * from $ai_show_table_album where album_slug='".$ai_album_slug."'");

		if(count($res) > 0)

		  $ai_album_slug = $ai_album_slug.'-'.generate_random_string();

		  

		//getting max album order

		$ai_album_get_res = $wpdb->get_results("SELECT MAX(album_order) as album_max_order FROM $ai_show_table_album",ARRAY_A) ;

		$ai_albumorder = 0;

		if(isset($ai_album_get_res))

			$ai_albumorder = $ai_album_get_res[0]['album_max_order'];	

			

		$ai_albumorder += 1;

		

		//insert table data with user input

		$ai_album_data=array(

						'album_title'=>$_REQUEST['album_title'],

						'album_date'=>date('Y-m-d'),

						'album_cover_image'=>$_FILES['album_image']['name'],

						'album_slug'=>$ai_album_slug,

						'album_visible'=>$_REQUEST['album_visible'],

						'album_order'=>$ai_albumorder

						);

		$wpdb->insert($ai_show_table_album,$ai_album_data);

		remove_filter('upload_dir', 'ai_upload_dir');

		$location=admin_url().'admin.php?page=ai_gallery&album_insert_success=1';

	    echo'<script> window.location="'.$location.'"; </script> ';

	}

	

	if(isset($_REQUEST['Submit']) && $_REQUEST['Submit']=='Update' && $_REQUEST['Action']=='Update' )

	{

		if(isset($_FILES['album_image']) && ($_FILES['album_image']['size'] > 0)) 

		{

			// image upload

			if ( ! function_exists( 'wp_handle_upload' ) )

				 require_once( ABSPATH . 'wp-admin/includes/file.php' );



			//replace non-word to - in file name

			$ai_with_space_album= explode('.',$_FILES['album_image']['name']);

		    $ai_without_space_album = trim(preg_replace("/\W+/", "-", $ai_with_space_album[0]), "-");// \W = any "non-word" character

		    $_FILES['album_image']['name']= $ai_without_space_album.'.'.$ai_with_space_album[1];

			

			//checking file exsit in uploaded folder or not.

			if(file_exists(AI_GALLERY_DIR_PATH.'/'.$_FILES['album_image']['name']))

			{

			  $ai_album_name = explode('.',$_FILES['album_image']['name']);

			  $_FILES['album_image']['name']=$ai_album_name[0].'_'.generate_random_string().'.'.$ai_album_name[1];

			}

			

			// Get the type of the uploaded file. This is returned as "type/extension"

			$ai_arr_file_type = wp_check_filetype(basename($_FILES['album_image']['name']));

			$ai_uploaded_file_type = $ai_arr_file_type['type'];

			

			$ai_uploadedfile = $_FILES['album_image'];

			$ai_allowed_file_types = array('image/jpg','image/jpeg','image/gif','image/png');

			

			 // If the uploaded file is the right format

			if(in_array($ai_uploaded_file_type, $ai_allowed_file_types)) {

				$ai_upload_overrides = array( 'test_form' => false );

				add_filter('upload_dir', 'ai_upload_dir');

				$ai_edit_movefile = wp_handle_upload( $ai_uploadedfile, $ai_upload_overrides );

			}

		}

		

		$ai_edit_file = $ai_edit_movefile['file'];

		$ai_edit_file_thumb=AI_GALLERY_THUMB_DIR_PATH.'/';

		

		//Resize Image for generate thymbnails.

		$ai_edit_image = wp_get_image_editor($ai_edit_file);

		if ( ! is_wp_error( $ai_edit_image ) ) {

			$ai_edit_image->resize( 200, 200, false );

			$ai_edit_image->set_quality( 100 );

			$ai_edit_filename = $ai_edit_image->generate_filename( 'thumb',$ai_edit_file_thumb, NULL );

			$ai_edit_saved_thumb=$ai_edit_image->save($ai_edit_filename);

			

		}		

		// creating album slug using it's title

		$ai_album_slug = strtolower(strtolower($_REQUEST['album_title']));

		$ai_album_slug = preg_replace("/\W+/", "-", $ai_album_slug); // \W = any "non-word" character

		$ai_album_slug = trim($ai_album_slug, "-");

        
        // checking album title exsit or not

		$res=$wpdb->get_results("select album_title from $ai_show_table_album where album_title='".$_REQUEST['album_title']."' and album_id='".$_REQUEST['album_id']."'");
		if(count($res) < 1)
        {
			$allres=$wpdb->get_results("select album_title from $ai_show_table_album where album_title='".$_REQUEST['album_title']."'");
		    if(count($allres) > 0)
			   $_REQUEST['album_title'] = $_REQUEST['album_title'].'-'.generate_random_string();
		}
		
		
		// checking album slug exsit or not

		$res=$wpdb->get_results("select * from $ai_show_table_album where album_slug='".$ai_album_slug."'");

		if(count($res) > 0)

		  $ai_album_slug = $ai_album_slug.'-'.generate_random_string();

		  

		//checking condition for userwant to update photo or not.

		if(isset($_FILES['album_image']['name']))

		{

			$album_cover_image=$_FILES['album_image']['name'];

		}

		if($_FILES['album_image']['name'] == '')

		{

			$album_cover_image=$ai_album_cover;

		}

		

		//update table data with user input

		$ai_album_data=array(

						'album_title'=>$_REQUEST['album_title'],

						'album_date'=>date('Y-m-d'),

						'album_cover_image'=>$album_cover_image,

						'album_slug'=>$ai_album_slug,

						'album_visible'=>$_REQUEST['album_visible'],

						);

			

		$wpdb->update($ai_show_table_album,$ai_album_data,array('album_id'=>$_REQUEST['album_id']));

		remove_filter('upload_dir', 'ai_upload_dir');

		$location=admin_url().'admin.php?page=ai_gallery&album_update_success=1';

	    echo'<script> window.location="'.$location.'"; </script> ';

	}

	

}

function ai_upload_dir($upload) {

	$upload['subdir']	= '/al_gallery_files';

	$upload['path']		= $upload['basedir'] . $upload['subdir'];

	$upload['url']		= $upload['baseurl'] . $upload['subdir'];

	return $upload;

}

function generate_random_string($name_length = 4) {

	$alpha_numeric = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

	return substr(str_shuffle($alpha_numeric), 0, $name_length);

}

?>

<script type="text/javascript">

jQuery(document).ready(function() {	

	// validate Album Form form on keyup and submit

	jQuery("#frmnewalbum").validate({

		rules: {

			album_title: {

				required: true,

			},

			album_image:{

				accept: "jpg|jpeg|png|gif"

		    }

		},

		messages: {

			album_title: {

				required: "Please provide a Album Title",

			},

			album_image:{

				accept: "only .jpg,.jpeg,.png and .gif files are allowed",

			}

		}

	});

});

</script>

<div class="wrap">

<br />

<div id="poststuff" class="postbox">

<h3 class="hndle"><span>

  <?php _e('Add New Album For AI Gallery','aigallery'); ?>

</h2>

</span>

</h3>

<div class="inside">

<form method="post" name="frmnewalbum" id="frmnewalbum" enctype="multipart/form-data">

<table class="form-table">

  <?php $ai_album_nonce = wp_create_nonce( 'add-album' );?>

   <input type="hidden" name="_wpnonce" value="<?php echo esc_attr($ai_album_nonce);?>"/>

    <tr>

      <td width="10%" nowrap="nowrap"><?php _e('Title','aigallery'); ?>

        <?php _e('*','aigallery'); ?></td>

      <td><input type="text" style="text-align:left;" value="<?php echo esc_attr($ai_edit_res[0]['album_title']); ?>" maxlength="16" size="50" name="album_title" id="album_title" class="required"></td>

    </tr>

    <tr>

      <td nowrap="nowrap"><?php _e('Album Cover Image','aigallery'); ?></td>

      <td>

       <input type="file" size="30" value="" name="album_image" id="album_image">

        <div><img border="0" id="pic" src="<?php echo esc_url($ai_file_thumb.$thub_album_name) ;?>"></div>

        <?php _e('Valid file format : .jpg|.jpeg|.png|.gif ','aigallery'); ?>

       </td>

    </tr>

    <tr>

      <td nowrap="nowrap"><?php _e('Active? ','aigallery'); ?></td>

      <td>

       <?php $ai_visible=array('Yes'=>'1','No'=>'0'); ?>

       <select name="album_visible" id="album_visible">

       <?php

       foreach($ai_visible as $ai_k=>$ai_v){?>

            <option value="<?php echo esc_attr($ai_v); ?>" <?php selected( $ai_v, $ai_edit_res[0]['album_visible']);?> ><?php echo $ai_k; ?></option>

            <?php } ?>

        </select></td>

    </tr>

    <tr>

    	<td nowrap="nowrap">&nbsp;</td>

      <td align="left">

      <span style="float:right; color:#CB2001">

      <?php _e('Fields marked with','aigallery'); ?>

        (

        <?php _e('*','aigallery'); ?>

        )

        <?php _e('are mandatory.','aigallery'); ?>

        </span>

      <?php

	    if(isset($_REQUEST['action']) && $_REQUEST['action']='Edit')

		{

			$button_value="Update";

			$action="Update";

		}

		else

		{

			$button_value="Save";

			$action="Add";

		}

	  ?>

        <input type="submit" class="save button button-primary" value="<?php echo esc_attr($button_value);?>" name="Submit">

        <input type="submit" class="cancel button button-primary" value="Cancel" name="Submit">

        <input type="hidden" value="<?php echo esc_attr($action);?>" name="Action">

        <input type="hidden" value="<?php echo esc_attr($ai_edit_res[0]['album_date']); ?>" name="album_date">

        <input type="hidden" value="<?php echo esc_attr($ai_edit_res[0]['album_slug']); ?>" name="album_slug">

        <input type="hidden" value="<?php echo esc_attr($ai_edit_res[0]['album_id']); ?>" name="album_id">

      </td>

    </tr>

</table>

</form>

</div>

</div>

</div>