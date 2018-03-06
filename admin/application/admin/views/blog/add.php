<?php
echo $header;
echo $leftmenu;
?>
<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />-->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
              <i class="fa fa-rss" aria-hidden="true"></i>
            <?php echo $module_name; ?>
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url('dashboard'); ?>">
                    <i class="fa fa-dashboard"></i>
                    Home
                </a>
            </li>
            <li class="active"><?php echo $module_name; ?></li>
        </ol>
    </section>
    <section class="content-header">
        <?php if ($this->session->flashdata('success')) { ?>
            <div class="callout callout-success">
                <p><?php echo $this->session->flashdata('success'); ?></p>
            </div>
        <?php } ?>
        <?php if ($this->session->flashdata('error')) { ?>  
            <div class="callout callout-danger" >
                <p><?php echo $this->session->flashdata('error'); ?></p>
            </div>
        <?php } ?>

    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">

            <div class="col-md-12">

                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $section_title; ?></h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <?php
                    $form_attr = array('id' => 'add_blog_frm', 'enctype' => 'multipart/form-data');
                    echo form_open_multipart('blog/blog_insert', $form_attr);
                    ?>
                    <div class="box-body">
                    
                        <!-- BLOG TITLE START -->
                        <div class="form-group col-sm-10">
                            <label for="blogtitle" name="blogtitle" id="blogtitle">Blog Title*</label>
                            <input type="text" class="form-control" name="blog_title" id="blog_title" value="">
                        </div>
                        <!-- BLOG TITLE END -->
                        
                         <div class="box-body">                   
                    <div class="form-group col-sm-10">
                            <label for="govcat" name="govcat" id="govcat">Category*</label>
                             <select name="category[]" id="category" tabindex="1" class="form-control" multiple="multiple">
                               <!--<option value="">Select blog Category</option>--> 
                            <?php                             
                                      foreach($blog_category as $blog){ 
                                              ?>
                                    <option value="<?php echo $blog['id']; ?>"><?php echo $blog['name'];?></option>    <?php  } ?>
                      </select>
                    </div>
                    </div>

                        <!--  TAG SELECTION START -->
<!--                        <div class="form-group col-sm-10">
                                <label>Tag*</label>

                               <input type="text" class="form-control" name="tag" id="tag" value="">
                        </div>-->
                        <!-- TAG SELECTION END -->

                         <!-- BLOG DESCRIPTION START -->
                        <div class="form-group col-sm-10">
                            <label for="blogdescription" name="blogdescription" id="blogdescription">Description *</label>
                            <textarea id="description" name="description" rows="10" cols="80">
                             </textarea>
                          <!--   <?php //echo form_textarea(array('name' => 'description', 'id' => 'description', 'class' => "textarea", 'style' => 'width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;', 'value' => '')); ?> --><br>
                        </div>
                        <!-- BLOG DESCRIPTION END -->

                        <!-- BLOG META DESCRIPTION START -->
                        <div class="form-group col-sm-10">
                            <label for="blogmetadescription" name="blogmetadescription" id="blogmetadescription">Meta Description *</label>
                            <?php echo form_textarea(array('name' => 'meta_description', 'id' => 'meta_description', 'class' => "textarea", 'style' => 'width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;', 'value' => '')); ?><br>
                        </div>
                        <!-- BLOG META DESCRIPTION END -->

                        <!-- BLOG IMAGE START -->
                        <div class="form-group col-sm-10">
                            <label for="blogimage" name="blogimage" id="blogimage">Image *</label>
                            <input type="file" class="form-control" name="image" id="image" value="" style="border: none;">
                        </div>
                        <!-- BLOG IMAGE END -->
                       
                        <!-- RELATED BLOG START -->
                        <div class="box-body">                   
                    <div class="form-group col-sm-10">
                            <label for="govcat" name="govcat" id="relblog">Related Blog*</label>
                            <select name="related[]" id="related" tabindex="1" class="form-control" multiple="multiple" size=<?php echo count($blog_title) + 1; ?> style='height: 100%;'>
                               <!--<option value="">Select blog Category</option>--> 
                            <?php                             
                                      foreach($blog_title as $blog){ 
                                              ?>
                                    <option value="<?php echo $blog['id']; ?>"><?php echo $blog['title'];?></option>    <?php  } ?>
                      </select>
                    </div>
                    </div>
                        <!-- RELATED BLOG END -->

                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <?php
                        $save_attr = array('id' => 'btn_save', 'name' => 'btn_save', 'value' => 'Save', 'class' => 'btn btn-primary');
                        echo form_submit($save_attr);
                        ?>    
                        <button type="button" onclick="window.history.back();" class="btn btn-default">Back</button>
                        <!--<button type="submit" class="btn btn-info pull-right">Sign in</button>-->
                    </div><!-- /.box-footer -->
                    </form>
                </div><!-- /.box -->


            </div><!--/.col (right) -->
        </div>   <!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php echo $footer; ?>

<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>-->
<script type="text/javascript">
    //validation for edit email formate form
    $(document).ready(function () {
        
         $('#related option').click(function() 
    { 
        var items = $(this).parent().val();
        if (items.length > 3) {
                       alert("You can only select 3 Related blogs");
           $(this).removeAttr("selected");
        }
    });
    
    
    
//        $('#related').multiselect({
//            includeSelectAllOption: true,
//            enableFiltering: true
//        });
        
//         $('#category').multiselect({
//            includeSelectAllOption: true,
//            enableFiltering: true
//        });
//   




        $("#add_blog_frm").validate({
            rules: {
                blog_title: {
                    required: true,
                },
//                tag: {
//                    required: true,
//                },
                manufacture_id: {
                    required: true,
                },
                meta_description: {
                    required: true,
                },
                description: {
                    required: true,
                },
                image: {
                    required: true,
                },
                "related[]": {
                    required: true,
                },
                "category[]": {
                    required: true,
                },
                
            },
            messages:
                    {
                        blog_title: {
                            required: "Please enter blog title",
                        },
//                        tag: {
//                            required: "Please select tag",
//                        },
                        meta_description: {
                            required: "Please enter meta description",
                        },
                        description: {
                            required: "Please enter blog description",
                        },
                        image: {
                            required: "Please choose image",
                        },
                        "related[]": {
                            required: "Related category is required",
                        },
                         "category[]": {
                            required: "category is required",
                        }
                       
                    },
        });
        $(".bidding").hide();
        $(".available_for").click(function () {
            var available_for = this.value;
            if (available_for == 'buy')
            {
                $(".bidding").hide();
                $(".stock").show();
            }
            if (available_for == 'bid')
            {
                $(".bidding").show();
                $(".stock").hide();
            }
        });

    });

</script>

<script language="javascript" type="text/javascript">
    $(document).ready(function () {
        $('.callout-danger').delay(3000).hide('700');
        $('.callout-success').delay(3000).hide('700');
    });
</script>
<script type="text/javascript">
    $(".form_datetime").datetimepicker({
        format: "yyyy-mm-dd hh:ii:ss",
        autoclose: true,
        todayBtn: true,
        pickerPosition: "bottom-left"
    });
</script> 

<!-- SCRIPT FOR CKEDITOR START-->
<script type="text/javascript">   
  var roxyFileman = '<?php echo SITEURL.'uploads/upload.php'; ?>' ; 
   CKEDITOR.replace( 'description',{
                                filebrowserBrowseUrl : roxyFileman,
                                filebrowserUploadUrl : roxyFileman,
                                filebrowserImageBrowseUrl : roxyFileman+'?type=image',
                                filebrowserImageUploadUrl : roxyFileman,
                                extraAllowedContent:  'img[alt,border,width,height,align,vspace,hspace,!src];' ,
                                removeDialogTabs: 'link:upload;image:upload'}); 
CKEDITOR.config.allowedContent = true;
CKEDITOR.on('instanceReady', function(ev) {
    // Ends self closing tags the HTML4 way, like <br>.
    ev.editor.dataProcessor.htmlFilter.addRules({
        elements: {
            $: function(element) {
                // Output dimensions of images as width and height
                if (element.name == 'img') {
                    var style = element.attributes.style;
                    if (style) {
                        // Get the width from the style.
                        var match = /(?:^|\s)width\s*:\s*(\d+)px/i.exec(style),
                            width = match && match[1];
                        // Get the height from the style.
                        match = /(?:^|\s)height\s*:\s*(\d+)px/i.exec(style);
                        var height = match && match[1];
                        // Get the float from the style.
                        match = /(?:^|\s)float\s*:\s*(\w+)/i.exec(style);
                        var float = match && match[1];
                        if (width) {
                            element.attributes.style = element.attributes.style.replace(/(?:^|\s)width\s*:\s*(\d+)px;?/i, '');
                            element.attributes.width = width;
                        }
                        if (height) {
                            element.attributes.style = element.attributes.style.replace(/(?:^|\s)height\s*:\s*(\d+)px;?/i, '');
                            element.attributes.height = height;
                        }
                        if (float) {
                            element.attributes.style = element.attributes.style.replace(/(?:^|\s)float\s*:\s*(\w+)/i, '');
                            element.attributes.align = float;
                        }
                    }
                }
                if (!element.attributes.style) delete element.attributes.style;
                return element;
            }
        }
    });
});     
</script>
<!-- SCRIPT FOR CKEDITOR END-->