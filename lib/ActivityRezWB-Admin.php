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

		public function admin_init(){

			// Check if Admin
			if ( is_admin() ){

				// Add Primary Menus
				add_action( 'admin_menu', array('ActivityRezWB_Admin', 'menu_admin') );

				// Add  Menu Item to Settings Page
				add_action( 'admin_menu', array('ActivityRezWB_Admin', 'menu_addlinkto_settings') );

				// Add Styles to Admin Head Section 
				add_action('admin_head', array('ActivityRezWB_Admin', 'ActivityRezWB_admin_head') );



				/*
				TODO:

				// Load Shortcode Generator
				add_action('admin_menu', array('Activities', 'shortcode_display_generator'));

				// Add Link to Plugin Page
				add_action('plugin_action_links', array('Activities', 'menu_addlinkto_plugin'),10,2);

				// Register Settings
				add_action('admin_init', array('RBAgency', 'do_register_settings') );

				*/

			}

		}


	/*
	 * Administrative Menu's
	 */

		// Add Admin Menu
		public static function menu_admin(){

			add_menu_page( __('Activities', ACTIVITYREZWB_TEXTDOMAIN), __('Activities', ACTIVITYREZWB_TEXTDOMAIN), 'edit_pages', 'arez', array('ActivityRezWB_Admin', 'menu_dashboard'), 'div', 4);

				add_submenu_page( 'arez', __('Dashboard', ACTIVITYREZWB_TEXTDOMAIN), __('Dashboard', ACTIVITYREZWB_TEXTDOMAIN), 'edit_pages', 'arez', array('ActivityRezWB_Admin', 'menu_dashboard') );
				add_submenu_page( 'arez', __('Settings', ACTIVITYREZWB_TEXTDOMAIN), __('Settings', ACTIVITYREZWB_TEXTDOMAIN), 'edit_pages', 'arez_menu_settings', array('ActivityRezWB_Admin', 'menu_settings') );

		}

		// Add Menu Item to Settings Dropdown
		public static function menu_addlinkto_settings() {

			// Check Permissions, Allow Editors and above, not just any low user level 
			if ( !current_user_can('edit_posts') )
				return;

			add_options_page( 'ActivityRez', 'ActivityRez', "manage_options", "arez_plugin", array('ActivityRezWB_Admin', 'menu_settings'));
		}

/*
		// Add Link to Settings Page
		public static function menu_addlinkto_plugin( $links, $file ) {
			static $this_plugin;

			if (!$this_plugin) {
				$this_plugin = plugin_basename(__FILE__);
			}

			// check to make sure we are on the correct plugin
			if ($file == $this_plugin) {

				// Create Link for Settings Page
				$settings_link = '<a href="' . admin_url("admin.php") . '?page=rb_agency_settings">Settings</a>';
				// Add link to List
				array_unshift($links, $settings_link);
			}

			return $links;
		}



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
			include_once( ACTIVITYREZWB_PLUGIN_DIR .'view/admin/dashboard.php');
		}

		// Settings Page View
		public static function menu_settings(){
			//include_once('view/admin/settings.php');
		}


	/*
	 * Define Admin Styles
	 */

		function ActivityRezWB_admin_head() {
			// Ensure we are in the admin section of wordpress
			if( is_admin() ) {

				// Get Styles
				wp_register_style( 'ActivityRezWBadmin', ACTIVITYREZWB_PLUGIN_PATH .'assets/css/admin/admin.css' );
				wp_enqueue_style( 'ActivityRezWBadmin' );

				// Get Scripts
				//wp_enqueue_script( 'jquery-ui-datepicker' );

			}
		}

}
