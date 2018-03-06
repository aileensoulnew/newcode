<?php
echo $header;
echo $leftmenu;
?>

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
                    $form_attr = array('id' => 'edit_blog_frm', 'enctype' => 'multipart/form-data');
                    echo form_open_multipart('blog/blog_edit/' . $blog_detail[0]['id'], $form_attr);
                    ?>
                    <div class="box-body">

                        <!-- BLOG TITLE START -->
                        <div class="form-group col-sm-10">
                            <label for="blogtitle" name="blogtitle" id="blogtitle">Blog Title*</label>
                            <input type="text" class="form-control" name="blog_title" id="blog_title" value="<?php echo $blog_detail[0]['title']; ?>">
                        </div>
                        <!-- BLOG TITLE END -->
                        <!-- BLOG CATEGORY END -->

                        <div class="box-body">                   
                            <div class="form-group col-sm-10">
                                <label for="govcat" name="govcat" id="govcat">Category*</label>
                                <select name="category[]" id="category" tabindex="1" class="form-control" multiple>
                                    <!--<option value="">Select blog Category</option>--> 
                                    <?php
                                    $category = explode(',', $blog_detail[0]['blog_category_id']);
                                    foreach ($blog_category as $blog) {
                                        ?>
                                        <option value="<?php echo $blog['id']; ?>" <?php echo (isset($category) && in_array($blog['id'], $category) ) ? "selected" : "" ?>><?php echo $blog['name']; ?></option>    <?php } ?>
                                </select>
                            </div>
                        </div>

<!--  BLOG CATEGORY END -->
                        <!-- BLOG SLUG START -->
                        <div class="form-group col-sm-10">
                            <label for="blogslug" name="blogslug" id="blogslug">Blog Slug*</label>
                            <input type="text" class="form-control" name="blog_slug" id="blog_slug" value="<?php echo $blog_detail[0]['blog_slug']; ?>">
                        </div>
                        <!-- BLOG SLUG END -->

                        <!--  TAG SELECTION START -->
                        <!--                        <div class="form-group col-sm-10">
                                                        <label>Tag*</label>
                        
                                                       <input type="text" class="form-control" name="tag" id="tag" value="<?php echo $blog_detail[0]['tag']; ?>">
                                                </div>-->
                        <!-- TAG SELECTION END -->

                        <!-- BLOG DESCRIPTION START -->
                        <div class="form-group col-sm-10">
                            <label for="blogdescription" name="blogdescription" id="blogdescription">Description *</label>
                            <textarea id="description" name="description" rows="10" cols="80"><?php echo $blog_detail[0]['description']; ?>
                            </textarea>
                            <!--   <?php //echo form_textarea(array('name' => 'description', 'id' => 'description', 'class' => "textarea", 'style' => 'width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;', 'value' => ''));  ?> --><br>
                        </div>
                        <!-- BLOG DESCRIPTION END -->

                        <!-- BLOG META DESCRIPTION START -->
                        <div class="form-group col-sm-10">
                            <label for="blogmetadescription" name="blogmetadescription" id="blogmetadescription">Meta Description *</label>
                            <textarea id="meta_description" name="meta_description" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" ><?php echo $blog_detail[0]['meta_description']; ?>
                            </textarea>
                            <br>
                        </div>
                        <!-- BLOG META DESCRIPTION END -->


                        <!-- BLOG IMAGE START -->
                        <div class="form-group col-sm-10">
                            <label for="blogimage" name="blogimage" id="blogimage">Image *</label>
                            <input type="file" class="form-control" name="image" id="image" value="" style="border: none;">
                            <?php
                            if ($blog_detail[0]['image']) {
                                ?>
                                <div class="thumbnail">
                                    <img src="<?php echo SITEURL . $this->config->item('blog_view_main_upload_path') . $blog_detail[0]['image']; ?>" alt="" class="portrait">
                                </div>
                                <?php
                            }
                            ?>

                            <input type="hidden" class="form-control" name="hidden_image" id="hidden_image" value="<?php echo $blog_detail[0]['image']; ?>" style="border: none;" >
                        </div>
                        
                         <!-- BLOG RELATED END -->

                        <div class="box-body">                   
                            <div class="form-group col-sm-10">
                                <label for="govcat" name="govcat" id="govcat">Category*</label>
                                <select name="related[]" id="related" tabindex="1" class="form-control" multiple size=<?php echo count($blog_title) + 1; ?> style='height: 100%;'>
                                    <!--<option value="">Select blog Category</option>--> 
                                    <?php
                                    $related = explode(',', $blog_detail[0]['blog_related_id']);
                                    foreach ($blog_title as $blog) {
                                        ?>
                                        <option value="<?php echo $blog['id']; ?>" <?php echo (isset($related) && in_array($blog['id'], $related) ) ? "selected" : "" ?>><?php echo $blog['title']; ?></option>    <?php } ?>
                                </select>
                            </div>
                        </div>

                     <!--  BLOG RELATED END -->
                    </div>
                    <!-- BLOG IMAGE END -->

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
    

        $("#edit_blog_frm").validate({
            rules: {
                blog_title: {
                    required: true,
                },
                blog_slug: {
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
                        blog_slug: {
                            required: "Please enter blog slug",
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
                        
                        "related[]": {
                            required: "Related category is required",
                        },
                         "related[]": {
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
    var roxyFileman = '<?php echo SITEURL . 'uploads/upload.php'; ?>';
    CKEDITOR.replace('description', {
        filebrowserBrowseUrl: roxyFileman,
        filebrowserUploadUrl: roxyFileman,
        filebrowserImageBrowseUrl: roxyFileman + '?type=image',
        filebrowserImageUploadUrl: roxyFileman,
        extraAllowedContent: 'img[alt,border,width,height,align,vspace,hspace,!src];',
        removeDialogTabs: 'link:upload;image:upload'});
    CKEDITOR.config.allowedContent = true;
    CKEDITOR.on('instanceReady', function (ev) {
        // Ends self closing tags the HTML4 way, like <br>.
        ev.editor.dataProcessor.htmlFilter.addRules({
            elements: {
                $: function (element) {
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
                    if (!element.attributes.style)
                        delete element.attributes.style;
                    return element;
                }
            }
        });
    });
</script>
<!-- SCRIPT FOR CKEDITOR END-->
<style type="text/css">
    .thumbnail {
        position: relative;
        width: 200px;
        height: 200px;
        overflow: hidden;
    }
    .thumbnail img {
        position: absolute;
        left: 50%;
        top: 50%;
        height: 100%;
        width: auto;
        -webkit-transform: translate(-50%,-50%);
        -ms-transform: translate(-50%,-50%);
        transform: translate(-50%,-50%);
    }
    .thumbnail img.portrait {
        width: 100%;
        height: auto;
    }

</style>