<?php

/*
 * ActivityRezWB_Admin Class
 *
 * These are administrative specific functions
 */

class ActivityRezWB_Admin {

	// *************************************************************************************************** //

	/*
	 * Initialize
	 */

		public static function init(){
			// Check if Admin
			if ( is_admin() ){

				// Add Primary Menus
				add_action( 'admin_menu', array('ActivityRezWB_Admin', 'menu_admin') );

				// Add  Menu Item to Settings Page
				add_action( 'admin_menu', array('ActivityRezWB_Admin', 'menu_addlinkto_settings') );

				// Add Styles to Admin Head Section 
				add_action( 'admin_head', array('ActivityRezWB_Admin', 'admin_head_style') );

				// Add Scripts to Admin Head Section 
				add_action( 'admin_head', array('ActivityRezWB_Admin', 'admin_head_scripts'), 0 );

				// Add Link to Settings on Plugin Page
				add_action( 'plugin_action_links', array('ActivityRezWB_Admin', 'menu_addlinkto_plugin'), 10, 2 );

				// Register Settings
				add_action( 'admin_init', array('ActivityRezWB_Admin', 'register_settings'), 10, 2 );

				/*
					TODO:

					// Load Shortcode Generator
					add_action('admin_menu', array('Activities', 'shortcode_display_generator'));

					// Edit Link on Activity
					add_action('admin_menu', array('Activities', 'site_editlink'));

				*/

			}

			// Register Settings
			add_action( 'admin_init', array('ActivityRezWB_Admin', 'register_settings') );

		}



	/*
	 * Register Settings
	 */

		public static function register_settings() {
			register_setting('arez_options_group', 'arez_options');
		}


	/*
	 * Administrative Menu
	 */

		// Add Admin Menu
		public static function menu_admin(){
			add_menu_page( __('Activities', ACTIVITYREZWB_TEXTDOMAIN), __('Activities', ACTIVITYREZWB_TEXTDOMAIN), 'edit_pages', 'arez', array('ActivityRezWB_Admin', 'menu_dashboard'), 'div', 4);
				add_submenu_page( 'arez', __('Dashboard', ACTIVITYREZWB_TEXTDOMAIN), __('Dashboard', ACTIVITYREZWB_TEXTDOMAIN), 'edit_pages', 'arez', array('ActivityRezWB_Admin', 'menu_dashboard') );
				add_submenu_page( 'arez', __('Settings', ACTIVITYREZWB_TEXTDOMAIN), __('Settings', ACTIVITYREZWB_TEXTDOMAIN), 'edit_pages', 'arez-settings', array('ActivityRezWB_Admin', 'menu_settings') );
				add_submenu_page( 'arez', __('Help', ACTIVITYREZWB_TEXTDOMAIN), __('Help', ACTIVITYREZWB_TEXTDOMAIN), 'edit_pages', 'arez-help', array('ActivityRezWB_Admin', 'menu_help') );
		}


		// Add Menu Item to Settings Dropdown
		public static function menu_addlinkto_settings() {

			// Check Permissions, Allow Editors and above, not just any low user level 
			if ( !current_user_can('edit_posts') )
				return;

			add_options_page( 'ActivityRez', 'ActivityRez', "manage_options", "arez_options", array('ActivityRezWB_Admin', 'menu_settings'));
		}


		// Add Link to Settings Page
		public static function menu_addlinkto_plugin( $links, $file ) {
			static $this_plugin;

			if (!$this_plugin) {
				$this_plugin = plugin_basename(__FILE__);
			}

			// check to make sure we are on the correct plugin
			if ($file == ACTIVITYREZWB_PLUGIN_NAME .'/'. ACTIVITYREZWB_PLUGIN_NAME .'.php') {

				// Create Link for Settings Page
				$settings_link = '<a href="'. admin_url("admin.php?page=arez-settings") .'">Settings</a>';
				// Add link to List
				array_unshift($links, $settings_link);
			}

			return $links;
		}

/*

		// Add Link to Edit Activity
		public function site_editlink($profileID){
			// Check if Admin
			if (current_user_can('level_10') && !is_admin()) {

				function prepare_tool($wp_toolbar){
					 $arr = array(
						'id' => 'rb-agency-edit-profile',
						'title' => 'Edit this Profile',
						'href' => admin_url('admin.php?page=rb_agency_profiles&action=editRecord&ProfileID='.get_current_viewingID()),
						'meta' => array('target' => 'rb-agency-edit-profile')
					);

					$wp_toolbar->add_node($arr);
				}
				add_action('admin_bar_menu',"prepare_tool",999,2);
			}
		}


*/


	/*
	 * Define Views for Navigation
	 */

		// Admin Dashboard View
		public static function menu_dashboard(){
			$options = get_option( 'arez_options' );

			// Get Posted Values
			$options = get_option( 'arez_options' );
				if (isset($options['authorized'])) {
					$authorized = $options['authorized'];
				} else {
					$authorized = "";
				}

			// Check if Web Bookers Exist
			$webbookers_count = ActivityRezWB_Data::webbooker_count();

			// Check where we are at
			if( ! $authorized ) {
				include_once( ACTIVITYREZWB_PLUGIN_DIR .'view/admin/authorize.php');
			} elseif( $webbookers_count == 0 ) {
				include_once( ACTIVITYREZWB_PLUGIN_DIR .'view/admin/setup.php');
			} else {
				include_once( ACTIVITYREZWB_PLUGIN_DIR .'view/admin/dashboard.php');
			}
		}


		// Settings Page View
		public static function menu_settings(){
			include_once(ACTIVITYREZWB_PLUGIN_DIR .'view/admin/settings.php');
		}


		// Help Page View
		public static function menu_help(){
			include_once(ACTIVITYREZWB_PLUGIN_DIR .'view/admin/help.php');
		}


	/*
	 * Define Admin Styles
	 */

		// Get Styles
		public static function admin_head_style() {

			// Ensure we are in the admin section of wordpress
			if( is_admin() ) {

				// Get Styles
				wp_register_style( 'ActivityRezWBadmin', ACTIVITYREZWB_PLUGIN_PATH .'assets/css/admin/admin.css' );
				wp_enqueue_style( 'ActivityRezWBadmin' );

			}

		}


		// Get Scripts
		public static function admin_head_scripts() {

			// Ensure we are in the admin section of wordpress
			if( is_admin() ) {
				/*
				// Fix Conflict
				wp_deregister_script('jquery');
				// load the Google API copy in the footer
				wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js', array(), '2.1.3', false);
				wp_enqueue_script('jquery');

				// Loader Bar
				wp_register_script( 'loader', ACTIVITYREZWB_PLUGIN_PATH .'assets/js/admin/loader.js', array( 'jquery' ), '', false);
				wp_enqueue_script( 'loader' );

				// TODO Figure out why this will not load in head:
				?>
				<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
				<script type='text/javascript' src='http://activityrez.dev:8888/wp-content/plugins/activityrez-wb/assets/js/admin/loader.js?ver=4.1'></script><?php
				*/

			}
		}

}
