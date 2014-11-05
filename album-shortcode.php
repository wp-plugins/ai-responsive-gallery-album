<?php

add_shortcode('Album','add_album_frontend');
function add_album_frontend($atts) {   
	//$width = get_option( 'thumbnail_size_w' );
	//$height = get_option( 'thumbnail_size_h' );
	extract( shortcode_atts( array(
			'id' => '',
		), $atts ) );

	wp_enqueue_script('jquery' );
	wp_register_script('ai-responsive-gallery', AI_URL_PATH.'js/ai-responsive-gallery.js');
	wp_enqueue_script('ai-responsive-gallery');
	wp_enqueue_style('ai-responsive-gallery', AI_URL_PATH.'css/ai-responsive-gallery.css');
	wp_register_script('colorbox-min', AI_URL_PATH.'js/jquery.colorbox-min.js');
	wp_enqueue_script('colorbox-min' );
	wp_enqueue_style('colorbox', AI_URL_PATH.'css/colorbox.css');
	wp_head();

	global $wpdb;

	$album_sql="";
	$ai_shrt_album = $wpdb->prefix . "ai_album";
	$ai_shrt_photos = $wpdb->prefix . "ai_photos";
	$album_sql .= "SELECT * FROM $ai_shrt_album WHERE album_visible='1' ";

	if($id != '')
		$album_sql .= "AND album_id IN ($id)";
		
	$album_sql .="ORDER BY album_order ASC";
	$ai_get_all_album=$wpdb->get_results($album_sql,ARRAY_A);

	$data='<div class="ai-responsive-gallery">
	<div class="topbar">
	<span id="close" class="back">&larr;</span>
	<h2>AI Responsive Gallery Album</h2><h3 id="name"></h3>
	</div>
	<ul id="tp-grid" class="tp-grid">';
	foreach($ai_get_all_album as $ai_album_k=>$ai_album_v) {
		$ai_get_all_photos=$wpdb->get_results("SELECT * FROM $ai_shrt_photos
								WHERE photo_visible='1' 
								AND photo_album_id='".$ai_album_v['album_id']."' 
								ORDER BY photo_order ASC",ARRAY_A);

		foreach($ai_get_all_photos as $ai_photo_k=>$ai_photo_v) {
			if(!empty($ai_photo_v['photo_filename'])) {
				$ai_fnt_photo_thumb_path = AI_PHOTO_THUMB_URL_PATH.'/' ;
				$ai_fnt_photo_url_path = AI_PHOTO_URL_PATH.'/';
				$ai_fnt_photo_name= explode('.',$ai_photo_v['photo_filename']);
				$ai_fnt_thumb_photo_name=$ai_fnt_photo_name[0].'-thumb'.'.'.$ai_fnt_photo_name[1];
				$ai_fnt_photo_name= $ai_photo_v['photo_filename'];
			} else {
				$ai_fnt_photo_thumb_path = AI_URL_PATH.'/images/';
				$ai_fnt_photo_url_path = AI_URL_PATH.'/images/';
				$ai_fnt_thumb_photo_name= 'no_photo.jpg';
				$ai_fnt_photo_name= 'no_photo.jpg';
			}

			$data .='<li data-pile="'.$ai_album_v['album_title'].'">
			<a class="gallery" rel="'.$ai_album_v['album_title'].'" href="'.$ai_fnt_photo_url_path.$ai_fnt_photo_name.'" title="'.$ai_photo_v['photo_title'].'">
			<span class="tp-info"><span>'.$ai_photo_v['photo_title'].'</span></span>
			<img src="'.$ai_fnt_photo_thumb_path.$ai_fnt_thumb_photo_name.'"/>
			</a>
			</li>';
		}
	}

	$data .='</ul>
	</div>';


	?>
	<script type="text/javascript">	
	jQuery(function() {
		var $grid = jQuery( '#tp-grid' ),
		$name = jQuery( '#name' ),
		$close = jQuery( '#close' ),
		$loader = jQuery( '<div class="loader"><i></i><i></i><i></i><i></i><i></i><i></i><span>Loading...</span></div>' ).insertBefore( $grid ),
		stapel = $grid.stapel( {
			randomAngle : true,
			delay : 50,
			gutter : 90,
			pileAngles : 5,
			onLoad : function() {
				$loader.remove();
			},
			onBeforeOpen : function( pileName ) {
				$name.html( pileName );
			},
			onAfterOpen : function( pileName ) {
				$close.show();
			}
		});

		$close.on( 'click', function() {
			$close.hide();
			$name.empty();
			stapel.closePile();
		} );
	
		jQuery('a.gallery').colorbox({ transition:"fade", maxWidth:'90%', maxHeight:'90%' });
	});
	
		jQuery.colorbox.settings.maxWidth  = '90%';
		jQuery.colorbox.settings.maxHeight = '90%';

		// ColorBox resize function
		var resizeTimer;
		function resizeColorBox()
		{
			if (resizeTimer) clearTimeout(resizeTimer);
				resizeTimer = setTimeout(function() {
					if (jQuery('#cboxOverlay').is(':visible')) {
							jQuery.colorbox.load(true);
					}
			}, 300);
		}

		// Resize ColorBox when resizing window or changing mobile device orientation
		jQuery(window).resize(resizeColorBox);
		window.addEventListener("orientationchange", resizeColorBox, false);
	</script>

	<?php
	return $data;
}
?>