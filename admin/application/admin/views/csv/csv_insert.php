<?php
echo $header;
echo $leftmenu;
?>
<div class="content-wrapper">
    <?php
    $form_attr = array('id' => 'add_page_frm', 'enctype' => 'multipart/form-data');
    echo form_open_multipart('csv_file/csv_function', $form_attr);
    ?>
    <input type="file" name="file" />
    <input type="submit" class="btn btn-primary" name="importSubmit" value="IMPORT">
    <?php form_close(); ?>
    
</div>