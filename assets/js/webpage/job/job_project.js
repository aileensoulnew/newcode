
//Validation Start
 $(document).ready(function () { 
 
   $.validator.addMethod("regx1", function(value, element, regexpr) {          
   if(!value) 
   {
    return true;
   }
   else
   {
      return regexpr.test(value);
   }
   }, "Only space, only number and only special characters are not allow");
   
   
   $.validator.addMethod("regdigit", function(value, element, regexpr) {          
   if(!value) 
   {
    return true;
   }
   else
   {
      return regexpr.test(value);
   }
   },"Only digit allowed");
   
   
                $("#jobseeker_regform").validate({
   
                    rules: {
   
                        project_name:{
                            regx1:/^[-@./#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/,
                        },
   
                        project_description:{
                          regx1:/^[-@./#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/,
                        },
                        project_duration:{
                    
                            regdigit:/^[0-9]*$/,
                        },
                        training_as:{
                           regx1:/^[-@./#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/,
                        },
                        training_duration:{
                          regdigit:/^[0-9]*$/,
                        },
                        training_organization:{
                          regx1:/^[-@./#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/,
                        },
   
                    },
       
                });
            });
   
//validation End

//disable spacebar js start
  $(window).load(function(){
   $("#project_duration").on("keydown", function (e) {
   return e.which !== 32;
   });
   }); 
   
   $(window).load(function(){
   $("#training_duration").on("keydown", function (e) {
   return e.which !== 32;
   });
   }); 
//disable spacebar js end

//THIS FUNCTION IS USED FOR PASTE SAME DESCRIPTION THAT COPIED START
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
           // Stop stack overflow
           if (!_onPaste_StripFormatting_IEPaste) {
               _onPaste_StripFormatting_IEPaste = true;
               e.preventDefault();
               window.document.execCommand('ms-pasteTextOnly', false);
           }
           _onPaste_StripFormatting_IEPaste = false;
       }
   }
//THIS FUNCTION IS USED FOR PASTE SAME DESCRIPTION THAT COPIED END

 $(".formSentMsg").delay(3200).fadeOut(300);