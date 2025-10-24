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

    $('#groups_all_checkbox').change(function()
    {             
        var isChecked = $(this).prop("checked");       
        
        if(isChecked == true)
        {
            $('.groups_checkbox').prop("checked",true);
            $('#groups_all_checkbox_value').val('1');
            $('.groups_checkbox_value').val('1');
        }   
        else
        {
            $('.groups_checkbox').prop("checked",false);
            $('#groups_all_checkbox_value').val('0');
            $('.groups_checkbox_value').val('0');
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

    $('#aggregation_all_checkbox').change(function()
    {
        var isChecked = $(this).prop("checked");
        if(isChecked == true)
        {
            $('.aggregation_checkbox').prop("checked",true);
            $('#aggregation_all_checkbox_value').val('1');
            $('.aggregation_checkbox_value').val('1');
        }
        else
        {
            $('.aggregation_checkbox').prop("checked",false);
            $('#aggregation_all_checkbox_value').val('0');
            $('.aggregation_checkbox_value').val('0');
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

    $('#dashboard_all_checkbox').change(function()
    {
        var isChecked = $(this).prop("checked");

        if(isChecked == true)
        {
            $('.dashboard_checkbox').prop("checked",true);
            $('#dashboard_all_checkbox_value').val('1');
            $('.dashboard_checkbox_value').val('1');
        }
        else
        {
            $('.dashboard_checkbox').prop("checked",false);
            $('#dashboard_all_checkbox_value').val('0');
            $('.dashboard_checkbox_value').val('0');
        }
    });

    $('#reports_all_checkbox').change(function()
    {
        var isChecked = $(this).prop("checked");

        if(isChecked == true)
        {
            $('.reports_checkbox').prop("checked",true);
            $('#reports_all_checkbox_value').val('1');
            $('.reports_checkbox_value').val('1');
        }
        else
        {
            $('.reports_checkbox').prop("checked",false);
            $('#reports_all_checkbox_value').val('0');
            $('.reports_checkbox_value').val('0');
        }
    });

    $('#notification_all_checkbox').change(function()
    {
        var isChecked = $(this).prop("checked");

        if(isChecked == true)
        {
            $('.notification_checkbox').prop("checked",true);
            $('#notification_all_checkbox_value').val('1');
            $('.notification_checkbox_value').val('1');
        }
        else
        {
            $('.notification_checkbox').prop("checked",false);
            $('#notification_all_checkbox_value').val('0');
            $('.notification_checkbox_value').val('0');
        }
    });

    $('#subscription_all_checkbox').change(function()
    {
        var isChecked = $(this).prop("checked");

        if(isChecked == true)
        {
            $('.subscription_checkbox').prop("checked",true);
            $('#subscription_all_checkbox_value').val('1');
            $('.subscription_checkbox_value').val('1');
        }
        else
        {
            $('.subscription_checkbox').prop("checked",false);
            $('#subscription_all_checkbox_value').val('0');
            $('.subscription_checkbox_value').val('0');
        }
    });

    $('#ai_prediction_all_checkbox').change(function()
    {
        var isChecked = $(this).prop("checked");

        if(isChecked == true)
        {
            $('.ai_prediction_checkbox').prop("checked",true);
            $('#ai_prediction_all_checkbox_value').val('1');
            $('.ai_prediction_checkbox_value').val('1');
        }
        else
        {
            $('.ai_prediction_checkbox').prop("checked",false);
            $('#ai_prediction_all_checkbox_value').val('0');
            $('.ai_prediction_checkbox_value').val('0');
        }
    });

    // codes for model builder starts here
    // dataroot code starts here
    $('#model_builder_all_dataroot_checkbox').change(function () {
        var isChecked = $(this).prop("checked");
        if (isChecked == true) {
            $('.model_builder_dataroot_checkbox').prop("checked", true);
            $('#model_builder_all_dataroot_checkbox_value').val('1');
            $('.model_builder_dataroot_checkbox_value').val('1');
        }
        else {
            $('.model_builder_dataroot_checkbox').prop("checked", false);
            $('#model_builder_all_dataroot_checkbox_value').val('0');
            $('.model_builder_dataroot_checkbox_value').val('0');
        }
    });
    // dataroot code ends here

    // project code starts here
    $('#model_builder_all_project_checkbox').change(function () {
        var isChecked = $(this).prop("checked");
        if (isChecked) {
            $('.model_builder_project_checkbox').prop("checked", true);
            $('#model_builder_all_project_checkbox_value').val('1');
            $('.model_builder_project_checkbox_value').val('1');
        } else {
            $('.model_builder_project_checkbox').prop("checked", false);
            $('#model_builder_all_project_checkbox_value').val('0');
            $('.model_builder_project_checkbox_value').val('0');
        }
    });
    // project code ends here

    // node code starts here
     $('#model_builder_all_node_checkbox').change(function () {
        var isChecked = $(this).prop("checked");
        if (isChecked) {
            $('.model_builder_node_checkbox').prop("checked", true);
            $('#model_builder_all_node_checkbox_value').val('1');
            $('.model_builder_node_checkbox_value').val('1');
        } else {
            $('.model_builder_node_checkbox').prop("checked", false);
            $('#model_builder_all_node_checkbox_value').val('0');
            $('.model_builder_node_checkbox_value').val('0');
        }
    });
    // node code ends here

    // node paaremeter code starts here
    $('#model_builder_all_node_parameter_checkbox').change(function () {
        var isChecked = $(this).prop("checked");
        if (isChecked) {
            $('.model_builder_node_parameter_checkbox').prop("checked", true);
            $('#model_builder_all_node_parameter_checkbox_value').val('1');
            $('.model_builder_node_parameter_checkbox_value').val('1');
        } else {
            $('.model_builder_node_parameter_checkbox').prop("checked", false);
            $('#model_builder_all_node_parameter_checkbox_value').val('0');
            $('.model_builder_node_parameter_checkbox_value').val('0');
        }
    });
    // node paaremeter code ends here

    // node calculation starts here
    $('#model_builder_all_node_calculation_checkbox').change(function () {
        var isChecked = $(this).prop("checked");
        if (isChecked) {
            $('.model_builder_node_calculation_checkbox').prop("checked", true);
            $('#model_builder_all_node_calculation_checkbox_value').val('1');
            $('.model_builder_node_calculation_checkbox_value').val('1');
        } else {
            $('.model_builder_node_calculation_checkbox').prop("checked", false);
            $('#model_builder_all_node_calculation_checkbox_value').val('0');
            $('.model_builder_node_calculation_checkbox_value').val('0');
        }
    });
    // node calculation starts here

    // node expression code starts here
    $('#model_builder_all_node_expression_checkbox').change(function () {
        var isChecked = $(this).prop("checked");
        if (isChecked) {
            $('.model_builder_node_expression_checkbox').prop("checked", true);
            $('#model_builder_all_node_expression_checkbox_value').val('1');
            $('.model_builder_node_expression_checkbox_value').val('1');
        } else {
            $('.model_builder_node_expression_checkbox').prop("checked", false);
            $('#model_builder_all_node_expression_checkbox_value').val('0');
            $('.model_builder_node_expression_checkbox_value').val('0');
        }
    });
    // node expression code ends here

    // search code starts here
    $('#model_builder_all_search_checkbox').change(function () {
        var isChecked = $(this).prop("checked");
        if (isChecked) {
            $('.model_builder_search_checkbox').prop("checked", true);
            $('#model_builder_all_search_checkbox_value').val('1');
            $('.model_builder_search_checkbox_value').val('1');
        } else {
            $('.model_builder_search_checkbox').prop("checked", false);
            $('#model_builder_all_search_checkbox_value').val('0');
            $('.model_builder_search_checkbox_value').val('0');
        }
    });
    // search code ends here

    // template code starts here
    $('#model_builder_all_template_checkbox').change(function () {
        var isChecked = $(this).prop("checked");
        if (isChecked) {
            $('.model_builder_template_checkbox').prop("checked", true);
            $('#model_builder_all_template_checkbox_value').val('1');
            $('.model_builder_template_checkbox_value').val('1');
        } else {
            $('.model_builder_template_checkbox').prop("checked", false);
            $('#model_builder_all_template_checkbox_value').val('0');
            $('.model_builder_template_checkbox_value').val('0');
        }
    });
    // template code ends here

    // template parameter code starts here
    $('#model_builder_all_template_parameter_checkbox').change(function () {
        var isChecked = $(this).prop("checked");
        if (isChecked) {
            $('.model_builder_template_parameter_checkbox').prop("checked", true);
            $('#model_builder_all_template_parameter_checkbox_value').val('1');
            $('.model_builder_template_parameter_checkbox_value').val('1');
        } else {
            $('.model_builder_template_parameter_checkbox').prop("checked", false);
            $('#model_builder_all_template_parameter_checkbox_value').val('0');
            $('.model_builder_template_parameter_checkbox_value').val('0');
        }
    });
    // template parameter code ends here

    // template calculation code starts here
    // Handle "Select All" checkbox for Template Calculation
    $('#model_builder_all_template_calculation_checkbox').change(function () {
        var isChecked = $(this).prop("checked");
        if (isChecked) {
            $('.model_builder_template_calculation_checkbox').prop("checked", true);
            $('#model_builder_all_template_calculation_checkbox_value').val('1');
            $('.model_builder_template_calculation_checkbox_value').val('1');
        } else {
            $('.model_builder_template_calculation_checkbox').prop("checked", false);
            $('#model_builder_all_template_calculation_checkbox_value').val('0');
            $('.model_builder_template_calculation_checkbox_value').val('0');
        }
    });
    // template calculation code ends here

    // template expression code starts here
    $('#model_builder_all_template_expression_checkbox').change(function () {
        var isChecked = $(this).prop("checked");
        if (isChecked) {
            $('.model_builder_template_expression_checkbox').prop("checked", true);
            $('#model_builder_all_template_expression_checkbox_value').val('1');
            $('.model_builder_template_expression_checkbox_value').val('1');
        } else {
            $('.model_builder_template_expression_checkbox').prop("checked", false);
            $('#model_builder_all_template_expression_checkbox_value').val('0');
            $('.model_builder_template_expression_checkbox_value').val('0');
        }
    });
    // template expression code ends here

    // tag code starts here
    $('#model_builder_all_tag_checkbox').change(function () {
        var isChecked = $(this).prop("checked");
        if (isChecked) {
            $('.model_builder_tag_checkbox').prop("checked", true);
            $('#model_builder_all_tag_checkbox_value').val('1');
            $('.model_builder_tag_checkbox_value').val('1');
        } else {
            $('.model_builder_tag_checkbox').prop("checked", false);
            $('#model_builder_all_tag_checkbox_value').val('0');
            $('.model_builder_tag_checkbox_value').val('0');
        }
    });
    // tag code ends here

    // uom categories code starts here
    $('#model_builder_all_uom_category_checkbox').change(function () {
        var isChecked = $(this).prop("checked");
        if (isChecked) {
            $('.model_builder_uom_category_checkbox').prop("checked", true);
            $('#model_builder_all_uom_category_checkbox_value').val('1');
            $('.model_builder_uom_category_checkbox_value').val('1');
        } else {
            $('.model_builder_uom_category_checkbox').prop("checked", false);
            $('#model_builder_all_uom_category_checkbox_value').val('0');
            $('.model_builder_uom_category_checkbox_value').val('0');
        }
    });
    // uom categories code ends here

    // uom conversion code starts here
    $('#model_builder_all_uom_conversions_checkbox').change(function () {
        var isChecked = $(this).prop("checked");
        if (isChecked) {
            $('.model_builder_uom_conversions_checkbox').prop("checked", true);
            $('#model_builder_all_uom_conversions_checkbox_value').val('1');
            $('.model_builder_uom_conversions_checkbox_value').val('1');
        } else {
            $('.model_builder_uom_conversions_checkbox').prop("checked", false);
            $('#model_builder_all_uom_conversions_checkbox_value').val('0');
            $('.model_builder_uom_conversions_checkbox_value').val('0');
        }
    });
    // uom conversion code ends here

    // group code starts here
    $('#model_builder_all_group_checkbox').change(function () {
        var isChecked = $(this).prop("checked");
        if (isChecked) {
            $('.model_builder_group_checkbox').prop("checked", true);
            $('#model_builder_all_group_checkbox_value').val('1');
            $('.model_builder_group_checkbox_value').val('1');
        } else {
            $('.model_builder_group_checkbox').prop("checked", false);
            $('#model_builder_all_group_checkbox_value').val('0');
            $('.model_builder_group_checkbox_value').val('0');
        }
    });
    // group code ends here

    // template mapped node
     $('#model_builder_all_template_mapped_node_checkbox').change(function () {
     var isChecked = $(this).prop("checked");
     if (isChecked) {
         $('.model_builder_template_mapped_node_checkbox').prop("checked", true);
         $('#model_builder_all_template_mapped_node_checkbox_value').val('1');
         $('.model_builder_template_mapped_node_checkbox_value').val('1');
     } else {
         $('.model_builder_template_mapped_node_checkbox').prop("checked", false);
         $('#model_builder_all_template_mapped_node_checkbox_value').val('0');
         $('.model_builder_template_mapped_node_checkbox_value').val('0');
     }
     });
    // template mapped node

    // codes for model builder ends here

    $('.roles_checkbox, .users_checkbox, .groups_checkbox, .opc_checkbox, .mqtt_checkbox, .http_checkbox, .tag_checkbox, .aggregation_checkbox, .bulk_checkbox, .dashboard_checkbox, .reports_checkbox, .notification_checkbox, .subscription_checkbox, .ai_prediction_checkbox, .model_builder_dataroot_checkbox,.model_builder_project_checkbox,.model_builder_node_checkbox,.model_builder_node_parameter_checkbox,.model_builder_node_calculation_checkbox,.model_builder_node_expression_checkbox,.model_builder_search_checkbox,.model_builder_template_checkbox,.model_builder_template_parameter_checkbox,.model_builder_template_calculation_checkbox,.model_builder_template_expression_checkbox,.model_builder_tag_checkbox,.model_builder_uom_category_checkbox,.model_builder_uom_conversions_checkbox,.model_builder_group_checkbox,.model_builder_template_mapped_node_checkbox').change(function()
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
        else if($(this).hasClass('groups_checkbox'))
        {
            var groups_checkboxes = document.querySelectorAll('.groups_checkbox_div input[type="checkbox"]');

            var user_allChecked = Array.from(groups_checkboxes).every(function(usercheckbox) {
            return usercheckbox.checked;
            });

            if(user_allChecked == true)
            {              
                $('#groups_all_checkbox').prop("checked", true);
                $('#groups_all_checkbox_value').val('1');
            }
            else
            {               
                $('#groups_all_checkbox').prop("checked", false);
                $('#groups_all_checkbox_value').val('0');
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
        else if($(this).hasClass('aggregation_checkbox'))
        {
            var aggregation_checkboxes = document.querySelectorAll('.aggregation_checkbox_div input[type="checkbox"]');

            var aggregation_allChecked = Array.from(aggregation_checkboxes).every(function(aggregationcheckbox) {
            return aggregationcheckbox.checked;
            });

            if(aggregation_allChecked == true)
            {              
                $('#aggregation_all_checkbox').prop("checked", true);
                $('#aggregation_all_checkbox_value').val('1');
            }
            else
            {               
                $('#aggregation_all_checkbox').prop("checked", false);
                $('#aggregation_all_checkbox_value').val('0');
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
        else if($(this).hasClass('dashboard_checkbox'))
        {
            var dashboard_checkboxes = document.querySelectorAll('.dashboard_checkbox_div input[type="checkbox"]');

            var dashboard_allChecked = Array.from(dashboard_checkboxes).every(function(dashboardcheckbox) {
            return dashboardcheckbox.checked;
            });

            if(dashboard_allChecked == true)
            {              
                $('#dashboard_all_checkbox').prop("checked", true);
                $('#dashboard_all_checkbox_value').val('1');
            }
            else
            {               
                $('#dashboard_all_checkbox').prop("checked", false);
                $('#dashboard_all_checkbox_value').val('0');
            }
        }
        else if($(this).hasClass('reports_checkbox'))
        {
            var reports_checkboxes = document.querySelectorAll('.reports_checkbox_div input[type="checkbox"]');

            var reports_allChecked = Array.from(reports_checkboxes).every(function(reportscheckbox) {
            return reportscheckbox.checked;
            });

            if(reports_allChecked == true)
            {              
                $('#reports_all_checkbox').prop("checked", true);
                $('#reports_all_checkbox_value').val('1');
            }
            else
            {               
                $('#reports_all_checkbox').prop("checked", false);
                $('#reports_all_checkbox_value').val('0');
            }
        }
        else if($(this).hasClass('notification_checkbox'))
        {
            var notification_checkboxes = document.querySelectorAll('.notification_checkbox_div input[type="checkbox"]');

            var notification_allChecked = Array.from(notification_checkboxes).every(function(notificationscheckbox) {
            return notificationscheckbox.checked;
            });

            if(notification_allChecked == true)
            {              
                $('#notification_all_checkbox').prop("checked", true);
                $('#notification_all_checkbox_value').val('1');
            }
            else
            {               
                $('#notification_all_checkbox').prop("checked", false);
                $('#notification_all_checkbox_value').val('0');
            }
        }
        else if($(this).hasClass('subscription_checkbox'))
        {
            var subscription_checkboxes = document.querySelectorAll('.subscription_checkbox_div input[type="checkbox"]');

            var subscription_allChecked = Array.from(subscription_checkboxes).every(function(subscriptioncheckbox) {
            return subscriptioncheckbox.checked;
            });

            if(subscription_allChecked == true)
            {              
                $('#subscription_all_checkbox').prop("checked", true);
                $('#subscription_all_checkbox_value').val('1');
            }
            else
            {               
                $('#subscription_all_checkbox').prop("checked", false);
                $('#subscription_all_checkbox_value').val('0');
            }
        }
        else if($(this).hasClass('ai_prediction_checkbox'))
        {
            var ai_prediction_checkboxes = document.querySelectorAll('.ai_prediction_checkbox_div input[type="checkbox"]');

            var ai_prediction_allChecked = Array.from(ai_prediction_checkboxes).every(function(ai_predictioncheckbox) {
            return ai_predictioncheckbox.checked;
            });

            if(ai_prediction_allChecked == true)
            {              
                $('#ai_prediction_all_checkbox').prop("checked", true);
                $('#ai_prediction_all_checkbox_value').val('1');
            }
            else
            {               
                $('#ai_prediction_all_checkbox').prop("checked", false);
                $('#ai_prediction_all_checkbox_value').val('0');
            }
        }

        // model builder code starts here
        // dataroot code starts here 
        else if ($(this).hasClass('model_builder_dataroot_checkbox')) {
            var dataroot_checkboxes = document.querySelectorAll('.model_builder_dataroot_checkbox_div input[type="checkbox"]');

            var dataroot_allChecked = Array.from(dataroot_checkboxes).every(function (checkbox) {
                return checkbox.checked;
            });

            if (dataroot_allChecked == true) {
                $('#model_builder_all_dataroot_checkbox').prop("checked", true);
                $('#model_builder_all_dataroot_checkbox_value').val('1');
            } else {
                $('#model_builder_all_dataroot_checkbox').prop("checked", false);
                $('#model_builder_all_dataroot_checkbox_value').val('0');
            }
        }

        // dataroot code ends here 

        // for project
        else if ($(this).hasClass('model_builder_project_checkbox')) {
            var project_checkboxes = document.querySelectorAll('.model_builder_project_checkbox_div input[type="checkbox"]');

            var project_allChecked = Array.from(project_checkboxes).every(function (checkbox) {
                return checkbox.checked;
            });

            if (project_allChecked == true) {
                $('#model_builder_all_project_checkbox').prop("checked", true);
                $('#model_builder_all_project_checkbox_value').val('1');
            } else {
                $('#model_builder_all_project_checkbox').prop("checked", false);
                $('#model_builder_all_project_checkbox_value').val('0');
            }
        }

        // for project

        // for node
        else if ($(this).hasClass('model_builder_node_checkbox')) {
            var node_checkboxes = document.querySelectorAll('.model_builder_node_checkbox_div input[type="checkbox"]');

            var node_allChecked = Array.from(node_checkboxes).every(function (checkbox) {
                return checkbox.checked;
            });

            if (node_allChecked == true) {
                $('#model_builder_all_node_checkbox').prop("checked", true);
                $('#model_builder_all_node_checkbox_value').val('1');
            } else {
                $('#model_builder_all_node_checkbox').prop("checked", false);
                $('#model_builder_all_node_checkbox_value').val('0');
            }
        }

        // for node

        // for node parameter
        else if ($(this).hasClass('model_builder_node_parameter_checkbox')) {
            var model_builder_node_parameter_checkboxes = document.querySelectorAll('.model_builder_node_parameter_checkbox_div input[type="checkbox"]');

            var node_parameter_allChecked = Array.from(model_builder_node_parameter_checkboxes).every(function (nodeParameterBox) {
                return nodeParameterBox.checked;
            });

            if (node_parameter_allChecked === true) {
                $('#model_builder_all_node_parameter_checkbox').prop("checked", true);
                $('#model_builder_all_node_parameter_checkbox_value').val('1');
            } else {
                $('#model_builder_all_node_parameter_checkbox').prop("checked", false);
                $('#model_builder_all_node_parameter_checkbox_value').val('0');
            }
        }
       
        // for node parameter

        // node calculation code starts here
        else if ($(this).hasClass('model_builder_node_calculation_checkbox')) {
            var checkboxes = document.querySelectorAll('.model_builder_node_calculation_checkbox_div input[type="checkbox"]');

            var allChecked = Array.from(checkboxes).every(function (checkbox) {
                return checkbox.checked;
            });

            if (allChecked === true) {
                $('#model_builder_all_node_calculation_checkbox').prop("checked", true);
                $('#model_builder_all_node_calculation_checkbox_value').val('1');
            } else {
                $('#model_builder_all_node_calculation_checkbox').prop("checked", false);
                $('#model_builder_all_node_calculation_checkbox_value').val('0');
            }
        }
        // node calculation code starts here

        // node expression code starts here
        else if ($(this).hasClass('model_builder_node_expression_checkbox')) {
            var checkboxes = document.querySelectorAll('.model_builder_node_expression_checkbox_div input[type="checkbox"]');

            var allChecked = Array.from(checkboxes).every(function (checkbox) {
                return checkbox.checked;
            });

            if (allChecked === true) {
                $('#model_builder_all_node_expression_checkbox').prop("checked", true);
                $('#model_builder_all_node_expression_checkbox_value').val('1');
            } else {
                $('#model_builder_all_node_expression_checkbox').prop("checked", false);
                $('#model_builder_all_node_expression_checkbox_value').val('0');
            }
        }
        // node expression code ends here

        // seacrh code starts here
        else if ($(this).hasClass('model_builder_search_checkbox')) {
            var checkboxes = document.querySelectorAll('.model_builder_search_checkbox_div input[type="checkbox"]');

            var allChecked = Array.from(checkboxes).every(function (checkbox) {
                return checkbox.checked;
            });

            if (allChecked === true) {
                $('#model_builder_all_search_checkbox').prop("checked", true);
                $('#model_builder_all_search_checkbox_value').val('1');
            } else {
                $('#model_builder_all_search_checkbox').prop("checked", false);
                $('#model_builder_all_search_checkbox_value').val('0');
            }
        }
        // seacrh code ends here

        //template code starts here
        else if ($(this).hasClass('model_builder_template_checkbox')) {
            var templateCheckboxes = document.querySelectorAll('.model_builder_template_checkbox_div input[type="checkbox"]');

            var allChecked = Array.from(templateCheckboxes).every(function (checkbox) {
                return checkbox.checked;
            });

            if (allChecked === true) {
                $('#model_builder_all_template_checkbox').prop("checked", true);
                $('#model_builder_all_template_checkbox_value').val('1');
            } else {
                $('#model_builder_all_template_checkbox').prop("checked", false);
                $('#model_builder_all_template_checkbox_value').val('0');
            }
        }
        //template code ends here

        // template parameter code starts here
        else if ($(this).hasClass('model_builder_template_parameter_checkbox')) {
            var checkboxes = document.querySelectorAll('.model_builder_template_parameter_checkbox_div input[type="checkbox"]');

            var allChecked = Array.from(checkboxes).every(function (checkbox) {
                return checkbox.checked;
            });

            if (allChecked) {
                $('#model_builder_all_template_parameter_checkbox').prop("checked", true);
                $('#model_builder_all_template_parameter_checkbox_value').val('1');
            } else {
                $('#model_builder_all_template_parameter_checkbox').prop("checked", false);
                $('#model_builder_all_template_parameter_checkbox_value').val('0');
            }
        }
        // template parameter code ends here

        // template calculation code starts here
        else if ($(this).hasClass('model_builder_template_calculation_checkbox')) {
            var calculationCheckboxes = document.querySelectorAll('.model_builder_template_calculation_checkbox_div input[type="checkbox"]');

            var allChecked = Array.from(calculationCheckboxes).every(function (checkbox) {
                return checkbox.checked;
            });

            if (allChecked) {
                $('#model_builder_all_template_calculation_checkbox').prop("checked", true);
                $('#model_builder_all_template_calculation_checkbox_value').val('1');
            } else {
                $('#model_builder_all_template_calculation_checkbox').prop("checked", false);
                $('#model_builder_all_template_calculation_checkbox_value').val('0');
            }
        }
        // template calculation code ends here

        // template expression code starts here
        else if ($(this).hasClass('model_builder_template_expression_checkbox')) {
            var expressionCheckboxes = document.querySelectorAll('.model_builder_template_expression_checkbox_div input[type="checkbox"]');

            var allChecked = Array.from(expressionCheckboxes).every(function (checkbox) {
                return checkbox.checked;
            });

            if (allChecked) {
                $('#model_builder_all_template_expression_checkbox').prop("checked", true);
                $('#model_builder_all_template_expression_checkbox_value').val('1');
            } else {
                $('#model_builder_all_template_expression_checkbox').prop("checked", false);
                $('#model_builder_all_template_expression_checkbox_value').val('0');
            }
        }
        // template expression code ends here

        // template mapped node code starts here
          else if ($(this).hasClass('model_builder_template_mapped_node_checkbox')) {
            var mappedNodeCheckboxes = document.querySelectorAll('.model_builder_template_mapped_node_checkbox_div input[type="checkbox"]');

            var allChecked = Array.from(mappedNodeCheckboxes).every(function (checkbox) {
                return checkbox.checked;
            });

            if (allChecked) {
                $('#model_builder_all_template_mapped_node_checkbox').prop("checked", true);
                $('#model_builder_all_template_mapped_node_checkbox_value').val('1');
            } else {
                $('#model_builder_all_template_mapped_node_checkbox').prop("checked", false);
                $('#model_builder_all_template_mapped_node_checkbox_value').val('0');
            }
        }
        // template mapped node code starts ends


        // tag code starts here
        else if ($(this).hasClass('model_builder_tag_checkbox')) {
            var tagCheckboxes = document.querySelectorAll('.model_builder_tag_checkbox_div input[type="checkbox"]');

            var allChecked = Array.from(tagCheckboxes).every(function (checkbox) {
                return checkbox.checked;
            });

            if (allChecked) {
                $('#model_builder_all_tag_checkbox').prop("checked", true);
                $('#model_builder_all_tag_checkbox_value').val('1');
            } else {
                $('#model_builder_all_tag_checkbox').prop("checked", false);
                $('#model_builder_all_tag_checkbox_value').val('0');
            }
        }
        // tag code ends here 
        
        // uom categories code starts here
        else if ($(this).hasClass('model_builder_uom_category_checkbox')) {
            var uomCategoryCheckboxes = document.querySelectorAll('.model_builder_uom_category_checkbox_div input[type="checkbox"]');

            var allChecked = Array.from(uomCategoryCheckboxes).every(function (checkbox) {
                return checkbox.checked;
            });

            if (allChecked) {
                $('#model_builder_all_uom_category_checkbox').prop("checked", true);
                $('#model_builder_all_uom_category_checkbox_value').val('1');
            } else {
                $('#model_builder_all_uom_category_checkbox').prop("checked", false);
                $('#model_builder_all_uom_category_checkbox_value').val('0');
            }
        }
        // uom categories code ends here

        // uom conversions code starts here
        else if ($(this).hasClass('model_builder_uom_conversions_checkbox')) {
            var uomConversionsCheckboxes = document.querySelectorAll('.model_builder_uom_conversions_checkbox_div input[type="checkbox"]');

            var allChecked = Array.from(uomConversionsCheckboxes).every(function (checkbox) {
                return checkbox.checked;
            });

            if (allChecked) {
                $('#model_builder_all_uom_conversions_checkbox').prop("checked", true);
                $('#model_builder_all_uom_conversions_checkbox_value').val('1');
            } else {
                $('#model_builder_all_uom_conversions_checkbox').prop("checked", false);
                $('#model_builder_all_uom_conversions_checkbox_value').val('0');
            }
        }
        // uom conversions code ends here

        // group code starts here
        else if ($(this).hasClass('model_builder_group_checkbox')) {
            var groupCheckboxes = document.querySelectorAll('.model_builder_group_checkbox_div input[type="checkbox"]');

            var allChecked = Array.from(groupCheckboxes).every(function (checkbox) {
                return checkbox.checked;
            });

            if (allChecked) {
                $('#model_builder_all_group_checkbox').prop("checked", true);
                $('#model_builder_all_group_checkbox_value').val('1');
            } else {
                $('#model_builder_all_group_checkbox').prop("checked", false);
                $('#model_builder_all_group_checkbox_value').val('0');
            }
        }
        // group code ends here
        // model builder code ends here

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
            $('form#update_company_role_client_config').submit();
            // $('.custom_update_model_alert').modal('show');        
        }
    });

    //Update Rrigger
    // $(document).on('click','#update_save_changes', function()
    // {
    //     $('.custom_update_model_alert').modal('hide');
    //     $('form#update_company_role_client_config').submit();
    // });

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