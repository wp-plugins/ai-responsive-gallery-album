<?php

//wp_register_script( 'jquery.validate', AI_URL_PATH.'js/jquery.validate.js');

//wp_enqueue_script( 'jquery.validate' ); 



global $wpdb;



$ai_show_table_photos = $wpdb->prefix . "ai_photos";



$ai_check_photos_nonce=$_REQUEST['_wpnonce'];



if($_REQUEST['action'] == 'Edit')

{

	$ai_photo_res=$wpdb->get_results("select * from $ai_show_table_photos where photo_id='".$_REQUEST['id']."'",ARRAY_A);

	if(!empty($ai_photo_res[0]['photo_filename']))
	{
		$photo_file_thumb=AI_PHOTO_THUMB_URL_PATH.'/';
	
		$ai_photo_image =$ai_photo_res[0]['photo_filename'];
	
		$photo_name= explode('.',$ai_photo_res[0]['photo_filename']);
	
		$thub_photo_name=$photo_name[0].'-thumb'.'.'.$photo_name[1];
	}
	else
	{
		$photo_file_thumb=AI_URL_PATH.'/images/';
		$thub_photo_name='no_photo.jpg';
	}


}

if(isset($_REQUEST['Submit']) && $_REQUEST['Submit']=='Cancel')

{

	$location=admin_url().'admin.php?page=ai_listing_photos&album_id='.$_REQUEST['album_id'];

	echo'<script> window.location="'.$location.'"; </script> ';

}



if(wp_verify_nonce( $ai_check_photos_nonce, 'add-photos' ))

{

	if(isset($_REQUEST['Submit']) && $_REQUEST['Submit']=='Save' && $_REQUEST['Action']=='Add' )

	{

		if(isset($_FILES['photo_image']) && ($_FILES['photo_image']['size'] > 0)) 

		{

			// image upload

			if ( ! function_exists( 'wp_handle_upload' ) ) 

				require_once( ABSPATH . 'wp-admin/includes/file.php' );

			

			//replace non-word to - in file name

			$ai_with_space_name= explode('.',$_FILES['photo_image']['name']);

		    $ai_without_space_name = trim(preg_replace("/\W+/", "-", $ai_with_space_name[0]), "-");// \W = any "non-word" character

		    $_FILES['photo_image']['name']= $ai_without_space_name.'.'.$ai_with_space_name[1];

			

			//checking file exsit in uploaded folder or not.

			if(file_exists(AI_PHOTO_DIR_PATH.'/'.$_FILES['photo_image']['name']))

			{

			  $ai_photo_name = explode('.',$_FILES['photo_image']['name']);

			  $_FILES['photo_image']['name']=$ai_photo_name[0].'_'.generate_random_string().'.'.$ai_photo_name[1];

			}

			

			// Get the type of the uploaded file. This is returned as "type/extension"

			$ai_photo_file_type = wp_check_filetype(basename($_FILES['photo_image']['name']));

			$ai_photo_uploaded_file_type = $ai_photo_file_type['type'];

			

			$ai_photo_uploadedfile = $_FILES['photo_image'];

			$ai_photo_allowed_file_types = array('image/jpg','image/jpeg','image/gif','image/png');

			

			 // If the uploaded file is the right format

			if(in_array($ai_photo_uploaded_file_type, $ai_photo_allowed_file_types)) {

				$ai_photo_upload_overrides = array( 'test_form' => false );

				add_filter('upload_dir', 'ai_photo_upload_dir');

				$ai_photo_movefile = wp_handle_upload( $ai_photo_uploadedfile, $ai_photo_upload_overrides );

			}

		}

		$ai_photo_file = $ai_photo_movefile['file'];

		$ai_photo_file_thumb=AI_PHOTO_THUMB_DIR_PATH.'/';

		

		//Resize Image for generate thymbnails.

		$photo = wp_get_image_editor($ai_photo_file);

		

		if ( ! is_wp_error( $photo ) ) {

			$photo->resize( 200, 200, false );

			$photo->set_quality( 100 );

			$ai_photo_filename = $photo->generate_filename( 'thumb',$ai_photo_file_thumb, NULL );

			$ai_photo_saved_150=$photo->save($ai_photo_filename);

		}	

			

		// creating photo slug using it's title

		$ai_photo_slug = strtolower(strtolower($_REQUEST['photo_title']));

		$ai_photo_slug = preg_replace("/\W+/", "-", $ai_photo_slug); // \W = any "non-word" character

		$ai_photo_slug = trim($ai_photo_slug, "-");

        

		// checking photo slug exsit or not

		$res=$wpdb->get_results("select * from $ai_show_table_photos where photo_slug='".$ai_photo_slug."'");

		if(count($res) > 0)

		  $ai_photo_slug = $ai_photo_slug.'-'.generate_random_string();

		  

		//getting max photo order 

		$ai_photo_get_res = $wpdb->get_results("SELECT MAX(photo_order) as photo_max_order FROM $ai_show_table_photos where photo_album_id='".$_REQUEST['album_id']."'",ARRAY_A) ;

		$photoorder = 0;

		if(isset($ai_photo_get_res))

			$photoorder = $ai_photo_get_res[0]['photo_max_order'];	

			

		$photoorder += 1;

		

		//insert table data with user input

		$ai_photos_data=array(

						'photo_album_id'=>$_REQUEST['album_id'],

						'photo_title'=>$_REQUEST['photo_title'],

						'photo_date'=>date('Y-m-d'),

						'photo_filename'=>$_FILES['photo_image']['name'],

						'photo_slug'=>$ai_photo_slug,

						'photo_visible'=>$_REQUEST['photo_visible'],

						'photo_order'=>$photoorder

						);

		$wpdb->insert($ai_show_table_photos,$ai_photos_data);

		remove_filter('upload_dir', 'ai_photo_upload_dir');

		$location=admin_url().'admin.php?page=ai_listing_photos&album_id='.$_REQUEST['album_id'].'&photo_insert_success=1';

	    echo'<script> window.location="'.$location.'"; </script> ';

	}

	if(isset($_REQUEST['Submit']) && $_REQUEST['Submit']=='Update' && $_REQUEST['Action']=='Update' )

	{

		

		if(isset($_FILES['photo_image']) && ($_FILES['photo_image']['size'] > 0)) 

		{

			// image upload

			if ( ! function_exists( 'wp_handle_upload' ) ) require_once( ABSPATH . 'wp-admin/includes/file.php' );

			

			//replace non-word to - in file name

			$ai_with_space_name= explode('.',$_FILES['photo_image']['name']);

		    $ai_without_space_name = trim(preg_replace("/\W+/", "-", $ai_with_space_name[0]), "-");// \W = any "non-word" character

		    $_FILES['photo_image']['name']= $ai_without_space_name.'.'.$ai_with_space_name[1];

			

			//checking file exsit in uploaded folder or not.

			if(file_exists(AI_PHOTO_DIR_PATH.'/'.$_FILES['photo_image']['name']))

			{

			  $ai_photo_name = explode('.',$_FILES['photo_image']['name']);

			  $_FILES['photo_image']['name']=$ai_photo_name[0].'_'.generate_random_string().'.'.$ai_photo_name[1];

			}

						

			// Get the type of the uploaded file. This is returned as "type/extension"

			$ai_photo_file_type = wp_check_filetype(basename($_FILES['photo_image']['name']));

			$ai_photo_uploaded_file_type = $ai_photo_file_type['type'];

			

			$ai_photo_uploadedfile = $_FILES['photo_image'];

			$ai_photo_allowed_file_types = array('image/jpg','image/jpeg','image/gif','image/png');

			

			 // If the uploaded file is the right format

			 if(in_array($ai_photo_uploaded_file_type, $ai_photo_allowed_file_types)) {

				$ai_photo_upload_overrides = array( 'test_form' => false );

				

				add_filter('upload_dir', 'ai_photo_upload_dir');

				$ai_photo_movefile = wp_handle_upload( $ai_photo_uploadedfile, $ai_photo_upload_overrides );

			}

		}

		$ai_photo_file = $ai_photo_movefile['file'];

		$ai_photo_file_thumb=AI_PHOTO_THUMB_DIR_PATH.'/';

		

		//Resize Image for generate thymbnails.

		$photo = wp_get_image_editor($ai_photo_file);

		if ( ! is_wp_error( $photo ) ) {

			$photo->resize( 200, 200, false );

			$photo->set_quality( 100 );

			$ai_photo_filename = $photo->generate_filename( 'thumb',$ai_photo_file_thumb, NULL );

			$ai_photo_saved_150=$photo->save($ai_photo_filename);

			

		}		

		// creating photo slug using it's title

		$ai_photo_slug = strtolower(strtolower($_REQUEST['photo_title']));

		$ai_photo_slug = preg_replace("/\W+/", "-", $ai_photo_slug); // \W = any "non-word" character

		$ai_photo_slug = trim($ai_photo_slug, "-");

		

		// checking photo slug exsit or not

		$res=$wpdb->get_results("select * from $ai_show_table_photos where photo_slug='".$ai_photo_slug."'");

		if(count($res) > 0)

		  $ai_photo_slug = $ai_photo_slug.'-'.generate_random_string();

		

		//checking condition for userwant to update photo or not.

		if(isset($_FILES['photo_image']['name']))

		{

			$ai_photo=$_FILES['photo_image']['name'];

		}

		if($_FILES['photo_image']['name'] == '')

		{

			$ai_photo=$ai_photo_image;

		}

		

		//update table data with user input

		$ai_photos_data=array(

						'photo_album_id'=>$_REQUEST['album_id'],

						'photo_title'=>$_REQUEST['photo_title'],

						'photo_date'=>date('Y-m-d'),

						'photo_filename'=>$ai_photo,

						'photo_slug'=>$ai_photo_slug,

						'photo_visible'=>$_REQUEST['photo_visible'],

						);

			

		$wpdb->update($ai_show_table_photos,$ai_photos_data,array('photo_id'=>$_REQUEST['id']));

		remove_filter('upload_dir', 'ai_photo_upload_dir');

		$location=admin_url().'admin.php?page=ai_listing_photos&album_id='.$_REQUEST['album_id'].'&photo_update_success=1';

	    echo'<script> window.location="'.$location.'"; </script> ';

	}

	

}

function ai_photo_upload_dir($ai_photo_uploads) {

	$ai_photo_uploads['subdir']	= '/al_gallery_files/ai_photo_files';

	$ai_photo_uploads['path']		= $ai_photo_uploads['basedir'] . $ai_photo_uploads['subdir'];

	$ai_photo_uploads['url']		= $ai_photo_uploads['baseurl'] . $ai_photo_uploads['subdir'];

	return $ai_photo_uploads;

}

function generate_random_string($name_length = 4) {

	$alpha_numeric = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

	return substr(str_shuffle($alpha_numeric), 0, $name_length);

}

?>

<script type="text/javascript">

jQuery(document).ready(function() {	

	// validate Photo Form form on keyup and submit

	jQuery("#frmnewphoto").validate({

		rules: {

			photo_title: {

				required: true,

			},

			photo_image:{

				accept: "jpg|jpeg|png|gif"

		    }

		},

		messages: {

			photo_title: {

				required: "Please provide a Album Title",

			},

			photo_image:{

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

  <?php _e('Add New Photos For AI Gallery','aigallery'); ?>

  </span>

</h3>

<div class="inside">

<form method="post" name="frmnewphoto" id="frmnewphoto" enctype="multipart/form-data">

<table class="form-table">

  <?php $ai_photo_nonce = wp_create_nonce( 'add-photos' );?>

   <input type="hidden" name="_wpnonce" value="<?php echo esc_attr($ai_photo_nonce);?>"/>

    <tr>

      <td width="10%" nowrap="nowrap"><?php _e('Title','aigallery'); ?>

        <?php _e('*','aigallery'); ?></td>

      <td><input type="text" style="text-align:left;" value="<?php echo esc_attr($ai_photo_res[0]['photo_title']); ?>" maxlength="16" size="50" name="photo_title" id="photo_title" class="required"></td>

    </tr>

    <tr>

      <td nowrap="nowrap"><?php _e('Photo','aigallery'); ?></td>

      <td>

       <input type="file" size="30" value="" name="photo_image" id="photo_image"/>

        <div><img border="0" id="pic" src="<?php echo esc_url($photo_file_thumb.$thub_photo_name) ;?>"></div>

        <?php _e('Valid file format : .jpg|.jpeg|.png|.gif ','aigallery'); ?>

       </td>

    </tr>

    <tr>

      <td nowrap="nowrap"><?php _e('Active? ','aigallery'); ?></td>

      <td>

       <?php $ai_photo_visible=array('Yes'=>'1','No'=>'0'); ?>

       <select name="photo_visible" id="photo_visible">

       <?php

       foreach($ai_photo_visible as $ai_k=>$ai_v){?>

            <option value="<?php echo esc_attr($ai_v); ?>" <?php selected( $ai_v, $ai_photo_res[0]['photo_visible']);?> ><?php echo $ai_k; ?></option>

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

			$ai_button_value="Update";

			$action="Update";

		}

		else

		{

			$ai_button_value="Save";

			$action="Add";

		}

	  ?>

      <input type="submit" class="save button button-primary" value="<?php echo esc_attr($ai_button_value);?>" name="Submit">

        <input type="submit" class="cancel button button-primary" value="Cancel" name="Submit">

        <input type="hidden" value="<?php echo esc_attr($action);?>" name="Action">

        <input type="hidden" value="<?php echo esc_attr($ai_photo_res[0]['photo_date']); ?>" name="photo_date">

        <input type="hidden" value="<?php echo esc_attr($ai_photo_res[0]['photo_slug']); ?>" name="photo_slug">

        <input type="hidden" value="<?php echo esc_attr($ai_photo_res[0]['photo_id']); ?>" name="photo_id">

        <input type="hidden" value="<?php echo esc_attr($_REQUEST['album_id']); ?>" name="album_id">

      </td>

    </tr>

 </table>

</form>

</div>

</div>

</div>