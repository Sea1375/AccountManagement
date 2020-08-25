<?php
/**
 * Neve functions.php file
 *
 * Author:          Andrei Baicus <andrei@themeisle.com>
 * Created on:      17/08/2018
 *
 * @package Neve
 */

function aia_styles_scripts() {
	$theme_path = get_stylesheet_directory_uri();
	
	if( is_page_template( 'page-templates/account.php' ) || is_page( 'Account' ) 
		|| is_page_template( 'page-templates/contact.php' ) || is_page( 'Contacts' )
		|| is_page_template( 'page-templates/confirm.php' ) || is_page( 'Confirm' )
		|| is_page_template( 'page-templates/myfiles.php' ) || is_page( 'MyFiles' )
		|| is_page_template( 'page-templates/checkpulse.php' ) || is_page( 'Checkpulse' )
		|| is_page_template( 'page-templates/recipient.php' ) || is_page( 'Recipient' )
		|| is_page_template( 'page-templates/close.php' ) || is_page( 'Thankyou' )
		|| is_page_template( 'page-templates/myschedule.php' ) || is_page( 'MySchedules' ) ) { 

	   	
		wp_enqueue_style( 'bootstrap1', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css', array( 'neve-style' ) );
		wp_enqueue_style( 'bootstrap2', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css', array( 'bootstrap1' ) );
		wp_enqueue_style( 'intlTelInput', $theme_path .'/page-templates/account_management/build/css/intlTelInput.css', array( 'bootstrap2' ) );
		wp_enqueue_style( 'home_custom', $theme_path .'/page-templates/account_management/home_custom.css', array( 'intlTelInput' ) );

		wp_enqueue_script( 'script-1', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js', array( 'jquery' ) );
		wp_enqueue_script( 'script-2', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js', array( 'script-1' ) );
		wp_enqueue_script( 'script-3', 'https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js', array( 'script-2' ) );
		wp_enqueue_script( 'script-4', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js', array( 'script-3' ) );

		wp_enqueue_script( 'intlTelInput-script', $theme_path . '/page-templates/account_management/build/js/intlTelInput.js', array( 'script-4' ) );
		wp_enqueue_script( 'utils-script', $theme_path . '/page-templates/account_management/build/js/utils.js', array( 'intlTelInput-script' ) );

		//https://wpml.org/de/forums/topic/translate-custom-html-php-code/
	}

}
add_action( 'wp_enqueue_scripts', 'aia_styles_scripts' );
