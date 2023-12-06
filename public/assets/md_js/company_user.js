(function($){
    
    $(document).on('click','#save_user', function(){

        $('#message').html('');
        
        var form =$('#company_user_form').parsley();
        form.validate();

        var pwd = $('#password').val();
        var c_pwd = $('#conf_password').val();

        if (pwd == c_pwd) {
            $('#message').html('');
            $('#remove_content').val('1');
        }else {
            $('#remove_content').val('0');
            $('#message').html('Passwords do not match').css('color', '#ff4d4d');
        }

      var valid = $('#remove_content').val();
        if (form.isValid() && valid == 1 ) {
            $('form#company_user_form').submit();
        } 
});

     //Update Company Role
     $(document).on('click','#update_user', function(){

        var form =$('#update_company_user_client_config').parsley();        
        form.validate();
        $('#c_pwd').prop('required',false);

        var pwd = $('#pwd').val();
        var c_pwd = $('#c_pwd').val();

        if (pwd !== '' && c_pwd == '') {
            $('#c_pwd').prop('required',true);
        }else{
            if (pwd == c_pwd) {
                $('#edmessage').html('');
                $('#ccheck').val('1');
            }else {
                $('#ccheck').val('0');
                $('#edmessage').html('Passwords do not match').css('color', '#ff4d4d');
            }
        }
        var ccheckval = $('#ccheck').val();
        if (form.isValid() && ccheckval == 1 ) {
            $('.custom_update_model_alert').modal('show');        
        }
    });

    //Update Rrigger
    $(document).on('click','#update_save_changes', function()
    {
        $('.custom_update_model_alert').modal('hide');
        $('form#update_company_user_client_config').submit();
    });

      //Delete Role            
      $(document).on('click','#delete_user', function()
      {           
          var id = $(this).data('id');
          $('#this_id').val(id);  
          $('.custom_model_alert').modal('show');               
          });
  
          $(document).on('click','#save_changes', function()
          {           
              var id =  $('#this_id').val();            
              $('.custom_model_alert').modal('hide');
              if(id != '')
              {
                  $.ajax({
                      url: base_url+'company_user/userdelete',
                      method: 'GET',
                      data: {id: id},
                      dataType: 'json',
                      success: function(response){                        
                          window.location.reload();                            
                      },
                      error: function(xhr, status, error) {
                          // Handle errors, if any
                          console.log(error);                            
                      }
                  });
              }            
          
      });
      //Delete Role  

setTimeout(function() {
    var parenterrordiv = document.getElementById('custom_error_alert_controller_message');
    $("#custom_error_alert_controller_message").addClass('fade-out'); // Custom Error Alert Hide
    parenterrordiv.style.opacity = '0';
    $("#custom_error_alert_controller_message").addClass('d-none');

    var parentsuccessdiv = document.getElementById('custom_success_alert_controller_message');
    $("#custom_success_alert_controller_message").addClass('fade-out'); // Custom Error Alert Hide
    parentsuccessdiv.style.opacity = '0';
    $("#custom_success_alert_controller_message").addClass('d-none');
}, 10000); // 10000 milliseconds = 10 second


})(jQuery);