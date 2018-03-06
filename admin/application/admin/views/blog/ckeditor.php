

<!-- bootstrap wysihtml5 - text editor -->
 <!--  <link rel="stylesheet" href="../../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
<script src="../../bower_components/ckeditor/ckeditor.js"></script> -->


<!-- /.box-header -->
      
              <form>
                    <textarea id="editor1" name="editor1" rows="10" cols="80">
                                            This is my textarea to be replaced with CKEditor.
                    </textarea>
              </form>
         
          <!-- /.box -->
          <script>
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
   // CKEDITOR.replace('editor1')
    //bootstrap WYSIHTML5 - text editor
 //   $('.textarea').wysihtml5()
  })
</script>

<!-- SCRIPT FOR CKEDITOR END-->

<script type="text/javascript">
    
  var roxyFileman = '<?php echo SITEURL.'uploads/upload.php'; ?>' ; 
   CKEDITOR.replace( 'editor1',{
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