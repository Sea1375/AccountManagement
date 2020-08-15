<?php /* Template Name: MyFiles */ ?>
<?php get_header(); ?>

<?php
if ( have_posts() ) {

    if(!empty($_GET)) {
        $account_id = $_GET['account_id'];
        $sql = "SELECT ACT_PLAN FROM account WHERE ACT_ID = '" . $account_id . "'";
        $plan_code = $wpdb->get_var($sql);
        
        $sql = "SELECT PLN_MAX_STORAGE FROM plan WHERE PLN_CODE = '" . $plan_code . "'";
        $capacity = round($wpdb->get_var($sql) / 1024, 3);

        $sql = "SELECT FIL_SIZE FROM 'file' WHERE FIL_ACCOUNT_ID = '" . $account_id . "'";
        $results = $wpdb->get_results($sql);

        $used = 0;
        foreach($results as $result) {
            $used = $used + $result->FIL_SIZE;
        }
        $used = round($used / 1024, 3);
        $available = $capacity - $used;
    }
?>

    <div class="other_elements">
		<input type="hidden" value="<?php bloginfo('template_directory');?>" id="theme_url" />
        <input type="hidden" value="<?=home_url();?>" id="site_url"/>
    </div>
    <div class="container mt-1 p-3">
        <div class='row'>
            <div class='col-12 col-md-8 mt-5'>
                <h3 class="bg-success text-white p-2 text-center" style="font-family: 'Lobster', cursive;">My Files</h3>
            </div>
            <div class='col-12 col-md-4'>
                <div class="card m-4 p-2 " style="position: relative;">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">Capacity: </div>
                            <div class="col-md-6">
                                <?php echo $capacity . ' '; ?>MB
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">Available: </div>
                            <div class="col-md-6">
                                <?php echo $available . ' '; ?>MB
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">Used: </div>
                            <div class="col-md-6">
                                <?php echo $used . ' '; ?>MB
                            </div>
                        </div>
                    </div>
                    <div style="position: absolute; left: 30px; top: -15px; background-color: white;" class="px-2">
                        <p style="font-size: larger;"><strong>Storage</strong></p>
                    </div>
                </div>
            </div>
        </div>
        <div class='m-5'>
            <div class="m-4" style="max-height: 200px; overflow: auto;" class='border'>
                <div class="table-responsive-sm">
                    <table class="table table-bordered" style="margin-bottom: 0; margin-top: 0; " id='filesTable'>
                        <h5 class='text-center'>File is not exist...</h5>
                    </table>
                </div>
            </div>
                
            <div class="d-flex justify-content-around mb-3">
                <button type="button" class="btn btn-info">Add</button>
                <button type="button" class="btn btn-info">Delete</button>
                <button type="button" class="btn btn-info">Download</button>
            </div>
        </div>
        
        <div class='m-2'>
            <form method="post" enctype="multipart/form-data" id='file_upload' action='file_upload.php'>
                <div class="card m-4 p-2 " style="position: relative;">
                    <div class="card-body">
                        <h5>Please choose a file to upload</h5>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="customFile">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-around mb-3">
                    <input type='submit' class='bg-info' value='Upload' />
                    <button type="button" class="btn btn-info">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        var selectedFile;
        var selectedFileName;

        $(".custom-file-input").on("change", function() {
            selectedFileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(selectedFileName);
            selectedFile = $(this).prop('files')[0];
        });
        
        $(document).ready(function () {
            $('#file_upload').on('submit', function(e) {
                e.preventDefault();
/*
                // upload using ajax request
                const userId = '<?php echo $account_id ?>';
                const fileName = selectedFileName;
                const uploadTokenUrl = `https://67qegqceo8.execute-api.us-east-1.amazonaws.com/v1/get-na-presignedurl?user=${userId}&object=${fileName}`;
                $.get(uploadTokenUrl, (res) => {
                    const uploadUrl = res;
                    jQuery.ajax({
                        url: uploadUrl,
                        type: "PUT",
                        data: selectedFile,
                        contentType: 'binary/octet-stream',
                        processData: false,
                        cache: false,
                        success: function (result) {
                            console.log(`upload succeeded: ${result}`);
                        },
                        error: function(result) {
                            console.log(`upload failed: ${result}`);
                        }
                    });
                });
*/
                var currentUrl = $('#theme_url').val() + '/page-templates/account_management/files/' + $(this).attr('action');
                var formData = new FormData();

                // add assoc key values, this will be posts values
                formData.append("file", selectedFile);

                $.ajax({
                    url : currentUrl || window.location.pathname,
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    cached: false,
                    success: function (data) {
                        console.log('upload succeeded');
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