<html>
    <head>
        <title><?php echo $title; ?></title>
    </head>
<style>
    body{margin: 0;}
    </style>
    
<embed src="<?php echo base_url().$this->config->item('free_portfolio_main_upload_path').$freelancerdata[0]['freelancer_post_portfolio_attachment']?>" width="100%" height="100%" style="scroll:">
</html>