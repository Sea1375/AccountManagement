<?php /* Template Name: MySchedules */ ?>
<?php get_header(); ?>

<?php
if ( have_posts() ) {
    
?>
     <div class="other_elements">
		<input type="hidden" value="<?php bloginfo('template_directory');?>" id="theme_url" />
        <input type="hidden" value="<?=home_url();?>" id="site_url"/>
    </div>
    <div class="container mt-5 p-3">
        <form action='myschedule_form_action.php' method='POST' id='myschedule'>
            <div class='m-2'>
                <div class="m-4" style="max-height: 200px; overflow: auto;">
                    <div class="table-responsive-sm">
                        <table class="table table-bordered" style="margin-bottom: 0; margin-top: 0; " id='schdule_table'>
                        </table>
                    </div>
                </div>
                <div class="d-flex justify-content-around mb-3">
                    <button type="button" class="btn btn-info">Add</button>
                    <button type="button" class="btn btn-info">Delete</button>
                    <button type="button" class="btn btn-info">Update</button>
                </div>
            </div>
            
            <div class='m-2'>
                <div class='row'>
                    <div class='col-12 col-md-6'>
                        <div class="table-responsive-sm">
                            <table class="table table-bordered" style="margin-bottom: 0; margin-top: 0; " id='filename_table'>
                            </table>
                        </div>
                    </div>
                    <div class='col-12 col-md-6'>
                        <div class="table-responsive-sm">
                            <table class="table table-bordered" style="margin-bottom: 0; margin-top: 0; " id='recipient_table'>
                            </table>
                        </div>
                    </div>
                </div>

                <div class='m-2 p-2'>
                    <h5>Please define when you want this file to be sent(*)</h5>
                    <div class="radio">
                        <div class='row m-3'>
                            <div class='col-12 col-md-3'>
                                <label><input type="radio" name="radio" checked> At a specific date </label>
                            </div>
                            <div class='col-12 col-md-3'>
                                <input type='date' name='date'>
                            </div>
                        </div>
                        <div class='row m-3'>
                            <div class='col-12 col-md-3'>
                                <label><input type="radio" name="radio"> Number de days after </label>
                            </div>
                            <div class='col-12 col-md-3'>
                                <input type='text' name='deadline'>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='m-2 p-2'>
                    <h5>You can add a personal message for this recipient when they receive the file.</h5>
                    <textarea class="form-control" rows="5" id="message"></textarea>
                </div>
                <div class="d-flex justify-content-around mb-3">
                    <input type="submit" class="bg-info" value='Save'></input>
                    <button type="button" class="btn btn-info">Cancel</button>
                </div>
            </div>
        </form>
    </div>
<?php
}
?>
<?php get_footer(); ?>