<?php
/*
Plugin Name: ActivityRez Wordpress Web Booker Plugin
Plugin URI: http://www.activityrez.com/features/booking-engine/
Description: ActivityRez plugin to show your ActivityRez booking engine on your site
Author: ActivityRez LLC
Author URI: http://ActivityRez.com/
Version: 3.0
*/
$ACTIVITYREZWB_VERSION = "3.0";
/*
License: CF Commercial-to-GPL License
Copyright 2013-2015 ActivityRez LLC
This License is a legal agreement between You and the Developer for the use of the Software. 
By installing, copying, or otherwise using the Software, You agree to be bound by the terms of this License. 
If You do not agree to the terms of this License, do not install or use the Software.
*/

// *************************************************************************************************** //

	// Start Session
	if (!session_id()) session_start();


/*
 * Security
 */

	// Avoid direct calls to this file, because now WP core and framework has been used
	if ( !function_exists('add_action') ) {
		header('Status: 403 Forbidden');
		header('HTTP/1.1 403 Forbidden');
		exit();
	}

// *************************************************************************************************** //

/*
 * Declare Global Constants
 */

	// Version
	define( 'ACTIVITYREZWB_VERSION', $ACTIVITYREZWB_VERSION ); // e.g. 3.0
	// WordPress Version
	define( 'ACTIVITYREZWB_VERSION_WP_MIN', '3.2' );
	// Paths
	define( 'ACTIVITYREZWB_PLUGIN_PATH', plugin_dir_url(__FILE__) );
	define( 'ACTIVITYREZWB_PLUGIN_DIR', plugin_dir_path(__FILE__) );
	define( 'ACTIVITYREZWB_SLUG', plugin_basename(__FILE__) );
	define( 'ACTIVITYREZWB_TEXTDOMAIN', ACTIVITYREZWB_SLUG );

	// Define Destinations
	define( 'ACTIVITYREZWB_REMOTE', true );  // Let's just assume that we are remote shall we?
	define( 'AREZ_SERVER', 'https://secure.activityrez.com' );
	define( 'AREZ_SERVER_TRAINING', 'https://training.activityrez.com' );


// *************************************************************************************************** //

/*
 * Initialize
 */

	// Call Classes
	require_once( ACTIVITYREZWB_PLUGIN_DIR .'lib/ActivityRezWB-Init.php'); // WP Related
		add_action( 'init', array('ActivityRezWB_Init', 'init') ); // Menu/Internationalization etc.

	//require_once( ACTIVITYREZWB_PLUGIN_DIR .'lib/ActivityRezWB-Common.php'); // Common Functions


	require_once( ACTIVITYREZWB_PLUGIN_DIR .'lib/ActivityRezWB-Admin.php'); // Admin Specific
		add_action( 'init', array('ActivityRezWB_Admin', 'init') ); // Menu/Internationalization etc.

/*
	require_once( ACTIVITYREZWB_PLUGIN_DIR .'lib/ActivityRezWB-App.php'); // App Specific
		add_action( 'init', array('ActivityRezWB_App', 'post_type') ); // Define Post Type
		add_action( 'init', array('ActivityRezWB_App', 'rewrite_slugs') ); // Define Paths


	// DATA
	// TODO
		//add_action('arez_webbooker_update_check', 'arez_update_webbookers');
*/

/*
 * Hooks
 */

	// Activate Plugin
	register_activation_hook(__FILE__, array('ActivityRezWB_Init', 'activation'));

	// Deactivate Plugin
	register_deactivation_hook(__FILE__, array('ActivityRezWB_Init', 'deactivation'));

	// Uninstall Plugin
	register_uninstall_hook(__FILE__, array('ActivityRezWB_Init', 'uninstall'));



// *************************************************************************************************** //

/*
 * Diagnostics
 */

	define( 'ACTIVITYREZWB_VERSION_SUPPORTED', version_compare(get_bloginfo('version'), ACTIVITYREZWB_VERSION_WP_MIN, '>=') );



