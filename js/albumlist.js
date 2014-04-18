function Edit_Click(id)
{
	   location.replace('admin.php?page=ai_album&action=Edit&id='+id);
}
function Photos_Click(id)
{
	   location.replace('admin.php?page=ai_listing_photos&album_id='+id);
}
function Delete_Click(id)
{
	if(confirm('Are you sure you want to delete this information?'))
	{
	   location.replace('admin.php?page=ai_gallery&action=Delete&id='+id);
	}
}
function Disable_Click(id)
{
	   location.replace('admin.php?page=ai_gallery&action=Disable&id='+id);
}
function Enable_Click(id)
{
	   location.replace('admin.php?page=ai_gallery&action=Enable&id='+id);
}
//====================================================================================================
//	Function Name	:	CDeleteChecked_Click
//----------------------------------------------------------------------------------------------------
function CDeleteChecked_Click(frm, PK)
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
function CVisibleHideChecked_Click(frm, PK, Visibility)
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
		submit();
	}
}
jQuery(function() 
		{
			jQuery("#ai_album_sortable").sortable(
			{ 
				opacity: 0.5, cursor: 'move', update: function() 
				{
					var order = jQuery(this).sortable("serialize")+'&action=ai_album_ajax_updateOrder'; 
                   jQuery.post(ajaxurl, order, function(theResponse)
					{
						if(theResponse==0){jQuery('#ai_album_notice').show();
						setTimeout(function() {
							jQuery('#ai_album_notice').fadeOut('fast');
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