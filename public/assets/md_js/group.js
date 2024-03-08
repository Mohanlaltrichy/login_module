(function($){

    //Add New Group
    $('#save_group').click(function(){

        var form =$('#add_group_details').parsley();        
        form.validate();

        var group_name_duplicate = $('#group_name_duplicate').val();

        if (form.isValid() && group_name_duplicate != '1') {
            $('form#add_group_details').submit();
        }
    });

    //Update Group Details
    $('#update_group').click(function(){

        var form =$('#update_group_details').parsley();     
        form.validate();

        if (form.isValid()) {
            $('form#update_group_details').submit();                    
        }
    });

     //Delete Group          
     $(document).on('click','#delete_group_list', function()
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
                     url: base_url+'group/groupdelete',
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

    //
    var check_all = true;  
    $('#checkAll').click( function(){  
        if(check_all){
            $('.valbadge').val("1");  
            check_all = false;
            $(".change-checkbox-value").prop("checked", true);
        }
        else{        
            $('.valbadge').val("0");    
            check_all = true;
            $(".change-checkbox-value").prop("checked", false);
        }
    }); 

    $('#update_user_mapped').click( function(){
    
        var group_id = $('#group_id').val();

        // Get all checkboxes with the specified class name
        var checkboxes = document.querySelectorAll('.change-checkbox-value');
        
        // Array to store data-id values of checked checkboxes
        var user_checkedIds = [];
        
        // Iterate over checkboxes
        checkboxes.forEach(function(checkbox) {
            // Check if checkbox is checked
            if (checkbox.checked) {
                // Get data-id attribute value and push it to checkedIds array
                var dataId = checkbox.getAttribute('data-id');
                user_checkedIds.push(dataId);
            }
        });

        $.ajax({
            url: base_url+'group/group_user_update',
            method: 'GET',
            data: {group_id: group_id,user_checkedIds: user_checkedIds },
            dataType: 'json',
            success: function(response){                        
                window.location.reload();                            
            },
            error: function(xhr, status, error) {
                // Handle errors, if any
                console.log(error);                            
            }
        });
    });

    //
    $('#group_name').blur(function(){

        var group_name = $(this).val();
        const errorMessageElement = document.getElementById('error-message');

        $.ajax({
            url: base_url+"group/group_duplicate_check",
            type: 'GET',
            dataType: 'json',
            data: {      
                'group_name': group_name,                        
            },
            success: function(data) {                
                if(data.group_name)
                {      
                   $('#group_name').addClass('parsley-error');
                   errorMessageElement.textContent = 'This Group Name Already Exists.';             
                   $('#group_name_duplicate').val('1');
                }
                else
                {
                   errorMessageElement.textContent = '';
                   $('#group_name').removeClass('parsley-error');    
                   $('#group_name_duplicate').val('0');
                }
            }
        });

    });
    
    $(document).ready(function(){//document.ready

        setTimeout(function() {
            var parenterrordiv = document.getElementById('custom_error_alert_controller_message');
            $("#custom_error_alert_controller_message").addClass('fade-out'); // Custom Error Alert Hide
            parenterrordiv.style.opacity = '0';
            $("#custom_error_alert_controller_message").addClass('d-none');

            var parenterrorerrordiv = document.getElementById('custom_error_alert_message');
            $("#custom_error_alert_message").addClass('fade-out'); // Custom Error Alert Hide
            parenterrorerrordiv.style.opacity = '0';
            $("#custom_error_alert_message").addClass('d-none');

            var parentsuccessdiv = document.getElementById('custom_success_alert_controller_message');
            $("#custom_success_alert_controller_message").addClass('fade-out'); // Custom Error Alert Hide
            parentsuccessdiv.style.opacity = '0';
            $("#custom_success_alert_controller_message").addClass('d-none');
        }, 10000); // 10000 milliseconds = 10 second

    });//document.ready

})(jQuery);