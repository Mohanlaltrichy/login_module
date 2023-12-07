(function($){

    $('#roles_all_checkbox').change(function()
    {             
        var isChecked = $(this).prop("checked");       
        
        if(isChecked == true)
        {
            $('.roles_checkbox').prop("checked",true);
            $('#roles_all_checkbox_value').val('1');
            $('.roles_checkbox_value').val('1');
        }   
        else
        {
            $('.roles_checkbox').prop("checked",false);
            $('#roles_all_checkbox_value').val('0');
            $('.roles_checkbox_value').val('0');
        }
    }); 
    
    $('#users_all_checkbox').change(function()
    {             
        var isChecked = $(this).prop("checked");       
        
        if(isChecked == true)
        {
            $('.users_checkbox').prop("checked",true);
            $('#users_all_checkbox_value').val('1');
            $('.users_checkbox_value').val('1');
        }   
        else
        {
            $('.users_checkbox').prop("checked",false);
            $('#users_all_checkbox_value').val('0');
            $('.users_checkbox_value').val('0');
        }
    }); 

    $('#opc_all_checkbox').change(function()
    {             
        var isChecked = $(this).prop("checked");
        if(isChecked == true)
        {
            $('.opc_checkbox').prop("checked",true);
            $('#opc_all_checkbox_value').val('1');
            $('.opc_checkbox_value').val('1');
        }   
        else
        {
            $('.opc_checkbox').prop("checked",false);
            $('#opc_all_checkbox_value').val('0');
            $('.opc_checkbox_value').val('0');
        }
    });

    $('#mqtt_all_checkbox').change(function()
    {
        var isChecked = $(this).prop("checked");

        if(isChecked == true)
        {
            $('.mqtt_checkbox').prop("checked",true);
            $('#mqtt_all_checkbox_value').val('1');
            $('.mqtt_checkbox_value').val('1');
        }
        else
        {
            $('.mqtt_checkbox').prop("checked",false);
            $('#mqtt_all_checkbox_value').val('0');
            $('.mqtt_checkbox_value').val('0');
        }
    });

    $('#http_all_checkbox').change(function()
    {             
        var isChecked = $(this).prop("checked");
        if(isChecked == true)
        {
            $('.http_checkbox').prop("checked",true);
            $('#http_all_checkbox_value').val('1');
            $('.http_checkbox_value').val('1');
        }   
        else
        {
            $('.http_checkbox').prop("checked",false);
            $('#http_all_checkbox_value').val('0');
            $('.http_checkbox_value').val('0');
        }
    });    

    $('#tag_all_checkbox').change(function()
    {
        var isChecked = $(this).prop("checked");
        if(isChecked == true)
        {
            $('.tag_checkbox').prop("checked",true);
            $('#tag_all_checkbox_value').val('1');
            $('.tag_checkbox_value').val('1');
        }
        else
        {
            $('.tag_checkbox').prop("checked",false);
            $('#tag_all_checkbox_value').val('0');
            $('.tag_checkbox_value').val('0');
        }
    });


    $('#bulk_all_checkbox').change(function()
    {
        var isChecked = $(this).prop("checked");

        if(isChecked == true)
        {
            $('.bulk_checkbox').prop("checked",true);
            $('#bulk_all_checkbox_value').val('1');
            $('.bulk_checkbox_value').val('1');
        }
        else
        {
            $('.bulk_checkbox').prop("checked",false);
            $('#bulk_all_checkbox_value').val('0');
            $('.bulk_checkbox_value').val('0');
        }
    });

    $('.roles_checkbox, .users_checkbox, .opc_checkbox, .mqtt_checkbox, .http_checkbox, .tag_checkbox, .bulk_checkbox').change(function()
    {
        var isChecked = $(this).prop("checked"); 
        var data_name = $(this).data('name');
        var data_id = $(this).data('id');       
        
        if(isChecked == true)
        {
            if(data_name == 'can_view')
            {
                $('#checkbox_view_'+data_id).val('1');
            }
            else if(data_name == 'can_edit')
            {
                $('#checkbox_edit_'+data_id).val('1');
            }
            else if(data_name == 'can_delete')
            {
                $('#checkbox_delete_'+data_id).val('1');
            }
        }
        else
        {
            if(data_name == 'can_view')
            {
                $('#checkbox_view_'+data_id).val('0');
            }
            else if(data_name == 'can_edit')
            {
                $('#checkbox_edit_'+data_id).val('0');
            }
            else if(data_name == 'can_delete')
            {
                $('#checkbox_delete_'+data_id).val('0');
            }
        }

        if($(this).hasClass('roles_checkbox'))
        {
            var roles_checkboxes = document.querySelectorAll('.roles_checkbox_div input[type="checkbox"]');

            var role_allChecked = Array.from(roles_checkboxes).every(function(rolecheckbox) {
            return rolecheckbox.checked;
            });

            if(role_allChecked == true)
            {              
                $('#roles_all_checkbox').prop("checked", true);
                $('#roles_all_checkbox_value').val('1');
            }
            else
            {               
                $('#roles_all_checkbox').prop("checked", false);
                $('#roles_all_checkbox_value').val('0');
            }
        }
        else if($(this).hasClass('users_checkbox'))
        {
            var users_checkboxes = document.querySelectorAll('.users_checkbox_div input[type="checkbox"]');

            var user_allChecked = Array.from(users_checkboxes).every(function(usercheckbox) {
            return usercheckbox.checked;
            });

            if(user_allChecked == true)
            {              
                $('#users_all_checkbox').prop("checked", true);
                $('#users_all_checkbox_value').val('1');
            }
            else
            {               
                $('#users_all_checkbox').prop("checked", false);
                $('#users_all_checkbox_value').val('0');
            }
        }
        else if($(this).hasClass('opc_checkbox'))
        {
            var opc_checkboxes = document.querySelectorAll('.opc_checkbox_div input[type="checkbox"]');

            var opc_allChecked = Array.from(opc_checkboxes).every(function(opccheckbox) {
            return opccheckbox.checked;
            });

            if(opc_allChecked == true)
            {              
                $('#opc_all_checkbox').prop("checked", true);
                $('#opc_all_checkbox_value').val('1');
            }
            else
            {               
                $('#opc_all_checkbox').prop("checked", false);
                $('#opc_all_checkbox_value').val('0');
            }
        }        
        else if($(this).hasClass('mqtt_checkbox'))
        {
            var mqtt_checkboxes = document.querySelectorAll('.mqtt_checkbox_div input[type="checkbox"]');

            var mqtt_allChecked = Array.from(mqtt_checkboxes).every(function(mqttcheckbox) {
            return mqttcheckbox.checked;
            });

            if(mqtt_allChecked == true)
            {              
                $('#mqtt_all_checkbox').prop("checked", true);
                $('#mqtt_all_checkbox_value').val('1');
            }
            else
            {               
                $('#mqtt_all_checkbox').prop("checked", false);
                $('#mqtt_all_checkbox_value').val('0');
            }
        }
        else if($(this).hasClass('http_checkbox'))
        {
            var http_checkboxes = document.querySelectorAll('.http_checkbox_div input[type="checkbox"]');

            var http_allChecked = Array.from(http_checkboxes).every(function(httpcheckbox) {
            return httpcheckbox.checked;
            });

            if(http_allChecked == true)
            {              
                $('#http_all_checkbox').prop("checked", true);
                $('#http_all_checkbox_value').val('1');
            }
            else
            {               
                $('#http_all_checkbox').prop("checked", false);
                $('#http_all_checkbox_value').val('0');
            }
        } 
        else if($(this).hasClass('tag_checkbox'))
        {
            var tag_checkboxes = document.querySelectorAll('.tag_checkbox_div input[type="checkbox"]');

            var tag_allChecked = Array.from(tag_checkboxes).every(function(tagcheckbox) {
            return tagcheckbox.checked;
            });

            if(tag_allChecked == true)
            {              
                $('#tag_all_checkbox').prop("checked", true);
                $('#tag_all_checkbox_value').val('1');
            }
            else
            {               
                $('#tag_all_checkbox').prop("checked", false);
                $('#tag_all_checkbox_value').val('0');
            }
        }
        else if($(this).hasClass('bulk_checkbox'))
        {
            var bulk_checkboxes = document.querySelectorAll('.bulk_checkbox_div input[type="checkbox"]');

            var bulk_allChecked = Array.from(bulk_checkboxes).every(function(bulkcheckbox) {
            return bulkcheckbox.checked;
            });

            if(bulk_allChecked == true)
            {              
                $('#bulk_all_checkbox').prop("checked", true);
                $('#bulk_all_checkbox_value').val('1');
            }
            else
            {               
                $('#bulk_all_checkbox').prop("checked", false);
                $('#bulk_all_checkbox_value').val('0');
            }
        }

    });

    //Status Role Update Script
    $('#status').change(function(){

        var status = $(this).val();
        const errorMessageElement = document.getElementById('status-error-message');

        if(status == 'inactive')
        {       
            errorMessageElement.textContent = 'user map to this role will be inactive';
        }
        else
        {
            errorMessageElement.textContent = '';            
        }

    });

    //Add Company Role
    $('#save_company_role').click(function(){

        var form =$('#add_company_role_client_config').parsley();        
        form.validate();

        var role_name_duplicate = $('#role_name_duplicate').val();

        if (form.isValid() && role_name_duplicate != '1') {
            $('form#add_company_role_client_config').submit();
        }

    });

    $('#role_name').blur(function(){

        var role_name = $(this).val();
        const errorMessageElement = document.getElementById('error-message');

        $.ajax({
            url: base_url+"company_role/company_role_duplicate_check",
            type: 'GET',
            dataType: 'json',
            data: {      
                'role_name': role_name,                        
            },
            success: function(data) {                
                if(data.role_name)
                {      
                   $('#role_name').addClass('parsley-error');
                   errorMessageElement.textContent = 'This Role Name Already Exists.';             
                   $('#role_name_duplicate').val('1');
                }
                else
                {
                   errorMessageElement.textContent = '';
                   $('#role_name').removeClass('parsley-error');    
                   $('#role_name_duplicate').val('0');
                }
            }
        });

    });

     //Update Company Role
     $('#update_company_role').click(function(){

        var form =$('#update_company_role_client_config').parsley();        
        form.validate();

        if (form.isValid()) {
            $('.custom_update_model_alert').modal('show');        
        }
    });

    //Update Rrigger
    $(document).on('click','#update_save_changes', function()
    {
        $('.custom_update_model_alert').modal('hide');
        $('form#update_company_role_client_config').submit();
    });

    //Delete Role            
    $(document).on('click','#delete_role_list', function()
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
                    url: base_url+'company_role/roledelete',
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