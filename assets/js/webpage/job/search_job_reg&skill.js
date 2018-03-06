// job title script start
         $(function() {
             function split( val ) {
                 return val.split( /,\s*/ );
             }
             function extractLast( term ) {
                 return split( term ).pop();
             }
             
             $( "#job_title" ).bind( "keydown", function( event ) {
                 if ( event.keyCode === $.ui.keyCode.TAB &&
                     $( this ).autocomplete( "instance" ).menu.active ) {
                     event.preventDefault();
                 }
             })
             .autocomplete({
                 minLength: 2,
                 source: function( request, response ) { 
                     // delegate back to autocomplete, but extract the last term
                     $.getJSON(base_url + "general/get_jobtitle", { term : extractLast( request.term )},response);
                     $("#ui-id-1").addClass("autoposition");
                 },
                 focus: function() {
                     // prevent value inserted on focus
                     return false;
                 },
      
                  select: function(event, ui) {
                event.preventDefault();
                $("#job_title").val(ui.item.label);
                $("#selected-tag").val(ui.item.label);
               
            },
          
             });
         });

             
//new script for cities start
 $(function() {
 
          function split( val ) {
              return val.split( /,\s*/ );
          }
          function extractLast( term ) {
              return split( term ).pop();
          }
          
          $( "#cities2" ).bind( "keydown", function( event ) {
              if ( event.keyCode === $.ui.keyCode.TAB &&
                  $( this ).autocomplete( "instance" ).menu.active ) {
                  event.preventDefault();
              }
          })
          .autocomplete({
              minLength: 2,
              source: function( request, response ) { 
                  // delegate back to autocomplete, but extract the last term
                  $.getJSON(base_url +"general/get_location", { term : extractLast( request.term )},response);
                  $("#ui-id-2").addClass("autoposition");
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

//new script for cities end

//new script for skill start
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
                  // delegate back to autocomplete, but extract the last term
                  $.getJSON(base_url +"general/get_skill", { term : extractLast( request.term )},response);
                  $("#ui-id-1").addClass("autoposition");
                  $("#ui-id-3").addClass("autoposition");
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
                  if(terms.length <= 20) {
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
//new script for skill end