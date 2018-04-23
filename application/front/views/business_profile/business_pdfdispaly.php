
<input action="action" type="button" value="Back" onclick="history.back();" /> <br/><br/>


<?php

	if($busdata[0]['file_name']){ 
?>
<embed src="<?php echo base_url().$this->config->item('bus_post_main_upload_path').$busdata[0]['file_name'] ?>" width="600" height="775">
<?php }else { ?>
<embed src="<?php echo base_url().$this->config->item('bus_profile_main_upload_path').$businessdata[0]['product_image']; ?>" width="600" height="775">
<?php }?>

