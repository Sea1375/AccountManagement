<?php /* Template Name: MySchedules */ ?>
<?php get_header(); ?>

<?php
if ( have_posts() ) {
    $account_id = wp_get_current_user()->ID;

?>

    <div class="other_elements">
		<input type="hidden" value="<?php bloginfo('template_directory');?>" id="theme_url" />
        <input type="hidden" value="<?=home_url();?>" id="site_url"/>
        <input type='hidden' value='<?php echo $account_id;  ?>' name='accountId' id='accountId' />
    </div>
    <div class="container mt-5 p-3">
        <div class='m-2'>
            <div class="m-4" style="max-height: 200px; overflow: auto;">
                <div class="table-responsive-sm">
                    <table class="table table-bordered" style="margin-bottom: 0; margin-top: 0; " id='scheduleTable'>
                    </table>
                </div>
            </div>
            <div class="d-flex justify-content-around mb-3">
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addModal" onclick='filename_recipient()'>Add</button>
                <button type="button" class="btn btn-info" onclick='delete_modal_check()'>Delete</button>
                <button type="button" class="btn btn-info" onclick='update_modal_check()'>Update</button>
            </div>
        </div>
        
        <div id="addModal" class="modal fade" tabindex="-1">
            <form method="post" enctype="multipart/form-data" id='schedule' action='schedule_add.php'>
                <input type='hidden' value='D' name='selection' />
                <input type='hidden' name='fil_id' />
                <input type='hidden' name='ctc_id' />
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Schedule Add</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class='row'>
                                <div class='col-ls-6 m-4'>
                                    <h5>Filename(*)</h5>
                                    <div style="max-height: 200px; overflow: auto;">
                                        <div class="table-responsive-sm">
                                            <table class="table table-bordered" style="margin-bottom: 0; margin-top: 0; " id='filenameTable'>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class='col-ls-6 m-4'>
                                    <h5>Recipient Name(*)</h5>
                                    <div style="max-height: 200px; overflow: auto;">
                                        <div class="table-responsive-sm">
                                            <table class="table table-bordered" style="margin-bottom: 0; margin-top: 0; " id='recipientTable'>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class='m-2 p-2'>
                                <h5>Please define when you want this file to be sent(*):</h5>
                                <div class="radio">
                                    <label><input type="radio" name="pulseRadio" checked value = 'every'> At a specific date </label>
                                    <input type='date' id='specific' name='specific' />
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="pulseRadio" value='automatic'> Number de days after</label>
                                    <input type='text' id='after' name='after' />
                                </div>
                            </div>
                            <div class='m-2 p-2'>
                                <h5>You can add a personal message for this recipient when they receive the file:</h5>
                                <div class="form-group">
                                    <textarea class="form-control" rows="5" id="message" name='message'></textarea>
                                </div>
                            </div>
                            <div class='m-2 p-2 bg-warning invisible' id='alert'>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info" onclick='save_content()'>Save</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="modal fade" id="deleteModal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete a schedule</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <h5>Do you delete want to delete this schedule?</h5>
                    </div>
                    <div class='m-2 p-2 bg-warning invisible' id='alert_delete'>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" onclick='delete_schedule()'>Delete</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <div class='m-2 p-2 bg-warning invisible' id='alert_main'>
        </div>
    </div>
    
    <script>
        var sch_ids, fil_ids, ctc_ids, sch_id = '', addOrUpdate = 'add';
        refresh_table();

        function refresh_table() {  
            $.ajax({
                type: "POST",
                url: $('#theme_url').val() + '/page-templates/account_management/myschedule/refresh_table.php',
                data: { accountId: $('input[name=accountId]').val()}, 
                success:function(data){
                    const result = JSON.parse(data);
                    $('#scheduleTable').html(result.tableContent);
                    sch_ids = result.ids;
                },
                error: function (jXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        }

        function schedule_click(row) {
            $('#scheduleTable > tr').css('background-color', '#ffffff');
            $(row).css('background-color', '#f2f2f2');
            sch_id = sch_ids[row.rowIndex - 1];
        }

        function filename_click(row) {
            $('#filenameTable > tr').css('background-color', '#ffffff');
            $(row).css('background-color', '#f2f2f2');
            $('input[name=fil_id]').val(fil_ids[row.rowIndex]);
        }
        
        function recipient_click(row) {
            $('#recipientTable > tr').css('background-color', '#ffffff');
            $(row).css('background-color', '#f2f2f2');
            $('input[name=ctc_id]').val(ctc_ids[row.rowIndex]);
        }
        
        function filename_recipient() {
            $.ajax({
                type: "POST",
                url: $('#theme_url').val() + '/page-templates/account_management/myschedule/filename_recipient.php',
                data: { accountId: $('input[name=accountId]').val()}, 
                success:function(data){
                    const result = JSON.parse(data);
                    fil_ids = result.fil_ids;
                    ctc_ids = result.ctc_ids;
                    $('#filenameTable').html(result.filename);              
                    $('#recipientTable').html(result.recipient);
                },
                error: function (jXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });    
        }
        function save_content() {
            const fil_id = $('input[name=fil_id]').val();
            const ctc_id = $('input[name=ctc_id]').val();
            console.log($('#message').val(), ' ', fil_id, ' ', ctc_id);
            
            if(fil_id == '') {
                $('#alert').removeClass('invisible');
                $('#alert').html('Please select a filename');
                return;
            }
            else if(ctc_id == '') {
                $('#alert').removeClass('invisible');
                $('#alert').html('Please select a recipient name');
                return;
            }

            var index = $("input[name=pulseRadio]")[0].checked ? 0 : 1;
            if(index == 1) $("input[name=selection]").val('N');
            
            if((index == 0 && $('input[name=specific]').val() == '') || (index == 1 && $('input[name=after]').val() == '')) {
                $('#alert').removeClass('invisible');
                $('#alert').html('Please select a timeline.');
                return;
            }

            
            var currentUrl = $('#theme_url').val() + '/page-templates/account_management/myschedule/schedule_add.php';
            $.ajax({
                url : currentUrl || window.location.pathname,
                type: "POST",
                data: {
                    account_id: $('input[name=accountId]').val(),
                    fil_id: $('input[name=fil_id]').val(),
                    ctc_id: $('input[name=ctc_id]').val(),
                    selection: $('input[name=selection]').val(),
                    specific: $('input[name=specific]').val(),
                    after: $('input[name=after]').val(),
                    message: $('#message').val(),
                    addOrUpdate: addOrUpdate,
                },
                success: function (data) {
                    console.log(data);
                    if(data == 'success') {
                        $('#alert').removeClass('invisible');
                        $('#alert').html('The schedule is saved successfully.');
                    }
                    refresh_table();
                },
                error: function (jXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });

        }

        function delete_modal_check() {           
            if(sch_id == '') {
                console.log('enter');
                $('#alert_main').removeClass('invisible');
                $('#alert_main').html('Please a schedule to delete.');
                return;
            }
            $('#deleteModal').modal();
        }

        function delete_schedule() {
            
            var currentUrl = $('#theme_url').val() + '/page-templates/account_management/myschedule/delete_schedule.php';
            $.ajax({
                url : currentUrl || window.location.pathname,
                type: "POST",
                data: {
                    schedule_id: sch_id,
                },
                success: function (data) {
                    if(data == 'success') {
                        $('#alert_delete').removeClass('invisible');
                        $('#alert_delete').html('The schedule is deleted successfully.');
                        sch_id = '';
                    }
                    refresh_table();
                    $('#alert_main').addClass('invisible');
                },
                error: function (jXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        }

        function update_modal_check() {
            if(sch_id == '') {
                console.log('enter');
                $('#alert_main').removeClass('invisible');
                $('#alert_main').html('Please a schedule to update.');
                return;
            }
            filename_recipient();
            addOrUpdate = sch_id;
            $('#addModal').modal();
        }
    </script>
    
<?php
}
?>
<?php get_footer(); ?>