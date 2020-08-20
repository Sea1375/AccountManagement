<?php /* Template Name: MyFiles */ ?>
<?php get_header(); ?>

<?php
if ( have_posts() ) {

    $account_id = wp_get_current_user()->ID;

?>

    <div class="other_elements">
		<input type="hidden" value="<?php bloginfo('template_directory');?>" id="theme_url" />
        <input type="hidden" value="<?=home_url();?>" id="site_url" />
        <input type='hidden' value='<?php echo $account_id;  ?>' name='accountId' id='accountId' />
        <input type='hidden' name='fil_id' id='fil_id' />
    </div>

    <div class="container mt-1 p-3">
        

        <div class='mx-5'>
            <div class='row'>
                <div class='col-12 col-md-8 mt-5'>
                    <h2 class="p-2 mx-3"><strong>My Files</strong></h2>
                </div>
                <div class='col-12 col-md-4 mt-5'>
                    <div class="table-responsive-sm" style='border: 1px solid;'>
                        <table class="storage" style="margin-bottom: 0; margin-top: 0; position: relative;">
                            <tr>
                                <td>Capacity: </td><td><div id='capacity'></div></td>
                            </tr>
                            <tr>
                                <td>Available: </td><td><div id='available'></div></td>
                            </tr>
                            <tr>
                                <td>Used: </td><td><div id='used'></div></td>
                            </tr>
                            <div style="position: absolute; left: 30px; top: -15px; background-color: #f0f0f0;" class="px-2">
                                <p style="font-size: larger;"><strong>Storage</strong></p>
                            </div>
                        </table>
                    </div>
                </div>
            </div>

            <div class="m-4" style="max-height: 200px; overflow: auto;" class='border'>
                <div class="table-responsive-sm">
                    <table class="table table-bordered" style="margin-bottom: 0; margin-top: 0; " id='filesTable'>
                    </table>
                </div>
            </div>
                
            <div class="d-flex justify-content-around mb-3">
                <button type="button" data-toggle="modal" data-target="#addModal">Add</button>
                <button type="button" data-toggle="modal" data-target="#deleteModal">Delete</button>
                <button type="button" data-toggle="modal" data-target="#downloadModal">Download</button>
            </div>
        </div>

        <div id="addModal" class="modal fade" tabindex="-1">
            <form method="post" enctype="multipart/form-data" id='file_upload' action='file_upload.php'>
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">File Upload</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <h5>Please choose a file to upload</h5>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="uploadFile">
                                <label class="custom-file-label" for="uploadFile">Choose file</label>
                            </div>
                            <div class='my-2 bg-warning invisible text-center' id='alert'>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class='modal_button' onclick='upload_file()' data-dismiss="modal">Upload</button>
                            <button type="button" data-dismiss="modal" class='modal_button'>Close</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class='my-2 p-2 bg-warning invisible text-center' id='del_and_down'></div>

        <div id="downloadModal" class="modal fade" tabindex="-1">
            <form method="post" enctype="multipart/form-data" id='file_download' action='file_download.php'>
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">File Download</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="card-body">
                                <h5>Please choose a location to download a file</h5>
                                <div class="custom-file">                               
                                    <input type="file" class='custom-file-input' id='downloadFile' webkitdirectory directory />
                                    <label class="custom-file-label" for="downloadFile">Choose Destination</label>
                                </div>
                            </div>
                            <div class='my-2 p-2 bg-warning invisible text-center' id='down'></div>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class='modal_button' onclick='download_file()' data-dismiss="modal">Upload</button>
                            <button type="button" data-dismiss="modal" class='modal_button'>Close</button>
                        </div>
                    </div>
                </div>
                
            </form>
        </div>
        <div class="modal fade" id="deleteModal">
            <div class="modal-dialog">
                <div class="modal-content">
                
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Please confirm you want to delete this contact.</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    
                    <!-- Modal body -->
                    <div class="modal-body">
                        Do you confirm deleting?
                    </div>
                    
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class='modal_button' onclick='delete_file()' data-dismiss="modal">Confirm</button>
                        <button type="button" data-dismiss="modal" class='modal_button'>Go back</button>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    
    <script>
        
        var fil_ids;
        var selectedFile;
        var selectedFileName;

        refresh_table();

        $(".custom-file-input").on("change", function() {
            selectedFileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(selectedFileName);
            selectedFile = $(this).prop('files')[0];
        });
        
        function upload_file() {
                
            var currentUrl = $('#theme_url').val() + '/page-templates/account_management/files/file_upload.php';
            var formData = new FormData();
            
            formData.append("file", selectedFile);
            formData.append('available', $('#available').html());
            formData.append('accountId', parseInt('<?php echo $account_id; ?>'));

            $.ajax({
                url : currentUrl || window.location.pathname,
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                cached: false,
                success: function (data) {
                    console.log('success  ', data);
                    $('#alert').removeClass('invisible');
                    if(data == "File is too large.") {
                        console.log('enter');
                        $('#alert').html('<h6>File is too large.</h6>');
                    } else {
                        $('#alert').html('<h6>Upload is succeeded.</h6>');
                        refresh_table();
                        $('#del_and_down').removeClass('invisible');
                        $('#del_and_down').html('<h6>The Upload is succeeded.</h6>');
                    }
                },
                error: function (jXHR, textStatus, errorThrown) {
                    $('#alert').removeClass('invisible');
                    $('#alert').html('<h6>Upload is failed.</h6>');
                    alert(errorThrown);
                }
            });
        }

        function row_click(row) {
            $('table > tr').css('background-color', '#ffffff');
            $(row).css('background-color', '#f2f2f2');
            $('input[name=fil_id]').val(fil_ids[row.rowIndex-1]);
        }

        function refresh_table() {      
            $.ajax({
                type: "POST",
                url: $('#theme_url').val() + '/page-templates/account_management/files/refresh_table.php',
                data: { accountId: $('input[name=accountId]').val()}, 
                success:function(data){
                    const result = JSON.parse(data);
                    
                    $('#capacity').html(result.capacity);
                    $('#available').html(result.available);
                    $('#used').html(result.used);
                    $('#filesTable').html(result.tableContent);
                    fil_ids = result.ids;
                },
                error: function (jXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        }


        function delete_file() {
            if($('input[name=fil_id]').val() == '') {
                alert('Please select a file to delete.');
            }
            $.ajax({
                type: "POST",
                url: $('#theme_url').val() + '/page-templates/account_management/files/file_delete.php',
                data: { 
                    userId: $('input[name=accountId]').val(),
                    filId: $('input[name=fil_id]').val()
                },
                success:function(data){
                    console.log(data);
                    refresh_table();
                    $('#del_and_down').removeClass('invisible');
                    $('#del_and_down').html('<h6>The Delete is succeeded.</h6>');
                },
                error: function (jXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                    $('#del_and_down').removeClass('invisible');
                    $('#del_and_down').html('<h6>The Delete is failed.</h6>');
                }
            });
        }

        function file_download() {
            if($('input[name=fil_id]').val() == '') {
                $('#down').removeClass('invisible');
                $('#down').html('<h6>Please a file to download.</h6>');
                return;
            }
            $.ajax({
                type: "POST",
                url: $('#theme_url').val() + '/page-templates/account_management/files/file_download.php',
                data: { 
                    userId: $('input[name=accountId]').val(),
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