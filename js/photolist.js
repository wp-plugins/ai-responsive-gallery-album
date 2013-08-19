function Edit_Click(id,albumid)
{
	   location.replace('admin.php?page=ai_new_photos&action=Edit&id='+id+'&album_id='+albumid);
}
function Delete_Click(photoid,albumid)
{
	if(confirm('Are you sure you want to delete this information?'))
	{
	   location.replace('admin.php?page=ai_listing_photos&action=Delete&photoid='+photoid+'&albumid='+albumid);
	}
}
function Disable_Click(photoid,albumid)
{
	   location.replace('admin.php?page=ai_listing_photos&action=Disable&photoid='+photoid+'&albumid='+albumid);
}
function Enable_Click(photoid,albumid)
{
	   location.replace('admin.php?page=ai_listing_photos&action=Enable&photoid='+photoid+'&albumid='+albumid);
}
//====================================================================================================
//	Function Name	:	CDeleteChecked_Click
//----------------------------------------------------------------------------------------------------
function CDeleteChecked_Click(frm, PK,album_id)
{
	with(frm)
	{
		var flg = false;

		for(i=0; i < PK.length; i++)
		{
			if(PK[i].checked)
				flg = true;
		}

		if(!flg)
		{
			alert('Please select the information you want to delete.');
			return false;
		}

		if(confirm('Are you sure you want to delete selected information?'))
		{
			Action.value = 'DeleteSelected';
			albumid.value   = album_id;
			submit();
		}
	}
}
function CheckUncheck_Click(fld, status)
{
	if(fld)
	{
		if(fld.length)
			for(i = 0; i < fld.length; i++)
				fld[i].checked = status;
		else
			fld.checked = status;
	}
}
//====================================================================================================
//	Function Name	:	CVisibleHideChecked_Click
//----------------------------------------------------------------------------------------------------
function CVisibleHideChecked_Click(frm, PK, Visibility,album_id)
{
	with(frm)
	{
		var flg = false;

		for(i=0; i < PK.length; i++)
		{
			if(PK[i].checked)
				flg = true;
		}

		if(!flg)
		{
			alert('Please select the information you want to visible/hide.');
			return false;
		}

		visible.value	= Visibility;
		Action.value 	= 'EnableDisableSelected';
		albumid.value   = album_id;
		submit();
	}
}
jQuery(function() 
{
	jQuery("#ai_photo_sortable").sortable(
	{ 
		opacity: 0.5, cursor: 'move', update: function() 
		{
			var order = jQuery(this).sortable("serialize")+'&action=ai_photo_ajax_updateOrder'; 
		   jQuery.post(ajaxurl, order, function(theResponse)
			{
				if(theResponse==0){jQuery('#ai_photo_notice').show();
				setTimeout(function() {
					jQuery('#ai_photo_notice').fadeOut('fast');
					}, 3000); // <-- time in milliseconds
				 }
				});

		}								  
	});
});
jQuery(function() {
	setTimeout(function() {
		jQuery('.update-nag').fadeOut('fast');
		}, 3000);
});		