<?php /* Template Name: Recipient */ ?>

<?php get_header(); ?>
<?php
if ( have_posts() ) {
    
    
?>
    <div class="other_elements">
		<input type="hidden" value="<?php bloginfo('template_directory');?>" id="theme_url" />
		<input type="hidden" value="<?=home_url();?>" id="site_url"/>
	</div>

    <div class="container mt-5 p-3">
        <form action='recipient_form_action.php' method='POST' id='recipient'>
            <input type='hidden' name='accountId' value='<?php echo $account_id; ?>' />
            <input type='hidden' name='contactId' value='<?php echo $contact_id; ?>' />
            <div class='m-2 p-2'>
                <h3>Dear <?php echo '  ' . $first_name . ' ' . $last_name . ','; ?></h3>
                <div class='text mt-3 px-2'>
                    <?php echo $act_first_name . ' ' . $act_last_name; ?> has subscribed to our service named.<br>
                    You can find explanation of what this service does by clicking <a href="#" id='home'>here</a><br>
                    As per <?php echo $act_first_name; ?> `s, you will find below file(s) he wants you to receive:
                    For your information, the files(s) will be available for download until 
                </div>
            </div>
                    
            <div class="m-2 p-2 mt-5">
                <h5>Here is below a personal message <?php echo $act_first_name; ?> left for you:</h5>
                <div class='text mt-3 px-2'><h6><?php echo $ctc_message; ?></h6></div>
            </div>
                
            <div class="m-2 p-2 mt-5">
                <h5>Please fill the information below and click 'Save' when done. We thank you for your help.</h5>
                <div>
                    <div class='my-2 p-2 text mt-4'>
                        <h6>I confirm <?php echo $act_first_name; ?></h6>
                        <div class='row'>
                            <div class='col-sm-1'>
                                <h6>Date</h6>
                            </div>
                            <div class='col-sm-4'>
                                <input type="date" class="form-control" name='date' required />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="m-1 p-2">
                <div class='mt-3'>
                    <div class="radio">
                        <label><input type="radio" name="confirmRadio" checked> I cannot confirm <?php echo $act_first_name; ?></label>
                    </div>  
                    <div class="radio">
                        <label><input type="radio" name="confirmRadio"><?php echo ' ' . $act_first_name; ?></label>
                    </div>
                    <input type='hidden' value='NOCONFIRM' name='actAuto' />
                </div>
                <div class='row'>
                    <div class="col-md-3"></div>
                    <div class="col-md-3">
                        <input type="submit" class="form-control bg-success text-white" value="Save" />
                    </div>
                    <div class="col-md-3">
                        <input type="button" class="bg-warning text-white" data-toggle="modal" data-target="#myModal" value='Close' />
                    </div>`
                </div>
            </div>
        </form>
        <div class="modal fade" id="myModal">
            <div class="modal-dialog">
            <div class="modal-content">
            
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Do you want to cancel?</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <!-- Modal body -->
                <div class="modal-body">
                    Go to Home page...
                </div>
                
                <!-- Modal footer -->
                <div class="modal-footer">
                    <a href='#'><button type="button" class="btn btn-danger" data-dismiss="modal">Go to Home</button></a>
                </div>
                
            </div>
        </div>
    </div>
    <script>
        var route = '<?=home_url();?>' + '/sample-page/';
        $("#home").attr("href", route);

        $(document).ready(function () {
            $('#confirm').on('submit', function(e) {

                var index = $("input[name=confirmRadio]")[0].checked ? 0 : 1;
                if(index == 0) $("input[name=actAuto]").val('NOCONFIRM');
                else $("input[name=actAuto]").val('CONFIRM');
                console.log($("input[name=actAuto]").val());

                e.preventDefault();
                var currentUrl = $('#theme_url').val() + '/page-templates/account_management/confirm/' + $(this).attr('action');
                console.log(currentUrl);
                $.ajax({
                    url : currentUrl || window.location.pathname,
                    type: "POST",
                    data: $(this).serialize(),
                    success: function (data) {
                        console.log(data, '------------');
                    },
                    error: function (jXHR, textStatus, errorThrown) {
                        alert(errorThrown);
                    }
                });
            });
        });
    </script>
<?php
}
?>
<?php get_footer(); ?>