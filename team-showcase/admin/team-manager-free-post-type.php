<?php
	/*
	* @Author 		Themepoints
	* Copyright: 	Themepoints
	* Version : 2.3
	*/

	if ( ! defined( 'ABSPATH' ) ) {
	    exit;
	} // Exit if accessed directly

	/*===================================================================
		Register Custom Post Function
	=====================================================================*/
	function team_manager_free_custom_post_type(){
		$labels = array(
			'name'                  => _x( 'Team Showcase', 'Post Type General Name', 'team-manager-free' ),
			'singular_name'         => _x( 'Team Showcase', 'Post Type Singular Name', 'team-manager-free' ),
			'menu_name'             => __( 'Team Showcase', 'team-manager-free' ),
			'name_admin_bar'        => __( 'Team Manager', 'team-manager-free' ),
			'parent_item_colon'     => __( 'Parent Item:', 'team-manager-free' ),
			'all_items'             => __( 'All Team Members', 'team-manager-free' ),
			'add_new_item'          => __( 'Add New Member', 'team-manager-free' ),
			'add_new'               => __( 'Add New Member', 'team-manager-free' ),
			'new_item'              => __( 'New Member', 'team-manager-free' ),
			'edit_item'             => __( 'Edit Member', 'team-manager-free' ),
			'update_item'           => __( 'Update Member', 'team-manager-free' ),
			'view_item'             => __( 'View Member', 'team-manager-free' ),
			'search_items'          => __( 'Search Team Member', 'team-manager-free' ),
			'not_found'             => __( 'Not found', 'team-manager-free' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'team-manager-free' ),
			'featured_image'        => __( 'Team Member Image', 'team-manager-free' ),
			'set_featured_image'    => __( 'Set Team Member image', 'team-manager-free' ),
			'remove_featured_image' => __( 'Remove Team Member image', 'team-manager-free' ),
			'use_featured_image'    => __( 'Use as Team Member image', 'team-manager-free' ),
			'items_list'            => __( 'Items list', 'team-manager-free' ),
			'items_list_navigation' => __( 'Items list navigation', 'team-manager-free' ),
			'filter_items_list'     => __( 'Filter items list', 'team-manager-free' ),
		);
		$args = array(
			'label'                 => __( 'Post Type', 'team-manager-free' ),
			'description'           => __( 'Post Type Description', 'team-manager-free' ),
			'labels'                => $labels,
			'supports'              =>  array( 'title', 'editor', 'thumbnail',),
			'hierarchical'          => false,
			'public'                => true,
			'menu_icon' 			=> 'dashicons-admin-users',
			'show_ui'               => true,
			'show_in_menu'          => true,
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,		
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'page',
		);
		register_post_type( 'team_mf', $args );
	}
	// end custom post type
	add_action('init', 'team_manager_free_custom_post_type');

	function team_manager_free_custom_post_taxonomies_reg() {
		$labels = array(
			'name'              => _x( 'Team Member Groups', 'taxonomy general name' ),
			'singular_name'     => _x( 'Team Group', 'taxonomy singular name' ),
			'search_items'      => __( 'Search Groups' ),
			'all_items'         => __( 'All Groups' ),
			'parent_item'       => __( 'Parent Group' ),
			'parent_item_colon' => __( 'Parent Group:' ),
			'edit_item'         => __( 'Edit Team Group' ), 
			'update_item'       => __( 'Update Group' ),
			'add_new_item'      => __( 'Add New Team Group' ),
			'new_item_name'     => __( 'New Team Group' ),
			'menu_name'         => __( 'Team Groups' ),
		);
		$args = array(
			'labels' => $labels,
			'hierarchical' => true,
		);
		register_taxonomy( 'team_mfcategory', 'team_mf', $args );
	}
	add_action( 'init', 'team_manager_free_custom_post_taxonomies_reg', 0 );

	# Modify Member Title
	function team_manager_free_admin_enter_title( $input ) {
		global $post_type;
		if ( 'team_mf' == $post_type )
			return __( 'Enter Member Name', 'team-manager-free' );
		return $input;
	}
	add_filter( 'enter_title_here', 'team_manager_free_admin_enter_title' );

	# Team Update Notice
	function team_manager_free_custom_post_updated_messages( $messages ) {
		global $post, $post_id;
		$messages['team_mf'] = array(
			1 => __('Team Showcase updated.', 'team-manager-free'),
			2 => $messages['post'][2],
			3 => $messages['post'][3],
			4 => __('Team Showcase updated.', 'team-manager-free'),
			5 => isset($_GET['revision']) ? sprintf( __('Team Showcase restored to revision from %s', 'team-manager-free'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6 => __('Team Showcase published.', 'team-manager-free'),
			7 => __('Team Showcase saved.', 'team-manager-free'),
			8 => __('Team Showcase submitted.', 'team-manager-free'),
			9 => sprintf( __('Team Showcase scheduled for: <strong>%1$s</strong>.', 'team-manager-free'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) )),
			10 => __('Team Showcase draft updated.', 'team-manager-free'),
		);
		return $messages;
	}
	add_filter( 'post_updated_messages', 'team_manager_free_custom_post_updated_messages' );	

	# Team Add Options page
	function team_manager_free_custom_post_add_submenu_items(){
		add_submenu_page('edit.php?post_type=team_mf', __('Generate Shortcode', 'team-manager-free'), __('Generate Shortcode', 'team-manager-free'), 'manage_options', 'post-new.php?post_type=team_mf_team');
	}
	add_action('admin_menu', 'team_manager_free_custom_post_add_submenu_items');


	# Team Shortcode post register
	function team_manager_free_custom_post_create_team_type() {
	// Set UI labels for Custom Post Type
		$labels = array(
			'name'                => _x( 'Team Shortcodes', 'Post Type General Name', 'team-manager-free' ),
			'singular_name'       => _x( 'Shortcode', 'Post Type Singular Name', 'team-manager-free' ),
			'menu_name'           => __( 'Shortcodes', 'team-manager-free' ),
			'parent_item_colon'   => __( 'Parent Shortcode', 'team-manager-free' ),
			'all_items'           => __( 'All Shortcodes', 'team-manager-free' ),
			'view_item'           => __( 'View Shortcode', 'team-manager-free' ),
			'add_new_item'        => __( 'Create New Team Shortcode', 'team-manager-free' ),
			'add_new'             => __( 'Add New Team Shortcode', 'team-manager-free' ),
			'edit_item'           => __( 'Edit Team Shortcode', 'team-manager-free' ),
			'update_item'         => __( 'Update Team Shortcode', 'team-manager-free' ),
			'search_items'        => __( 'Search Team Shortcode', 'team-manager-free' ),
			'not_found'           => __( 'Team Shortcode Not Found', 'team-manager-free' ),
			'not_found_in_trash'  => __( 'Team Shortcode Not found in Trash', 'team-manager-free' ),
		);

		// Set other options for Custom Post Type
		$args = array(
			'label'               => __( 'Shortcodes', 'team-manager-free' ),
			'description'         => __( 'Shortcode news and reviews', 'team-manager-free' ),
			'labels'              => $labels,
			'supports'            => array( 'title'),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu' 		  => 'edit.php?post_type=team_mf',
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 5,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'page',
		);

		// Registering your Custom Post Type
		register_post_type( 'team_mf_team', $args );
	}

	add_action( 'init', 'team_manager_free_custom_post_create_team_type');	

	# Modify shortcode page title
	function team_manager_free_team_mf_team_admin_enter_title( $input ) {
		global $post_type;
		if ( 'team_mf_team' == $post_type )
			return __( 'Enter Shortcode Name For Identity', 'team-manager-free' );
		return $input;
	}
	add_filter( 'enter_title_here', 'team_manager_free_team_mf_team_admin_enter_title' );

	# Team updated notice
	function team_manager_free_custom_post_team_mf_team_updated_messages( $messages ) {
		global $post, $post_id;
		$messages['team_mf_team'] = array( 
			1 => __('Team Shortcode updated.', 'team-manager-free'),
			2 => $messages['post'][2],
			3 => $messages['post'][3],
			4 => __('Shortcode updated.', 'team-manager-free'),
			5 => isset($_GET['revision']) ? sprintf( __('Shortcode restored to revision from %s', 'team-manager-free'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6 => __('Team Shortcode published.', 'team-manager-free'),
			7 => __('Team Shortcode saved.', 'team-manager-free'),
			8 => __('Team Shortcode submitted.', 'team-manager-free'),
			9 => sprintf( __('Shortcode scheduled for: <strong>%1$s</strong>.', 'team-manager-free'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) )),
			10 => __('Shortcode draft updated.', 'team-manager-free'),
		);
		return $messages;
	}
	add_filter( 'post_updated_messages', 'team_manager_free_custom_post_team_mf_team_updated_messages' );

	# Columns Declaration Function
	function team_manager_free_columns($team_manager_free_columns){

		$order='asc';
		if($_GET['order']=='asc') {
			$order='desc';
		}
		$team_manager_free_columns = array(
			"cb"                      => "<input type=\"checkbox\" />",
			"thumbnail"               => __('Image', 'team-manager-free'),
			"title"                   => __('Name', 'team-manager-free'),
			"client_shortdescription" => __('Short Description', 'team-manager-free'),
			"client_designation"      => __('Designation', 'team-manager-free'),
			"ktstcategories"          => __('Categories', 'team-manager-free'),
			"date"                    => __('Date', 'team-manager-free'),
		);
		return $team_manager_free_columns;
	}

	# testimonial Value Function
	function team_manager_free_columns_display($team_manager_free_columns, $post_id){

		global $post;
		$width = (int) 80;
		$height = (int) 80;

		if ( 'thumbnail' == $team_manager_free_columns ) {
			if ( has_post_thumbnail($post_id)) {
				$thumbnail_id = get_post_meta( $post_id, '_thumbnail_id', true );
				$thumb = wp_get_attachment_image( $thumbnail_id, array($width, $height), true );
				echo $thumb;
			}else{
				echo __('None');
			}
		}

		if ( 'client_designation' == $team_manager_free_columns ) {
			echo esc_attr( get_post_meta($post_id, 'client_designation', true) );
		}
		if ( 'client_shortdescription' == $team_manager_free_columns ) {
			echo esc_attr( get_post_meta($post_id, 'client_shortdescription', true) );
		}
		if ( 'ktstcategories' == $team_manager_free_columns ) {
			$terms = get_the_terms( $post_id , 'team_mfcategory');
			$count = count( array( $terms ) );
			if ( $terms ) {
				$i = 0;
				foreach ( $terms as $term ) {
					if ( $i+1 != $count ) {
						echo ", ";
					}
					echo '<a href="'.admin_url( 'edit.php?post_type=team_mf&team_mfcategory='.$term->slug ).'">'.$term->name.'</a>';
					$i++;
				}
			}
		}
	}
	
	# Add manage_tmls_posts_columns Filter 
	add_filter("manage_team_mf_posts_columns", "team_manager_free_columns");
	add_action("manage_team_mf_posts_custom_column",  "team_manager_free_columns_display", 10, 2 );	

	function team_manager_free_add_shortcode_column( $columns ) {
		$order='asc';
		if($_GET['order']=='asc') {
			$order='desc';
		}
		$columns = array(
			"cb"        => "<input type=\"checkbox\" />",
			"title"     => __('Shortcode Name', 'team-manager-free'),
			"shortcode" => __('Shortcode', 'team-manager-free'),
			"date"      => __('Date', 'team-manager-free'),
		);
		return $columns;
	}
	add_filter( 'manage_team_mf_team_posts_columns' , 'team_manager_free_add_shortcode_column' );

	function team_manager_free_add_posts_shortcode_display( $column, $post_id ) {
		if ($column == 'shortcode'){ ?>
			<span><input style="background:#ddd" type="text" onClick="this.select();" value="[tmfshortcode <?php echo 'id=&quot;'.$post_id.'&quot;';?>]" /></span>
			<?php
		}
	}
	add_action( 'manage_team_mf_team_posts_custom_column' , 'team_manager_free_add_posts_shortcode_display', 10, 2 );

	# Register Post Meta Boxes
	function team_manager_free_add_metabox() {
		$screens = array('team_mf_team');
		foreach ($screens as $screen) {
			add_meta_box('team_manager_free_sectionid', __('Team Options', 'team-manager-free'),'single_team_manager_free_display', $screen,'normal','high');
		}
	} // end metabox boxes

	add_action('add_meta_boxes', 'team_manager_free_add_metabox');

	/*=====================================================================
	 * Renders the nonce and the textarea for the notice.
	 =======================================================================*/
	function single_team_manager_free_display( $post, $args ) {
        global $post;

		//get the saved meta as an arry
		$team_manager_free_category_select        = get_post_meta( $post->ID, 'team_manager_free_category_select', true );
		if(empty($team_manager_free_category_select)){
		$team_manager_free_category_select        = array();
		}
		$team_manager_free_post_themes            = get_post_meta( $post->ID, 'team_manager_free_post_themes', true );
		$team_manager_free_theme_style            = get_post_meta( $post->ID, 'team_manager_free_theme_style', true );
		$team_manager_free_limits                 = get_post_meta( $post->ID, 'team_manager_free_limits', true );
		$teamf_orderby                            = get_post_meta( $post->ID, 'teamf_orderby', true );
		$teamf_order                              = get_post_meta( $post->ID, 'teamf_order', true );
		$team_manager_free_imagesize              = get_post_meta( $post->ID, 'team_manager_free_imagesize', true );
		$team_manager_free_post_column            = get_post_meta( $post->ID, 'team_manager_free_post_column', true );
		$team_manager_free_margin_bottom          = get_post_meta( $post->ID, 'team_manager_free_margin_bottom', true );
		$team_manager_free_padding_left           = get_post_meta( $post->ID, 'team_manager_free_padding_left', true );
		$team_manager_free_padding_right          = get_post_meta( $post->ID, 'team_manager_free_padding_right', true );
		$team_manager_free_margin_lfr             = get_post_meta( $post->ID, 'team_manager_free_margin_lfr', true );
		$team_manager_free_img_height             = get_post_meta( $post->ID, 'team_manager_free_img_height', true );
		$team_manager_free_social_target          = get_post_meta( $post->ID, 'team_manager_free_social_target', true );
		$team_manager_free_text_alignment         = get_post_meta( $post->ID, 'team_manager_free_text_alignment', true );
		$team_manager_free_multicolor_hide        = get_post_meta( $post->ID, 'team_manager_free_multicolor_hide', true );
		$team_manager_free_emails_hide            = get_post_meta( $post->ID, 'team_manager_free_emails_hide', true );	
		$team_manager_free_emails_font_color      = get_post_meta( $post->ID, 'team_manager_free_emails_font_color', true );
		$team_manager_free_emails_hover_color     = get_post_meta( $post->ID, 'team_manager_free_emails_hover_color', true );
		$team_manager_free_emails_font_size       = get_post_meta( $post->ID, 'team_manager_free_emails_font_size', true );
		$team_manager_free_biography_option       = get_post_meta( $post->ID, 'team_manager_free_biography_option', true );
		$team_manager_free_header_font_size       = get_post_meta( $post->ID, 'team_manager_free_header_font_size', true );
		$team_manager_name_font_weight            = get_post_meta( $post->ID, 'team_manager_name_font_weight', true );
		$team_manager_name_font_style             = get_post_meta( $post->ID, 'team_manager_name_font_style', true );
		$team_manager_free_designation_hide  	  = get_post_meta( $post->ID, 'team_manager_free_designation_hide', true );
		$team_manager_free_designation_font_size  = get_post_meta( $post->ID, 'team_manager_free_designation_font_size', true );
		$team_manager_free_header_font_color      = get_post_meta( $post->ID, 'team_manager_free_header_font_color', true );
		$team_manager_free_name_hover_font_color  = get_post_meta( $post->ID, 'team_manager_free_name_hover_font_color', true );
		$team_manager_name_font_case              = get_post_meta( $post->ID, 'team_manager_name_font_case', true );
		$team_manager_free_designation_font_color = get_post_meta( $post->ID, 'team_manager_free_designation_font_color', true );
		$team_manager_desig_font_case             = get_post_meta( $post->ID, 'team_manager_desig_font_case', true );
		$team_manager_desig_font_style            = get_post_meta( $post->ID, 'team_manager_desig_font_style', true );
		$team_manager_free_numbers_hide           = get_post_meta( $post->ID, 'team_manager_free_numbers_hide', true );
		$team_manager_free_numbers_font_size      = get_post_meta( $post->ID, 'team_manager_free_numbers_font_size', true );
		$team_manager_free_numbers_font_color     = get_post_meta( $post->ID, 'team_manager_free_numbers_font_color', true );
		$team_manager_free_numbers_hover_color    = get_post_meta( $post->ID, 'team_manager_free_numbers_hover_color', true );
		$team_manager_free_address_hide           = get_post_meta( $post->ID, 'team_manager_free_address_hide', true );
		$team_manager_free_addresss_font_color    = get_post_meta( $post->ID, 'team_manager_free_addresss_font_color', true );
		$team_manager_free_addresss_font_size     = get_post_meta( $post->ID, 'team_manager_free_addresss_font_size', true );
		$team_manager_free_website_hide           = get_post_meta( $post->ID, 'team_manager_free_website_hide', true );
		$team_manager_free_website_font_size      = get_post_meta( $post->ID, 'team_manager_free_website_font_size', true );
		$team_manager_free_website_font_color     = get_post_meta( $post->ID, 'team_manager_free_website_font_color', true );
		$team_manager_free_website_hover_color    = get_post_meta( $post->ID, 'team_manager_free_website_hover_color', true );
		$team_manager_free_biography_font_size    = get_post_meta( $post->ID, 'team_manager_free_biography_font_size', true );
		$team_manager_free_overlay_bg_color       = get_post_meta( $post->ID, 'team_manager_free_overlay_bg_color', true );
		$team_manager_free_biography_font_color   = get_post_meta( $post->ID, 'team_manager_free_biography_font_color', true );
		$filter_align                             = get_post_meta( $post->ID, 'filter_align', true );
		$filter_bg_color                          = get_post_meta( $post->ID, 'filter_bg_color', true );
		$filter_border_color                      = get_post_meta( $post->ID, 'filter_border_color', true );
		$filter_mfont_color                       = get_post_meta( $post->ID, 'filter_mfont_color', true );
		$filter_active_color                      = get_post_meta( $post->ID, 'filter_active_color', true );
		$filter_active_font                       = get_post_meta( $post->ID, 'filter_active_font', true );
		$filter_hover_color                       = get_post_meta( $post->ID, 'filter_hover_color', true );
		$filter_hover_tcolor                      = get_post_meta( $post->ID, 'filter_hover_tcolor', true );
		$filter_border_radius                     = get_post_meta( $post->ID, 'filter_border_radius', true );

		$team_fbackground_color                   = get_post_meta( $post->ID, 'team_fbackground_color', true );
		$team_manager_free_socialicons_hide       = get_post_meta( $post->ID, 'team_manager_free_socialicons_hide', true );
		$tmffree_social_font_size                 = get_post_meta( $post->ID, 'tmffree_social_font_size', true );
		$tmffree_social_icon_color                = get_post_meta( $post->ID, 'tmffree_social_icon_color', true );
		$tmffree_social_hover_color               = get_post_meta( $post->ID, 'tmffree_social_hover_color', true );
		$tmffree_social_bg_color                  = get_post_meta( $post->ID, 'tmffree_social_bg_color', true );
		$team_manager_free_popupbox_hide          = get_post_meta( $post->ID, 'team_manager_free_popupbox_hide', true);
		$team_manager_free_popupbox_positions     = get_post_meta( $post->ID, 'team_manager_free_popupbox_positions', true);

		$item_no                                  = get_post_meta( $post->ID, 'item_no', true );
		$loop                                     = get_post_meta( $post->ID, 'loop', true );
		$margin                                   = get_post_meta( $post->ID, 'margin', true );
		$navigation                               = get_post_meta( $post->ID, 'navigation', true );
		$pagination                               = get_post_meta( $post->ID, 'pagination', true );
		$autoplay                                 = get_post_meta( $post->ID, 'autoplay', true );
		$autoplay_speed                           = get_post_meta( $post->ID, 'autoplay_speed', true );
		$stop_hover                               = get_post_meta( $post->ID, 'stop_hover', true );
		$itemsdesktop                             = get_post_meta( $post->ID, 'itemsdesktop', true );
		$itemsdesktopsmall                        = get_post_meta( $post->ID, 'itemsdesktopsmall', true );
		$itemsmobile                              = get_post_meta( $post->ID, 'itemsmobile', true );
		$autoplaytimeout                          = get_post_meta( $post->ID, 'autoplaytimeout', true );
		$nav_text_color                           = get_post_meta( $post->ID, 'nav_text_color', true );	
		$nav_hover_text_color                     = get_post_meta( $post->ID, 'nav_hover_text_color', true );	
		$nav_hover_bg_color                       = get_post_meta( $post->ID, 'nav_hover_bg_color', true );	
		$nav_bg_color                             = get_post_meta( $post->ID, 'nav_bg_color', true );
		$navigation_align                         = get_post_meta( $post->ID, 'navigation_align', true );
		$navigation_btn_style                     = get_post_meta( $post->ID, 'navigation_btn_style', true );
		$pagination_bg_color                      = get_post_meta( $post->ID, 'pagination_bg_color', true );
		$pagination_active_color                  = get_post_meta( $post->ID, 'pagination_active_color', true );
		$pagination_align                         = get_post_meta( $post->ID, 'pagination_align', true );

		$team_popup_title_hide              	  = get_post_meta( $post->ID, 'team_popup_title_hide', true);
		$team_popup_designatins_hide              = get_post_meta( $post->ID, 'team_popup_designatins_hide', true);
		$team_popup_emails_hide                   = get_post_meta( $post->ID, 'team_popup_emails_hide', true);
		$team_popup_contacts_hide                 = get_post_meta( $post->ID, 'team_popup_contacts_hide', true);
		$team_popup_address_hide                  = get_post_meta( $post->ID, 'team_popup_address_hide', true);
		$team_popup_website_hide                  = get_post_meta( $post->ID, 'team_popup_website_hide', true);
		$team_popup_infoicons_hide                = get_post_meta( $post->ID, 'team_popup_infoicons_hide', true);
		$nav_value                                = get_post_meta( $post->ID, 'nav_value', true );
	?>

	<div class="tupsetings post-grid-metabox">
		<!-- <div class="wrap"> -->
		<ul class="tab-nav">
			<li nav="1" class="nav1 <?php if($nav_value == 1){echo "active";}?>"><?php _e('Shortcodes','team-manager-free'); ?></li>
			<li nav="2" class="nav2 <?php if($nav_value == 2){echo "active";}?>"><?php _e('Team Query','team-manager-free'); ?></li>
			<li nav="3" class="nav3 <?php if($nav_value == 3){echo "active";}?>"><?php _e('All Settings ','team-manager-free'); ?></li>
			<li nav="4" class="nav4 <?php if($nav_value == 4){echo "active";}?>"><?php _e( 'Grid Settings','team-manager-free' ); ?></li>
			<li nav="5" class="nav5 <?php if($nav_value == 5){echo "active";}?>"><?php _e('Popup box Settings','team-manager-free'); ?></li>
			<li nav="6" class="nav6 <?php if($nav_value == 6){echo "active";}?>"><?php _e('Social Settings','team-manager-free'); ?></li>
			<li nav="7" class="nav7 <?php if($nav_value == 7){echo "active";}?>"><?php _e( 'Slider Settings','team-manager-free' ); ?></li>
		</ul> <!-- tab-nav end -->
		<?php 
			$getNavValue = "";
			if(!empty($nav_value)){ $getNavValue = $nav_value; } else { $getNavValue = 1; }
		?>
		<input type="hidden" name="nav_value" id="nav_value" value="<?php echo $getNavValue; ?>"> 

		<ul class="box">
			<!-- Tab 1 -->
			<li style="<?php if($nav_value == 1){echo "display: block;";} else{ echo "display: none;"; }?>" class="box1 tab-box <?php if($nav_value == 1){echo "active";}?>">
				<div class="option-box">
					<p class="option-title"><?php _e('Shortcode','team-manager-free'); ?></p>
					<p class="option-info"><?php _e('Copy this shortcode and paste on post, page or text widgets where you want to display Team Showcase.','team-manager-free'); ?></p>
					<textarea cols="50" rows="1" onClick="this.select();" >[tmfshortcode <?php echo 'id="'.$post->ID.'"';?>]</textarea>
					<br /><br />
					<p class="option-info"><?php _e('PHP Code:','team-manager-free'); ?></p>
					<p class="option-info"><?php _e('Use PHP code to your themes file to display Team Showcase.','team-manager-free'); ?></p>
					<textarea cols="50" rows="2" onClick="this.select();" ><?php echo '<?php echo do_shortcode("[tmfshortcode id='; echo "'".$post->ID."']"; echo '"); ?>'; ?></textarea>  
				</div>
			</li>
			
			<!-- Tab 2  -->
			<li style="<?php if($nav_value == 2){echo "display: block;";} else{ echo "display: none;"; }?>" class="box2 tab-box <?php if($nav_value == 2){echo "active";}?>">
				<div class="wrap">
					<div class="option-box">
						<p class="option-title"><?php _e('Team Query','team-manager-free'); ?></p>
						<table class="form-table">
							<tr valign="top">
								<th scope="row">
									<label for="team_manager_free_category_select"><?php _e('Select Categories', 'team-manager-free');?></label>
									<span class="team_manager_hint toss"><?php echo __('The category names will only be visible when members are published within any categories.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<ul>			
										<?php
											$args = array( 
												'taxonomy'     => 'team_mfcategory',
												'orderby'      => 'name',
												'show_count'   => 1,
												'pad_counts'   => 1,
												'hierarchical' => 1,
												'echo'         => 0
											);

											$allthecats = get_categories( $args );

											foreach( $allthecats as $category ):
											    $cat_id = $category->cat_ID;
											    $checked = ( in_array($cat_id,(array)$team_manager_free_category_select)? ' checked="checked"': "" );
											        echo'<li id="cat-'.$cat_id.'"><input type="checkbox" name="team_manager_free_category_select[]" id="'.$cat_id.'" value="'.$cat_id.'"'.$checked.'> <label for="'.$cat_id.'">'.__( $category->cat_name, 'team-manager-free' ).'</label></li>';
											endforeach;
										?>
									</ul>
									<span class="team_manager_hint"><?php echo __('Choose multiple categories for each Shortcode.', 'team-manager-free'); ?></span>
								</td>
							</tr>
							<!-- End Testimonial Categories -->

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_free_post_themes"><?php echo __('Select Style', 'team-manager-free'); ?></label>
									<span class="team_manager_hint toss"><?php echo __('Select a Style which you want to display.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<select name="team_manager_free_post_themes" id="team_manager_free_post_themes" class="timezone_string">
										<option value="theme1" <?php if ( isset ( $team_manager_free_post_themes ) ) selected( $team_manager_free_post_themes, 'theme1' ); ?>><?php _e('Team Theme 1', 'team-manager-free');?></option>
										<option value="theme2" <?php if ( isset ( $team_manager_free_post_themes ) ) selected( $team_manager_free_post_themes, 'theme2' ); ?>><?php _e('Team Theme 2', 'team-manager-free');?></option>
										<option value="theme3" <?php if ( isset ( $team_manager_free_post_themes ) ) selected( $team_manager_free_post_themes, 'theme3' ); ?>><?php _e('Team Theme 3', 'team-manager-free');?></option>
										<option value="theme4" <?php if ( isset ( $team_manager_free_post_themes ) ) selected( $team_manager_free_post_themes, 'theme4' ); ?>><?php _e('Team Theme 4', 'team-manager-free');?></option>
										<option value="5" <?php if ( isset ( $team_manager_free_post_themes ) ) selected( $team_manager_free_post_themes, '5' ); ?>><?php _e('Team Theme 5 (Pro)', 'team-manager-free');?></option>
										<option value="6" <?php if ( isset ( $team_manager_free_post_themes ) ) selected( $team_manager_free_post_themes, '6' ); ?>><?php _e('Team Theme 6 (Pro)', 'team-manager-free');?></option>
										<option value="7" <?php if ( isset ( $team_manager_free_post_themes ) ) selected( $team_manager_free_post_themes, '7' ); ?>><?php _e('Team Theme 7 (Pro)', 'team-manager-free');?></option>
										<option value="8" <?php if ( isset ( $team_manager_free_post_themes ) ) selected( $team_manager_free_post_themes, '8' ); ?>><?php _e('Team Theme 8 (Pro)', 'team-manager-free');?></option>
										<option value="9" <?php if ( isset ( $team_manager_free_post_themes ) ) selected( $team_manager_free_post_themes, '9' ); ?>><?php _e('Team Theme 9 (Pro)', 'team-manager-free');?></option>
										<option value="10" <?php if ( isset ( $team_manager_free_post_themes ) ) selected( $team_manager_free_post_themes, '10' ); ?>><?php _e('Team Theme 10 (Pro)', 'team-manager-free');?></option>
										<option value="11" <?php if ( isset ( $team_manager_free_post_themes ) ) selected( $team_manager_free_post_themes, '11' ); ?>><?php _e('Team Theme 11 (Pro)', 'team-manager-free');?></option>
										<option value="12" <?php if ( isset ( $team_manager_free_post_themes ) ) selected( $team_manager_free_post_themes, '12' ); ?>><?php _e('Team Theme 12 (Pro)', 'team-manager-free');?></option>
										<option value="13" <?php if ( isset ( $team_manager_free_post_themes ) ) selected( $team_manager_free_post_themes, '13' ); ?>><?php _e('Team Theme 13 (Pro)', 'team-manager-free');?></option>
										<option value="14" <?php if ( isset ( $team_manager_free_post_themes ) ) selected( $team_manager_free_post_themes, '14' ); ?>><?php _e('Team Theme 14 (Pro)', 'team-manager-free');?></option>
										<option value="15" <?php if ( isset ( $team_manager_free_post_themes ) ) selected( $team_manager_free_post_themes, '15' ); ?>><?php _e('Team Theme 15 (Pro)', 'team-manager-free');?></option>
										<option value="16" <?php if ( isset ( $team_manager_free_post_themes ) ) selected( $team_manager_free_post_themes, '16' ); ?>><?php _e('Team Theme 16 (Pro)', 'team-manager-free');?></option>
										<option value="17" <?php if ( isset ( $team_manager_free_post_themes ) ) selected( $team_manager_free_post_themes, '17' ); ?>><?php _e('Team Theme 17 (Pro)', 'team-manager-free');?></option>
										<option value="18" <?php if ( isset ( $team_manager_free_post_themes ) ) selected( $team_manager_free_post_themes, '18' ); ?>><?php _e('Team Theme 18 (Pro)', 'team-manager-free');?></option>
										<option value="19" <?php if ( isset ( $team_manager_free_post_themes ) ) selected( $team_manager_free_post_themes, '19' ); ?>><?php _e('Team Theme 19 (Pro)', 'team-manager-free');?></option>
										<option value="20" <?php if ( isset ( $team_manager_free_post_themes ) ) selected( $team_manager_free_post_themes, '20' ); ?>><?php _e('Team Theme 20 (Pro)', 'team-manager-free');?></option>
										<option value="21" <?php if ( isset ( $team_manager_free_post_themes ) ) selected( $team_manager_free_post_themes, '21' ); ?>><?php _e('Team Theme 21 (Pro)', 'team-manager-free');?></option>
										<option value="22" <?php if ( isset ( $team_manager_free_post_themes ) ) selected( $team_manager_free_post_themes, '22' ); ?>><?php _e('Team Theme 22 (Pro)', 'team-manager-free');?></option>
										<option value="23" <?php if ( isset ( $team_manager_free_post_themes ) ) selected( $team_manager_free_post_themes, '23' ); ?>><?php _e('Team Theme 23 (Pro)', 'team-manager-free');?></option>
										<option value="24" <?php if ( isset ( $team_manager_free_post_themes ) ) selected( $team_manager_free_post_themes, '24' ); ?>><?php _e('Team Theme 24 (Pro)', 'team-manager-free');?></option>
										<option value="25" <?php if ( isset ( $team_manager_free_post_themes ) ) selected( $team_manager_free_post_themes, '25' ); ?>><?php _e('Team Theme 25 (Pro)', 'team-manager-free');?></option>
									</select>
									<span class="team_manager_hint">To unlock all Team Styles, <a href="https://themepoints.com/product/team-showcase-pro/" target="_blank"><?php _e('Upgrade To Pro!', 'team-manager-free');?></a></span>
								</td>
							</tr>
							<!-- End Team Laout Style -->

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_free_theme_style"><?php _e( 'Select Layout', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php _e( 'Select a layout to display the testimonials.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<select name="team_manager_free_theme_style" id="team_manager_free_theme_style" class="timezone_string">
										<option value="1" <?php if ( isset ( $team_manager_free_theme_style ) ) selected( $team_manager_free_theme_style, '1' ); ?>><?php _e( 'Normal Grid', 'team-manager-free' );?></option>
										<option value="2" <?php if ( isset ( $team_manager_free_theme_style ) ) selected( $team_manager_free_theme_style, '2' ); ?>><?php _e( 'Filter Grid (Pro)', 'team-manager-free' );?></option>
										<option value="3" <?php if ( isset ( $team_manager_free_theme_style ) ) selected( $team_manager_free_theme_style, '3' ); ?>><?php _e( 'Slider (Pro)', 'team-manager-free' );?></option>
									</select><br />
									<span class="team_manager_hint">To unlock all Team Layout, <a href="https://themepoints.com/product/team-showcase-pro/" target="_blank"><?php _e('Upgrade To Pro!', 'team-manager-free');?></a></span>
								</td>
							</tr>
							<!-- End Team Laout -->

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_free_limits"><?php _e( 'Member Limit', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Limit number of teams to show.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="number" name="team_manager_free_limits" id="team_manager_free_limits" class="timezone_string" value="<?php  if($team_manager_free_limits !=''){echo $team_manager_free_limits; }else{ echo '12';} ?>">
								</td>
							</tr>
							<!-- End column Margin Bottom -->

							<tr valign="top">
								<th scope="row">
									<label for="teamf_orderby"><?php echo __('Order Team Member', 'team-manager-free'); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Select an order option.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<select name="teamf_orderby" id="teamf_orderby" class="timezone_string">
										<option value="date" <?php if ( isset ( $teamf_orderby ) ) selected( $teamf_orderby, 'date' ); ?>><?php _e('Publish Date', 'team-manager-free'); ?></option>
										<option value="menu_order" <?php if ( isset ( $teamf_orderby ) ) selected( $teamf_orderby, 'menu_order' ); ?>><?php _e('Menu Order', 'team-manager-free');?></option>
										<option value="rand" <?php if ( isset ( $teamf_orderby ) ) selected( $teamf_orderby, 'rand' ); ?>><?php _e('Random', 'team-manager-free'); ?></option>
									</select>
								</td>
							</tr>
							<!-- End Team Order By -->

							<tr valign="top">
								<th scope="row">
									<label for="teamf_order"><?php echo __( 'Order Member', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Select an order option.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<select name="teamf_order" id="teamf_order" class="timezone_string">
										<option value="ASC" <?php if ( isset ( $teamf_order ) ) selected( $teamf_order, 'ASC' ); ?>><?php _e('Ascending Order', 'team-manager-free'); ?></option>
										<option value="DESC" <?php if ( isset ( $teamf_order ) ) selected( $teamf_order, 'DESC' ); ?>><?php _e('Descending Order', 'team-manager-free'); ?></option>
									</select>
								</td>
							</tr>
							<!-- End Team Order -->

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_free_imagesize"><?php echo __('Team Image Size', 'team-manager-free'); ?></label>
									<span class="team_manager_hint toss"><?php echo __('Choose Team Member Image Size.', 'team-manager-free'); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<select name="team_manager_free_imagesize" id="team_manager_free_imagesize" class="timezone_string">
										<option value="1" <?php if ( isset ( $team_manager_free_imagesize ) ) selected( $team_manager_free_imagesize, '1' ); ?>><?php _e('Default Size', 'team-manager-free'); ?></option>
										<option value="2" <?php if ( isset ( $team_manager_free_imagesize ) ) selected( $team_manager_free_imagesize, '2' ); ?>><?php _e('Custom Size', 'team-manager-free'); ?></option>
									</select>
								</td>
							</tr>
							<!-- End Team Image Size -->

							<tr valign="top" id="hide1" style="<?php if($team_manager_free_imagesize == 1){	echo "display:none;"; }?>">
								<th scope="row">
									<label for="team_manager_free_img_height"><?php echo __('Insert Image Height', 'team-manager-free'); ?></label>
									<span class="team_manager_hint toss"><?php echo __('Insert image height.', 'team-manager-free'); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input type="number" name="team_manager_free_img_height" id="team_manager_free_img_height" maxlength="4" class="timezone_string" required value="<?php  if($team_manager_free_img_height !=''){echo $team_manager_free_img_height; }else{ echo '220';} ?>">px<br/>
								</td>
							</tr>
							<!-- End Insert Image Height -->

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_free_post_column"><?php echo __('Team Column', 'team-manager-free'); ?></label>
									<span class="team_manager_hint toss"><?php echo __('Choose an option for posts column.', 'team-manager-free'); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<select name="team_manager_free_post_column" id="team_manager_free_post_column" class="timezone_string">
										<option value="3" <?php if ( isset ( $team_manager_free_post_column ) ) selected( $team_manager_free_post_column, '3' ); ?>><?php _e('3 Column', 'team-manager-free');?></option>
										<option value="2" <?php if ( isset ( $team_manager_free_post_column ) ) selected( $team_manager_free_post_column, '2' ); ?>><?php _e('2 Column', 'team-manager-free');?></option>
										<option value="4" <?php if ( isset ( $team_manager_free_post_column ) ) selected( $team_manager_free_post_column, '4' ); ?>><?php _e('4 Column', 'team-manager-free');?></option>
										<option value="5" <?php if ( isset ( $team_manager_free_post_column ) ) selected( $team_manager_free_post_column, '5' ); ?>><?php _e('5 Column', 'team-manager-free');?></option>
										<option value="6" <?php if ( isset ( $team_manager_free_post_column ) ) selected( $team_manager_free_post_column, '6' ); ?>><?php _e('6 Column', 'team-manager-free');?></option>
									</select>
								</td>
							</tr>
							<!-- End Choose Team Column -->

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_free_margin_bottom"><?php echo __('Margin Bottom', 'team-manager-free'); ?></label>
									<span class="team_manager_hint toss"><?php echo __('Column Margin Bottom.', 'team-manager-free'); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input type="number" name="team_manager_free_margin_bottom" id="team_manager_free_margin_bottom" maxlength="4" class="timezone_string" value="<?php  if($team_manager_free_margin_bottom !=''){echo $team_manager_free_margin_bottom; }else{ echo '30';} ?>">
									<span class="team_manager_hint">To unlock all Column Margin, <a href="https://themepoints.com/product/team-showcase-pro/" target="_blank"><?php _e('Upgrade To Pro!', 'team-manager-free');?></a></span>
								</td>
							</tr>
							<!-- End column Margin Bottom -->

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_free_padding_left"><?php _e( 'Padding Left', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __('Column padding left.', 'team-manager-free'); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="number" name="team_manager_free_padding_left" id="team_manager_free_padding_left" min="0" max="100" class="timezone_string" required value="<?php  if($team_manager_free_padding_left !=''){echo $team_manager_free_padding_left; }else{ echo '15';} ?>">
								</td>
							</tr>
							<!-- End column Padding Left -->

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_free_padding_right"><?php _e( 'Padding Right', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __('Column padding Right.', 'team-manager-free'); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="number" name="team_manager_free_padding_right" id="team_manager_free_padding_right" min="0" max="100" class="timezone_string" required value="<?php  if($team_manager_free_padding_right !=''){echo $team_manager_free_padding_right; }else{ echo '15';} ?>">
								</td>
							</tr>
							<!-- End column Padding Left -->

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_free_overlay_bg_color"><?php echo __('Hover Overlay Color', 'team-manager-free'); ?></label>
									<span class="team_manager_hint toss"><?php echo __('Choose image hover overlay background color.', 'team-manager-free'); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input type="text" name="team_manager_free_overlay_bg_color" id="team_manager_free_overlay_bg_color" class="timezone_string" value="<?php  if($team_manager_free_overlay_bg_color !=''){echo $team_manager_free_overlay_bg_color; }else{ echo '#000000';} ?>">
								</td>
							</tr>
							<!-- End Member Overlay Background Color -->

						</table>
					</div>
				</div>
			</li>

			<!-- Tab Three -->
			<li style="<?php if($nav_value == 3){echo "display: block;";} else{ echo "display: none;"; }?>" class="box3 tab-box <?php if($nav_value == 3){echo "active";}?>">
				<div class="wrap">
					<div class="option-box">
						<p class="option-title"><?php _e('All Settings','team-manager-free'); ?></p>
						<table class="form-table">

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_free_header_font_size"><?php echo __('Name Font Size', 'team-manager-free'); ?></label>
									<span class="team_manager_hint toss"><?php echo __('Choose name font size. default font size 18px.', 'team-manager-free'); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input type="number" name="team_manager_free_header_font_size" id="team_manager_free_header_font_size" maxlength="4" class="timezone_string" value="<?php  if($team_manager_free_header_font_size !=''){echo $team_manager_free_header_font_size; }else{ echo '20';} ?>">
								</td>
							</tr>
							<!-- End Name Font Size -->

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_name_font_case"><?php echo __('Name Text Transform', 'team-manager-free'); ?></label>
									<span class="team_manager_hint toss"><?php echo __('Select Your Text Transform.', 'team-manager-free'); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<select name="team_manager_name_font_case" id="team_manager_name_font_case" class="timezone_string">
										<option value="unset" <?php if ( isset ( $team_manager_name_font_case ) ) selected( $team_manager_name_font_case, 'unset' ); ?>><?php _e('Default', 'team-manager-free'); ?></option>
										<option value="capitalize" <?php if ( isset ( $team_manager_name_font_case ) ) selected( $team_manager_name_font_case, 'capitalize' ); ?>><?php _e('Capitilize', 'team-manager-free');?></option>
										<option value="lowercase" <?php if ( isset ( $team_manager_name_font_case ) ) selected( $team_manager_name_font_case, 'lowercase' ); ?>><?php _e('Lowercase', 'team-manager-free');?></option>
										<option value="uppercase" <?php if ( isset ( $team_manager_name_font_case ) ) selected( $team_manager_name_font_case, 'uppercase' ); ?>><?php _e('Uppercase', 'team-manager-free');?></option>
									</select>
								</td>
							</tr>
							<!-- End Name Text Transfrom -->

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_name_font_style"><?php _e('Name Text Style', 'team-manager-free'); ?></label>
									<span class="team_manager_hint toss"><?php echo __('Select Your Text Style.', 'team-manager-free'); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<select name="team_manager_name_font_style" id="team_manager_name_font_style" class="timezone_string">
										<option value="normal" <?php if ( isset ( $team_manager_name_font_style ) ) selected( $team_manager_name_font_style, 'normal' ); ?>><?php _e('Default', 'team-manager-free');?></option>
										<option value="italic" <?php if ( isset ( $team_manager_name_font_style ) ) selected( $team_manager_name_font_style, 'italic' ); ?>><?php _e('Italic', 'team-manager-free');?></option>
									</select><br>
								</td>
							</tr>
							<!-- End Name Text Transform -->
							
							<tr valign="top">
								<th scope="row">
									<label for="team_manager_name_font_weight"><?php _e('Name Font Weight', 'team-manager-free'); ?></label>
									<span class="team_manager_hint toss"><?php echo __('Select Your Font Weight.', 'team-manager-free'); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<select name="team_manager_name_font_weight" id="team_manager_name_font_weight" class="timezone_string">
										<option value="pro" <?php if ( isset ( $team_manager_name_font_weight ) ) selected( $team_manager_name_font_weight, 'pro' ); ?>><?php _e('Available Pro', 'team-manager-free');?></option>
										<option value="600" <?php if ( isset ( $team_manager_name_font_weight ) ) selected( $team_manager_name_font_weight, '600' ); ?>><?php _e('600', 'team-manager-free');?></option>
										<option value="700" <?php if ( isset ( $team_manager_name_font_weight ) ) selected( $team_manager_name_font_weight, '700' ); ?>><?php _e('700', 'team-manager-free');?></option>
										<option value="500" <?php if ( isset ( $team_manager_name_font_weight ) ) selected( $team_manager_name_font_weight, '500' ); ?>><?php _e('500', 'team-manager-free');?></option>
										<option value="400" <?php if ( isset ( $team_manager_name_font_weight ) ) selected( $team_manager_name_font_weight, '400' ); ?>><?php _e('400', 'team-manager-free');?></option>
									</select><br>
								</td>
							</tr>
							<!-- End Name Text Transform -->

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_free_header_font_color"><?php echo __('Name Font Color', 'team-manager-free'); ?></label>
									<span class="team_manager_hint toss"><?php echo __('Choose name font color.', 'team-manager-free'); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input type="text" name="team_manager_free_header_font_color" id="team_manager_free_header_font_color" class="timezone_string" value="<?php  if($team_manager_free_header_font_color !=''){echo $team_manager_free_header_font_color; }else{ echo '#007acc';} ?>">
								</td>
							</tr>
							<!-- End Name Font Color -->

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_free_name_hover_font_color"><?php echo __('Name Hover Font Color', 'team-manager-free'); ?></label>
									<span class="team_manager_hint toss"><?php echo __('Choose name hover font color.', 'team-manager-free'); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input type="text" name="team_manager_free_name_hover_font_color" id="team_manager_free_name_hover_font_color" class="timezone_string" value="<?php  if($team_manager_free_name_hover_font_color !=''){echo $team_manager_free_name_hover_font_color; }else{ echo '#333333';} ?>">
								</td>
							</tr>
							<!-- End Name Hover Font Color -->

							<tr valign="top">
								<th scope="row">
									<label style="color:red" for="team_manager_free_designation_hide"><?php _e( 'Designation', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Show/Hide Designation on front page.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="designation_true" name="team_manager_free_designation_hide" value="1" <?php if ( $team_manager_free_designation_hide == '1' || $team_manager_free_designation_hide == '') echo 'checked'; ?>/>
										<label for="designation_true"><?php _e( 'Show', 'team-manager-free' ); ?></label>

										<input type="radio" id="designation_false" name="team_manager_free_designation_hide" value="0" <?php if ( $team_manager_free_designation_hide == '0' ) echo 'checked'; ?>/>
										<label for="designation_false" class="designation_false"><?php _e( 'Hide', 'team-manager-free' ); ?></label>
									</div>
								</td>
							</tr>
							<!-- End Show/Hide Designation -->

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_free_designation_font_size"><?php echo __('Designation Font Size', 'team-manager-free'); ?></label>
									<span class="team_manager_hint toss"><?php echo __('Select Team member Designation Font Size. default font size (15px)', 'team-manager-free'); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input type="number" name="team_manager_free_designation_font_size" id="team_manager_free_designation_font_size" maxlength="4" class="timezone_string" value="<?php  if($team_manager_free_designation_font_size !=''){echo $team_manager_free_designation_font_size; }else{ echo '15';} ?>">
								</td>
							</tr>
							<!-- End Designation Font Size -->

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_free_designation_font_color"><?php echo __('Designation Font Color', 'team-manager-free'); ?></label>
									<span class="team_manager_hint toss"><?php echo __('Choose designation font color.', 'team-manager-free'); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input type="text" name="team_manager_free_designation_font_color" id="team_manager_free_designation_font_color" class="timezone_string" value="<?php  if($team_manager_free_designation_font_color !=''){echo $team_manager_free_designation_font_color; }else{ echo '#333333';} ?>">
								</td>
							</tr>
							<!-- End Designation Font Color -->

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_desig_font_case"><?php echo __('Designation Text Transform', 'team-manager-free'); ?></label>
									<span class="team_manager_hint toss"><?php echo __('Choose designation Text Transform.', 'team-manager-free'); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<select name="team_manager_desig_font_case" id="team_manager_desig_font_case" class="timezone_string">
										<option value="unset" <?php if ( isset ( $team_manager_desig_font_case ) ) selected( $team_manager_desig_font_case, 'unset' ); ?>><?php _e('Default', 'team-manager-free');?></option>
										<option value="capitalize" <?php if ( isset ( $team_manager_desig_font_case ) ) selected( $team_manager_desig_font_case, 'capitalize' ); ?>><?php _e('Capitilize', 'team-manager-free');?></option>
										<option value="lowercase" <?php if ( isset ( $team_manager_desig_font_case ) ) selected( $team_manager_desig_font_case, 'lowercase' ); ?>><?php _e('Lowercase', 'team-manager-free');?></option>
										<option value="uppercase" <?php if ( isset ( $team_manager_desig_font_case ) ) selected( $team_manager_desig_font_case, 'uppercase' ); ?>><?php _e('Uppercase', 'team-manager-free');?></option>
									</select>
								</td>
							</tr>
							<!-- End Designation text transform -->

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_desig_font_style"><?php _e( 'Designation Text Style', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Choose designation text style', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<select name="team_manager_desig_font_style" id="team_manager_desig_font_style" class="timezone_string">
										<option value="normal" <?php if ( isset ( $team_manager_desig_font_style ) ) selected( $team_manager_desig_font_style, 'normal' ); ?>><?php _e('Default', 'team-manager-free');?></option>
										<option value="italic" <?php if ( isset ( $team_manager_desig_font_style ) ) selected( $team_manager_desig_font_style, 'italic' ); ?>><?php _e('Italic', 'team-manager-free');?></option>
									</select><br>
								</td>
							</tr>
							<!-- End Designation text style -->

							<tr valign="top">
								<th scope="row">
									<label style="color:red" for="team_manager_free_emails_hide"><?php _e( 'Email', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Show/Hide Email on front page.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="emails_true" name="team_manager_free_emails_hide" value="1" <?php if ( $team_manager_free_emails_hide == '1' || $team_manager_free_emails_hide == '') echo 'checked'; ?>/>
										<label for="emails_true"><?php _e( 'Show', 'team-manager-free' ); ?></label>

										<input type="radio" id="emails_false" name="team_manager_free_emails_hide" value="0" <?php if ( $team_manager_free_emails_hide == '0' ) echo 'checked'; ?>/>
										<label for="emails_false" class="emails_false"><?php _e( 'Hide', 'team-manager-free' ); ?></label>
									</div>
								</td>
							</tr>
							<!-- End show/hide Email -->

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_free_emails_font_size"><?php _e( 'Email Font Size', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Choose email font size. default font size 14px', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="number" name="team_manager_free_emails_font_size" id="team_manager_free_emails_font_size" min="10" max="45" class="timezone_string" required value="<?php  if($team_manager_free_emails_font_size !=''){echo $team_manager_free_emails_font_size; }else{ echo '14';} ?>"> <br />
								</td>
							</tr>
							<!-- End Email Font Size -->

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_free_emails_font_color"><?php echo __( 'Email Font Color', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Choose email font color.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input size='10' name='team_manager_free_emails_font_color' class='team-manager-free-emails-font-color' type='text' id="team_manager_free_emails_font_color" value="<?php if($team_manager_free_emails_font_color !=''){echo $team_manager_free_emails_font_color;} else{ echo "#666666";} ?>" /> <br />
								</td>
							</tr>
							<!-- End Email Font Color -->

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_free_emails_hover_color"><?php echo __( 'Email Hover Color', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Choose email hover font color.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input size='10' name='team_manager_free_emails_hover_color' class='team-manager-free-emails-font-color' type='text' id="team_manager_free_emails_hover_color" value="<?php if($team_manager_free_emails_hover_color !=''){echo $team_manager_free_emails_hover_color;} else{ echo "#666666";} ?>" /> <br />
								</td>
							</tr>
							<!-- End Email Hover Font Color -->

							<tr valign="top">
								<th scope="row">
									<label style="color:red" for="team_manager_free_numbers_hide"><?php _e( 'Number', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Show/Hide Number on front page.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="numbers_true" name="team_manager_free_numbers_hide" value="1" <?php if ( $team_manager_free_numbers_hide == '1' || $team_manager_free_numbers_hide == '') echo 'checked'; ?>/>
										<label for="numbers_true"><?php _e( 'Show', 'team-manager-free' ); ?></label>

										<input type="radio" id="numbers_false" name="team_manager_free_numbers_hide" value="0" <?php if ( $team_manager_free_numbers_hide == '0' ) echo 'checked'; ?>/>
										<label for="numbers_false" class="numbers_false"><?php _e( 'Hide', 'team-manager-free' ); ?></label>
									</div><br>
								</td>
							</tr>
							<!-- End Number -->

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_free_numbers_font_size"><?php _e( 'Number Font Size', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Choose number font size. default font size 14px', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="number" name="team_manager_free_numbers_font_size" id="team_manager_free_numbers_font_size" min="10" max="45" class="timezone_string" required value="<?php  if($team_manager_free_numbers_font_size !=''){echo $team_manager_free_numbers_font_size; }else{ echo '14';} ?>"> <br />
								</td>
							</tr>
							<!-- End Number Font Size -->

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_free_numbers_font_color"><?php echo __( 'Number Font Color', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Choose number font color.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input size='10' name='team_manager_free_numbers_font_color' class='team-manager-free-numbers-font-color' type='text' id="team_manager_free_numbers_font_color" value="<?php if($team_manager_free_numbers_font_color !=''){echo $team_manager_free_numbers_font_color;} else{ echo "#666666";} ?>" /> <br />
								</td>
							</tr>
							<!-- End Number Font Color -->

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_free_numbers_hover_color"><?php echo __( 'Number Hover Color', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Choose numer hover font color.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input size='10' name='team_manager_free_numbers_hover_color' class='team-manager-free-emails-font-color' type='text' id="team_manager_free_numbers_hover_color" value="<?php if($team_manager_free_numbers_hover_color !=''){echo $team_manager_free_numbers_hover_color;} else{ echo "#666666";} ?>" /> <br />
								</td>
							</tr>
							<!-- End Member Hover Font Color -->

							<tr valign="top">
								<th scope="row">
									<label style="color:red" for="team_manager_free_address_hide"><?php _e( 'Address', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Show/Hide Address on front page.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="address_true" name="team_manager_free_address_hide" value="1" <?php if ( $team_manager_free_address_hide == '1' || $team_manager_free_address_hide == '') echo 'checked'; ?>/>
										<label for="address_true"><?php _e( 'Show', 'team-manager-free' ); ?></label>

										<input type="radio" id="address_false" name="team_manager_free_address_hide" value="0" <?php if ( $team_manager_free_address_hide == '0' ) echo 'checked'; ?>/>
										<label for="address_false" class="address_false"><?php _e( 'Hide', 'team-manager-free' ); ?></label>
									</div><br>
								</td>
							</tr>
							<!-- End Show/Hide Address -->

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_free_addresss_font_size"><?php _e( 'Address Font Size', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Choose address font size. default font size 14px', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="number" name="team_manager_free_addresss_font_size" id="team_manager_free_addresss_font_size" min="10" max="45" class="timezone_string" required value="<?php  if($team_manager_free_addresss_font_size !=''){echo $team_manager_free_addresss_font_size; }else{ echo '14';} ?>"> <br />
								</td>
							</tr>
							<!-- End Address Font Size -->

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_free_addresss_font_color"><?php echo __( 'Address Font Color', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Choose address font color.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input size='10' name='team_manager_free_addresss_font_color' class='team-manager-free-address-font-color' type='text' id="team_manager_free_addresss_font_color" value="<?php if($team_manager_free_addresss_font_color !=''){echo $team_manager_free_addresss_font_color;} else{ echo "#666666";} ?>" /> <br />
								</td>
							</tr>
							<!-- End Address Font Color -->

							<tr valign="top">
								<th scope="row">
									<label style="color:red" for="team_manager_free_website_hide"><?php _e( 'Website', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Show/Hide Website on front page.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="website_true" name="team_manager_free_website_hide" value="1" <?php if ( $team_manager_free_website_hide == '1' || $team_manager_free_website_hide == '') echo 'checked'; ?>/>
										<label for="website_true"><?php _e( 'Show', 'team-manager-free' ); ?></label>
										<input type="radio" id="website_false" name="team_manager_free_website_hide" value="0" <?php if ( $team_manager_free_website_hide == '0' ) echo 'checked'; ?>/>
										<label for="website_false" class="website_false"><?php _e( 'Hide', 'team-manager-free' ); ?></label>
									</div>
								</td>
							</tr>
							<!-- End show/hide Website -->

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_free_website_font_size"><?php _e( 'Website Font Size', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Choose website font size. default font size 14px', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="number" name="team_manager_free_website_font_size" id="team_manager_free_website_font_size" min="10" max="45" class="timezone_string" required value="<?php  if($team_manager_free_website_font_size !=''){echo $team_manager_free_website_font_size; }else{ echo '14';} ?>"> <br />
								</td>
							</tr>
							<!-- End Website Link Font Size -->

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_free_website_font_color"><?php echo __( 'Website Link Color', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Choose Website font color.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input size='10' name='team_manager_free_website_font_color' class='team-manager-free-website-font-color' type='text' id="team_manager_free_website_font_color" value="<?php if($team_manager_free_website_font_color !=''){echo $team_manager_free_website_font_color;} else{ echo "#666666";} ?>" /> <br />
								</td>
							</tr>
							<!-- End Website Link Font Color -->

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_free_website_hover_color"><?php echo __( 'Website Link Hover Color', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Choose Website link hover font color.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input size='10' name='team_manager_free_website_hover_color' class='team-manager-free-website-font-color' type='text' id="team_manager_free_website_hover_color" value="<?php if($team_manager_free_website_hover_color !=''){echo $team_manager_free_website_hover_color;} else{ echo "#666666";} ?>" /> <br />
								</td>
							</tr>
							<!-- End Website Link Hover Font Color -->

							<tr valign="top">
								<th scope="row">
									<label style="color:red" for="team_manager_free_biography_option"><?php _e( 'Biography', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Show/Hide Team Member Short Biography.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="biography_true" name="team_manager_free_biography_option" value="1" <?php if ( $team_manager_free_biography_option == '1' || $team_manager_free_biography_option == '') echo 'checked'; ?>/>
										<label for="biography_true"><?php _e( 'Show', 'team-manager-free' ); ?></label>
										<input type="radio" id="biography_false" name="team_manager_free_biography_option" value="0" <?php if ( $team_manager_free_biography_option == '0' ) echo 'checked'; ?>/>
										<label for="biography_false" class="biography_false"><?php _e( 'Hide', 'team-manager-free' ); ?></label>
									</div>
								</td>
							</tr>
							<!-- End show/hide Biography -->

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_free_biography_font_size"><?php echo __('Biography Font Size', 'team-manager-free'); ?></label>
									<span class="team_manager_hint toss"><?php echo __('Select Team member Biography Font Size. default font size (15px)', 'team-manager-free'); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input type="number" name="team_manager_free_biography_font_size" id="team_manager_free_biography_font_size" maxlength="4" class="timezone_string" value="<?php  if($team_manager_free_biography_font_size !=''){echo $team_manager_free_biography_font_size; }else{ echo '15';} ?>">
								</td>
							</tr>
							<!-- End Biography Font Size -->

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_free_biography_font_color"><?php echo __('Biography Font Color', 'team-manager-free'); ?></label>
									<span class="team_manager_hint toss"><?php echo __('Choose Team member biography font color.default font color:#000000', 'team-manager-free'); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input type="text" name="team_manager_free_biography_font_color" id="team_manager_free_biography_font_color" class="timezone_string" value="<?php  if($team_manager_free_biography_font_color !=''){echo $team_manager_free_biography_font_color; }else{ echo '#000000';} ?>">
								</td>
							</tr>
							<!-- End Biography Font Color -->

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_free_text_alignment"><?php _e( 'All Text Alignment', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Select all content position left, right or center.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="text_alignment_left" name="team_manager_free_text_alignment" value="left" <?php if ( $team_manager_free_text_alignment == 'left' || $team_manager_free_text_alignment == '') echo 'checked'; ?>/>
										<label for="text_alignment_left"><?php _e( 'Left', 'team-manager-free' ); ?></label>

										<input type="radio" id="text_alignment_center" name="team_manager_free_text_alignment" value="center" <?php if ( $team_manager_free_text_alignment == 'center' ) echo 'checked'; ?>/>
										<label for="text_alignment_center"><?php _e( 'Center', 'team-manager-free' ); ?></label>

										<input type="radio" id="text_alignment_right" name="team_manager_free_text_alignment" value="right" <?php if ( $team_manager_free_text_alignment == 'right' ) echo 'checked'; ?>/>
										<label for="text_alignment_right"><?php _e( 'Right', 'team-manager-free' ); ?></label>

										<input type="radio" id="text_alignment_justify" name="team_manager_free_text_alignment" value="justify" <?php if ( $team_manager_free_text_alignment == 'justify' ) echo 'checked'; ?>/>
										<label for="text_alignment_justify"><?php _e( 'Justify', 'team-manager-free' ); ?></label>
									</div><br>
								</td>
							</tr>
							<!-- End all Text Alignment -->

							<tr valign="top">
								<th scope="row">
									<label style="color:red" for="team_manager_free_multicolor_hide"><?php _e( 'Team Multi-Color', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Show Team Multicolor Option.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="multicolor_true" name="team_manager_free_multicolor_hide" value="1" <?php if ( $team_manager_free_multicolor_hide == '1' ) echo 'checked'; ?>/>
										<label for="multicolor_true"><?php _e( 'Yes', 'team-manager-free' ); ?></label>

										<input type="radio" id="multicolor_false" name="team_manager_free_multicolor_hide" value="0" <?php if ( $team_manager_free_multicolor_hide == '0' || $team_manager_free_multicolor_hide == '' ) echo 'checked'; ?>/>
										<label for="multicolor_false" class="multicolor_false"><?php _e( 'No', 'team-manager-free' ); ?></label>
									</div><br>
								</td>
							</tr>
							<!-- End Show/Hide Multicolor -->

							<tr valign="top">
								<th scope="row">
									<label for="team_fbackground_color"><?php echo __('Member Background Color', 'team-manager-free'); ?></label>
									<span class="team_manager_hint toss"><?php echo __('Choose all team item background color.', 'team-manager-free'); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input type="text" name="team_fbackground_color" id="team_fbackground_color" class="timezone_string" value="<?php  if($team_fbackground_color !=''){echo $team_fbackground_color; }else{ echo '#f8f8f8';} ?>">
								</td>
							</tr>
							<!-- End Member Background Color -->

						</table>
					</div>
				</div>
			</li>


			<li style="<?php if($nav_value == 4){echo "display: block;";} else{ echo "display: none;"; }?>" class="box4 tab-box <?php if($nav_value == 4){echo "active";}?>">
				<div class="wrap">
					<div class="option-box">
						<p class="option-title"><?php _e( 'Grid Settings','team-manager-free' ); ?></p>
						<table class="form-table">
							<tr valign="top">
								<th scope="row">
									<label for="filter_align"><?php _e( 'Filter Menu Align', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Set the alignment of filter menu.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="filter_align_left" name="filter_align" value="left" <?php if ( $filter_align == 'left' ) echo 'checked'; ?>/>
										<label for="filter_align_left"><?php _e( 'Left', 'team-manager-free' ); ?></label>
										<input type="radio" id="filter_align_center" name="filter_align" value="center" <?php if ( $filter_align == 'center' || $filter_align == '' ) echo 'checked'; ?>/>
										<label for="filter_align_center"><?php _e( 'Center', 'team-manager-free' ); ?></label>
										<input type="radio" id="filter_align_right" name="filter_align" value="right" <?php if ( $filter_align == 'right' ) echo 'checked'; ?>/>
										<label for="filter_align_right"><?php _e( 'Right', 'team-manager-free' ); ?></label>
									</div>	
								</td>
							</tr>
							<!-- End Filter Menu Align -->

							<tr valign="top">
								<th scope="row">
									<label for="filter_bg_color"><?php echo __( 'Menu Background', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Pick a color for filter menu', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input size='10' name='filter_bg_color' class='team-manager-free-header-font-color' type='text' id="filter_bg_color" value="<?php if($filter_bg_color !=''){echo $filter_bg_color;} else{ echo "#efefef";} ?>" />
								</td>
							</tr>
							<!-- End Filter Menu Background -->

							<tr valign="top">
								<th scope="row">
									<label for="filter_mfont_color"><?php echo __( 'Menu Font Color', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Pick a color for filter menu text', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input size='10' name='filter_mfont_color' class='team-manager-free-header-font-color' type='text' id="filter_mfont_color" value="<?php if($filter_mfont_color !=''){echo $filter_mfont_color;} else{ echo "#000000";} ?>" />
								</td>
							</tr>
							<!-- End Filter Menu Menu Font Color -->

							<tr valign="top">
								<th scope="row">
									<label for="filter_border_color"><?php echo __( 'Menu Border', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Pick a color for filter Menu border.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input size='10' name='filter_border_color' class='team-manager-free-header-font-color' type='text' id="filter_border_color" value="<?php if($filter_border_color !=''){echo $filter_border_color;} else{ echo "#dddddd";} ?>" />
								</td>
							</tr>
							<!-- End Filter Menu Menu Border Color -->

							<tr valign="top">
								<th scope="row">
									<label for="filter_active_color"><?php echo __( 'Menu Active', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Pick a color for filter Menu active background Color.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input size='10' name='filter_active_color' class='team-manager-free-header-font-color' type='text' id="filter_active_color" value="<?php if($filter_active_color !=''){echo $filter_active_color;} else{ echo "#222f3d";} ?>" /><br>
								</td>
							</tr>
							<!-- End Menu Active Background Color -->

							<tr valign="top">
								<th scope="row">
									<label for="filter_active_font"><?php echo __( 'Menu Active Font', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Pick a color for filter Menu active font Color.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input size='10' name='filter_active_font' class='team-manager-free-header-font-color' type='text' id="filter_active_font" value="<?php if($filter_active_font !=''){echo $filter_active_font;} else{ echo "#ffffff";} ?>" /><br>
								</td>
							</tr>
							<!-- End Menu Active Font Color -->

							<tr valign="top">
								<th scope="row">
									<label for="filter_hover_color"><?php echo __( 'Menu Hover', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Pick a color for filter Menu hover background Color.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input size='10' name='filter_hover_color' class='team-manager-free-header-font-color' type='text' id="filter_hover_color" value="<?php if($filter_hover_color !=''){echo $filter_hover_color;} else{ echo "#222f3d";} ?>" /><br>
								</td>
							</tr>
							<!-- End Menu Hover Background Color -->

							<tr valign="top">
								<th scope="row">
									<label for="filter_hover_tcolor"><?php echo __( 'Menu Hover Font', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Pick a color for filter Menu hover text Color.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input size='10' name='filter_hover_tcolor' class='team-manager-free-header-font-color' type='text' id="filter_hover_tcolor" value="<?php if($filter_hover_tcolor !=''){echo $filter_hover_tcolor;} else{ echo "#ffffff";} ?>" /><br>
								</td>
							</tr>
							<!-- End Menu Hover Font Color -->

							<tr valign="top">
								<th scope="row">
									<label for="filter_border_radius"><?php _e( 'Border Radius', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Set Buttom Border Radius. Ex: 50', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="number" name="filter_border_radius" id="filter_border_radius" min="0" max="100" class="timezone_string" required value="<?php  if($filter_border_radius !=''){echo $filter_border_radius; }else{ echo '5';} ?>"> <br />
								</td>
							</tr>
							<!-- End Border Radius -->

						</table>
					</div>
				</div>
			</li>

			<!-- Tab Four -->
			<li style="<?php if($nav_value == 5){echo "display: block;";} else{ echo "display: none;"; }?>" class="box5 tab-box <?php if($nav_value == 5){echo "active";}?>">
				<div class="wrap">
					<div class="option-box">

						<p class="option-title">
							<?php _e('Popup Box Settings','team-manager-free'); ?> <a href="https://themepoints.com/product/team-showcase-pro/" target="_blank"><?php _e('Upgrade To Pro!', 'team-manager-free');?></a>
						</p>
						<!-- <p class="prover_hints">Note: This features not available in free version. upgrade pro version to unlock all features.</p> -->
						<table class="form-table">

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_free_popupbox_hide"><?php _e('Show/Hide Popup', 'team-manager-free');?></label>
									<span class="team_manager_hint toss"><?php echo __('Show/Hide popup details page.', 'team-manager-free'); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="popupbox_true" name="team_manager_free_popupbox_hide" value="1" <?php if ( $team_manager_free_popupbox_hide == '1' || $team_manager_free_popupbox_hide == '') echo 'checked'; ?>/>
										<label for="popupbox_true"><?php _e( 'Show', 'team-manager-free' ); ?></label>

										<input type="radio" id="popupbox_false" name="team_manager_free_popupbox_hide" value="0" <?php if ( $team_manager_free_popupbox_hide == '0' ) echo 'checked'; ?>/>
										<label for="popupbox_false" class="popupbox_false"><?php _e( 'Hide', 'team-manager-free' ); ?></label>
									</div><br>
								</td>
							</tr>
							<!-- End hide Popup details page -->

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_free_popupbox_positions"><?php _e( 'Popup Style', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Choose Team Member popup page Style.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="popupbox_positions_default" name="team_manager_free_popupbox_positions" value="1" <?php if ( $team_manager_free_popupbox_positions == '1' || $team_manager_free_popupbox_positions == '') echo 'checked'; ?>/>
										<label for="popupbox_positions_default"><?php _e( 'Default', 'team-manager-free' ); ?></label>

										<input type="radio" id="popupbox_positions_center" name="team_manager_free_popupbox_positions" value="4" <?php if ( $team_manager_free_popupbox_positions == '4' ) echo 'checked'; ?>/>
										<label for="popupbox_positions_center"><?php _e( 'Style 2', 'team-manager-free' ); ?></label>

										<input type="radio" id="popupbox_positions_right" name="team_manager_free_popupbox_positions" value="2" <?php if ( $team_manager_free_popupbox_positions == '2' ) echo 'checked'; ?>/>
										<label for="popupbox_positions_right"><?php _e( 'Style 3', 'team-manager-free' ); ?></label>

										<input type="radio" id="popupbox_positions_left" name="team_manager_free_popupbox_positions" value="3" <?php if ( $team_manager_free_popupbox_positions == '3' ) echo 'checked'; ?>/>
										<label for="popupbox_positions_left"><?php _e( 'Style 4', 'team-manager-free' ); ?></label>
									</div><br>
								</td>
							</tr>
							<!-- End popup page position -->

							<tr valign="top">
								<th scope="row">
									<label for="team_popup_title_hide"><?php _e( 'Show/Hide Title', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Show/Hide Title in popup page.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="popup_title_true" name="team_popup_title_hide" value="1" <?php if ( $team_popup_title_hide == '1' || $team_popup_title_hide == '') echo 'checked'; ?>/>
										<label for="popup_title_true"><?php _e( 'Show', 'team-manager-free' ); ?></label>

										<input type="radio" id="popup_title_false" name="team_popup_title_hide" value="0" <?php if ( $team_popup_title_hide == '0' ) echo 'checked'; ?>/>
										<label for="popup_title_false" class="popup_title_false"><?php _e( 'Hide', 'team-manager-free' ); ?></label>
									</div><br>
								</td>
							</tr>
							<!-- End hide designation popup page -->

							<tr valign="top">
								<th scope="row">
									<label for="team_popup_designatins_hide"><?php _e('Show/Hide Designation', 'team-manager-free');?></label>
									<span class="team_manager_hint toss"><?php echo __('Show/Hide Team Member Designation in popup page.', 'team-manager-free'); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="popup_designations_true" name="team_popup_designatins_hide" value="1" <?php if ( $team_popup_designatins_hide == '1' || $team_popup_designatins_hide == '') echo 'checked'; ?>/>
										<label for="popup_designations_true"><?php _e( 'Show', 'team-manager-free' ); ?></label>

										<input type="radio" id="popup_designations_false" name="team_popup_designatins_hide" value="0" <?php if ( $team_popup_designatins_hide == '0' ) echo 'checked'; ?>/>
										<label for="popup_designations_false" class="popup_designations_false"><?php _e( 'Hide', 'team-manager-free' ); ?></label>
									</div><br>
								</td>
							</tr>
							<!-- End hide designation popup page -->

							<tr valign="top">
								<th scope="row">
									<label for="team_popup_emails_hide"><?php _e( 'Show/Hide Email', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Show/Hide Team Member Email in popup page.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="popup_emails_true" name="team_popup_emails_hide" value="1" <?php if ( $team_popup_emails_hide == '1' || $team_popup_emails_hide == '') echo 'checked'; ?>/>
										<label for="popup_emails_true"><?php _e( 'Show', 'team-manager-free' ); ?></label>

										<input type="radio" id="popup_emails_false" name="team_popup_emails_hide" value="0" <?php if ( $team_popup_emails_hide == '0' ) echo 'checked'; ?>/>
										<label for="popup_emails_false" class="popup_emails_false"><?php _e( 'Hide', 'team-manager-free' ); ?></label>
									</div><br>
								</td>
							</tr>
							<!-- End hide email popup page -->

							<tr valign="top">
								<th scope="row">
									<label for="team_popup_contacts_hide"><?php _e( 'Show/Hide Contact', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Show/Hide Team Member Contact info in popup page.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="popup_contacts_true" name="team_popup_contacts_hide" value="1" <?php if ( $team_popup_contacts_hide == '1' || $team_popup_contacts_hide == '') echo 'checked'; ?>/>
										<label for="popup_contacts_true"><?php _e( 'Show', 'team-manager-free' ); ?></label>

										<input type="radio" id="popup_contacts_false" name="team_popup_contacts_hide" value="0" <?php if ( $team_popup_contacts_hide == '0' ) echo 'checked'; ?>/>
										<label for="popup_contacts_false" class="popup_contacts_false"><?php _e( 'Hide', 'team-manager-free' ); ?></label>
									</div><br>
								</td>
							</tr>
							<!-- End hide contact info popup page -->

							<tr valign="top">
								<th scope="row">
									<label for="team_popup_address_hide"><?php _e( 'Show/Hide Address', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Show/Hide Team Member Address info in popup page.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="popup_address_true" name="team_popup_address_hide" value="1" <?php if ( $team_popup_address_hide == '1' || $team_popup_address_hide == '') echo 'checked'; ?>/>
										<label for="popup_address_true"><?php _e( 'Show', 'team-manager-free' ); ?></label>

										<input type="radio" id="popup_address_false" name="team_popup_address_hide" value="0" <?php if ( $team_popup_address_hide == '0' ) echo 'checked'; ?>/>
										<label for="popup_address_false" class="popup_address_false"><?php _e( 'Hide', 'team-manager-free' ); ?></label>
									</div><br>
								</td>
							</tr>
							<!-- End hide Address popup page -->

							<tr valign="top">
								<th scope="row">
									<label for="team_popup_website_hide"><?php _e( 'Show/Hide Website', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Show/Hide Website info in popup page.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="popup_website_true" name="team_popup_website_hide" value="1" <?php if ( $team_popup_website_hide == '1' || $team_popup_website_hide == '') echo 'checked'; ?>/>
										<label for="popup_website_true"><?php _e( 'Show', 'team-manager-free' ); ?></label>

										<input type="radio" id="popup_website_false" name="team_popup_website_hide" value="0" <?php if ( $team_popup_website_hide == '0' ) echo 'checked'; ?>/>
										<label for="popup_website_false" class="popup_website_false"><?php _e( 'Hide', 'team-manager-free' ); ?></label>
									</div><br>
								</td>
							</tr>
							<!-- End hide Website info popup page -->
							
							<tr valign="top">
								<th scope="row">
									<label for="team_popup_infoicons_hide"><?php _e( 'Show/Hide Icon', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Show/Hide Website info icon popup page.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="popup_icons_true" name="team_popup_infoicons_hide" value="1" <?php if ( $team_popup_infoicons_hide == '1' || $team_popup_infoicons_hide == '') echo 'checked'; ?>/>
										<label for="popup_icons_true"><?php _e( 'Show', 'team-manager-free' ); ?></label>

										<input type="radio" id="popup_icons_false" name="team_popup_infoicons_hide" value="0" <?php if ( $team_popup_infoicons_hide == '0' ) echo 'checked'; ?>/>
										<label for="popup_icons_false" class="popup_icons_false"><?php _e( 'Hide', 'team-manager-free' ); ?></label>
									</div><br>
								</td>
							</tr>
							<!-- End hide Icon popup page -->

						</table>
					</div>
				</div>
			</li>

			<!-- Tab Four -->
			<li style="<?php if($nav_value == 6){echo "display: block;";} else{ echo "display: none;"; }?>" class="box6 tab-box <?php if($nav_value == 6){echo "active";}?>">
				<div class="wrap">
					<div class="option-box">
						<p class="option-title"><?php _e('Social Icon Settings','team-manager-free'); ?> <a href="https://themepoints.com/product/team-showcase-pro/" target="_blank"><?php _e('Upgrade To Pro!', 'team-manager-free');?></a></p>

						<table class="form-table">
							<tr valign="top">
								<th scope="row">
									<label for="team_manager_free_socialicons_hide"><?php _e('Show/Hide Social', 'team-manager-free');?></label>
									<span class="team_manager_hint toss"><?php echo __('Show/Hide Social Icons on front page.', 'team-manager-free'); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="social_icons_true" name="team_manager_free_socialicons_hide" value="1" <?php if ( $team_manager_free_socialicons_hide == '1' || $team_manager_free_socialicons_hide == '') echo 'checked'; ?>/>
										<label for="social_icons_true"><?php _e( 'Show', 'team-manager-free' ); ?></label>

										<input type="radio" id="social_icons_false" name="team_manager_free_socialicons_hide" value="0" <?php if ( $team_manager_free_socialicons_hide == '0' ) echo 'checked'; ?>/>
										<label for="social_icons_false" class="social_icons_false"><?php _e( 'Hide', 'team-manager-free' ); ?></label>
									</div><br>
								</td>
							</tr>
							<!-- End Show/Hide Social Icons -->

							<tr valign="top">
								<th scope="row">
									<label for="tmffree_social_font_size"><?php _e('Icon Font Size', 'team-manager-free');?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Social Icon Font Size.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="number" name="tmffree_social_font_size" id="tmffree_social_font_size" maxlength="4" class="timezone_string" value="<?php  if($tmffree_social_font_size !=''){echo $tmffree_social_font_size; }else{ echo '12';} ?>">
								</td>
							</tr>
							<!-- End Icon Font Size -->

							<tr valign="top">
								<th scope="row">
									<label for="tmffree_social_icon_color"><?php _e('Icon Color', 'team-manager-free');?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Social Icon Color.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="text" class="jscolor" id="tmffree_social_icon_color" name="tmffree_social_icon_color" value="<?php if($tmffree_social_icon_color !=''){echo $tmffree_social_icon_color;} else{ echo "#000";} ?>">
								</td>
							</tr> <!-- End Social Icon Color -->

							<tr valign="top">
								<th scope="row">
									<label for="tmffree_social_hover_color"><?php _e('Icon Hover Color', 'team-manager-free');?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Social Icon Hover Color.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="text" class="jscolor" id="tmffree_social_hover_color" name="tmffree_social_hover_color" value="<?php if($tmffree_social_hover_color !=''){echo $tmffree_social_hover_color;} else{ echo "#dd3333";} ?>">
								</td>
							</tr> <!-- End Social Icon Hover Color -->

							<tr valign="top">
								<th scope="row">
									<label for="tmffree_social_bg_color"><?php _e('Icon Bg Color', 'team-manager-free');?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Social Icon Background Color.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="text" class="jscolor" id="tmffree_social_bg_color" name="tmffree_social_bg_color" value="<?php if($tmffree_social_bg_color !=''){echo $tmffree_social_bg_color;} else{ echo "#fff";} ?>">
								</td>
							</tr> <!-- End Social Icon Color -->

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_free_social_target"><?php echo __('Social Profile Link', 'team-manager-free'); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Open Social Link on same page or new page.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="openpages_true" name="team_manager_free_social_target" value="_self" <?php if ( $team_manager_free_social_target == '_self' || $team_manager_free_social_target == '') echo 'checked'; ?>/>
										<label for="openpages_true"><?php _e( 'Same Page', 'team-manager-free' ); ?></label>

										<input type="radio" id="openpages_false" name="team_manager_free_social_target" value="_blank" <?php if ( $team_manager_free_social_target == '_blank' ) echo 'checked'; ?>/>
										<label for="openpages_false"><?php _e( 'New Page', 'team-manager-free' ); ?></label>
									</div>
								</td>
							</tr>
							<!-- End Social Profile Link -->

						</table>
					</div>
				</div>
			</li>

			<li style="<?php if($nav_value == 7){echo "display: block;";} else{ echo "display: none;"; }?>" class="box7 tab-box <?php if($nav_value == 7){echo "active";}?>">
				<div class="wrap">
					<div class="option-box">
						<p class="option-title"><?php _e('Slider Settings','team-manager-free'); ?> <a href="https://themepoints.com/product/team-showcase-pro/" target="_blank"><?php _e('Upgrade To Pro!', 'team-manager-free');?></a></p>
						<table class="form-table">
							<tr valign="top">
								<th scope="row">
									<label for="autoplay"><?php _e( 'Autoplay', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Choose an option whether you want the slider autoplay or not.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="autoplay_true" name="autoplay" value="true" <?php if ( $autoplay == 'true' || $autoplay == '' ) echo 'checked'; ?>/>
										<label for="autoplay_true"><?php _e( 'Yes', 'team-manager-free' ); ?></label>
										<input type="radio" id="autoplay_false" name="autoplay" value="false" <?php if ( $autoplay == 'false' ) echo 'checked'; ?>/>
										<label for="autoplay_false" class="autoplay_false"><?php _e( 'No', 'team-manager-free' ); ?></label>
									</div>
								</td>
							</tr>
							<!-- End Autoplay -->

							<tr valign="top">
								<th scope="row">
									<label for="autoplay_speed"><?php _e( 'Slide Delay', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Select a value for sliding speed.', 'team-manager-free' ); ?></span>							
								</th>
								<td style="vertical-align: middle;" class="auto_play">
									<input type="range" step="100" min="100" max="5000" value="<?php  if ( $autoplay_speed !='' ) { echo $autoplay_speed; } else{ echo '700'; } ?>" class="slider" id="myRange"><br>
									<input size="5" type="text" name="autoplay_speed" id="autoplay_speed" maxlength="4" class="timezone_string" readonly  value="<?php  if ( $autoplay_speed !='' ) {echo $autoplay_speed; }else{ echo '700'; } ?>">
								</td>
							</tr>
							<!-- End Slide Delay -->

							<tr valign="top">
								<th scope="row">
									<label for="stop_hover"><?php _e( 'Stop Hover', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Select an option whether you want to pause sliding on mouse hover.', 'team-manager-free' ); ?></span>						
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="stop_hover_true" name="stop_hover" value="true" <?php if ( $stop_hover == 'true' || $stop_hover == '' ) echo 'checked'; ?>/>
										<label for="stop_hover_true"><?php _e( 'Yes', 'team-manager-free' ); ?></label>
										<input type="radio" id="stop_hover_false" name="stop_hover" value="false" <?php if ( $stop_hover == 'false' ) echo 'checked'; ?>/>
										<label for="stop_hover_false" class="stop_hover_false"><?php _e( 'No', 'team-manager-free' ); ?></label>
									</div>	
								</td>
							</tr>
							<!-- End Stop Hover -->

							<tr valign="top">
								<th scope="row">
									<label for="autoplaytimeout"><?php _e( 'Autoplay Time Out (Sec)', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Select an option for autoplay time out.', 'team-manager-free' ); ?></span>							
								</th>
								<td style="vertical-align: middle;">
									<select name="autoplaytimeout" id="autoplaytimeout" class="timezone_string">
										<option value="1000" <?php if ( isset ( $autoplaytimeout ) ) selected( $autoplaytimeout, '1000' ); ?>><?php _e( '1', 'team-manager-free' );?></option>
										<option value="2000" <?php if ( isset ( $autoplaytimeout ) ) selected( $autoplaytimeout, '2000' ); ?>><?php _e( '2', 'team-manager-free' );?></option>
										<option value="3000" <?php if ( isset ( $autoplaytimeout ) ) selected( $autoplaytimeout, '3000' ); ?>><?php _e( '3', 'team-manager-free' );?></option>
										<option value="4000" <?php if ( isset ( $autoplaytimeout ) ) selected( $autoplaytimeout, '4000' ); ?>><?php _e( '4', 'team-manager-free' );?></option>
										<option value="5000" <?php if ( isset ( $autoplaytimeout ) ) selected( $autoplaytimeout, '5000' ); ?>><?php _e( '5', 'team-manager-free' );?></option>
										<option value="6000" <?php if ( isset ( $autoplaytimeout ) ) selected( $autoplaytimeout, '6000' ); ?>><?php _e( '6', 'team-manager-free' );?></option>
										<option value="7000" <?php if ( isset ( $autoplaytimeout ) ) selected( $autoplaytimeout, '7000' ); ?>><?php _e( '7', 'team-manager-free' );?></option>
										<option value="8000" <?php if ( isset ( $autoplaytimeout ) ) selected( $autoplaytimeout, '8000' ); ?>><?php _e( '8', 'team-manager-free' );?></option>
										<option value="9000" <?php if ( isset ( $autoplaytimeout ) ) selected( $autoplaytimeout, '9000' ); ?>><?php _e( '9', 'team-manager-free' );?></option>
										<option value="10000" <?php if ( isset ( $autoplaytimeout ) ) selected( $autoplaytimeout, '10000' ); ?>><?php _e( '10', 'team-manager-free' );?></option>
									</select>
								</td>
							</tr>
							<!-- End Autoplay Time Out -->

							<tr valign="top">
								<th scope="row">
									<label for="item_no"><?php _e( 'Items No', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Select number of items you want to show.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<select name="item_no" id="item_no" class="timezone_string">
										<option value="3" <?php if ( isset ( $item_no ) )  selected( $item_no, '3' ); ?>><?php _e( '3', 'team-manager-free' );?></option>
										<option value="1" <?php if ( isset ( $item_no ) )  selected( $item_no, '1' ); ?>><?php _e( '1', 'team-manager-free' );?></option>
										<option value="2" <?php if ( isset ( $item_no ) )  selected( $item_no, '2' ); ?>><?php _e( '2', 'team-manager-free' );?></option>
										<option value="4" <?php if ( isset ( $item_no ) )  selected( $item_no, '4' ); ?>><?php _e( '4', 'team-manager-free' );?></option>
										<option value="5" <?php if ( isset ( $item_no ) )  selected( $item_no, '5' ); ?>><?php _e( '5', 'team-manager-free' );?></option>
										<option value="6" <?php if ( isset ( $item_no ) )  selected( $item_no, '6' ); ?>><?php _e( '6', 'team-manager-free' );?></option>
										<option value="7" <?php if ( isset ( $item_no ) )  selected( $item_no, '7' ); ?>><?php _e( '7', 'team-manager-free' );?></option>
										<option value="8" <?php if ( isset ( $item_no ) )  selected( $item_no, '8' ); ?>><?php _e( '8', 'team-manager-free' );?></option>
										<option value="9" <?php if ( isset ( $item_no ) )  selected( $item_no, '9' ); ?>><?php _e( '9', 'team-manager-free' );?></option>
										<option value="10" <?php if ( isset ( $item_no ) ) selected( $item_no, '10' ); ?>><?php _e( '10', 'team-manager-free' );?></option>
									</select>
								</td> 
							</tr>
							<!-- End Items No -->

							<tr valign="top">
								<th scope="row">
									<label for="itemsdesktop"><?php _e( 'Items Desktop', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Number of items you want to show for large desktop monitor.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<select name="itemsdesktop" id="itemsdesktop" class="timezone_string">
										<option value="3" <?php if ( isset ( $itemsdesktop ) ) selected( $itemsdesktop, '3' ); ?>><?php _e( '3', 'team-manager-free' );?></option>
										<option value="1" <?php if ( isset ( $itemsdesktop ) ) selected( $itemsdesktop, '1' ); ?>><?php _e( '1', 'team-manager-free' );?></option>
										<option value="2" <?php if ( isset ( $itemsdesktop ) ) selected( $itemsdesktop, '2' ); ?>><?php _e( '2', 'team-manager-free' );?></option>
										<option value="4" <?php if ( isset ( $itemsdesktop ) ) selected( $itemsdesktop, '4' ); ?>><?php _e( '4', 'team-manager-free' );?></option>
										<option value="5" <?php if ( isset ( $itemsdesktop ) ) selected( $itemsdesktop, '5' ); ?>><?php _e( '5', 'team-manager-free' );?></option>
										<option value="6" <?php if ( isset ( $itemsdesktop ) ) selected( $itemsdesktop, '6' ); ?>><?php _e( '6', 'team-manager-free' );?></option>
										<option value="7" <?php if ( isset ( $itemsdesktop ) ) selected( $itemsdesktop, '7' ); ?>><?php _e( '7', 'team-manager-free' );?></option>
										<option value="8" <?php if ( isset ( $itemsdesktop ) ) selected( $itemsdesktop, '8' ); ?>><?php _e( '8', 'team-manager-free' );?></option>
										<option value="9" <?php if ( isset ( $itemsdesktop ) ) selected( $itemsdesktop, '9' ); ?>><?php _e( '9', 'team-manager-free' );?></option>
										<option value="10" <?php if ( isset ( $itemsdesktop ) ) selected( $itemsdesktop, '10' ); ?>><?php _e( '10', 'team-manager-free' );?></option>
									</select>
								</td>
							</tr>
							<!-- End Items Desktop -->

							<tr valign="top">
								<th scope="row">
									<label for="itemsdesktopsmall"><?php _e( 'Items Desktop Small', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Number of items you want to show for small desktop monitor.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<select name="itemsdesktopsmall" id="itemsdesktopsmall" class="timezone_string">
										<option value="1" <?php if ( isset ( $itemsdesktopsmall ) ) selected( $itemsdesktopsmall, '1' ); ?>><?php _e( '1', 'team-manager-free' );?></option>
										<option value="2" <?php if ( isset ( $itemsdesktopsmall ) ) selected( $itemsdesktopsmall, '2' ); ?>><?php _e( '2', 'team-manager-free' );?></option>
										<option value="3" <?php if ( isset ( $itemsdesktopsmall ) ) selected( $itemsdesktopsmall, '3' ); ?>><?php _e( '3', 'team-manager-free' );?></option>
										<option value="4" <?php if ( isset ( $itemsdesktopsmall ) ) selected( $itemsdesktopsmall, '4' ); ?>><?php _e( '4', 'team-manager-free' );?></option>
										<option value="5" <?php if ( isset ( $itemsdesktopsmall ) ) selected( $itemsdesktopsmall, '5' ); ?>><?php _e( '5', 'team-manager-free' );?></option>
										<option value="6" <?php if ( isset ( $itemsdesktopsmall ) ) selected( $itemsdesktopsmall, '6' ); ?>><?php _e( '6', 'team-manager-free' );?></option>
										<option value="7" <?php if ( isset ( $itemsdesktopsmall ) ) selected( $itemsdesktopsmall, '7' ); ?>><?php _e( '7', 'team-manager-free' );?></option>
										<option value="8" <?php if ( isset ( $itemsdesktopsmall ) ) selected( $itemsdesktopsmall, '8' ); ?>><?php _e( '8', 'team-manager-free' );?></option>
										<option value="9" <?php if ( isset ( $itemsdesktopsmall ) ) selected( $itemsdesktopsmall, '9' ); ?>><?php _e( '9', 'team-manager-free' );?></option>
										<option value="10" <?php if ( isset ( $itemsdesktopsmall ) ) selected( $itemsdesktopsmall, '10' ); ?>><?php _e( '10', 'team-manager-free' );?></option>
									</select>

								</td>
							</tr>
							<!-- End Items Desktop Small -->

							<tr valign="top">
								<th scope="row">
									<label for="itemsmobile"><?php _e( 'Items Mobile', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Number of items you want to show for mobile device.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<select name="itemsmobile" id="itemsmobile" class="timezone_string">
										<option value="1" <?php if ( isset ( $itemsmobile ) ) selected( $itemsmobile, '1' ); ?>><?php _e( '1', 'team-manager-free' );?></option>
										<option value="2" <?php if ( isset ( $itemsmobile ) ) selected( $itemsmobile, '2' ); ?>><?php _e( '2', 'team-manager-free' );?></option>
										<option value="3" <?php if ( isset ( $itemsmobile ) ) selected( $itemsmobile, '3' ); ?>><?php _e( '3', 'team-manager-free' );?></option>
										<option value="4" <?php if ( isset ( $itemsmobile ) ) selected( $itemsmobile, '4' ); ?>><?php _e( '4', 'team-manager-free' );?></option>
										<option value="5" <?php if ( isset ( $itemsmobile ) ) selected( $itemsmobile, '5' ); ?>><?php _e( '5', 'team-manager-free' );?></option>
										<option value="6" <?php if ( isset ( $itemsmobile ) ) selected( $itemsmobile, '6' ); ?>><?php _e( '6', 'team-manager-free' );?></option>
										<option value="7" <?php if ( isset ( $itemsmobile ) ) selected( $itemsmobile, '7' ); ?>><?php _e( '7', 'team-manager-free' );?></option>
										<option value="8" <?php if ( isset ( $itemsmobile ) ) selected( $itemsmobile, '8' ); ?>><?php _e( '8', 'team-manager-free' );?></option>
										<option value="9" <?php if ( isset ( $itemsmobile ) ) selected( $itemsmobile, '9' ); ?>><?php _e( '9', 'team-manager-free' );?></option>
										<option value="10" <?php if ( isset ( $itemsmobile ) ) selected( $itemsmobile, '10' ); ?>><?php _e( '10', 'team-manager-free' );?></option>
									</select>
								</td>
							</tr>
							<!-- End Items Mobile -->

							<tr valign="top">
								<th scope="row">
									<label for="item_no"><?php _e( 'Loop', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Choose an option whether you want to loop the sliders.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="loop_true" name="loop" value="true" <?php if ( $loop == 'true' || $loop == '' ) echo 'checked'; ?>/>
										<label for="loop_true"><?php _e( 'Yes', 'team-manager-free' ); ?></label>
										<input type="radio" id="loop_false" name="loop" value="false" <?php if ( $loop == 'false' ) echo 'checked'; ?>/>
										<label for="loop_false" class="loop_true"><?php _e( 'No', 'team-manager-free' ); ?></label>
									</div>
								</td>
							</tr>
							<!-- End Loop -->

							<tr valign="top">
								<th scope="row">
									<label for="margin"><?php _e( 'Margin', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Select margin for a slider item.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input size="5" type="number" name="margin" id="margin_top" maxlength="3" class="timezone_string" value="<?php if ( $margin != '' ) { echo $margin; } else { echo '0'; } ?>">
								</td>
							</tr>
							<!-- End Margin -->

							<tr valign="top">
								<th scope="row">
									<label for="navigation"><?php _e( 'Navigation', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Choose an option whether you want navigation option or not.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="navigation_true" name="navigation" value="true" <?php if ( $navigation == 'true' || $navigation == '' ) echo 'checked'; ?>/>
										<label for="navigation_true"><?php _e( 'Yes', 'team-manager-free' ); ?></label>
										<input type="radio" id="navigation_false" name="navigation" value="false" <?php if ( $navigation == 'false' ) echo 'checked'; ?>/>
										<label for="navigation_false" class="navigation_false"><?php _e( 'No', 'team-manager-free' ); ?></label>
									</div>
								</td>
							</tr>
							<!-- End Navigation -->
							
							<tr valign="top">
								<th scope="row">
									<label for="navigation_align"><?php _e( 'Navigation Align', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Set the alignment of the navigation tool.', 'team-manager-free' ); ?></span>		
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="navigation_align_left" name="navigation_align" value="left" <?php if ( $navigation_align == 'left' ) echo 'checked'; ?>/>
										<label for="navigation_align_left"><?php _e( 'Top Left', 'team-manager-free' ); ?></label>
										<input type="radio" id="navigation_align_center" name="navigation_align" value="center" <?php if ( $navigation_align == 'center' || $navigation_align == '' ) echo 'checked'; ?>/>
										<label for="navigation_align_center"><?php _e( 'Center', 'team-manager-free' ); ?></label>
										<input type="radio" id="navigation_align_right" name="navigation_align" value="right" <?php if ( $navigation_align == 'right' ) echo 'checked'; ?>/>
										<label for="navigation_align_right"><?php _e( 'Top Right', 'team-manager-free' ); ?></label>
									</div>	
								</td>
							</tr>
							<!-- End Navigation Align -->

							<tr valign="top">
								<th scope="row">
									<label for="navigation_btn_style"><?php _e( 'Navigation Style', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Choose style of the navigation tool.', 'team-manager-free' ); ?></span>						
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="navigation_btn_1" name="navigation_btn_style" value="0" <?php if ( $navigation_btn_style == '0' ) echo 'checked'; ?>/>
										<label for="navigation_btn_1"><?php _e( 'Default', 'team-manager-free' ); ?></label>
										<input type="radio" id="navigation_btn_2" name="navigation_btn_style" value="50" <?php if ( $navigation_btn_style == '50' || $navigation_btn_style == '' ) echo 'checked'; ?>/>
										<label for="navigation_btn_2"><?php _e( 'Round', 'team-manager-free' ); ?></label>
									</div>	
								</td>
							</tr>
							<!-- End Navigation Button Style -->

							<tr valign="top">
								<th scope="row">
									<label for="nav_text_color"><?php echo __( 'Navigation Text Color', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Pick a color for navigation tool.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input size='10' name='nav_text_color' class='team-manager-free-header-font-color' type='text' id="nav_text_color" value="<?php if($nav_text_color !=''){echo $nav_text_color;} else{ echo "#000000";} ?>" /><br>
								</td>
							</tr>
							<!-- End Navigation Color -->

							<tr valign="top">
								<th scope="row">
									<label for="nav_bg_color"><?php echo __( 'Navigation Background Color', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Pick a color for background of navigation tool.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input size='10' name='nav_bg_color' class='team-manager-free-header-font-color' type='text' id="nav_bg_color" value="<?php if($nav_bg_color !=''){echo $nav_bg_color;} else{ echo "#dddddd";} ?>" /><br>
								</td>
							</tr>
							<!-- End Navigation Background Color -->

							<tr valign="top">
								<th scope="row">
									<label for="nav_hover_text_color"><?php echo __( 'Navigation Hover Text', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Pick a color for navigation hover tool.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input size='10' name='nav_hover_text_color' class='team-manager-free-header-font-color' type='text' id="nav_hover_text_color" value="<?php if($nav_hover_text_color !=''){echo $nav_hover_text_color;} else{ echo "#000000";} ?>" /><br>
								</td>
							</tr>
							<!-- End Navigation Hover Text Color -->

							<tr valign="top">
								<th scope="row">
									<label for="nav_hover_bg_color"><?php echo __( 'Navigation Hover Background', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Pick a color for background of navigation hover tool.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input size='10' name='nav_hover_bg_color' class='team-manager-free-header-font-color' type='text' id="nav_hover_bg_color" value="<?php if($nav_hover_bg_color !=''){echo $nav_hover_bg_color;} else{ echo "#dddddd";} ?>" /><br>
								</td>
							</tr>
							<!-- End Navigation Hover Background -->

							<tr valign="top">
								<th scope="row">
									<label for="pagination"><?php _e( 'Pagination', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Choose an option whether you want pagination option or not.', 'team-manager-free' ); ?></span>	
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="pagination_true" name="pagination" value="true" <?php if ( $pagination == 'true' || $pagination == '' ) echo 'checked'; ?>/>
										<label for="pagination_true"><?php _e( 'Yes', 'team-manager-free' ); ?></label>
										<input type="radio" id="pagination_false" name="pagination" value="false" <?php if ( $pagination == 'false' ) echo 'checked'; ?>/>
										<label for="pagination_false" class="pagination_false"><?php _e( 'No', 'team-manager-free' ); ?></label>
									</div>	
								</td>
							</tr>
							<!-- End Pagination -->
							
							<tr valign="top">
								<th scope="row">
									<label for="pagination_align"><?php _e( 'Pagination Align', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Set the alignment of pagination.' ); ?></span>						
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="pagination_align_left" name="pagination_align" value="left" <?php if ( $pagination_align == 'left' ) echo 'checked'; ?>/>
										<label for="pagination_align_left"><?php _e( 'Left', 'team-manager-free' ); ?></label>
										<input type="radio" id="pagination_align_center" name="pagination_align" value="center" <?php if ( $pagination_align == 'center' || $pagination_align == '' ) echo 'checked'; ?>/>
										<label for="pagination_align_center"><?php _e( 'Center', 'team-manager-free' ); ?></label>
										<input type="radio" id="pagination_align_right" name="pagination_align" value="right" <?php if ( $pagination_align == 'right' ) echo 'checked'; ?>/>
										<label for="pagination_align_right"><?php _e( 'Right', 'team-manager-free' ); ?></label>
									</div>	
								</td>
							</tr>
							<!-- End Pagination Align -->

							<tr valign="top">
								<th scope="row">
									<label for="pagination_bg_color"><?php echo __('Pagination Background', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Pick a color for pagination', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input size='10' name='pagination_bg_color' class='team-manager-free-header-font-color' type='text' id="pagination_bg_color" value="<?php if($pagination_bg_color !=''){echo $pagination_bg_color;} else{ echo "#ddd";} ?>" /><br>
								</td>
							</tr>
							<!-- End Pagination Background Color -->

							<tr valign="top">
								<th scope="row">
									<label for="pagination_active_color"><?php echo __( 'Pagination Active Color', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Pick a color for pagination active icon.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input size='10' name='pagination_active_color' class='team-manager-free-header-font-color' type='text' id="pagination_active_color" value="<?php if($pagination_active_color !=''){echo $pagination_active_color;} else{ echo "#998f8f";} ?>" /><br>
								</td>
							</tr>
							<!-- End Pagination Active Background Color -->
						</table>
					</div>
				</div>
			</li>
		</ul>
	</div>
	<script type="text/javascript">
		jQuery(document).ready(function(jQuery){
			jQuery('#team_manager_free_header_font_color,#team_manager_free_biography_font_color,#team_manager_free_name_hover_font_color,#team_manager_free_designation_font_color,#team_manager_free_overlay_bg_color, #team_fbackground_color, #team_manager_free_emails_font_color, #team_manager_free_emails_hover_color, #team_manager_free_numbers_font_color, #team_manager_free_numbers_hover_color, #team_manager_free_addresss_font_color, #team_manager_free_website_hover_color, #team_manager_free_website_font_color, #filter_bg_color, #filter_border_color, #filter_mfont_color, #filter_active_color, #filter_hover_tcolor, #filter_hover_color, #filter_active_font, #pagination_bg_color, #pagination_active_color, #nav_text_color, #nav_bg_color, #nav_hover_bg_color, #nav_hover_text_color').wpColorPicker();
		});
	</script>
	<?php
	}		

		
	/**
	 * Saves the notice for the given post.
	 *
	 * @params	$post_id	The ID of the post that we're serializing
	 */
	function save_notice( $post_id ) {

	    // Check if autosave
	    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
	        return;
	    }

	    // Check if current user has permission to edit the post
	    if ( ! current_user_can( 'edit_post', $post_id ) ) {
	        return;
	    }

		#Checks for input and saves if needed
		if( isset( $_POST[ 'team_manager_free_category_select' ] ) ) {
			update_post_meta( $post_id, 'team_manager_free_category_select', $_POST['team_manager_free_category_select'] );
		} else {
            update_post_meta( $post_id, 'team_manager_free_category_select', 'unchecked');
        }

		#Checks for input and saves if needed
		if( isset( $_POST[ 'team_manager_free_post_themes' ] ) ) {
			update_post_meta( $post_id, 'team_manager_free_post_themes', $_POST[ 'team_manager_free_post_themes' ] );
		}

		#Checks for input and saves if needed
		if(isset($_POST['team_manager_free_theme_style'])) {
			update_post_meta($post_id, 'team_manager_free_theme_style', $_POST['team_manager_free_theme_style']);
		}

		#Checks for input and saves if needed
		if( isset( $_POST[ 'team_manager_free_limits' ] ) ) {
			update_post_meta( $post_id, 'team_manager_free_limits', $_POST[ 'team_manager_free_limits' ] );
		}

		#Checks for input and saves if needed
		if( isset( $_POST[ 'teamf_orderby' ] ) ) {
			update_post_meta( $post_id, 'teamf_orderby', $_POST[ 'teamf_orderby' ] );
		}

		#Checks for input and saves if needed
		if( isset( $_POST[ 'teamf_order' ] ) ) {
			update_post_meta( $post_id, 'teamf_order', $_POST[ 'teamf_order' ] );
		}

		#Checks for input and saves if needed
		if( isset( $_POST[ 'team_manager_free_imagesize' ] ) ) {
			update_post_meta( $post_id, 'team_manager_free_imagesize', $_POST[ 'team_manager_free_imagesize' ] );
		}

		#Checks for input and saves if needed
		if( isset( $_POST[ 'team_manager_free_post_column' ] ) ) {
			update_post_meta( $post_id, 'team_manager_free_post_column', $_POST[ 'team_manager_free_post_column' ] );
		}

		#Checks for input and saves if needed
		if( isset( $_POST[ 'team_manager_free_margin_bottom' ] ) ) {
			update_post_meta( $post_id, 'team_manager_free_margin_bottom', $_POST[ 'team_manager_free_margin_bottom' ] );
		}

		#Checks for input and saves if needed
		if(isset($_POST['team_manager_free_padding_left'])) {
			update_post_meta($post_id, 'team_manager_free_padding_left', $_POST['team_manager_free_padding_left']);
		}

		#Checks for input and saves if needed
		if(isset($_POST['team_manager_free_padding_right'])) {
			update_post_meta($post_id, 'team_manager_free_padding_right', $_POST['team_manager_free_padding_right']);
		}

		#Checks for input and saves if needed
		if( isset( $_POST[ 'team_manager_free_margin_lfr' ] ) ) {
			update_post_meta( $post_id, 'team_manager_free_margin_lfr', $_POST[ 'team_manager_free_margin_lfr' ] );
		}

		#Checks for input and saves if needed
		if( isset( $_POST[ 'team_manager_free_img_height' ] ) ) {
			update_post_meta( $post_id, 'team_manager_free_img_height', $_POST['team_manager_free_img_height'] );
		}

		#Checks for input and saves if needed
		if( isset( $_POST[ 'team_manager_free_text_alignment' ] ) ) {
			update_post_meta( $post_id, 'team_manager_free_text_alignment', $_POST[ 'team_manager_free_text_alignment' ] );
		}

		#Checks for input and saves if needed
		if( isset( $_POST[ 'team_manager_free_multicolor_hide' ] ) ) {
			update_post_meta( $post_id, 'team_manager_free_multicolor_hide', $_POST[ 'team_manager_free_multicolor_hide' ] );
		}

		#Checks for input and saves if needed
		if( isset( $_POST[ 'team_manager_free_biography_option' ] ) ) {
			update_post_meta( $post_id, 'team_manager_free_biography_option', $_POST[ 'team_manager_free_biography_option' ] );
		}

		#Checks for input and saves if needed
		if( isset( $_POST[ 'team_manager_free_header_font_size' ] ) ) {
			update_post_meta( $post_id, 'team_manager_free_header_font_size', $_POST[ 'team_manager_free_header_font_size' ] );
		}

		#Checks for input and saves if needed
		if(isset($_POST['team_manager_name_font_weight'])) {
			update_post_meta($post_id, 'team_manager_name_font_weight', $_POST['team_manager_name_font_weight']);
		}

		#Checks for input and saves if needed
		if(isset($_POST['team_manager_name_font_style'])) {
			update_post_meta($post_id, 'team_manager_name_font_style', $_POST['team_manager_name_font_style']);
		}

		#Checks for input and saves if needed
		if( isset( $_POST[ 'team_manager_free_designation_hide' ] ) ) {
			update_post_meta( $post_id, 'team_manager_free_designation_hide', $_POST[ 'team_manager_free_designation_hide' ] );
		}

		#Checks for input and saves if needed
		if( isset( $_POST[ 'team_manager_free_designation_font_size' ] ) ) {
			update_post_meta( $post_id, 'team_manager_free_designation_font_size', $_POST[ 'team_manager_free_designation_font_size' ] );
		}	

		#Checks for input and saves if needed
		if( isset( $_POST[ 'team_manager_free_header_font_color' ] ) ) {
			update_post_meta( $post_id, 'team_manager_free_header_font_color', $_POST[ 'team_manager_free_header_font_color' ] );
		}

		#Checks for input and saves if needed
		if( isset( $_POST[ 'team_manager_free_name_hover_font_color' ] ) ) {
			update_post_meta( $post_id, 'team_manager_free_name_hover_font_color', $_POST[ 'team_manager_free_name_hover_font_color' ] );
		}

		#Checks for input and saves if needed
		if( isset( $_POST[ 'team_manager_name_font_case' ] ) ) {
			update_post_meta( $post_id, 'team_manager_name_font_case', $_POST[ 'team_manager_name_font_case' ] );
		}

		#Checks for input and saves if needed
		if( isset( $_POST[ 'team_manager_free_designation_font_color' ] ) ) {
			update_post_meta( $post_id, 'team_manager_free_designation_font_color', $_POST[ 'team_manager_free_designation_font_color' ] );
		}

		#Checks for input and saves if needed
		if( isset( $_POST[ 'team_manager_desig_font_case' ] ) ) {
			update_post_meta( $post_id, 'team_manager_desig_font_case', $_POST[ 'team_manager_desig_font_case' ] );
		}

		#Checks for input and saves if needed
		if( isset( $_POST[ 'team_manager_desig_font_style' ] ) ) {
			update_post_meta( $post_id, 'team_manager_desig_font_style', $_POST[ 'team_manager_desig_font_style' ] );
		}

		#Checks for input and saves if needed
		if(isset($_POST['team_manager_free_emails_hide'])) {
			update_post_meta($post_id, 'team_manager_free_emails_hide', $_POST['team_manager_free_emails_hide']);
		}

		#Checks for input and saves if needed
		if(isset($_POST['team_manager_free_emails_font_color'])) {
			update_post_meta($post_id, 'team_manager_free_emails_font_color', $_POST['team_manager_free_emails_font_color']);
		}

		#Checks for input and saves if needed
		if(isset($_POST['team_manager_free_emails_hover_color'])) {
			update_post_meta($post_id, 'team_manager_free_emails_hover_color', $_POST['team_manager_free_emails_hover_color']);
		}

		#Checks for input and saves if needed
		if(isset($_POST['team_manager_free_emails_font_size'])) {
			update_post_meta($post_id, 'team_manager_free_emails_font_size', $_POST['team_manager_free_emails_font_size']);
		}

		#Checks for input and saves if needed
		if(isset($_POST['team_manager_free_numbers_hide'])) {
			update_post_meta($post_id, 'team_manager_free_numbers_hide', $_POST['team_manager_free_numbers_hide']);
		}

		#Checks for input and saves if needed
		if(isset($_POST['team_manager_free_numbers_font_size'])) {
			update_post_meta($post_id, 'team_manager_free_numbers_font_size', $_POST['team_manager_free_numbers_font_size']);
		}

		#Checks for input and saves if needed
		if(isset($_POST['team_manager_free_numbers_font_color'])) {
			update_post_meta($post_id, 'team_manager_free_numbers_font_color', $_POST['team_manager_free_numbers_font_color']);
		}

		#Checks for input and saves if needed
		if(isset($_POST['team_manager_free_numbers_hover_color'])) {
			update_post_meta($post_id, 'team_manager_free_numbers_hover_color', $_POST['team_manager_free_numbers_hover_color']);
		}

		#Checks for input and saves if needed
		if(isset($_POST['team_manager_free_address_hide'])) {
			update_post_meta($post_id, 'team_manager_free_address_hide', $_POST['team_manager_free_address_hide']);
		}

		#Checks for input and saves if needed
		if(isset($_POST['team_manager_free_addresss_font_color'])) {
			update_post_meta($post_id, 'team_manager_free_addresss_font_color', $_POST['team_manager_free_addresss_font_color']);
		}

		#Checks for input and saves if needed
		if(isset($_POST['team_manager_free_addresss_font_size'])) {
			update_post_meta($post_id, 'team_manager_free_addresss_font_size', $_POST['team_manager_free_addresss_font_size']);
		}

		#Checks for input and saves if needed
		if(isset($_POST['team_manager_free_website_hide'])) {
			update_post_meta($post_id, 'team_manager_free_website_hide', $_POST['team_manager_free_website_hide']);
		}

		#Checks for input and saves if needed
		if(isset($_POST['team_manager_free_website_font_size'])) {
			update_post_meta($post_id, 'team_manager_free_website_font_size', $_POST['team_manager_free_website_font_size']);
		}

		#Checks for input and saves if needed
		if(isset($_POST['team_manager_free_website_font_color'])) {
			update_post_meta($post_id, 'team_manager_free_website_font_color', $_POST['team_manager_free_website_font_color']);
		}

		#Checks for input and saves if needed
		if(isset($_POST['team_manager_free_website_hover_color'])) {
			update_post_meta($post_id, 'team_manager_free_website_hover_color', $_POST['team_manager_free_website_hover_color']);
		}

		#Checks for input and saves if needed
		if( isset( $_POST[ 'team_manager_free_biography_font_size' ] ) ) {
			update_post_meta( $post_id, 'team_manager_free_biography_font_size', $_POST[ 'team_manager_free_biography_font_size' ] );
		}





 
	    
	 	#Checks for input and sanitizes/saves if needed    
	    if ( isset( $_POST['autoplay'] ) && ( $_POST['autoplay'] != '' ) ) {
	        update_post_meta( $post_id, 'autoplay', esc_html( $_POST['autoplay'] ) );
	    }
	    
	 	#Checks for input and sanitizes/saves if needed    
	    if ( ! empty( $_POST['autoplay_speed'] ) ) {
	    	if (strlen( $_POST['autoplay_speed'] ) > 4 ) {
	    		
	    	} else {
	    		if ( $_POST['autoplay_speed'] == '' || is_null( $_POST['autoplay_speed'] ) ) {
	    			update_post_meta( $post_id, 'autoplay_speed', 700 );
	    		} else{
		    		if ( is_numeric( $_POST['autoplay_speed'] ) && strlen( $_POST['autoplay_speed'] ) <= 4 ) {
		    			update_post_meta( $post_id, 'autoplay_speed', esc_html( $_POST['autoplay_speed'] ) );
		    		}
	    		}
	    	}
	    }

	 	#Checks for input and sanitizes/saves if needed    
	    if ( isset( $_POST['stop_hover'] ) && ( $_POST['stop_hover'] != '' ) ) {
	        update_post_meta( $post_id, 'stop_hover', esc_html( $_POST['stop_hover'] ) );
	    }

		#Checks for input and sanitizes/saves if needed
	    if ( isset( $_POST['item_no'] ) && ( $_POST['item_no'] != '' ) ) {
	        update_post_meta( $post_id, 'item_no', esc_html( $_POST['item_no'] ) );
	    }

	 	#Checks for input and sanitizes/saves if needed    
	    if ( isset( $_POST['itemsdesktop'] ) && ( $_POST['itemsdesktop'] != '' ) ) {
	        update_post_meta( $post_id, 'itemsdesktop', esc_html( $_POST['itemsdesktop'] ) );
	    }

	 	#Checks for input and sanitizes/saves if needed    
	    if ( isset( $_POST['itemsdesktopsmall'] ) && ( $_POST['itemsdesktopsmall'] != '' ) ) {
	        update_post_meta( $post_id, 'itemsdesktopsmall', esc_html( $_POST['itemsdesktopsmall'] ) );
	    }

	 	#Checks for input and sanitizes/saves if needed    
	    if ( isset( $_POST['itemsmobile'] ) && ( $_POST['itemsmobile'] != '' ) ) {
	        update_post_meta( $post_id, 'itemsmobile', esc_html( $_POST['itemsmobile'] ) );
	    }

	 	#Checks for input and sanitizes/saves if needed    
	    if ( isset( $_POST['autoplaytimeout'] ) && ( $_POST['autoplaytimeout'] != '' ) ) {
	        update_post_meta( $post_id, 'autoplaytimeout', esc_html( $_POST['autoplaytimeout'] ) );
	    }

	 	#Checks for input and sanitizes/saves if needed    
	    if ( isset( $_POST['nav_text_color'] ) && ( $_POST['nav_text_color'] != '' ) ) {
	        update_post_meta( $post_id, 'nav_text_color', esc_html( $_POST['nav_text_color'] ) );
	    }

	 	#Checks for input and sanitizes/saves if needed    
	    if ( isset( $_POST['nav_hover_bg_color'] ) && ( $_POST['nav_hover_bg_color'] != '' ) ) {
	        update_post_meta( $post_id, 'nav_hover_bg_color', esc_html( $_POST['nav_hover_bg_color'] ) );
	    }

	 	#Checks for input and sanitizes/saves if needed    
	    if ( isset( $_POST['nav_hover_text_color'] ) && ( $_POST['nav_hover_text_color'] != '' ) ) {
	        update_post_meta( $post_id, 'nav_hover_text_color', esc_html( $_POST['nav_hover_text_color'] ) );
	    }

	    #Checks for input and sanitizes/saves if needed    
	    if ( isset( $_POST['pagination_bg_color'] ) && ( $_POST['pagination_bg_color'] != '' ) ) {
	        update_post_meta( $post_id, 'pagination_bg_color', esc_html( $_POST['pagination_bg_color'] ) );
	    }  

	    #Checks for input and sanitizes/saves if needed    
	    if ( isset( $_POST['pagination_active_color'] ) && ( $_POST['pagination_active_color'] != '' ) ) {
	        update_post_meta( $post_id, 'pagination_active_color', esc_html( $_POST['pagination_active_color'] ) );
	    }   


	 	#Checks for input and sanitizes/saves if needed    
	    if ( isset( $_POST['filter_bg_color'] ) && ( $_POST['filter_bg_color'] != '' ) ) {
	        update_post_meta( $post_id, 'filter_bg_color', esc_html( $_POST['filter_bg_color'] ) );
	    }

	 	#Checks for input and sanitizes/saves if needed    
	    if ( isset( $_POST['filter_border_color'] ) && ( $_POST['filter_border_color'] != '' ) ) {
	        update_post_meta( $post_id, 'filter_border_color', esc_html( $_POST['filter_border_color'] ) );
	    }

	 	#Checks for input and sanitizes/saves if needed    
	    if ( isset( $_POST['filter_mfont_color'] ) && ( $_POST['filter_mfont_color'] != '' ) ) {
	        update_post_meta( $post_id, 'filter_mfont_color', esc_html( $_POST['filter_mfont_color'] ) );
	    }

	 	#Checks for input and sanitizes/saves if needed    
	    if ( isset( $_POST['filter_active_color'] ) && ( $_POST['filter_active_color'] != '' ) ) {
	        update_post_meta( $post_id, 'filter_active_color', esc_html( $_POST['filter_active_color'] ) );
	    }

	 	#Checks for input and sanitizes/saves if needed    
	    if ( isset( $_POST['filter_hover_color'] ) && ( $_POST['filter_hover_color'] != '' ) ) {
	        update_post_meta( $post_id, 'filter_hover_color', esc_html( $_POST['filter_hover_color'] ) );
	    }

	 	#Checks for input and sanitizes/saves if needed    
	    if ( isset( $_POST['filter_active_font'] ) && ( $_POST['filter_active_font'] != '' ) ) {
	        update_post_meta( $post_id, 'filter_active_font', esc_html( $_POST['filter_active_font'] ) );
	    }

	 	#Checks for input and sanitizes/saves if needed    
	    if ( isset( $_POST['nav_bg_color'] ) && ( $_POST['nav_bg_color'] != '' ) ) {
	        update_post_meta( $post_id, 'nav_bg_color', esc_html( $_POST['nav_bg_color'] ) );
	    }

	 	#Checks for input and sanitizes/saves if needed    
	    if ( isset( $_POST['filter_hover_tcolor'] ) && ( $_POST['filter_hover_tcolor'] != '' ) ) {
	        update_post_meta( $post_id, 'filter_hover_tcolor', esc_html( $_POST['filter_hover_tcolor'] ) );
	    }

	 	#Checks for input and sanitizes/saves if needed    
	    if ( isset( $_POST['filter_border_radius'] ) ) {
	    	update_post_meta( $post_id, 'filter_border_radius', $_POST['filter_border_radius'] );
	    }

		#Checks for input and saves if needed
		if( isset( $_POST[ 'team_manager_free_overlay_bg_color' ] ) ) {
			update_post_meta( $post_id, 'team_manager_free_overlay_bg_color', $_POST[ 'team_manager_free_overlay_bg_color' ] );
		}

		#Checks for input and saves if needed
		if( isset( $_POST[ 'team_manager_free_biography_font_color' ] ) ) {
			update_post_meta( $post_id, 'team_manager_free_biography_font_color', $_POST[ 'team_manager_free_biography_font_color' ] );
		}	

		#Checks for input and saves if needed
		if( isset( $_POST[ 'team_fbackground_color' ] ) ) {
			update_post_meta( $post_id, 'team_fbackground_color', $_POST[ 'team_fbackground_color' ] );
		}

		#Checks for input and saves if needed
		if(isset($_POST['team_manager_free_popupbox_hide'])) {
			update_post_meta($post_id, 'team_manager_free_popupbox_hide', $_POST['team_manager_free_popupbox_hide']);
		}

		#Checks for input and saves if needed
		if(isset($_POST['team_manager_free_popupbox_positions'])) {
			update_post_meta($post_id, 'team_manager_free_popupbox_positions', $_POST['team_manager_free_popupbox_positions']);
		}

		#Checks for input and saves if needed
		if(isset($_POST['team_popup_title_hide'])) {
			update_post_meta($post_id, 'team_popup_title_hide', $_POST['team_popup_title_hide']);
		}

		#Checks for input and saves if needed
		if(isset($_POST['team_popup_designatins_hide'])) {
			update_post_meta($post_id, 'team_popup_designatins_hide', $_POST['team_popup_designatins_hide']);
		}

		#Checks for input and saves if needed
		if(isset($_POST['team_popup_emails_hide'])) {
			update_post_meta($post_id, 'team_popup_emails_hide', $_POST['team_popup_emails_hide']);
		}

		#Checks for input and saves if needed
		if(isset($_POST['team_popup_contacts_hide'])) {
			update_post_meta($post_id, 'team_popup_contacts_hide', $_POST['team_popup_contacts_hide']);
		}

		#Checks for input and saves if needed
		if(isset($_POST['team_popup_address_hide'])) {
			update_post_meta($post_id, 'team_popup_address_hide', $_POST['team_popup_address_hide']);
		}
		
		#Checks for input and saves if needed
		if( isset( $_POST[ 'team_manager_free_socialicons_hide' ] ) ) {
			update_post_meta( $post_id, 'team_manager_free_socialicons_hide', $_POST[ 'team_manager_free_socialicons_hide' ] );
		}

		#Checks for input and saves if needed
		if( isset( $_POST[ 'tmffree_social_font_size' ] ) ) {
			update_post_meta( $post_id, 'tmffree_social_font_size', $_POST[ 'tmffree_social_font_size' ] );
		}

		#Checks for input and saves if needed
		if( isset( $_POST[ 'tmffree_social_icon_color' ] ) ) {
			update_post_meta( $post_id, 'tmffree_social_icon_color', $_POST[ 'tmffree_social_icon_color' ] );
		}

		#Checks for input and saves if needed
		if( isset( $_POST[ 'tmffree_social_hover_color' ] ) ) {
			update_post_meta( $post_id, 'tmffree_social_hover_color', $_POST[ 'tmffree_social_hover_color' ] );
		}

		#Checks for input and saves if needed
		if( isset( $_POST[ 'tmffree_social_bg_color' ] ) ) {
			update_post_meta( $post_id, 'tmffree_social_bg_color', $_POST[ 'tmffree_social_bg_color' ] );
		}

		#Checks for input and saves if needed
		if( isset( $_POST[ 'team_manager_free_social_target' ] ) ) {
			update_post_meta( $post_id, 'team_manager_free_social_target', $_POST[ 'team_manager_free_social_target' ] );
		}

		#Checks for input and saves if needed
		if(isset($_POST['team_popup_website_hide'])) {
			update_post_meta($post_id, 'team_popup_website_hide', $_POST['team_popup_website_hide']);
		}

		#Checks for input and saves if needed
		if(isset($_POST['team_popup_infoicons_hide'])) {
			update_post_meta($post_id, 'team_popup_infoicons_hide', $_POST['team_popup_infoicons_hide']);
		}

		#Value check and saves if needed
		if( isset( $_POST[ 'nav_value' ] ) ) {
			update_post_meta( $post_id, 'nav_value', $_POST['nav_value'] );
		} else {
			update_post_meta( $post_id, 'nav_value', 1 );
		}

	} // end save_notice
	add_action('save_post', 'save_notice');