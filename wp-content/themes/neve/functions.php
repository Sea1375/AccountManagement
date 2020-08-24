<?php
/**
 * Neve functions.php file
 *
 * Author:          Andrei Baicus <andrei@themeisle.com>
 * Created on:      17/08/2018
 *
 * @package Neve
 */

define( 'NEVE_VERSION', '2.7.6' );
define( 'NEVE_INC_DIR', trailingslashit( get_template_directory() ) . 'inc/' );
define( 'NEVE_ASSETS_URL', trailingslashit( get_template_directory_uri() ) . 'assets/' );

if ( ! defined( 'NEVE_DEBUG' ) ) {
	define( 'NEVE_DEBUG', false );
}
define( 'NEVE_NEW_DYNAMIC_STYLE', true );
/**
 * Themeisle SDK filter.
 *
 * @param array $products products array.
 *
 * @return array
 */
function neve_filter_sdk( $products ) {
	$products[] = get_template_directory() . '/style.css';

	return $products;
}

add_filter( 'themeisle_sdk_products', 'neve_filter_sdk' );

add_filter( 'themeisle_onboarding_phprequired_text', 'neve_get_php_notice_text' );

/**
 * Get php version notice text.
 *
 * @return string
 */
function neve_get_php_notice_text() {
	$message = sprintf(
	/* translators: %s message to upgrade PHP to the latest version */
		__( "Hey, we've noticed that you're running an outdated version of PHP which is no longer supported. Make sure your site is fast and secure, by %s. Neve's minimal requirement is PHP 5.4.0.", 'neve' ),
		sprintf(
		/* translators: %s message to upgrade PHP to the latest version */
			'<a href="https://wordpress.org/support/upgrade-php/">%s</a>',
			__( 'upgrading PHP to the latest version', 'neve' )
		)
	);

	return wp_kses_post( $message );
}

/**
 * Adds notice for PHP < 5.3.29 hosts.
 */
function neve_php_support() {
	printf( '<div class="error"><p>%1$s</p></div>', neve_get_php_notice_text() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

if ( version_compare( PHP_VERSION, '5.3.29' ) <= 0 ) {
	/**
	 * Add notice for PHP upgrade.
	 */
	add_filter( 'template_include', '__return_null', 99 );
	switch_theme( WP_DEFAULT_THEME );
	unset( $_GET['activated'] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	add_action( 'admin_notices', 'neve_php_support' );

	return;
}

require_once 'globals/migrations.php';
require_once 'globals/utilities.php';
require_once 'globals/hooks.php';
require_once 'globals/sanitize-functions.php';
require_once get_template_directory() . '/start.php';


require_once get_template_directory() . '/header-footer-grid/loader.php';





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
