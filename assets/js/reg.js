//calender code start

 
  
//calender code end

//verification code start
var re =/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
var monore = /^\d{10}$/;
var validformat=/^\d{2}\/\d{2}\/\d{4}$/ ;//Basic check for format validity - See more at: https://www.informationbuilders.com/support/developers/javascript-validate-date-entry#sthash.44MzMQCw.dpuf
var result;
function RestrictSpace() {
    if (event.keyCode == 32) {
        return false;
    }
}

function fname1(){
			result = true;
			if(document.getElementById('fname').value == '') {
				document.getElementById('fname-error').innerHTML = "<span style=\"color:red\">" + 'Please enter your first name' + "</span>";
				
				result = false;
			} else {
				document.getElementById('fname-error').innerHTML = '';	
				
			}
				return result;
			}

function lname1(){
			result = true;
			if(document.getElementById('lname').value == '') {
				document.getElementById('lname-error').innerHTML = "<span style=\"color:red\">" + 'Please enter your last name' + "</span>";
				
				result = false;
			} else {
				document.getElementById('lname-error').innerHTML = '';	
				
			}
				return result;
			}

function email1(){
			result = true;
			if(document.getElementById('email').value == '') {
				document.getElementById('email-error').innerHTML = "<span style=\"color:red\">" + 'Please enter your email address' + "</span>";
				
				//$('#email').focus();

				result = false;
			} else if(re.test(document.getElementById('email').value) == false) {
				document.getElementById('email-error').innerHTML = "<span style=\"color:blue\">" + 'The email address seems to be invalid' + "</span>";
				
				
				//$('#email').focus();

				result = false;
			} else {
				document.getElementById('email-error').innerHTML = '';
				
			}
			return 	result;
			}

function chkpswd(){
			result = true;

			if(document.getElementById('password1').value == ''||
			document.getElementById('password1').value.length < 6/*||
			document.getElementById('password1').value.length >16*/) {
				document.getElementById('password1-error').innerHTML = "<span style=\"color:red\">" + 'Please choose a password' + "</span>";
				
				result = false;
			} 
			
			else {
				document.getElementById('password1-error').innerHTML = '';
				

				//Validate confirm password
				
			}
				return result;
			}

function confpswd(){
			result = true;

				if(document.getElementById('password2').value == '') {
					document.getElementById('password2-error').innerHTML = "<span style=\"color:red\">" + 'enter confirmation password' + "</span>";
					result = false;
				} else if(document.getElementById('password2').value != document.getElementById('password1').value) {
					document.getElementById('password2-error').innerHTML = "<span style=\"color:blue\">" + 'Passwords do not match' + "</span>";
					
					
					result = false;
				} else {
					document.getElementById('password2-error').innerHTML = '';
					
				}
			return 	result;
			}

function date(){
			result = true;
			if(document.getElementById('datepicker').value == '') {
				document.getElementById('dob-error').innerHTML ="<span style=\"color:red\">" + 'Please enter your date of birth' + "</span>";
				
				result = false;
			} 
			else {
				document.getElementById('dob-error').innerHTML = '';	
				
			}
				return result;
			}

function image(){
			result = true;
			var target = document.getElementById("photoInput").files[0];
			if(document.getElementById('photoInput').value == '') {
				document.getElementById('file-error').innerHTML = "<span style=\"color:red\">" + 'Please choose image' + "</span>";
				
				result = false;
			} 
			else if(target.type.indexOf("image") == -1) {
        		document.getElementById("file-error").innerHTML = "<span style=\"color:blue\">" +  "File not supported" + "</span>";
       			 result=false;
    		}
			else {
				document.getElementById('file-error').innerHTML = '';	
				
			}
				return result;
			}


function gender()
{
	result=true;
	if ( ( document.regform.gen[0].checked == false )
    && ( document.regform.gen[1].checked == false ) && ( document.regform.gen[2].checked == false )  )
    {
       document.getElementById('gender-error').innerHTML ="<span style=\"color:red\">" + 'Please choose gender' + "</span>";
        result = false;
    }
    else {
				document.getElementById('gender-error').innerHTML = '';	
				
			}
    return result;
}

function uname1(){
			result = true;
			
			
			var uname=document.getElementById('uname').value;
			var postStr="uname="+uname;

			var name = $("#uname").val();
			if(name.length > 3)
			{		
			$("#uname-error").html('checking...');

			$.ajax({
				type: "POST",
				url: 'username-check.php',
				dataType:'xml',
				async: false,
				data: postStr,
				success:function(res)
				{
					var returnVal=$(res).text();
					
					if(returnVal=="Available")
					{
						
						document.getElementById('uname-error').innerHTML = returnVal;
						color = 'brown';
						result = true;
					}	 

					else
					{
						document.getElementById('uname-error').innerHTML = returnVal;
						
						color = 'green';
						result = false;
					}	
					 $('#uname-error').css('color', color);		
				}
			});
		}
		else
		{
			document.getElementById('uname-error').innerHTML = "<span style=\"color:red\">" + "Username Should be more than 3 characters" + "</span>";
			
			result = false;
			//$("#uname-error").html('');
		}
			
				return result;

			}

/*function date(){
	result = true;
    var regex=new RegExp("([0-9]{4}[-](0[1-9]|1[0-2])[-]([0-2]{1}[0-9]{1}|3[0-1]{1})|([0-2]{1}[0-9]{1}|3[0-1]{1})[-](0[1-9]|1[0-2])[-][0-9]{4})");
    var dateOk=regex.test(dob);
    if(dateOk){
       document.getElementById('dob-error').innerHTML = '';
    }else{
      document.getElementById('dob-error').innerHTML = 'Please enter your date of birth';
      result = false;
    }
    return result;
}*/

function validate(){ 
	
			result=true;
			r1=fname1();
			r2=lname1();
			r3=email1();
			r4=chkpswd();
			r5=confpswd();
			r6=date();
			r7=image();
			r8=gender();
			r9=uname1();
			
			if(result==true && r1==true && r2==true && r3==true && r4==true && r5==true && r6==true && r7==true && r8==true && r9==true  ){
			
				if (checkbox.checked == false) 
				{
					alert("Please check terms and conditions");
					result = false;
				} else { 	
					document.getElementById('checkbox-error').innerHTML = '';
					result=true;
				}
				return result;
			}
			else if(r9==false)
			{
				alert("Please Choose another Username");
				return false;
			}
			else{
			return false;
			
			
			}
		}