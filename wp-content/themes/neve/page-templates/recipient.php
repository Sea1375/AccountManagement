<?php /* Template Name: Recipient */ ?>

<?php get_header(); ?>
<?php
if ( have_posts() ) {
    $current_user = wp_get_current_user();
    
    $first_name = $current_user->first_name;
    $last_name = $current_user->last_name;
    
    $sql = "SELECT ACT_ID, ACT_FIRST_NAME,ACT_LAST_NAME FROM ACCOUNT, CONTACT where ACT_ID = CTC_ACCOUNT_ID and ACT_WP_USER_ID = '" . $current_user->ID . "'";
    $result = $wpdb->get_results($sql);

    $account_id = $result[0]->ACT_ID;
    $act_first_name = $result[0]->ACT_FIRST_NAME;
    $act_last_name = $result[0]->ACT_LAST_NAME;

    $contact_id = $current_user->ID;
    
    $pln_expiry_days = $wpdb->get_var("SELECT PLN_EXPIRY_DAYS FROM ACCOUNT, PLAN WHERE ACT_ID = '" . $account_id . "' AND ACT_PLAN = PLN_CODE");
    $cnf_conf_date = $wpdb->get_var("SELECT CNF_CONF_DATE FROM CONFIRM WHERE CNF_ACCOUNT_ID = '" . $account_id . "' AND CNF_CONTACT_ID = '" . $contact_id . "'");

    $sql = "SELECT SCH_ID, SCH_FILE_ID, SCH_TYPE, SCH_SCHEDULE_DATE, SCH_NB_DAYS FROM SCHEDULE WHERE SCH_ACCOUNT_ID = '" . $account_id . "' AND SCH_CONTACT_ID = '" . $contact_id . "'";
    $results = $wpdb->get_results($sql);

    foreach($results as $result) {
        $sch_id = $result->SCH_ID;
        $sch_type = $result->SCH_TYPE;
        $sch_schedule_date = $result->SCH_SCHEDULE_DATE;
        $sch_nb_days = $result->SCH_NB_DAYS;

        if($sch_type == 'D') {
            $until = date('Y-m-d', strtotime($sch_schedule_date. ' + ' . $pln_expiry_days . ' days'));            
        } else {
            $until = date('Y-m-d', strtotime($cnf_conf_date. ' + ' . ($pln_expiry_days + $sch_nb_days) . ' days'));
        }
        $until_max = max($until_max, $until);
        $file_name = $wpdb->get_var("SELECT FIL_NAME FROM FILES WHERE FIL_ID = '" . $result->SCH_FILE_ID . "'");
        $fil_ids = $fil_ids . ' ' . $result->SCH_FILE_ID;
        
        $table_html = $table_html . '<tr onclick="row_click(this)"><td>' . $file_name . '</td></tr>';
    }

?>
    <div class="other_elements">
		<input type="hidden" value="<?php bloginfo('template_directory');?>" id="theme_url" />
        <input type="hidden" value="<?=home_url();?>" id="site_url" />
        <input type='hidden' value='<?php echo $contact_id;  ?>' name='contactId' id='contactId' />
        <input type='hidden' name='fil_id' id='fil_id' />
    </div>

    <div class="container mt-5 p-3">
        <h2 class="p-2 mx-3"><strong>Recipient</strong></h2>
        <div class='form-field p-5'>
            <div class='m-2 p-2'>
                <h3>Dear <b><?php echo '  ' . $first_name . ' ' . $last_name . ','; ?></b></h3>
                <div class='text mt-3 px-2'>
                    <b><?php echo $act_first_name . ' ' . $act_last_name; ?></b> has subscribed to our service named Need2TellYou.<br>
                    You can find explanation of what this service does by clicking <a href="#" id='home'>here</a><br>
                    As per <b><?php echo $act_first_name; ?></b> `s wish, you will find below file(s) he wants you to receive:
                    For your information, the files(s) will be available for download until <b><?php echo $until_max; ?></b>
                </div>
            </div>

            <div class="m-2 p-2 mt-5">
                <h5>Here is below a personal message <b><?php echo $act_first_name; ?></b> left for you:</h5>
                <div class='text mt-3 px-2'><h6><b><?php echo $ctc_message; ?></b></h6></div>
            </div>
            <div class='m-5'>
                <h5>Filename(*)</h5>
                <div style="max-height: 200px; overflow: auto;">
                    <div class="table-responsive-sm">
                        <table class="table table-bordered" style="margin-bottom: 0; margin-top: 0; " id='filenameTable'>
                        <?php echo $table_html; ?>
                        </table>
                    </div>
                </div>
            </div>
            <div class='m-4' >
                <div class="d-flex justify-content-around mb-3">
                    <button type="button" onclick='file_download()'>Download</button>
                    <a href='<?=home_url();?>'><button type="button">Close</button></a>
                </div>
            </div>
            <div class='my-2 p-2 bg-warning invisible text-center' id='del_and_down'></div>
        </div>
    </div>
    <script>

        function row_click(row) {
            $('table > tr').css('background-color', '#ffffff');
            $(row).css('background-color', '#f2f2f2');
            const fil_ids = '<?php echo $fil_ids; ?>'.split(" ");
            $('input[name=fil_id]').val(fil_ids[row.rowIndex + 1]);
        }

        function file_download() {

            if($('input[name=fil_id]').val() == '') {
                $('#del_and_down').removeClass('invisible');
                $('#del_and_down').html('<h5>Please select a file to download.</h5>');
                return;
            }
            console.log($('input[name=contactId]').val(), ' ', $('input[name=fil_id]').val());
            $.ajax({
                type: "POST",
                url: $('#theme_url').val() + '/page-templates/account_management/files/file_download.php',
                data: { 
                    userId: $('input[name=contactId]').val(),
                    filId: $('input[name=fil_id]').val()
                }, 
                success:function(data){
                    console.log(data);
                    $('#del_and_down').removeClass('invisible');
                    $('#del_and_down').html('<h6>The Download is succeeded.</h6>');
                },
                error: function (jXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                    $('#del_and_down').removeClass('invisible');
                    $('#del_and_down').html('<h6>The Download is failed.</h6>');
                }
            });
        }
    </script>
<?php
}
?>
<?php get_footer(); ?>
