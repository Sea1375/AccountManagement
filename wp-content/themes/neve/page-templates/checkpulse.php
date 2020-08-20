<?php /* Template Name: Checkpulse */ ?>

<?php get_header(); ?>
<?php
if ( have_posts() ) {
    
?>
    <div class="other_elements">
		<input type="hidden" value="<?php bloginfo('template_directory');?>" id="theme_url" />
		<input type="hidden" value="<?=home_url();?>" id="site_url" />
	</div>
    
    <div class='container'>
        <div class='m-3 p-3 text-center mt-5'>
            <h1 class='display-4' id='text'></h1>
        </div>
        <div class='m-2 p-3'>
        <div class="d-flex justify-content-around mb-3">
            <a id='close'><button type='button' onclick='close_window()'>Close</button></a>
            <a id='contact'><button type='button' style='font-size: 16px;'>Check contacts Info</button></a>
            <a href='' id='home'><button type='button'>Home page</button></a>
        </div>
    </div>
    
    <script>
        var random = ['Thank you for letting us know!!', 'Nice to see you!!', 'Thank you for confirming!!', 'Thanks for your visit!!'];
        var x = Math.floor((Math.random() * 4));
        console.log(random, '  ', x);
        $('#text').html(random[x]);
        
        var route = '<?=home_url();?>' + '/my-contacts/';
        $("#contact").attr("href", route);

        route = '<?=home_url();?>' + '/sample-page/';
        $("#home").attr("href", route);
        
        route = '<?=home_url();?>' + '/thank-you/';
        $("#close").attr("href", route);
        
    </script>
<?php
}
?>
<?php get_footer(); ?>