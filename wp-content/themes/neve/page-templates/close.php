<?php /* Template Name: Thankyou */ ?>

<?php get_header(); ?>
<?php
if ( have_posts() ) {
    
?>
    <div class='container'>
        <div class="d-flex justify-content-center m-5">
            <div class='m-5'>
                <h1 class='m-5'>THANK YOU!!</h1>
            </div>
        </div>
    </div>
<?php
}
?>
<?php get_footer(); ?>