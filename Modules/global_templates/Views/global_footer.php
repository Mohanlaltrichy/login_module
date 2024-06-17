 <!-- Footer -->
 <footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                © <?=date('Y');?> Unfold Technologies
            </div>
        </div>
    </div>
</footer>
<!-- End Footer -->

<!-- Notification Bell Icon Data Code Start -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        makeAjaxRequest();        
    });

    function makeAjaxRequest() {
        var time = "<?=NOTIFICATION_TIME?>";
        $.ajax({
            url: base_url+"templates/getnotification",
            type: 'GET',
            dataType: 'json',            
            success: function(data) {              

                for (let i = 1; i <= 3; i++) {
                    let anchorId = "#anchor" + i;
                    $(anchorId).hide();
                }

                for (let i = 0; i < data.length; i++) {
                    let anchorId = "#anchor" + (i + 1);
                    let divId = "#div" + (i + 1);
                    let spanid = "#sp" + (i + 1);

                    if (data[i].parameter_name) {
                        $(anchorId).show();
                        $(divId).text(data[i].parameter_name);
                        $(spanid).text("Target : " + data[i].set_point + ', ' + "Actual Value : " + data[i].actual_value);
                    }
                }

                if (data.length == 0) {
                    $('#datacount').text('0');
                    $('#reddot').css('visibility', 'hidden');
                } else {
                    $('#datacount').text(data.length);
                    $('#reddot').css('visibility', 'visible');
                }
            },
            error: function(xhr, status, error) {}
        });

        // setTimeout(function() {
        //     makeAjaxRequest();
        // }, parseInt({           
        //         time            
        // })); //parseInt({{ env('TIME') }})
    }
</script>
<!-- Notification Bell Icon Data Code End -->

<script>
    base_url = "<?php echo base_url(); ?>";
    csrf_token = "<?php echo csrf_token(); ?>"; 
    csrf_hash = "<?php echo csrf_hash(); ?>";  
</script>

<?php
    echo view('\Modules\global_templates\Views\global_js_files'); // Global JS File Included
?>



