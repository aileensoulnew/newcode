jQuery(document).ready(function($) {  
// site preloader -- also uncomment the div in the header and the css style for #preloader
$(window).load(function(){
  $('#preloader').fadeOut('slow',function(){$(this).remove();});
});
});


$(document).ready(function () {
var input = $("#artportfolio123");
var len = input.val().length;
input[0].focus();
input[0].setSelectionRange(len, len);
 });



 $("#bestofmine").change(function(event) {
    
     $(".bestofmine_image").html("");
    var bestofmine = document.getElementById("bestofmine").value;
    var bestmine = document.getElementById("bestmine").value;
  var $field = $('#artportfolio123');
  var artportfolio = $('#artportfolio123').html();
  artportfolio = artportfolio.replace(/ /gi, " ");
  artportfolio = artportfolio.trim();


  var lastIndex = bestofmine.lastIndexOf("\\");
    if (lastIndex >= 0) {
        bestofmine = bestofmine.substring(lastIndex + 1);
        
    }    
  $("#datav").text(bestofmine); 


  if(bestofmine != ''){ 
      var bestofmine_ext = bestofmine.split('.').pop();      
      var allowespdf = ['pdf'];
      var foundPresentpdf = $.inArray(bestofmine_ext, allowespdf) > -1;
      }
      var bestmine_ext = bestmine.split('.').pop();    
       var allowespdf = ['pdf'];
       var foundPresentportfolio = $.inArray(bestmine_ext, allowespdf) > -1;
       if(foundPresentpdf == false)
       {
                 $(".bestofmine_image").html("Please select only pdf file.");
                return false;
                event.preventDefault();       
      }
            });


function portfolio_form_submit(event){  
    var bestofmine = document.getElementById("bestofmine").value;
    var bestmine = document.getElementById("bestmine").value;
  var $field = $('#artportfolio123');
  var artportfolio = $('#artportfolio123').html();
  artportfolio = artportfolio.replace(/ /gi, " ");
  artportfolio = artportfolio.trim();

      if(bestofmine != ''){ 
      var bestofmine_ext = bestofmine.split('.').pop();      
      var allowespdf = ['pdf'];
      var foundPresentpdf = $.inArray(bestofmine_ext, allowespdf) > -1;
      }
      var bestmine_ext = bestmine.split('.').pop();    
       var allowespdf = ['pdf'];
       var foundPresentportfolio = $.inArray(bestmine_ext, allowespdf) > -1;
       if(foundPresentpdf == false)
       {
                
                return false;
                event.preventDefault();       
      }else{
        var fd = new FormData();                
         fd.append("image", $("#bestofmine")[0].files[0]);
         files = this.files;
        fd.append('artportfolio', artportfolio);
        fd.append('bestmine', bestmine);
         $.ajax({
              url: base_url + "artist/art_portfolio_insert",
             //url: "<?php echo base_url(); ?>artist/art_portfolio_insert",
             type: "POST",
             data: fd,
            processData: false,
            contentType: false,
             beforeSend: function () { 
              document.getElementById("bestofmine").value = "";
              document.getElementById("submit").style.cursor = "default";
               document.getElementById("submit").onclick = '';                    
                       //$(".portfolioloader").html('<p style="text-align:center;"><img src = "'+ base_url + 'images/loading.gif" class = "loader" /></p>');
                       //document.getElementById("loader").display = "block";
                       if(bestofmine){
                       document.getElementById('loader').style.display = 'block';
                        }
                    },
            success: function (response) {
                $('#loader').hide();
              if(art_step == 4){ 
                 //window.location= "<?php echo base_url() ?>artist/artistic_profile";
                 window.location= base_url + "artist/details"; 
                 }else{ 
                 window.location= base_url + "artist/home"; 
                // window.location= "<?php echo base_url() ?>artist/art_post"; 
                  } 
            }
         });    
        }       
     
    }

    function delpdf(){
     $.ajax({ 
        type:'POST',
        url: base_url + "artist/deletepdf",
        //url:'<?php echo base_url() . "artist/deletepdf" ?>',
        success:function(data){ 
        $("#filename").text('');
        $("#pdffile").hide();
        document.getElementById('bestmine').value = '';
          }
            }); 
  }
// document.getElementById('bestofmine').onchange = uploadOnChange;   
// function uploadOnChange() {
//     var filename = null;
//     var filename = this.value;
//      var lastIndex = filename.lastIndexOf("\\");
//     if (lastIndex >= 0) {
//         filename = filename.substring(lastIndex + 1);
//     }    
//   $("#filename").text(filename); 
//    }
   $(".alert").delay(3200).fadeOut(300);


 var _onPaste_StripFormatting_IEPaste = false;
            function OnPaste_StripFormatting(elem, e) { 
                if (e.originalEvent && e.originalEvent.clipboardData && e.originalEvent.clipboardData.getData) {
                    e.preventDefault();
                    var text = e.originalEvent.clipboardData.getData('text/plain');
                    window.document.execCommand('insertText', false, text);
                } else if (e.clipboardData && e.clipboardData.getData) {                   
                    e.preventDefault();
                    var text = e.clipboardData.getData('text/plain');
                    window.document.execCommand('insertText', false, text);
                } else if (window.clipboardData && window.clipboardData.getData) {
                    if (!_onPaste_StripFormatting_IEPaste) {
                        _onPaste_StripFormatting_IEPaste = true;
                        e.preventDefault();
                        window.document.execCommand('ms-pasteTextOnly', false);
                    }
                    _onPaste_StripFormatting_IEPaste = false;
                }
            }


function checkvalue() {                          
    var searchkeyword = $.trim(document.getElementById('tags').value);
    var searchplace =$.trim( document.getElementById('searchplace').value);                            
      if (searchkeyword == "" && searchplace == "") {
                return false;
          }
}

function check() {
    var keyword = $.trim(document.getElementById('tags1').value);
      var place = $.trim(document.getElementById('searchplace1').value);
        if (keyword == "" && place == "") {
              return false;
          }
}

function cursorpointer(){

   elem = document.getElementById('artportfolio123');
   elem.focus();
  setEndOfContenteditable(elem);
}

function setEndOfContenteditable(contentEditableElement)
{
    var range,selection;
    if(document.createRange)
    {
        range = document.createRange();//Create a range (a range is a like the selection but invisible)
        range.selectNodeContents(contentEditableElement);//Select the entire contents of the element with the range
        range.collapse(false);//collapse the range to the end point. false means collapse to end rather than the start
        selection = window.getSelection();//get the selection object (allows you to change selection)
        selection.removeAllRanges();//remove any selections already made
        selection.addRange(range);//make the range you have just created the visible selection
    }
    else if(document.selection)
    { 
        range = document.body.createTextRange();//Create a range (a range is a like the selection but invisible)
        range.moveToElementText(contentEditableElement);//Select the entire contents of the element with the range
        range.collapse(false);//collapse the range to the end point. false means collapse to end rather than the start
        range.select();//Select the range (make it the visible selection
    }
}