<?php

	// Ensure the script is only executed within WordPress
	if( !defined( 'ABSPATH' ) ){
		exit;
	}

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
			'set_featured_image'    => __( 'Upload Team Member image', 'team-manager-free' ),
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
			'supports'              =>  array( 'title', 'editor', 'thumbnail', 'page-attributes'),
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
			'update_item'       => __( 'Update Team Group' ),
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

	# Team Manager Free Help Text
	function team_manager_free_custom_post_help($content){
		global $post_type,$post;
		if ($post_type == 'team_mf') {
			if(!has_post_thumbnail( $post->ID )){
			   $content .= '<p>'.__('For better performance, we recommend resizing your images before uploading them to keep the website fast and responsive.','team-manager-free').'</p>';
			}
		}
		return $content;
	}
	add_filter('admin_post_thumbnail_html','team_manager_free_custom_post_help');

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

	# Team Shortcode post register
	function team_manager_free_custom_post_create_team_type() {
	// Set UI labels for Custom Post Type
		$labels = array(
			'name'                => _x( 'Team Shortcodes', 'Post Type General Name', 'team-manager-free' ),
			'singular_name'       => _x( 'Shortcode', 'Post Type Singular Name', 'team-manager-free' ),
			'menu_name'           => __( 'Shortcodes', 'team-manager-free' ),
			'parent_item_colon'   => __( 'Parent Shortcode', 'team-manager-free' ),
			'all_items'           => __( 'Manage Shortcodes', 'team-manager-free' ),
			'view_item'           => __( 'View Shortcode', 'team-manager-free' ),
			'add_new_item'        => __( 'Generate New Shortcode', 'team-manager-free' ),
			'add_new'             => __( 'Generate New Shortcode', 'team-manager-free' ),
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
	    $order = 'asc';

	    if (isset($_GET['order']) && $_GET['order'] === 'asc') {
	        $order = 'desc';
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

	# Team Value Function
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
		    $client_shortdescription = get_post_meta( $post_id, 'client_shortdescription', true );
		    echo esc_html( wp_trim_words( $client_shortdescription, 22, '...' ) );
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

	    if (isset($_GET['order']) && $_GET['order'] === 'asc') {
	        $order = 'desc';
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