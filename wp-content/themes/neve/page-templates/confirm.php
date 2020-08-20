<?php /* Template Name: Confirm */ ?>

<?php get_header(); ?>
<?php
if ( have_posts() ) {
    
    $current_user = wp_get_current_user();
    $first_name = $current_user->first_name;
    $last_name = $current_user->last_name;
    
   
    $sql = "SELECT ACT_FIRST_NAME,ACT_LAST_NAME FROM ACCOUNT, CONTACT where ACT_ID = CTC_ACCOUNT_ID and ACT_WP_USER_ID = '" . $current_user->ID . "'";
    $result = $wpdb->get_results($sql);
    $act_first_name = $result[0]->ACT_FIRST_NAME;
    $act_last_name = $result[0]->ACT_LAST_NAME;
    
    $contact_id = $current_user->ID;
    $sql = "SELECT CTC_MESSAGE FROM contact WHERE CTC_ACCOUNT_ID = '" . $account_id . "' AND CTC_ID = '" . $contact_id . "'";
    $ctc_message = $wpdb->get_var($sql);
    
?>
    <div class="other_elements">
		<input type="hidden" value="<?php bloginfo('template_directory');?>" id="theme_url" />
		<input type="hidden" value="<?=home_url();?>" id="site_url"/>
	</div>

    <div class="container mt-5 p-3">
        <form action='confirm_form_action.php' method='POST' id='confirm'>
            <input type='hidden' name='contactId' value='<?php echo $contact_id; ?>' />
            <div class='m-2 p-2'>
                <h3>Dear <?php echo '  ' . $first_name . ' ' . $last_name . ','; ?></h3>
                <div class='text mt-3 px-2'>
                    <?php echo $act_first_name . ' ' . $act_last_name; ?> has subscribed to our service named Need2TellYou.<br>
                    You can find explanation of what this service does by clicking <a href="#" id='home'>here</a><br>
                    In order to initiate the document release process, and as per <?php echo $act_first_name; ?> `s wish, we need to make sure <?php echo $act_first_name; ?> Is dead.
                </div>
            </div>
                    
            <div class="m-2 p-2 mt-5">
                <h5>Here is below a personal message <?php echo $act_first_name; ?> left for you:</h5>
                <div class='text mt-3 px-2'><h6><?php echo $ctc_message; ?></h6></div>
            </div>
                
            <div class="m-1 p-2">
                <h5>Please fill the information below and click 'Save' when done. We thank you for your help.</h5>
                <div class='mt-3'>
                    <div class='radio'>
                        <label><input type="radio" name="confirmRadio" checked> I confirm <?php echo $act_first_name; ?> Is dead.</label>
                        <div class='row mx-5'>
                            <div class='col-sm-1'>
                                <h6>Date</h6>
                            </div>
                            <div class='col-sm-4'>
                                <input type="date" class="form-control" name='date' required />
                            </div>
                        </div>
                    </div>
                    <div class="radio">
                        <label><input type="radio" name="confirmRadio" checked> I cannot confirm <?php echo $act_first_name; ?> Is dead.</label>
                    </div>  
                    <div class="radio">
                        <label><input type="radio" name="confirmRadio"><?php echo ' ' . $act_first_name; ?>is dead but don’t know the date of the death. </label>
                    </div>
                    <input type='hidden' value='NOCONFIRM' name='actAuto' />
                </div>
                <div class="d-flex justify-content-around m-3">
                    <button type="button" onclick='save()'>Save</button>
                    <button type="button" data-toggle="modal" data-target="#cancelModal" >Close</button>
                </div>
            </div>
        </form>
        <div class="modal fade" id="saveModal">
            <div class="modal-dialog">
                <div class="modal-content">
                
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Success</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    
                    <!-- Modal body -->
                    <div class="modal-body">
                        Your account information has been updated correctly.
                    </div>
                    
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class='modal_button'>OK</button>
                    </div>
                    
                </div>
            </div>
        </div>

        <div class="modal fade" id="cancelModal">
            <div class="modal-dialog">
                <div class="modal-content">
                
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Please confirm you want to leave this page</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    
                    <!-- Modal body -->
                    <div class="modal-body">
                        Confirming will bring you to the home page
                    </div>
                    
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <a href='#'><button type="button" class='modal_button'>Confirm</button></a>
                        <button type="button" data-dismiss="modal" class='modal_button'>Go back</button>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <script>
        var route = '<?=home_url();?>' + '/sample-page/';
        $("#home").attr("href", route);
        
        function save() {

            var index = $("input[name=confirmRadio]")[0].checked ? 0 : 1;
            if(index == 0) $("input[name=actAuto]").val('NOCONFIRM');
            else $("input[name=actAuto]").val('CONFIRM');

            var currentUrl = $('#theme_url').val() + '/page-templates/account_management/confirm/confirm_form_action.php';
            console.log(currentUrl);
            $.ajax({
                url : currentUrl || window.location.pathname,
                type: "POST",
                data: {
                    accountId: $('input[name=accountId]').val(),
                    contactId: $('input[name=contactId]').val(),
                    actAuto: $('input[name=actAuto]').val(),
                    date: $('input[name=date]').val()
                },
                success: function (data) {
                    $('#saveModal').modal('show');
                },
                error: function (jXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        }
    </script>
<?php
}
?>
<?php get_footer(); ?>