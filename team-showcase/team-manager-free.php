<?php
	/*
	Plugin Name: Team Showcase
	Plugin URI: https://themepoints.com/teamshowcase/
	Description: Team Showcase is a WordPress plugin that allows you to easily create and manage teams. You can display single teams as multiple responsive columns, you can also showcase all teams in various styles.
	Version: 3.0.1
	Author: Themepoints
	Author URI: https://themepoints.com
	License: GPLv2
	Text Domain: team-manager-free
	Domain Path: /languages
	*/

	// Exit if accessed directly
	if ( ! defined( 'ABSPATH' ) ) {
	    exit;
	}

	// Define plugin version
	define( 'TEAM_MANAGER_PLUGIN_NAME', 'Team Showcase' );
	define( 'TEAM_MANAGER_PLUGIN_SLUG', 'team-manager-free' );
	define( 'TEAM_MANAGER_FREE_VERSION', '3.0.1' );

	// Define paths for the plugin
	define('TEAM_MANAGER_FREE_PLUGIN_PATH', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );
	define('team_manager_free_plugin_dir', plugin_dir_path( __FILE__ ) );
	add_filter('widget_text', 'do_shortcode');

	# load plugin textdomain 
	function team_manager_free_load_textdomain(){
		load_plugin_textdomain('team-manager-free', false, dirname(plugin_basename( __FILE__ )) . '/languages/');
	}
	add_action('plugins_loaded', 'team_manager_free_load_textdomain');

	# load plugin style & scripts
	function team_manager_free_initial_script(){
		wp_enqueue_style( 'team_manager-font-awesome', TEAM_MANAGER_FREE_PLUGIN_PATH.'assets/css/font-awesome.css');
		wp_enqueue_style( 'team_manager-fontello', plugins_url( '/assets/css/fontello.css' , __FILE__ ) );
		wp_enqueue_style( 'team_manager-magnific-popup', TEAM_MANAGER_FREE_PLUGIN_PATH.'assets/css/magnific-popup.css');
		wp_enqueue_style( 'team_manager-team-frontend', TEAM_MANAGER_FREE_PLUGIN_PATH.'assets/css/team-frontend.css');
		wp_enqueue_style( 'team_manager-style1', TEAM_MANAGER_FREE_PLUGIN_PATH.'assets/css/style1.css');
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'imagesloaded' );
		wp_enqueue_script( "jquery-ui-sortable" );
		wp_enqueue_script( "jquery-ui-draggable" );
		wp_enqueue_script( "jquery-ui-droppable" );
		wp_enqueue_script( 'team_manager-magnific', plugins_url( '/assets/js/jquery.magnific-popup.js', __FILE__ ), array('jquery'), '1.0', false);
		wp_enqueue_script('team_manager-main', plugins_url( '/assets/js/main.js', __FILE__ ), array('jquery'), '1.0', false);
	}
	add_action('wp_enqueue_scripts', 'team_manager_free_initial_script', 120);

	# load plugin admin style & scripts
	function team_manager_free_admin_scripts(){
		global $typenow;
		// Common admin styles
		wp_enqueue_style('team_manager-backend-css', TEAM_MANAGER_FREE_PLUGIN_PATH.'admin/css/team-manager-backend.css');

		// Load additional styles and scripts for specific post types
		if(($typenow == 'team_mf')){
			wp_enqueue_style('team-manager-free-admin2-style', TEAM_MANAGER_FREE_PLUGIN_PATH.'admin/css/team-manager-free-admin.css');
			wp_enqueue_style('wp-color-picker');
			wp_enqueue_script( 'jquery-ui-sortable' );
			wp_enqueue_script( 'team-manager-skills-scripts', plugins_url('/admin/js/team-manager-skills.js', __FILE__ ), array( 'jquery' ), '1.0.0', true );
			wp_enqueue_script( 'team-manager-color-picker', plugins_url('/admin/js/color-picker.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
		}
		// Load additional styles and scripts for specific post types
		if(($typenow == 'team_mf_team')){
			wp_enqueue_style('team-manager-free-admin-style', TEAM_MANAGER_FREE_PLUGIN_PATH.'admin/css/team-manager-free-admin.css');
			wp_enqueue_script('jquery');
			wp_enqueue_script('team-manager-free-admin-scripts', TEAM_MANAGER_FREE_PLUGIN_PATH.'admin/js/team-manager-free-admin.js', array('jquery'), '1.0.4', true );
			wp_enqueue_style('wp-color-picker');
			wp_enqueue_script('team-manager-color-picker', plugins_url('/admin/js/color-picker.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
			wp_enqueue_script('jquery-ui-tabs');
			wp_enqueue_script('jquery-ui-sortable');
			wp_enqueue_script('media-upload');
			wp_enqueue_script('thickbox');
			wp_enqueue_style('thickbox');
		}
	}
	add_action('admin_enqueue_scripts', 'team_manager_free_admin_scripts');

	function team_manager_free_buy_action_links( $links ) {
		$links[] = '<a target="_blank" href="https://themepoints.com/product/team-showcase-pro/" style="color: green; font-weight: bold;" target="_blank">Upgrade Pro!</a>';
		return $links;
	}
	add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'team_manager_free_buy_action_links' );

	// Team Post Type File
	require_once( plugin_dir_path(__FILE__) . 'admin/team-manager-free-post-type.php' );

	// Register Meta Boxes
	require_once( plugin_dir_path(__FILE__) . 'admin/team-manager-free-meta-boxes.php');

	// Team Post Type Metabox Options
	require_once( plugin_dir_path(__FILE__) . 'admin/team-manager-free-meta-options.php');

	// Team Post Shortcode File
	require_once( plugin_dir_path( __FILE__ ) . 'includes/shortcodes/team-shortcode.php' );

	# plugin activation/deactivation
	function active_team_manager_free(){

        $installed = get_option( 'tmffree_team_activation_time' );
	    // Check if this is the first activation
	    if (! $installed ) {
	        // If so, set the installation time
	        update_option('tmffree_team_activation_time', time() );
	    }

		require_once plugin_dir_path( __FILE__ ) . 'includes/team-manager-free-activator.php';

		Team_Manager_Free_Activator::activate();
	}

	function deactive_team_manager_free(){

		require_once plugin_dir_path(__FILE__) . 'includes/team-manager-free-deactivator.php';

		Team_Manager_Free_Deactivator::deactivate();
	}
	register_activation_hook(__FILE__, 'active_team_manager_free');
	register_deactivation_hook(__FILE__, 'deactive_team_manager_free');

	// Function to add a submenu page under the custom post type 'team_mf'
	function team_manager_free_help_submenu_page() {
		if (current_user_can('manage_options')) {
			add_submenu_page(
			    'edit.php?post_type=team_mf',     // Parent menu slug
			    __('Help & Usage', 'team-manager-free'), // Page title
			    __('Help & Usage', 'team-manager-free'), // Menu title
			    'manage_options',                     // Capability required to access
			    'team_welcome_shortcode',          // Menu slug
			    'tps_team_showcase_help_shortcode_callback' // Callback function
			);
		}
	}
	add_action('admin_menu', 'team_manager_free_help_submenu_page');

	// Callback function for the custom submenu page
	function tps_team_showcase_help_shortcode_callback() {
		// Include the file containing the shortcode options
		require_once( plugin_dir_path(__FILE__) . 'admin/team-manager-free-helps.php' );
	}

	// Run this function on plugin activation
	function tps_teamshowcase_pro_activate() {
	    add_option('tps_teamshowcase_pro_redirect', true);
	}
	register_activation_hook(__FILE__, 'tps_teamshowcase_pro_activate');

	function tps_teamshowcase_pro_redirect_after_activation() {
	    // Check if the option exists and the user has admin rights
	    if (get_option('tps_teamshowcase_pro_redirect') && current_user_can('manage_options')) {
	        // Delete the option so the redirect only happens once
	        delete_option('tps_teamshowcase_pro_redirect');
	        
	        // Redirect to the submenu page
	        wp_redirect(admin_url('edit.php?post_type=team_mf&page=team_welcome_shortcode'));
	        exit;
	    }
	}
	add_action('admin_init', 'tps_teamshowcase_pro_redirect_after_activation');