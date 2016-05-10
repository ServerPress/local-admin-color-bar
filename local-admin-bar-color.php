<?php
/**
Plugin Name: Local Admin Color Bar
Plugin URL: https://serverpress.com/plugins/local-admin-bar-color
Description: Changes the Admin bar color 
Version: 1.0.1
Author: Gregg Franklin
Author URI: http://greggfranklin.com
 */

/*
 *
 */
function ds_admin_bar_init() {
	if ( is_admin_bar_showing() ) {
		
		// Add admin notice
		add_action( 'admin_bar_menu', 'ds_admin_bar_notice' );
		
		// Style the admin bar
		add_action( 'admin_head', 'ds_admin_bar_notice_css' );
		add_action( 'wp_head', 'ds_admin_bar_notice_css' );

		// Remove "howdy" message
		add_filter( 'admin_bar_menu', 'ds_goodbye_howdy',25 );
	}
}
add_action('init', 'ds_admin_bar_init'); 
 
 /* 
  * Add admin notice
  */
function ds_admin_bar_notice() {

	if (defined( 'ENV_TEXT' ) && ENV_TEXT) {
	
		$env_text = ENV_TEXT;
		
	} else {
	
		$env_text = 'LOCAL DEVELOPMENT WEBSITE';
		
	}

	$admin_notice = array(
		'parent'	=> 'top-secondary', /** puts it on the right side. */
		'id'		=> 'environment-notice',
		'title'		=> '<span>'.$env_text.'</span>',
	);
	global $wp_admin_bar;
	$wp_admin_bar->add_menu($admin_notice);
	}
	
/*
 * Style the admin bar
 */
 function ds_admin_bar_notice_css() {
 
	if (defined( 'DS_COLOR' ) && DS_COLOR) {
	
			$env_color = strtolower(DS_COLOR);
			
	} else {
		
			$env_color = '#0073AA';
	}
			
echo "
<!-- WPLT Admin Bar Notice -->
<style type='text/css'>
	#wp-admin-bar-environment-notice>div,
	#wpadminbar { background-color: $env_color!important }
	#wp-admin-bar-environment-notice { display: none }
	@media only screen and (min-width:1030px) { 
	    #wp-admin-bar-environment-notice { display: block }
	    #wp-admin-bar-environment-notice>div>span {
	        color: #EEE!important;
	        font-size: 130%!important;
	    }
	}
	#adminbarsearch:before,
	.ab-icon:before,
	.ab-item:before { color: #EEE!important }
</style>";
}

/* 
 * Remove "howdy" message
 */
function ds_goodbye_howdy( $wp_admin_bar ) {
		
	$my_account = $wp_admin_bar->get_node('my-account');
	$newtitle = str_replace( 'Howdy,', '', $my_account->title );
	$wp_admin_bar->add_node( array(
		'id' => 'my-account',
		'title' => $newtitle,
	) );
}	
