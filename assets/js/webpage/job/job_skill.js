
//Validation Start
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

 $("#jobseeker_regform").validate({

        
         rules: {

                industry: {

                    required: true,
                 
                },
               job_title: {

                    required: true,
                     regx1:/^[-@./#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/,       
                },
                
                skills: {
                    required: true,
                     regx1:/^[-@./#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/,

                }, 
                 cities: {

                    required: true,
                     regx1:/^[-@./#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/,
                  
                 },             
            },

            messages: {

                industry: {

                    required: "Industry is required.",

                },

                job_title: {

                    required: "Job title is required.",

                },

                skills: {

                    required: "Skill is required.",
                   
                },
               
                cities: {

                    required: "City is required.",

                },           
            },

        });
//Validation End
