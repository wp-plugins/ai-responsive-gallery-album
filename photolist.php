<?php

wp_register_script( 'photolist', AI_URL_PATH.'js/photolist.js');

wp_enqueue_script( 'photolist' );

wp_enqueue_script('jquery-ui-sortable');

wp_enqueue_style('aigalley', AI_URL_PATH.'css/ai-gallery.css');



global $wpdb;

$ai_show_table_album = $wpdb->prefix . "ai_album";

$ai_show_table_photos = $wpdb->prefix . "ai_photos";



if($_REQUEST['action'] == 'Delete')

{  

	$ai_photo_get_image=$wpdb->get_results("SELECT photo_filename from $ai_show_table_photos WHERE photo_id = '".$_REQUEST['photoid']."' and photo_album_id = '".$_REQUEST['albumid']."'",ARRAY_A);



	if(file_exists(AI_PHOTO_DIR_PATH.'/'.$ai_photo_get_image[0]['photo_filename'])){

		@unlink(AI_PHOTO_DIR_PATH.'/'.$ai_photo_get_image[0]['photo_filename']);

	}

	

	$ai_photo_thumb_name= explode('.',$ai_photo_get_image[0]['photo_filename']);

	$ai_thumb_photo_name=$ai_photo_thumb_name[0].'-thumb'.'.'.$ai_photo_thumb_name[1];	

	

	if(file_exists(AI_PHOTO_THUMB_DIR_PATH.'/'.$ai_thumb_photo_name)){

		@unlink(AI_PHOTO_THUMB_DIR_PATH.'/'. $ai_thumb_photo_name);

	}

	

	$wpdb->query($wpdb->prepare("DELETE FROM $ai_show_table_photos WHERE photo_id = '".$_REQUEST['photoid']."'"));

	$location=admin_url().'admin.php?page=ai_listing_photos&photo_delete_success=1&album_id='.$_REQUEST['albumid'];	

	echo'<script> window.location="'.$location.'"; </script> ';	 

}

if($_REQUEST['action'] == 'Disable')

{  

	$wpdb->query($wpdb->prepare("UPDATE $ai_show_table_photos SET photo_visible=0 WHERE photo_id = '".$_REQUEST['photoid']."'"));

	$location=admin_url().'admin.php?page=ai_listing_photos&photo_disable_success=1&album_id='.$_REQUEST['albumid'];

	echo'<script> window.location="'.$location.'"; </script> ';	 	 

}

if($_REQUEST['action'] == 'Enable')

{  

	$wpdb->query($wpdb->prepare("UPDATE $ai_show_table_photos SET photo_visible=1 WHERE photo_id = '".$_REQUEST['photoid']."'"));

	$location= admin_url().'admin.php?page=ai_listing_photos&photo_enable_success=1&album_id='.$_REQUEST['albumid'];

	echo'<script> window.location="'.$location.'"; </script> ';	 

}

if($_REQUEST['Action'] == 'EnableDisableSelected')

{  

    $edittable=$_POST['selector'];

	$params = join(',', $edittable);

	$wpdb->query($wpdb->prepare("UPDATE $ai_show_table_photos SET photo_visible='".$_POST['visible']."' WHERE photo_id IN ($params)"));

	if($_POST['visible'] == '1')

	{

		$location= admin_url().'admin.php?page=ai_listing_photos&photo_enable_success=1&album_id='.$_REQUEST['albumid'];

		echo'<script> window.location="'.$location.'"; </script> ';	 

	}

	if($_POST['visible'] == '0')

	{

		$location= admin_url().'admin.php?page=ai_listing_photos&photo_disable_success=1&album_id='.$_REQUEST['albumid'];

		echo'<script> window.location="'.$location.'"; </script> ';	 

	}

}

if ($_REQUEST['Action'] == 'DeleteSelected') 

{

	$edittable=$_POST['selector'];

	$params = join(',', $edittable);

	

	//unlink photo image from uploaded path

	$ai_photo_get_image=$wpdb->get_results("SELECT photo_filename from $ai_show_table_photos WHERE photo_id IN ($params)",ARRAY_A);



	foreach($ai_photo_get_image as $photo_key => $photo_val)

	{

		if(file_exists(AI_PHOTO_DIR_PATH.'/'.$photo_val['photo_filename'])){

			@unlink(AI_PHOTO_DIR_PATH.'/'.$photo_val['photo_filename']);

		}

		

		$ai_photo_thumb_name= explode('.',$photo_val['photo_filename']);

		$ai_thumb_photo_name=$ai_photo_thumb_name[0].'-thumb'.'.'.$ai_photo_thumb_name[1];	

		

		if(file_exists(AI_PHOTO_THUMB_DIR_PATH.'/'.$ai_thumb_photo_name)){

			@unlink(AI_PHOTO_THUMB_DIR_PATH.'/'. $ai_thumb_photo_name);

		}

	}

	

	$wpdb->query(

	$wpdb->prepare("DELETE FROM $ai_show_table_photos

				  WHERE photo_id IN ($params)"));

				  

	 $location=admin_url().'admin.php?page=ai_listing_photos&photo_delete_success=1&album_id='.$_REQUEST['albumid'];

	 echo'<script> window.location="'.$location.'"; </script> ';				  

}



$res=$wpdb->get_results("select * from $ai_show_table_photos where photo_album_id='".$_REQUEST['album_id']."' ORDER BY photo_order ASC ");

$ai_album_name=$wpdb->get_results("select album_title from $ai_show_table_album where album_id='".$_REQUEST['album_id']."'",ARRAY_A);

?>

<div class="wrap">

<h2>

 <img src="<?php echo AI_URL_PATH.'images/augustinfotech-logo.jpg'?>" class="icon32" />

 <?php _e("AI Responsive Gallery Album","ai-gallery");?> <a class="add-new-h2" href="<?php echo admin_url().'admin.php?page=ai_new_photos&album_id='.$_REQUEST['album_id']?>">+ Add New Photos</a> <a class="add-new-h2" href="<?php echo admin_url().'admin.php?page=ai_gallery'?>">&laquo; Back To Albums</a>

</h2>

<br />

<div id="poststuff" class="postbox">

<h3 class="hndle"><img src="<?php echo AI_URL_PATH.'images/man_gal.png'?>"/>

<span>

  <?php _e("Manage Photos Of ","ai-gallery"); echo $ai_album_name[0]['album_title'];?>

</span>

</h3>

<div class="inside">  

<?php

         if(isset($_GET['photo_insert_success']) && $_GET['photo_insert_success']==1)

		 {

			 echo "<div class=update-nag style=background-color:#278AB7;color:#FFF;margin-bottom:5px;><strong>Photo Inserted Successfully.</strong></div>";

		 }

		 if(isset($_GET['photo_update_success']) && $_GET['photo_update_success']==1)

		 {

			 echo "<div class=update-nag style=background-color:#278AB7;color:#FFF;margin-bottom:5px;><strong>Selected Photo Update Successfully.</strong></div>";

		 }

		 if(isset($_GET['photo_delete_success']) && $_GET['photo_delete_success']==1)

		 {

			 echo "<div class=update-nag style=background-color:#278AB7;color:#FFF;margin-bottom:5px;><strong>Selected Photo Delete Successfully.</strong></div>";

		 }

		 if(isset($_GET['photo_disable_success']) && $_GET['photo_disable_success']==1)

		 {

			 echo "<div class=update-nag style=background-color:#278AB7;color:#FFF;margin-bottom:5px;><strong>Selected Photo Disable Successfully.</strong></div>";

		 }

		 if(isset($_GET['photo_enable_success']) && $_GET['photo_enable_success']==1)

		 {

			 echo "<div class=update-nag style=background-color:#278AB7;color:#FFF;margin-bottom:5px;><strong>Selected Photo Enable Successfully.</strong></div>";

		 }

	     ?>   

         <div id='ai_photo_notice' class="update-nag" style="display:none;background-color:#278AB7;color:#FFF;margin-bottom:5px;"><strong>Selected Photos Sorted Successfully.</strong></div>



<form  action="" method="post" name="photolist">

 <table cellspacing="0" class="wp-list-table widefat fixed ui-sortable" width="100%">

  <thead>

   <tr>

       <td align="left" colspan="6" style="padding-bottom:5px;"><a class="button button-primary" href="<?php echo admin_url().'admin.php?page=ai_new_photos&album_id='.$_REQUEST['album_id']?>">+ Add New Photos</a> &nbsp;&nbsp; <a class="button button-primary" href="<?php echo admin_url().'admin.php?page=ai_gallery'?>">&laquo; Back To Albums</a></td>

    </tr>  

    <tr>

      <th>&nbsp;&nbsp;</th>

      <th>Photo Title</th>

      <th>Photo</th>

      <th>Photo Date</th>

      <th>Photo Slug</th>

      <th>Action</th>

    </tr>

  </thead>

  <tfoot>

    <tr>

      <th>&nbsp;&nbsp;</th>

      <th>Photo Title</th>

      <th>Photo</th>

      <th>Photo Date</th>

      <th>Photo Slug</th>

      <th>Action</th>

    </tr>

    <tr>

        <td colspan="6" bgcolor="#FFFFFF">

            <img src="<?php echo AI_URL_PATH.'images/remove.png' ;?>"  title="MultipleDelete" onClick="JavaScript: CDeleteChecked_Click(document.photolist,document.getElementsByName('selector[]'),<?php echo $_REQUEST['album_id'] ; ?>);">

           <img src="<?php echo AI_URL_PATH.'images/bullet-green.png' ;?>" class="" title="MultipleEnable" onClick="JavaScript: CVisibleHideChecked_Click(document.photolist, document.getElementsByName('selector[]'), '1',<?php echo $_REQUEST['album_id'] ; ?>);"><img src="<?php echo AI_URL_PATH.'images/bullet-red.png' ;?>" title="multipleDisable" onClick="JavaScript: CVisibleHideChecked_Click(document.photolist, document.getElementsByName('selector[]'), '0',<?php echo $_REQUEST['album_id'] ; ?>);">

           <a href="JavaScript: CheckUncheck_Click(document.getElementsByName('selector[]'), true);" onMouseMove="window.status='Check All';" onMouseOut="window.status='';">Check All</a> / <a href="JavaScript: CheckUncheck_Click(document.getElementsByName('selector[]'), false);" onMouseMove="window.status='Uncheck All';" onMouseOut="window.status='';">Uncheck All</a>

         </td>

    </tr>

  </tfoot>

  <tbody id='ai_photo_sortable' class="sorted">

    <?php

	  if(count($res) > 0)

	  {

		  foreach($res as $key => $val)

		  {
              if(!empty($val->photo_filename))
			  { 
			    $ai_file_thumb=AI_PHOTO_THUMB_URL_PATH.'/';
				
			    $ai_photo_name= explode('.',$val->photo_filename);

			    $ai_thumb_photo_name=$ai_photo_name[0].'-thumb'.'.'.$ai_photo_name[1];
			  }
			  else
			  {
				   $ai_file_thumb = AI_URL_PATH.'/images/';
				   $ai_thumb_photo_name= 'no_photo.jpg';
			  }
			  $color='style="background-color:#CCCCCC;"';

		  ?> 

			<tr <?php if($val->photo_visible == 0){echo $color;}?> id="recordsArray_<?php echo $val->photo_id ;?>" class="ui-state-default">

			<td><input name="selector[]" type="checkbox" value=<?php echo $val->photo_id; ?>></td>

			<td class='title column-title'><?php echo $val->photo_title; ?></td>  

			<td class='title column-title'><img src="<?php echo $ai_file_thumb.$ai_thumb_photo_name ;?>" alt='No Image'></td> 

			<td class='title column-title'><?php echo $val->photo_date; ?></td>  

			<td class='title column-title'><?php echo $val->photo_slug; ?></td>

			<td style='min-width:386px;'>

			   <a href='javascript:Edit_Click(<?php echo $val->photo_id ; ?>,<?php echo $_REQUEST['album_id'] ; ?>)'><img src="<?php echo AI_URL_PATH.'images/edit.png' ; ?>" border='0' alt='Edit' title='Edit'></a>

			   <a href='javascript:Delete_Click(<?php echo $val->photo_id ; ?>,<?php echo $_REQUEST['album_id'] ; ?>)'><img src="<?php echo AI_URL_PATH.'images/remove.png' ;?>"  border='0' alt='Delete' title='Delete'></a>

			   <?php 

				 if($val->photo_visible == 1)

				 {

				?>

				  <a href='javascript:Disable_Click(<?php echo $val->photo_id ; ?>,<?php echo $_REQUEST['album_id'] ; ?>)'><img src="<?php echo AI_URL_PATH.'images/bullet-red.png';?>" border='0' alt='Disable' title='Disable'></a>

				<?php

				 }

				 else

				 {

				?>

				  <a href='javascript:Enable_Click(<?php echo $val->photo_id ; ?>,<?php echo $_REQUEST['album_id'] ; ?>)'><img src="<?php echo AI_URL_PATH.'images/bullet-green.png';?>" border='0' alt='Enable' title='Enable'></a>

				<?php

				 }

				?>

				</td></tr> 

				<?php

		  }

	  }//end of if

	  else

	   {

		   ?>

           <tr>

                <td colspan="6" align="center" bgcolor="#FFFFFF">

                    <?php _e("No Photos Found","ai_gallery");?>

                 </td>  

            </tr>

		<?php     

	   }

	    

	?>

  </tbody>

     <input type="hidden" name="Action">

     <input type="hidden" name="visible">

     <input type="hidden" name="albumid">

 </table>

</form>

</div>

</div>

</div>

