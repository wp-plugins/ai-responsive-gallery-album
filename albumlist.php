<?php

wp_register_script( 'albumlist', AI_URL_PATH.'js/albumlist.js');

wp_enqueue_script( 'albumlist' );

wp_enqueue_script('jquery-ui-sortable');

wp_enqueue_style('aigalley', AI_URL_PATH.'css/ai-gallery.css');



global $wpdb;

$ai_show_table_album = $wpdb->prefix . "ai_album";

$ai_show_table_photos = $wpdb->prefix . "ai_photos";



if($_REQUEST['action'] == 'Delete')

{  

	$ai_album_get_image=$wpdb->get_results("SELECT album_cover_image from $ai_show_table_album WHERE album_id = '".$_REQUEST['id']."'",ARRAY_A);


	if(file_exists(AI_GALLERY_DIR_PATH.'/'.$ai_album_get_image[0]['album_cover_image'])){

		@unlink(AI_GALLERY_DIR_PATH.'/'.$ai_album_get_image[0]['album_cover_image']);

	}

	

	$ai_album_thumb_name= explode('.',$ai_album_get_image[0]['album_cover_image']);

	$ai_thumb_album_name=$ai_album_thumb_name[0].'-thumb'.'.'.$ai_album_thumb_name[1];	

	

	if(file_exists(AI_GALLERY_THUMB_DIR_PATH.'/'.$ai_thumb_album_name)){

		@unlink(AI_GALLERY_THUMB_DIR_PATH.'/'. $ai_thumb_album_name);

	}

	

	$ai_photo_get_image=$wpdb->get_results("SELECT photo_filename from $ai_show_table_photos WHERE photo_album_id = '".$_REQUEST['id']."'",ARRAY_A);



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

	

	$wpdb->query($wpdb->prepare("DELETE FROM $ai_show_table_album WHERE album_id =%d",$_REQUEST['id']));

	$wpdb->query($wpdb->prepare("DELETE FROM $ai_show_table_photos WHERE photo_album_id =%d",$_REQUEST['id']));

	$location=admin_url().'admin.php?page=ai_gallery&album_delete_success=1';	

	echo'<script> window.location="'.$location.'"; </script> ';	 

}

if($_REQUEST['action'] == 'Disable')

{  

	$wpdb->query($wpdb->prepare("UPDATE $ai_show_table_album SET album_visible=0 WHERE album_id =%d",$_REQUEST['id']));

	$location=admin_url().'admin.php?page=ai_gallery&album_disable_success=1';

	echo'<script> window.location="'.$location.'"; </script> ';	 	 

}

if($_REQUEST['action'] == 'Enable')

{  

	$wpdb->query($wpdb->prepare("UPDATE $ai_show_table_album SET album_visible=1 WHERE album_id =%d",$_REQUEST['id']));

	$location= admin_url().'admin.php?page=ai_gallery&album_enable_success=1';

	echo'<script> window.location="'.$location.'"; </script> ';	 

}

if($_REQUEST['Action'] == 'EnableDisableSelected')

{  

    $edittable=$_POST['selector'];

	$params = join(',', $edittable);

	$wpdb->query($wpdb->prepare("UPDATE $ai_show_table_album SET album_visible='".$_POST['visible']."' WHERE album_id IN ($params)",ARRAY_N));

	

	if($_POST['visible'] == '1')

	{

		$location= admin_url().'admin.php?page=ai_gallery&album_enable_success=1';

		echo'<script> window.location="'.$location.'"; </script> ';	 

	}

	if($_POST['visible'] == '0')

	{

		$location= admin_url().'admin.php?page=ai_gallery&album_disable_success=1';

		echo'<script> window.location="'.$location.'"; </script> ';	 

	}

}

if ($_REQUEST['Action'] == 'DeleteSelected') 

{

	$edittable=$_POST['selector'];

	$params = join(',', $edittable);

	

	//unlink album image from uploaded path

	$ai_album_get_image=$wpdb->get_results("SELECT album_cover_image from $ai_show_table_album WHERE album_id IN ($params)",ARRAY_A);



	foreach($ai_album_get_image as $album_key => $album_val)

	{

		if(file_exists(AI_GALLERY_DIR_PATH.'/'.$album_val['album_cover_image'])){

			@unlink(AI_GALLERY_DIR_PATH.'/'.$album_val['album_cover_image']);

		}

		

		$ai_album_thumb_name= explode('.',$album_val['album_cover_image']);

		$ai_thumb_album_name=$ai_album_thumb_name[0].'-thumb'.'.'.$ai_album_thumb_name[1];	

		

		if(file_exists(AI_GALLERY_THUMB_DIR_PATH.'/'.$ai_thumb_album_name)){

			@unlink(AI_GALLERY_THUMB_DIR_PATH.'/'. $ai_thumb_album_name);

		}

	}

	

	//unlink photo image from uploaded path

	$ai_photo_get_image=$wpdb->get_results("SELECT photo_filename from $ai_show_table_photos WHERE photo_album_id IN ($params)",ARRAY_A);



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

	

	// use the IN operator in your WHERE-clause

	$wpdb->query($wpdb->prepare("DELETE FROM $ai_show_table_album WHERE album_id IN ($params)",ARRAY_N));

	$wpdb->query($wpdb->prepare("DELETE FROM $ai_show_table_photos WHERE photo_album_id IN ($params)",ARRAY_N));

	$location=admin_url().'admin.php?page=ai_gallery&album_delete_success=1';

	echo'<script> window.location="'.$location.'"; </script> ';				  

}

$ai_get_album_res=$wpdb->get_results("select * from $ai_show_table_album ORDER BY album_order ASC ");

?>

<div class="wrap">

<h2>

 <img src="<?php echo AI_URL_PATH.'images/augustinfotech-logo.jpg'?>" class="icon32" />

 <?php _e("AI Responsive Gallery Album","ai-gallery");?> <a class="add-new-h2" href="<?php echo admin_url().'admin.php?page=ai_album'?>">+ Add New Album</a>

</h2>

<br />

<div id="poststuff" class="postbox">

<h3 class="hndle"><img src="<?php echo AI_URL_PATH.'images/man_gal.png'?>"/>

<span>

  <?php _e("Manage Albums","ai-gallery");?>

  </span>

</h3>

<div class="inside">

 <?php

         if(isset($_GET['album_insert_success']) && $_GET['album_insert_success']==1)

		 {

			 echo "<div class=update-nag style=background-color:#278AB7;color:#FFF;margin-bottom:5px;><strong>Album Inserted Successfully.</strong></div>";

		 }

		 if(isset($_GET['album_update_success']) && $_GET['album_update_success']==1)

		 {

			 echo "<div class=update-nag style=background-color:#278AB7;color:#FFF;margin-bottom:5px;><strong>Selected Album Update Successfully.</strong></div>";

		 }

		 if(isset($_GET['album_delete_success']) && $_GET['album_delete_success']==1)

		 {

			 echo "<div class=update-nag style=background-color:#278AB7;color:#FFF;margin-bottom:5px;><strong>Selected Album Delete Successfully.</strong></div>";

		 }

		 if(isset($_GET['album_disable_success']) && $_GET['album_disable_success']==1)

		 {

			 echo "<div class=update-nag style=background-color:#278AB7;color:#FFF;margin-bottom:5px;><strong>Selected Album Disable Successfully.</strong></div>";

		 }

		 if(isset($_GET['album_enable_success']) && $_GET['album_enable_success']==1)

		 {

			 echo "<div class=update-nag style=background-color:#278AB7;color:#FFF;margin-bottom:5px;><strong>Selected Album Enable Successfully.</strong></div>";

		 }

	     ?>  

 <div id='ai_album_notice' class="update-nag" style="display:none;background-color:#278AB7;color:#FFF;margin-bottom: 5px;"><strong>Selected Albums Sorted Successfully.</strong></div>

 

<form  action="" method="post" name="albumlist">

 <table cellspacing="0" class="wp-list-table widefat ui-sortable" width="100%">

  <thead>

   <tr>

       <td align="left" colspan="7" style="padding-bottom:5px;"><a class="button button-primary" href="<?php echo admin_url().'admin.php?page=ai_album'?>">+ Add New Album</a></td>

    </tr>  

    <tr class="field_heading">

      <th>&nbsp;&nbsp;</th>

      <th style="width:170px;">Album Title</th>

      <th style="width:170px;">Album Cover Image</th>

      <th style="width:170px;">Album Date</th>
	  
	  <th style="width:175px;">Album Micro Images</th>
	  
      <th style="width:170px;">Album ShortCode</th>

      <th style="width:170px;">Total Images</th>

      <th style="width:170px;">Action</th>

    </tr>

 



  </thead>

  

  <tbody id='ai_album_sortable' class="sorted">

    <?php

      $ai_show_table_photo =$wpdb->prefix . "ai_photos";

	  if(count($ai_get_album_res) > 0)

	  {

		  foreach($ai_get_album_res as $key => $val)

		  {
              $ai_album_micro_images=$wpdb->get_results("select photo_filename from $ai_show_table_photo WHERE photo_album_id='".$val->album_id."'",ARRAY_A);
			  
			  if(!empty($val->album_cover_image))
			  { 
				  $file_thumb=AI_GALLERY_THUMB_URL_PATH.'/';
				   
				  $album_name= explode('.',$val->album_cover_image);
	
				  $thumb_album_name=$album_name[0].'-thumb'.'.'.$album_name[1];
			  }
			  else
			  {
				   $file_thumb = AI_URL_PATH.'/images/';
				   $thumb_album_name= 'no_photo.jpg';
			  }
			  $color='style="background-color:#CCCCCC;"';

			  
			  $ai_getcount_album_images=$wpdb->get_results("select count(*) as albumcount,photo_filename from $ai_show_table_photo WHERE photo_album_id='".$val->album_id."'",ARRAY_A);
			  

		  ?> 

			<tr <?php if($val->album_visible == 0){echo $color;}?> id="recordsArray_<?php echo $val->album_id ;?>" class="ui-state-default">

			<td><input name="selector[]" type="checkbox" value=<?php echo $val->album_id; ?>></td>

			<td class='title column-title' style="width:120px;"><?php echo $val->album_title; ?></td>  

			<td class='title column-title' style="width:120px;"><img class="cover_img" src="<?php echo $file_thumb.$thumb_album_name ;?>" alt='No Image'></td> 

			<td class='title column-title' style="width:120px;"><?php echo $val->album_date; ?></td>  

			<td class='title column-title' style="width:120px;">
			 
			 <div class="microGallery"> 
			  
			  <?php
			  foreach($ai_album_micro_images as $mkey => $mval)
			  {   
			      foreach($mval as $mick => $micv)
				  {
				  	
				  	  if(!empty($micv))
					  { 
					    
					    $ai_file_thumb=AI_PHOTO_THUMB_URL_PATH.'/';
						
					    $ai_photo_name= explode('.',$micv);
						
						$ai_thumb_photo_name=$ai_photo_name[0].'-thumb'.'.'.$ai_photo_name[1];
				   
					  }
					  ?>
					 
					 <img src="<?php echo $ai_file_thumb.$ai_thumb_photo_name ;?>" alt='No Image'>
			  
			  		<?php
				  }	 
				
			  }
			  ?>
			   </div>
			 	
			</td>
			<td class='title column-title album_id' style="width:120px;"><input type="text" value="[Album ID=<?php echo $val->album_id; ?>]"size="15" readonly /></td>

			<td class='title column-title total_img' style="width:120px;"><?php echo $ai_getcount_album_images[0]['albumcount']; ?></td>

			<td class='user_action' style="width:128px;">

               <a href='javascript:Photos_Click(<?php echo $val->album_id ; ?>)'><img src="<?php echo AI_URL_PATH.'images/gal.png' ; ?>" border='0' alt='Photos' title='Photos'></a>

			   <a href='javascript:Edit_Click(<?php echo $val->album_id ; ?>)'><img src="<?php echo AI_URL_PATH.'images/edit.png' ; ?>" border='0' alt='Edit' title='Edit'></a>

			   <a href='javascript:Delete_Click(<?php echo $val->album_id ; ?>)'><img src="<?php echo AI_URL_PATH.'images/remove.png' ;?>"  border='0' alt='Delete' title='Delete'></a>

			   <?php 

				 if($val->album_visible == 1)

				 {

				?>

				  <a href='javascript:Disable_Click(<?php echo $val->album_id ; ?>)'><img src="<?php echo AI_URL_PATH.'images/bullet-red.png';?>" border='0' alt='Disable' title='Disable'></a>

				<?php

				 }

				 else

				 {

				?>

				  <a href='javascript:Enable_Click(<?php echo $val->album_id ; ?>)'><img src="<?php echo AI_URL_PATH.'images/bullet-green.png';?>" border='0' alt='Enable' title='Enable'></a>

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

                <td colspan="7" align="center" bgcolor="#FFFFFF">

                    <?php _e("No Albums Found","ai_gallery");?>

                 </td>  

            </tr>

		<?php     

	   }

	    

	?>

  </tbody>
  <tfoot class="table_footer">

    <tr class="footer_heading">

      <th>&nbsp;&nbsp;</th>

      <th style="width:170px;">Album Title</th>

      <th style="width:170px;">Album Cover Image</th>

      <th style="width:170px;" >Album Date</th>
	  
	  <th style="width:175px;">Album Micro Images</th>

      <th style="width:170px;">Album ShortCode</th>

      <th style="width:170px;">Total Images</th>

      <th style="width:170px;">Action</th>

    </tr>

     <tr>

        <td colspan="7" bgcolor="#FFFFFF">

            <img src="<?php echo AI_URL_PATH.'images/remove.png' ;?>"  title="MultipleDelete" onClick="JavaScript: CDeleteChecked_Click(document.albumlist,document.getElementsByName('selector[]'));">

           <img src="<?php echo AI_URL_PATH.'images/bullet-green.png' ;?>" class="" title="MultipleEnable" onClick="JavaScript: CVisibleHideChecked_Click(document.albumlist, document.getElementsByName('selector[]'), '1');"><img src="<?php echo AI_URL_PATH.'images/bullet-red.png' ;?>" title="multipleDisable" onClick="JavaScript: CVisibleHideChecked_Click(document.albumlist, document.getElementsByName('selector[]'), '0');">

           <a href="JavaScript: CheckUncheck_Click(document.getElementsByName('selector[]'), true);" onMouseMove="window.status='Check All';" onMouseOut="window.status='';" style="margin-left:20px;">Check All</a> / <a href="JavaScript: CheckUncheck_Click(document.getElementsByName('selector[]'), false);" onMouseMove="window.status='Uncheck All';" onMouseOut="window.status='';" style="">Uncheck All</a>

         </td>

    </tr>

  </tfoot>

     <input type="hidden" name="Action">

     <input type="hidden" name="visible">

  </table>

</form>

</div>

</div>

</div>

