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

    var lastRequestTime = 0;
    var requestInterval = 5000; // Interval in milliseconds between each request

    function makeAjaxRequest() {
        var time = "<?=NOTIFICATION_TIME?>";

        var currentTime = Date.now();       

    	// Throttle the requests to ensure a minimum interval between consecutive requests
    	if (currentTime - lastRequestTime < requestInterval) {
        	setTimeout(makeAjaxRequest, requestInterval - (currentTime - lastRequestTime));
        	return;
    	}

    	lastRequestTime = currentTime;

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

                // Schedule the next request
                setTimeout(makeAjaxRequest, requestInterval);
            },
            error: function(xhr, status, error) {
                 // Handle error if needed
                 console.error("Error fetching data:", error);

                // Schedule the next request even if there's an error
                setTimeout(makeAjaxRequest, requestInterval);
            }
        });        
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



