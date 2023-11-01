(function($) {
    login();
   })(jQuery);
   
   function login() {
     $.login_landing = {
            login_sign_in: function() {

                // Form Validation Code Start
                $(document).on('click','#login', function()
                {
                    // Initialize Parsley on the form element
                    var form =$('#login_form').parsley();
                    
                    form.validate();

                    if (form.isValid()) {
                        document.getElementById('login_form').submit();
                    }                  
                });
                // Form Validation Code End
            }
        }
    }
