$(function() {
        function split( val ) {
            return val.split( /,\s*/ );
        }
        function extractLast( term ) { 
            return split( term ).pop();
        }
        
        $( "#skills2" ).bind( "keydown", function( event ) {
            if ( event.keyCode === $.ui.keyCode.TAB &&
                $( this ).autocomplete( "instance" ).menu.active ) {
                event.preventDefault();
            }
        })
        .autocomplete({
            minLength: 2,
            source: function( request, response ) { 

                //url: base_url + "general/get_artskill",

                // delegate back to autocomplete, but extract the last term
                $.getJSON(base_url + "general/get_artskill", { term : extractLast( request.term )},response);
            },
            focus: function() {
                // prevent value inserted on focus
                return false;
            },
            select: function( event, ui ) {
               
                 var text =this.value;
                var terms = split( this.value );
                 
                text = text == null || text == undefined ? "" : text;
                var checked = (text.indexOf(ui.item.value + ', ') > -1 ? 'checked' : '');
               if (checked == 'checked') {
      
                    terms.push( ui.item.value );
                    this.value = terms.split( ", " );
               }//if end

              else {
                if(terms.length <= 10) {
                    // remove the current input
                    terms.pop();
                    // add the selected item
                    terms.push( ui.item.value );
                    // add placeholder to get the comma-and-space at the end
                    terms.push( "" );
                    this.value = terms.join( ", " );
                    return false;
                }else{
                    var last = terms.pop();
                    $(this).val(this.value.substr(0, this.value.length - last.length - 2)); // removes text from input
                    $(this).effect("highlight", {}, 1000);
                    $(this).attr("style","border: solid 1px red;");
                    return false;
                }
             }//else end
            }
 
        });
    });


jQuery(document).ready(function($) {  
$(window).load(function(){
  $('#preloader').fadeOut('slow',function(){$(this).remove();});
});
});

textarea.onkeyup = function(evt) {
    this.scrollTop = this.scrollHeight;
}

    
jQuery.validator.addMethod("noSpace", function(value, element) { 
      return value == '' || value.trim().length != 0;  
    }, "No space please and don't leave it empty");


            $.validator.addMethod("regx1", function(value, element, regexpr) {          
    return regexpr.test(value);
}, "Only space not allow");


$.validator.addMethod("regx", function(value, element, regexpr) {          
     if(!value) 
            {
                return true;
            }
            else
            {
                  return regexpr.test(value);
            }

}, "Only space, only number and only special characters are not allow");


            $(document).ready(function () { 

                $("#artinfo").validate({ 
  
                  ignore: '*:not([name])',
                    rules: {

                        artname: {

                            required: true,
                            regx:/^[-@./#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/
                           
                        },

                        skills: {

                    required: true,

                },
                       desc_art: {

                            required: true,
                             regx:/^[-@./#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/
                           
                            
                        },
                        
                    },

                    messages: {

                        artname: {

                            required: "Speciality is required.",
                            
                        },

                         skills: {

                    required: "Skill is required.",
                   
                },

                        desc_art: {

                            required: "Description of your art is required.",
                            
                        },
                       
                },

                });
                   });


function checkvalue() {
                           
        var searchkeyword =$.trim(document.getElementById('tags').value);
        var searchplace =$.trim(document.getElementById('searchplace').value);
                           
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


$(document).ready(function () {
var input = $("#skills2");
var len = input.val().length;
input[0].focus();
input[0].setSelectionRange(len, len);
 });
$(".alert").delay(3200).fadeOut(300);