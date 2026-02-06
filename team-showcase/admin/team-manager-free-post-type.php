<?php
	/*
	* @Author 		Themepoints
	* Copyright: 	Themepoints
	* Version : 3.0.0
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

	function team_mf_team_sidebar_metabox_callback($post) {
	    // Get saved data
		$sort_array	= get_post_meta( $post->ID, 'sort_array', true);
	    ?>

		<div class="wrap">
			<p><?php _e( 'To organize member information, simply drag and drop the items into your desired order.','team-manager-free' ); ?><a href="https://themepoints.com/product/team-showcase-pro/" target="_blank"><?php _e('Upgrade To Pro!', 'team-manager-free');?></a></p>
			<table class="team tup-form-table">
				<tbody class="tup_class2">
				<?php if(!empty($sort_array)){
					foreach ($sort_array as $value) {
						if($value =="designation"){ ?>
							<tr valign="top" class="ui-state-default tup-drag">
								<th scope="row">
									<label for="sort_dg"><span class="dashicons dashicons-move"></span><?php _e( 'Designation', 'team-manager-free' ); ?></label>
								</th>
								<td style="vertical-align: middle;">
									<div style="float:left;width:100%;margin-bottom: 10px;">
										<input type="hidden" name="sort_array[]" value="designation">
									</div>
								</td>
							</tr>
							<?php
						} if($value =="email"){ ?>
							<tr valign="top" class="ui-state-default tup-drag">
								<th scope="row">
									<label for="sort_email"><span class="dashicons dashicons-move"></span><?php _e( 'Email', 'team-manager-free' ); ?></label>
								</th>
								<td style="vertical-align: middle;">
									<div style="float:left;width:100%;margin-bottom: 10px;">
										<input type="hidden" name="sort_array[]" value="email" >
									</div>
								</td>
							</tr>
							<?php
						} if($value =="contact"){ ?>
							<tr valign="top" class="ui-state-default tup-drag">
								<th scope="row">
									<label for="sort_contact"><span class="dashicons dashicons-move"></span><?php _e( 'Contact Number', 'team-manager-free' ); ?></label>
								</th>
								<td style="vertical-align: middle;">
									<div style="float:left;width:100%;margin-bottom: 10px;">
										<input type="hidden" name="sort_array[]" value="contact">
									</div>
								</td>
							</tr>
							<?php
						} if($value =="address"){ ?>
							<tr valign="top" class="ui-state-default tup-drag">
								<th scope="row">
									<label for="sort_address"><span class="dashicons dashicons-move"></span><?php _e( 'Address', 'team-manager-free' ); ?></label>
								</th>
								<td style="vertical-align: middle;">
									<div style="float:left;width:100%;margin-bottom: 10px;">
										<input type="hidden" name="sort_array[]" value="address">
									</div>
								</td>
							</tr>
							<?php
						} if($value =="website"){ ?>
							<tr valign="top" class="ui-state-default tup-drag">
								<th scope="row">
									<label for="sort_website"><span class="dashicons dashicons-move"></span><?php _e( 'Website', 'team-manager-free' ); ?></label>
								</th>
								<td style="vertical-align: middle;">
									<div style="float:left;width:100%;margin-bottom: 10px;">
										<input type="hidden" name="sort_array[]" value="website">
									</div>
								</td>
							</tr>
							<?php
						}
					}   // End foreach loop
				} else { ?>
					<tr valign="top" class="ui-state-default tup-drag">
						<th scope="row">
							<label for="sort_dg"><span class="dashicons dashicons-move"></span><?php _e( 'Designation', 'team-manager-free' ); ?></label>
						</th>
						<td style="vertical-align: middle;">
							<div style="float:left;width:100%;margin-bottom: 10px;">
								<input type="hidden" name="sort_array[]" value="designation">
							</div>
						</td>
					</tr>
					<tr valign="top" class="ui-state-default tup-drag">
						<th scope="row">
							<label for="sort_email"><span class="dashicons dashicons-move"></span><?php _e( 'Email', 'team-manager-free' ); ?></label>
						</th>
						<td style="vertical-align: middle;">
							<div style="float:left;width:100%;margin-bottom: 10px;">
								<input type="hidden" name="sort_array[]" value="email" >
							</div>
						</td>
					</tr>
					<tr valign="top" class="ui-state-default tup-drag">
						<th scope="row">
							<label for="sort_contact"><span class="dashicons dashicons-move"></span><?php _e( 'Contact Number', 'team-manager-free' ); ?></label>
						</th>
						<td style="vertical-align: middle;">
							<div style="float:left;width:100%;margin-bottom: 10px;">
								<input type="hidden" name="sort_array[]" value="contact">
							</div>
						</td>
					</tr>
					<tr valign="top" class="ui-state-default tup-drag">
						<th scope="row">
							<label for="sort_address"><span class="dashicons dashicons-move"></span><?php _e( 'Address', 'team-manager-free' ); ?></label>
						</th>
						<td style="vertical-align: middle;">
							<div style="float:left;width:100%;margin-bottom: 10px;">
								<input type="hidden" name="sort_array[]" value="address">
							</div>
						</td>
					</tr>
					<tr valign="top" class="ui-state-default tup-drag">
						<th scope="row">
							<label for="sort_website"><span class="dashicons dashicons-move"></span><?php _e( 'Website', 'team-manager-free' ); ?></label>
						</th>
						<td style="vertical-align: middle;">
							<div style="float:left;width:100%;margin-bottom: 10px;">
								<input type="hidden" name="sort_array[]" value="website">
							</div>
						</td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>
	    <?php
	}

	function multicolor_add_meta2( $post, $args ) {
		$team_manager_mbgcolor_color  = get_post_meta($post->ID, 'team_manager_mbgcolor_color', true);
		$team_manager_mborder_color   = get_post_meta($post->ID, 'team_manager_mborder_color', true);
		$team_manager_mbcontent_color = get_post_meta($post->ID, 'team_manager_mbcontent_color', true);
		?>

		<div class="wrap">
			<table class="form-table">
				<div class=""><?php echo __( 'Display different colors for each team member,', 'team-manager-free' ); ?><a href="https://themepoints.com/product/team-showcase-pro/" target="_blank"><?php _e('Upgrade To Pro!', 'team-manager-free');?></a></div>
				<tr valign="top">
					<th scope="row">
						<label for="team_manager_mbgcolor_color"><?php echo __( 'Background Color', 'team-manager-free' ); ?></label>
						<span class="team_manager_hint toss"><?php echo __( 'Set the background color of an individual team member item.', 'team-manager-free' ); ?></span>
					</th>
					<td style="vertical-align:middle;">
						<input size='10' name='team_manager_mbgcolor_color' class='team_manager_mbgcolor_color' type='text' id="team_manager_mbgcolor_color" value="<?php if($team_manager_mbgcolor_color !=''){echo $team_manager_mbgcolor_color;} else{ echo "#f6f7f8";} ?>" /> <br />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="team_manager_mborder_color"><?php echo __( 'Title Color', 'team-manager-free' ); ?></label>
						<span class="team_manager_hint toss"><?php echo __('Set the title color of an individual team member item..', 'team-manager-free' ); ?></span>
					</th>
					<td style="vertical-align:middle;">
						<input size='10' name='team_manager_mborder_color' class='team_manager_mborder_color' type='text' id="team_manager_mborder_color" value="<?php if($team_manager_mborder_color !=''){echo $team_manager_mborder_color;} else{ echo "#007acc";} ?>" /> <br />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="team_manager_mbcontent_color"><?php echo __( 'Content Color', 'team-manager-free' ); ?></label>
						<span class="team_manager_hint toss"><?php echo __( 'Set the content color of an individual team member item.', 'team-manager-free' ); ?></span>
					</th>
					<td style="vertical-align:middle;">
						<input size='10' name='team_manager_mbcontent_color' class='team_manager_mbcontent_color' type='text' id="team_manager_mbcontent_color" value="<?php if($team_manager_mbcontent_color !=''){echo $team_manager_mbcontent_color;} else{ echo "#333333";} ?>" /> <br />
					</td>
				</tr>
			</table>
			<script type="text/javascript">
				jQuery(document).ready(function($){
					$('#team_manager_mbgcolor_color, #team_manager_mborder_color, #team_manager_mbcontent_color').wpColorPicker();
				});
			</script>
		</div>
		<?php
	}

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
		$team_manager_free_post_column            = get_post_meta( $post->ID, 'team_manager_free_post_column', true) ?: '4';
		$team_manager_free_laptop_columns         = get_post_meta( $post->ID, 'team_manager_free_laptop_columns', true) ?: '3';
		$team_manager_free_tablet_columns         = get_post_meta( $post->ID, 'team_manager_free_tablet_columns', true) ?: '2';
		$team_manager_free_mobile_columns         = get_post_meta( $post->ID, 'team_manager_free_mobile_columns', true) ?: '1';
		$team_manager_free_margin_bottom          = get_post_meta( $post->ID, 'team_manager_free_margin_bottom', true );
		$team_manager_free_padding_left           = get_post_meta( $post->ID, 'team_manager_free_padding_left', true );
		$team_manager_free_margin_lfr             = get_post_meta( $post->ID, 'team_manager_free_margin_lfr', true );
		$team_manager_free_social_target          = get_post_meta( $post->ID, 'team_manager_free_social_target', true );
		$team_manager_social_nofollow             = get_post_meta( $post->ID, 'team_manager_social_nofollow', true);
		$team_manager_free_text_alignment         = get_post_meta( $post->ID, 'team_manager_free_text_alignment', true );
		$team_manager_free_multicolor_hide        = get_post_meta( $post->ID, 'team_manager_free_multicolor_hide', true );
		$team_manager_free_emails_hide            = get_post_meta( $post->ID, 'team_manager_free_emails_hide', true ) ?: '0';
		$team_manager_free_emails_font_color      = get_post_meta( $post->ID, 'team_manager_free_emails_font_color', true );
		$team_manager_free_emails_hover_color     = get_post_meta( $post->ID, 'team_manager_free_emails_hover_color', true );
		$team_manager_free_emails_font_size       = get_post_meta( $post->ID, 'team_manager_free_emails_font_size', true );
		$team_manager_free_biography_option       = get_post_meta( $post->ID, 'team_manager_free_biography_option', true );
		$team_manager_free_header_font_size       = get_post_meta( $post->ID, 'team_manager_free_header_font_size', true );
		$team_manager_name_font_weight            = get_post_meta( $post->ID, 'team_manager_name_font_weight', true );
		$team_manager_name_font_style             = get_post_meta( $post->ID, 'team_manager_name_font_style', true );
		$team_manager_free_image_hide             = get_post_meta( $post->ID, 'team_manager_free_image_hide', true );
		$team_manager_free_image_zoom             = get_post_meta( $post->ID, 'team_manager_free_image_zoom', true ) ?: '2';
		$team_manager_free_image_mode             = get_post_meta( $post->ID, 'team_manager_free_image_mode', true );
		$team_manager_free_designation_hide       = get_post_meta( $post->ID, 'team_manager_free_designation_hide', true );
		$team_manager_free_designation_font_size  = get_post_meta( $post->ID, 'team_manager_free_designation_font_size', true );
		$team_manager_free_header_font_color      = get_post_meta( $post->ID, 'team_manager_free_header_font_color', true );
		$team_manager_free_name_hover_font_color  = get_post_meta( $post->ID, 'team_manager_free_name_hover_font_color', true );
		$team_manager_name_font_case              = get_post_meta( $post->ID, 'team_manager_name_font_case', true );
		$team_manager_free_designation_font_color = get_post_meta( $post->ID, 'team_manager_free_designation_font_color', true );
		$team_manager_desig_font_case             = get_post_meta( $post->ID, 'team_manager_desig_font_case', true );
		$team_manager_desig_font_style            = get_post_meta( $post->ID, 'team_manager_desig_font_style', true );
		$team_manager_free_numbers_hide           = get_post_meta( $post->ID, 'team_manager_free_numbers_hide', true ) ?: '0';
		$team_manager_free_numbers_font_size      = get_post_meta( $post->ID, 'team_manager_free_numbers_font_size', true );
		$team_manager_free_numbers_font_color     = get_post_meta( $post->ID, 'team_manager_free_numbers_font_color', true );
		$team_manager_free_numbers_hover_color    = get_post_meta( $post->ID, 'team_manager_free_numbers_hover_color', true );
		$team_manager_free_address_hide           = get_post_meta( $post->ID, 'team_manager_free_address_hide', true ) ?: '0';
		$team_manager_free_addresss_font_color    = get_post_meta( $post->ID, 'team_manager_free_addresss_font_color', true );
		$team_manager_free_addresss_font_size     = get_post_meta( $post->ID, 'team_manager_free_addresss_font_size', true );
		$team_manager_free_website_hide           = get_post_meta( $post->ID, 'team_manager_free_website_hide', true ) ?: '0';
		$team_manager_free_website_font_size      = get_post_meta( $post->ID, 'team_manager_free_website_font_size', true );
		$team_manager_free_website_font_color     = get_post_meta( $post->ID, 'team_manager_free_website_font_color', true );
		$team_manager_free_website_hover_color    = get_post_meta( $post->ID, 'team_manager_free_website_hover_color', true );
		$team_manager_free_biography_font_size    = get_post_meta( $post->ID, 'team_manager_free_biography_font_size', true );
		$team_mf_short_desc_char_limit            = get_post_meta( $post->ID, 'team_mf_short_desc_char_limit', true );
		$team_manager_free_overlay_bg_color       = get_post_meta( $post->ID, 'team_manager_free_overlay_bg_color', true );
		$team_manager_free_biography_font_color   = get_post_meta( $post->ID, 'team_manager_free_biography_font_color', true );
		$team_infoicons_hide                      = get_post_meta( $post->ID, 'team_infoicons_hide', true ) ?: '0';
		$filter_align                             = get_post_meta( $post->ID, 'filter_align', true );
		$filter_free_all_text                     = get_post_meta( $post->ID, 'filter_free_all_text', true );
		$filter_free_all_text                     = !empty( $filter_free_all_text ) ? $filter_free_all_text : __( "All", "team-manager-free" );
		$team_manager_free_show_all               = get_post_meta( $post->ID, 'team_manager_free_show_all', true );
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
		$tmffree_social_style                     = get_post_meta( $post->ID, 'tmffree_social_style', true);
		if (!$tmffree_social_style) {
		$tmffree_social_style                     = 1; // Default style
		}
		$tmffree_social_color                     = get_post_meta( $post->ID, 'tmffree_social_color', true);
		if (!$tmffree_social_color) {
		$tmffree_social_color                     = 1; // Default style
		}
		$tmffree_social_font_size                 = get_post_meta( $post->ID, 'tmffree_social_font_size', true );
		$tmffree_social_icon_color                = get_post_meta( $post->ID, 'tmffree_social_icon_color', true );
		$tmffree_social_bg_color                  = get_post_meta( $post->ID, 'tmffree_social_bg_color', true );
		$tmffree_social_hover_color               = get_post_meta( $post->ID, 'tmffree_social_hover_color', true );
		$tmffree_social_hoverbg_color             = get_post_meta( $post->ID, 'tmffree_social_hoverbg_color', true );
		$team_manager_free_popupbox_hide          = get_post_meta( $post->ID, 'team_manager_free_popupbox_hide', true);
		$team_manager_free_popupbox_positions     = get_post_meta( $post->ID, 'team_manager_free_popupbox_positions', true);
		$item_no                                  = get_post_meta( $post->ID, 'item_no', true) ?: '3';
		$itemsdesktop                             = get_post_meta( $post->ID, 'itemsdesktop', true) ?: '3';
		$itemsdesktopsmall                        = get_post_meta( $post->ID, 'itemsdesktopsmall', true) ?: '2';
		$itemsmobile                              = get_post_meta( $post->ID, 'itemsmobile', true) ?: '1';
		$loop                                     = get_post_meta( $post->ID, 'loop', true );
		$lazyload                                 = get_post_meta( $post->ID, 'lazyload', true ) ?: '0';
		$autoheight                               = get_post_meta( $post->ID, 'autoheight', true ) ?: '0';
		$margin                                   = get_post_meta( $post->ID, 'margin', true );
		$navigation                               = get_post_meta( $post->ID, 'navigation', true );
		$pagination                               = get_post_meta( $post->ID, 'pagination', true );
		$autoplay                                 = get_post_meta( $post->ID, 'autoplay', true );
		$autoplay_speed                           = get_post_meta( $post->ID, 'autoplay_speed', true );
		$stop_hover                               = get_post_meta( $post->ID, 'stop_hover', true );
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
		$tmffree_pagination_style                 = get_post_meta( $post->ID, 'tmffree_pagination_style', true );
		if (!$tmffree_pagination_style) {
		$tmffree_pagination_style                 = 1; // Default style
		}
		
		$team_popup_title_hide                    = get_post_meta( $post->ID, 'team_popup_title_hide', true);
		$team_popup_designatins_hide              = get_post_meta( $post->ID, 'team_popup_designatins_hide', true);
		$team_popup_emails_hide                   = get_post_meta( $post->ID, 'team_popup_emails_hide', true);
		$team_popup_contacts_hide                 = get_post_meta( $post->ID, 'team_popup_contacts_hide', true);
		$team_popup_address_hide                  = get_post_meta( $post->ID, 'team_popup_address_hide', true);
		$team_popup_website_hide                  = get_post_meta( $post->ID, 'team_popup_website_hide', true);
		$team_popup_infoicons_hide                = get_post_meta( $post->ID, 'team_popup_infoicons_hide', true);
		$nav_value                                = get_post_meta( $post->ID, 'nav_value', true );
		$selected_size                            = get_post_meta( $post->ID, '_tmf_selected_image_size', true ) ?: 'medium';
		$custom_width                             = get_post_meta( $post->ID, '_tmf_custom_width', true );
		$custom_height                            = get_post_meta( $post->ID, '_tmf_custom_height', true );

	    global $_wp_additional_image_sizes;
	    $image_sizes = get_intermediate_image_sizes();
	    $options = [];

	    foreach ( $image_sizes as $size_name ) {
	        if ( in_array( $size_name, ['thumbnail', 'medium', 'medium_large', 'large'], true ) ) {
	            $options[ $size_name ] = ucfirst( $size_name ) . ' - ' . ( get_option( "{$size_name}_crop" ) ? 'hard:' : 'soft:' ) . get_option( "{$size_name}_size_w" ) . 'x' . get_option( "{$size_name}_size_h" );
	        } elseif ( isset( $_wp_additional_image_sizes[ $size_name ] ) ) {
	            $options[ $size_name ] = ucfirst( $size_name ) . ' - ' . ( $_wp_additional_image_sizes[ $size_name ]['crop'] ? 'hard:' : 'soft:' ) . $_wp_additional_image_sizes[ $size_name ]['width'] . 'x' . $_wp_additional_image_sizes[ $size_name ]['height'];
	        }
	    }

	    $options['original'] = __( 'Original uploaded image', 'team-manager-free' );
	    $options['custom']   = __( 'Set custom size (Pro)', 'team-manager-free' );
	?>

	<div class="tupsetings post-grid-metabox">
		<!-- <div class="wrap"> -->
		<ul class="tab-nav">
			<li nav="1" class="nav1 <?php if($nav_value == 1){echo "active";}?>"><span class="dashicons dashicons-clipboard"></span><?php _e('Team Query','team-manager-free'); ?></li>
			<li nav="2" class="nav2 <?php if($nav_value == 2){echo "active";}?>"><span class="dashicons dashicons-admin-settings"></span><?php _e('All Settings ','team-manager-free'); ?></li>
			<li nav="3" class="nav3 <?php if($nav_value == 3){echo "active";}?>"><span class="dashicons dashicons-grid-view"></span><?php _e( 'Grid Settings','team-manager-free' ); ?></li>
			<li nav="4" class="nav4 <?php if($nav_value == 4){echo "active";}?>"><span class="dashicons dashicons-slides"></span><?php _e( 'Slider Settings','team-manager-free' ); ?></li>
			<li nav="5" class="nav5 <?php if($nav_value == 5){echo "active";}?>"><span class="dashicons dashicons-external"></span><?php _e('Popup Settings','team-manager-free'); ?></li>
			<li nav="6" class="nav6 <?php if($nav_value == 6){echo "active";}?>"><span class="dashicons dashicons-share"></span><?php _e('Social Settings','team-manager-free'); ?></li>
		</ul> <!-- tab-nav end -->
		<?php 
			$getNavValue = "";
			if(!empty($nav_value)){ $getNavValue = $nav_value; } else { $getNavValue = 1; }
		?>
		<input type="hidden" name="nav_value" id="nav_value" value="<?php echo $getNavValue; ?>"> 

		<ul class="box">
			<!-- Tab 1 -->
			<li style="<?php if($nav_value == 1){echo "display: block;";} else{ echo "display: none;"; }?>" class="box1 tab-box <?php if($nav_value == 1){echo "active";}?>">
				<div class="wrap">
					<div class="option-box">
						<p class="option-title"><?php _e('Team Query','team-manager-free'); ?></p>
						<table class="form-table">
							<tr valign="top">
								<th scope="row">
									<label for="team_manager_free_category_select"><?php _e('Select Categories', 'team-manager-free'); ?></label>
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
									<span class="team_manager_hint toss"><?php _e( 'Select a layout to display the team.', 'team-manager-free' ); ?></span>
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
							        <label for="team_manager_free_post_column"><?php echo __('Team Column', 'team-manager-free'); ?></label>
							        <span class="team_manager_hint toss"><?php echo __('Set number of columns in different responsive devices.', 'team-manager-free'); ?></span>
							    </th>
							    <td style="vertical-align:middle;">
									<div class="pic-device-columns">
									    <!-- Desktop Columns -->
									    <label for="team_manager_free_post_column" class="tp-device-label">
									        <div class="tp-device-header">
									            <span class="dashicons dashicons-desktop"></span>
									            <span>Desktop</span>
									        </div>
									        <input type="number" name="team_manager_free_post_column" id="team_manager_free_post_column" value="<?php echo esc_attr($team_manager_free_post_column); ?>" min="1" max="6">
									    </label>

									    <!-- Laptop Columns -->
									    <label for="team_manager_free_laptop_columns" class="tp-device-label">
									        <div class="tp-device-header">
									            <span class="dashicons dashicons-laptop"></span>
									            <span>Laptop</span>
									        </div>
									        <input type="number" min="1" max="6" name="team_manager_free_laptop_columns" id="team_manager_free_laptop_columns" value="<?php echo esc_attr($team_manager_free_laptop_columns); ?>">
									    </label>

									    <!-- Tablet Columns -->
									    <label for="team_manager_free_tablet_columns" class="tp-device-label">
									        <div class="tp-device-header">
									            <span class="dashicons dashicons-tablet"></span>
									            <span>Tablet</span>
									        </div>
									        <input type="number" name="team_manager_free_tablet_columns" id="team_manager_free_tablet_columns" value="<?php echo esc_attr($team_manager_free_tablet_columns); ?>" min="1" max="6">
									    </label>

									    <!-- Mobile Columns -->
									    <label for="team_manager_free_mobile_columns" class="tp-device-label">
									        <div class="tp-device-header">
									            <span class="dashicons dashicons-smartphone"></span>
									            <span>Mobile</span>
									        </div>
									        <input type="number" name="team_manager_free_mobile_columns" id="team_manager_free_mobile_columns" value="<?php echo esc_attr($team_manager_free_mobile_columns); ?>" min="1" max="6">
									    </label>
									</div>
							    </td>
							</tr>
							<!-- End Choose Team Column -->

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_free_limits"><?php _e( 'Member Limit', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Limit number of team members to show. For all leave it empty.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="number" name="team_manager_free_limits" id="team_manager_free_limits" class="timezone_string" value="<?php echo esc_attr($team_manager_free_limits); ?>" placeholder="All">
								</td>
							</tr>
							<!-- End column Margin Bottom -->

							<tr valign="top">
								<th scope="row">
									<label for="teamf_orderby"><?php echo __('Order By', 'team-manager-free'); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Select an order by option.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<select name="teamf_orderby" id="teamf_orderby" class="timezone_string">
										<option value="date" <?php if ( isset ( $teamf_orderby ) ) selected( $teamf_orderby, 'date' ); ?>><?php _e('Publish Date', 'team-manager-free'); ?></option>
										<option value="title" <?php if ( isset ( $teamf_orderby ) ) selected( $teamf_orderby, 'title' ); ?>><?php _e('Title', 'team-manager-free'); ?></option>
										<option value="ID" <?php if ( isset ( $teamf_orderby ) ) selected( $teamf_orderby, 'ID' ); ?>><?php _e('ID', 'team-manager-free'); ?></option>
										<option value="author" <?php if ( isset ( $teamf_orderby ) ) selected( $teamf_orderby, 'author' ); ?>><?php _e('Author', 'team-manager-free'); ?></option>
										<option value="name" <?php if ( isset ( $teamf_orderby ) ) selected( $teamf_orderby, 'name' ); ?>><?php _e('Name', 'team-manager-free'); ?></option>
										<option value="menu_order" <?php if ( isset ( $teamf_orderby ) ) selected( $teamf_orderby, 'menu_order' ); ?>><?php _e('Menu Order', 'team-manager-free'); ?></option>
										<option value="rand" <?php if ( isset ( $teamf_orderby ) ) selected( $teamf_orderby, 'rand' ); ?>><?php _e('Random', 'team-manager-free'); ?></option>
									</select>
								</td>
							</tr>
							<!-- End Team Order By -->

							<tr valign="top">
								<th scope="row">
									<label for="teamf_order"><?php echo __( 'Order', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Select an order option.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<select name="teamf_order" id="teamf_order" class="timezone_string">
										<option value="ASC" <?php if ( isset ( $teamf_order ) ) selected( $teamf_order, 'ASC' ); ?>><?php _e('Ascending (A-Z)', 'team-manager-free'); ?></option>
										<option value="DESC" <?php if ( isset ( $teamf_order ) ) selected( $teamf_order, 'DESC' ); ?>><?php _e('Descending (Z-A)', 'team-manager-free'); ?></option>
									</select>
								</td>
							</tr>
							<!-- End Team Order -->

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_free_padding_left"><?php _e( 'Space Between Members', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __('Set the distance between team members.', 'team-manager-free'); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="number" name="team_manager_free_padding_left" id="team_manager_free_padding_left" min="0" max="100" class="timezone_string" required value="<?php  if($team_manager_free_padding_left !=''){echo $team_manager_free_padding_left; }else{ echo '15';} ?>">
								</td>
							</tr>
							<!-- End column Padding Left -->

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_free_margin_bottom"><?php echo __('Margin Between Members', 'team-manager-free'); ?></label>
									<span class="team_manager_hint toss"><?php echo __('Set the distance between rows of team members.', 'team-manager-free'); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input type="number" name="team_manager_free_margin_bottom" id="team_manager_free_margin_bottom" min="0" maxlength="4" class="timezone_string" required value="<?php  if($team_manager_free_margin_bottom !=''){echo $team_manager_free_margin_bottom; }else{ echo '30';} ?>">
								</td>
							</tr>
							<!-- End column Margin Bottom -->

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

			<!-- Tab 2 -->
			<li style="<?php if($nav_value == 2){echo "display: block;";} else{ echo "display: none;"; }?>" class="box2 tab-box <?php if($nav_value == 2){echo "active";}?>">
				<div class="wrap">
					<div class="option-box">
						<p class="option-title"><?php _e('All Settings','team-manager-free'); ?></p>
						<table class="form-table">

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_free_header_font_size"><?php echo __('Name Font Size', 'team-manager-free'); ?></label>
									<span class="team_manager_hint toss"><?php echo __('Set name font size.', 'team-manager-free'); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input type="number" name="team_manager_free_header_font_size" id="team_manager_free_header_font_size" maxlength="4" class="timezone_string" value="<?php  if($team_manager_free_header_font_size !=''){echo $team_manager_free_header_font_size; }else{ echo '20';} ?>">
								</td>
							</tr>
							<!-- End Name Font Size -->

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_name_font_case"><?php echo __('Name Text Transform', 'team-manager-free'); ?></label>
									<span class="team_manager_hint toss"><?php echo __('Set Text Transform.', 'team-manager-free'); ?></span>
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
									<span class="team_manager_hint toss"><?php echo __('Set Text Style.', 'team-manager-free'); ?></span>
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
									<span class="team_manager_hint toss"><?php echo __('Set Font Weight.', 'team-manager-free'); ?></span>
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
									<span class="team_manager_hint toss"><?php echo __('Set name font color.', 'team-manager-free'); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input type="text" name="team_manager_free_header_font_color" id="team_manager_free_header_font_color" class="timezone_string" value="<?php  if($team_manager_free_header_font_color !=''){echo $team_manager_free_header_font_color; }else{ echo '#007acc';} ?>">
								</td>
							</tr>
							<!-- End Name Font Color -->

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_free_name_hover_font_color"><?php echo __('Name Hover Font Color', 'team-manager-free'); ?></label>
									<span class="team_manager_hint toss"><?php echo __('Set name hover font color.', 'team-manager-free'); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input type="text" name="team_manager_free_name_hover_font_color" id="team_manager_free_name_hover_font_color" class="timezone_string" value="<?php  if($team_manager_free_name_hover_font_color !=''){echo $team_manager_free_name_hover_font_color; }else{ echo '#333333';} ?>">
								</td>
							</tr>
							<!-- End Name Hover Font Color -->

							<tr valign="top">
								<th scope="row">
									<label style="color:red" for="team_manager_free_image_hide"><?php _e( 'Member Image', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Show/Hide member image.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="image_true" name="team_manager_free_image_hide" value="1" <?php if ( $team_manager_free_image_hide == '1' || $team_manager_free_image_hide == '') echo 'checked'; ?>/>
										<label for="image_true"><?php _e( 'Show', 'team-manager-free' ); ?></label>

										<input type="radio" id="image_false" name="team_manager_free_image_hide" value="0" <?php if ( $team_manager_free_image_hide == '0' ) echo 'checked'; ?>/>
										<label for="image_false" class="image_false"><?php _e( 'Hide', 'team-manager-free' ); ?></label>
									</div>
								</td>
							</tr>
							<!-- End Show/Hide Member Image -->

							<tr valign="top">
							    <th scope="row">
							        <label for="tmf_image_size"><?php _e( 'Image Dimensions', 'team-manager-free' ); ?></label>
							        <span class="team_manager_hint toss"><?php echo __( 'Choose an image size to display perfectly', 'team-manager-free' ); ?></span>
							    </th>
							    <td style="vertical-align: middle;">
							        <select id="tmf_image_size" name="tmf_selected_image_size">
							            <?php
								            foreach ( $options as $key => $label ) {
								                echo '<option value="' . esc_attr( $key ) . '" ' . selected( $selected_size, $key, false ) . '>' . esc_html( $label ) . '</option>';
								            }
							            ?>
							        </select>

							        <!-- Custom size input fields -->
							        <div id="custom_size_fields" style="display: <?php echo ( $selected_size === 'custom' ? 'block' : 'none' ); ?>; margin-top: 10px;">
							            <label><?php _e( 'Width:', 'team-manager-free' ); ?></label>
							            <input type="number" disabled name="tmf_custom_width" id="tmf_custom_width" value="<?php echo esc_attr( $custom_width ); ?>" placeholder="Width in px" /><?php _e( 'px', 'team-manager-free' ); ?><br/><br/>
							            <label><?php _e( 'Height:', 'team-manager-free' ); ?></label>
							            <input type="number" disabled name="tmf_custom_height" id="tmf_custom_height" value="<?php echo esc_attr( $custom_height ); ?>" placeholder="Height in px" /><?php _e( 'px', 'team-manager-free' ); ?>
							        </div>
							    </td>
							</tr>

							<script>
							    document.addEventListener("DOMContentLoaded", function() {
							        var sizeSelect = document.getElementById("tmf_image_size");
							        var customFields = document.getElementById("custom_size_fields");

							        sizeSelect.addEventListener("change", function() {
							            if (this.value === "custom") {
							                customFields.style.display = "block";
							            } else {
							                customFields.style.display = "none";
							            }
							        });
							    });
							</script>
							<!-- End Image Size -->

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_free_image_zoom"><?php _e( 'Zoom', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Select a zoom effect for image on hover.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<select name="team_manager_free_image_zoom" id="team_manager_free_image_zoom" class="timezone_string">
										<option value="1" <?php if ( isset ( $team_manager_free_image_zoom ) ) selected( $team_manager_free_image_zoom, '1' ); ?>><?php _e('Default', 'team-manager-free');?></option>
										<option value="2" <?php if ( isset ( $team_manager_free_image_zoom ) ) selected( $team_manager_free_image_zoom, '2' ); ?>><?php _e('Zoom In', 'team-manager-free');?></option>
									</select><br>
								</td>
							</tr>
							<!-- End Image Zoom -->

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_free_image_mode"><?php _e( 'Image Mode', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Set a mode for the image.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<select name="team_manager_free_image_mode" id="team_manager_free_image_mode" class="timezone_string">
										<option value="0" <?php if ( isset ( $team_manager_free_image_mode ) ) selected( $team_manager_free_image_mode, '0' ); ?>><?php _e('Normal', 'team-manager-free');?></option>
										<option disabled value="1" <?php if ( isset ( $team_manager_free_image_mode ) ) selected( $team_manager_free_image_mode, '1' ); ?>><?php _e('Grayscale (Pro)', 'team-manager-free');?></option>
										<option disabled value="2" <?php if ( isset ( $team_manager_free_image_mode ) ) selected( $team_manager_free_image_mode, '2' ); ?>><?php _e('Grayscale on Hover (Pro)', 'team-manager-free');?></option>
									</select><br>
								</td>
							</tr>
							<!-- End Image Mode -->

							<tr valign="top">
								<th scope="row">
									<label style="color:red" for="team_manager_free_designation_hide"><?php _e( 'Designation', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Show/Hide Designation.', 'team-manager-free' ); ?></span>
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
									<span class="team_manager_hint toss"><?php echo __('Set Designation Font Size.', 'team-manager-free'); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input type="number" name="team_manager_free_designation_font_size" id="team_manager_free_designation_font_size" maxlength="4" class="timezone_string" value="<?php  if($team_manager_free_designation_font_size !=''){echo $team_manager_free_designation_font_size; }else{ echo '15';} ?>">
								</td>
							</tr>
							<!-- End Designation Font Size -->

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_free_designation_font_color"><?php echo __('Designation Font Color', 'team-manager-free'); ?></label>
									<span class="team_manager_hint toss"><?php echo __('Set designation font color.', 'team-manager-free'); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input type="text" name="team_manager_free_designation_font_color" id="team_manager_free_designation_font_color" class="timezone_string" value="<?php  if($team_manager_free_designation_font_color !=''){echo $team_manager_free_designation_font_color; }else{ echo '#333333';} ?>">
								</td>
							</tr>
							<!-- End Designation Font Color -->

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_desig_font_case"><?php echo __('Designation Text Transform', 'team-manager-free'); ?></label>
									<span class="team_manager_hint toss"><?php echo __('Set designation Text Transform.', 'team-manager-free'); ?></span>
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
									<span class="team_manager_hint toss"><?php echo __( 'Set designation text style.', 'team-manager-free' ); ?></span>
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
									<span class="team_manager_hint toss"><?php echo __( 'Show/Hide Email.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="emails_true" name="team_manager_free_emails_hide" disabled value="1" <?php if ( $team_manager_free_emails_hide == '1' || $team_manager_free_emails_hide == '') echo 'checked'; ?>/>
										<label for="emails_true"><?php _e( 'Show', 'team-manager-free' ); ?><span class="mark"><?php _e( 'Pro', 'team-manager-free' ); ?></span></label>

										<input type="radio" id="emails_false" name="team_manager_free_emails_hide" value="0" <?php if ( $team_manager_free_emails_hide == '0' ) echo 'checked'; ?>/>
										<label for="emails_false" class="emails_false"><?php _e( 'Hide', 'team-manager-free' ); ?></label>
									</div>
								</td>
							</tr>
							<!-- End show/hide Email -->

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_free_emails_font_size"><?php _e( 'Email Font Size', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Set email font size.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="number" name="team_manager_free_emails_font_size" id="team_manager_free_emails_font_size" min="10" max="45" class="timezone_string" required value="<?php  if($team_manager_free_emails_font_size !=''){echo $team_manager_free_emails_font_size; }else{ echo '14';} ?>"> <br />
								</td>
							</tr>
							<!-- End Email Font Size -->

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_free_emails_font_color"><?php echo __( 'Email Font Color', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Set email font color.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input size='10' name='team_manager_free_emails_font_color' class='team-manager-free-emails-font-color' type='text' id="team_manager_free_emails_font_color" value="<?php if($team_manager_free_emails_font_color !=''){echo $team_manager_free_emails_font_color;} else{ echo "#666666";} ?>" /> <br />
								</td>
							</tr>
							<!-- End Email Font Color -->

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_free_emails_hover_color"><?php echo __( 'Email Hover Color', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Set email hover font color.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input size='10' name='team_manager_free_emails_hover_color' class='team-manager-free-emails-font-color' type='text' id="team_manager_free_emails_hover_color" value="<?php if($team_manager_free_emails_hover_color !=''){echo $team_manager_free_emails_hover_color;} else{ echo "#666666";} ?>" /> <br />
								</td>
							</tr>
							<!-- End Email Hover Font Color -->

							<tr valign="top">
								<th scope="row">
									<label style="color:red" for="team_manager_free_numbers_hide"><?php _e( 'Number', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Show/Hide Number.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="numbers_true" name="team_manager_free_numbers_hide" disabled value="1" <?php if ( $team_manager_free_numbers_hide == '1' || $team_manager_free_numbers_hide == '') echo 'checked'; ?>/>
										<label for="numbers_true"><?php _e( 'Show', 'team-manager-free' ); ?><span class="mark"><?php _e( 'Pro', 'team-manager-free' ); ?></span></label>

										<input type="radio" id="numbers_false" name="team_manager_free_numbers_hide" value="0" <?php if ( $team_manager_free_numbers_hide == '0' ) echo 'checked'; ?>/>
										<label for="numbers_false" class="numbers_false"><?php _e( 'Hide', 'team-manager-free' ); ?></label>
									</div><br>
								</td>
							</tr>
							<!-- End Number -->

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_free_numbers_font_size"><?php _e( 'Number Font Size', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Set number font size.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="number" name="team_manager_free_numbers_font_size" id="team_manager_free_numbers_font_size" min="10" max="45" class="timezone_string" required value="<?php  if($team_manager_free_numbers_font_size !=''){echo $team_manager_free_numbers_font_size; }else{ echo '14';} ?>"> <br />
								</td>
							</tr>
							<!-- End Number Font Size -->

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_free_numbers_font_color"><?php echo __( 'Number Font Color', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Set number font color.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input size='10' name='team_manager_free_numbers_font_color' class='team-manager-free-numbers-font-color' type='text' id="team_manager_free_numbers_font_color" value="<?php if($team_manager_free_numbers_font_color !=''){echo $team_manager_free_numbers_font_color;} else{ echo "#666666";} ?>" /> <br />
								</td>
							</tr>
							<!-- End Number Font Color -->

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_free_numbers_hover_color"><?php echo __( 'Number Hover Color', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Set numer hover font color.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input size='10' name='team_manager_free_numbers_hover_color' class='team-manager-free-emails-font-color' type='text' id="team_manager_free_numbers_hover_color" value="<?php if($team_manager_free_numbers_hover_color !=''){echo $team_manager_free_numbers_hover_color;} else{ echo "#666666";} ?>" /> <br />
								</td>
							</tr>
							<!-- End Member Hover Font Color -->

							<tr valign="top">
								<th scope="row">
									<label style="color:red" for="team_manager_free_address_hide"><?php _e( 'Address', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Show/Hide Address.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="address_true" name="team_manager_free_address_hide" disabled value="1" <?php if ( $team_manager_free_address_hide == '1' || $team_manager_free_address_hide == '') echo 'checked'; ?>/>
										<label for="address_true"><?php _e( 'Show', 'team-manager-free' ); ?><span class="mark"><?php _e( 'Pro', 'team-manager-free' ); ?></span></label>

										<input type="radio" id="address_false" name="team_manager_free_address_hide" value="0" <?php if ( $team_manager_free_address_hide == '0' ) echo 'checked'; ?>/>
										<label for="address_false" class="address_false"><?php _e( 'Hide', 'team-manager-free' ); ?></label>
									</div><br>
								</td>
							</tr>
							<!-- End Show/Hide Address -->

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_free_addresss_font_size"><?php _e( 'Address Font Size', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Set address font size.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="number" name="team_manager_free_addresss_font_size" id="team_manager_free_addresss_font_size" min="10" max="45" class="timezone_string" required value="<?php  if($team_manager_free_addresss_font_size !=''){echo $team_manager_free_addresss_font_size; }else{ echo '14';} ?>"> <br />
								</td>
							</tr>
							<!-- End Address Font Size -->

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_free_addresss_font_color"><?php echo __( 'Address Font Color', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Set address font color.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input size='10' name='team_manager_free_addresss_font_color' class='team-manager-free-address-font-color' type='text' id="team_manager_free_addresss_font_color" value="<?php if($team_manager_free_addresss_font_color !=''){echo $team_manager_free_addresss_font_color;} else{ echo "#666666";} ?>" /> <br />
								</td>
							</tr>
							<!-- End Address Font Color -->

							<tr valign="top">
								<th scope="row">
									<label style="color:red" for="team_manager_free_website_hide"><?php _e( 'Website', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Show/Hide Website.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="website_true" name="team_manager_free_website_hide" disabled value="1" <?php if ( $team_manager_free_website_hide == '1' || $team_manager_free_website_hide == '') echo 'checked'; ?>/>
										<label for="website_true"><?php _e( 'Show', 'team-manager-free' ); ?><span class="mark"><?php _e( 'Pro', 'team-manager-free' ); ?></span></label>
										<input type="radio" id="website_false" name="team_manager_free_website_hide" value="0" <?php if ( $team_manager_free_website_hide == '0' ) echo 'checked'; ?>/>
										<label for="website_false" class="website_false"><?php _e( 'Hide', 'team-manager-free' ); ?></label>
									</div>
								</td>
							</tr>
							<!-- End show/hide Website -->

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_free_website_font_size"><?php _e( 'Website Font Size', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Set website font size.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="number" name="team_manager_free_website_font_size" id="team_manager_free_website_font_size" min="10" max="45" class="timezone_string" required value="<?php  if($team_manager_free_website_font_size !=''){echo $team_manager_free_website_font_size; }else{ echo '14';} ?>"> <br />
								</td>
							</tr>
							<!-- End Website Link Font Size -->

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_free_website_font_color"><?php echo __( 'Website Link Color', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Set Website font color.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input size='10' name='team_manager_free_website_font_color' class='team-manager-free-website-font-color' type='text' id="team_manager_free_website_font_color" value="<?php if($team_manager_free_website_font_color !=''){echo $team_manager_free_website_font_color;} else{ echo "#666666";} ?>" /> <br />
								</td>
							</tr>
							<!-- End Website Link Font Color -->

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_free_website_hover_color"><?php echo __( 'Website Link Hover Color', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Set Website link hover font color.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input size='10' name='team_manager_free_website_hover_color' class='team-manager-free-website-font-color' type='text' id="team_manager_free_website_hover_color" value="<?php if($team_manager_free_website_hover_color !=''){echo $team_manager_free_website_hover_color;} else{ echo "#666666";} ?>" /> <br />
								</td>
							</tr>
							<!-- End Website Link Hover Font Color -->

							<tr valign="top">
								<th scope="row">
									<label style="color:red" for="team_manager_free_biography_option"><?php _e( 'Biography', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Show/Hide Member Short Biography.', 'team-manager-free' ); ?></span>
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
									<label for="team_mf_short_desc_char_limit"><?php _e( 'Character Limit', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Set short description character limit.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<span class="prohints"><span class="mark"><?php _e( 'Pro', 'team-manager-free' ); ?></span>
									<input type="number" name="team_mf_short_desc_char_limit" disabled id="team_mf_short_desc_char_limit" class="timezone_string" value="<?php  if($team_mf_short_desc_char_limit !=''){echo $team_mf_short_desc_char_limit; }else{ echo '140';} ?>"> <br /></span>
								</td>
							</tr>
							<!-- End Biography Font Size -->

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_free_biography_font_size"><?php echo __('Biography Font Size', 'team-manager-free'); ?></label>
									<span class="team_manager_hint toss"><?php echo __('Set short description font size.', 'team-manager-free'); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input type="number" name="team_manager_free_biography_font_size" id="team_manager_free_biography_font_size" maxlength="4" class="timezone_string" value="<?php  if($team_manager_free_biography_font_size !=''){echo $team_manager_free_biography_font_size; }else{ echo '15';} ?>">
								</td>
							</tr>
							<!-- End Biography Font Size -->

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_free_biography_font_color"><?php echo __('Biography Font Color', 'team-manager-free'); ?></label>
									<span class="team_manager_hint toss"><?php echo __('Set short description font color.', 'team-manager-free'); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input type="text" name="team_manager_free_biography_font_color" id="team_manager_free_biography_font_color" class="timezone_string" value="<?php  if($team_manager_free_biography_font_color !=''){echo $team_manager_free_biography_font_color; }else{ echo '#000000';} ?>">
								</td>
							</tr>
							<!-- End Biography Font Color -->

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_free_text_alignment"><?php _e( 'All Text Alignment', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Select all Team content position.', 'team-manager-free' ); ?></span>
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
									<span class="team_manager_hint toss"><?php echo __( 'Show/Hide Team Multicolor Option.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="multicolor_true" name="team_manager_free_multicolor_hide" disabled value="1" <?php if ( $team_manager_free_multicolor_hide == '1' ) echo 'checked'; ?>/>
										<label for="multicolor_true"><?php _e( 'Yes', 'team-manager-free' ); ?><span class="mark"><?php _e( 'Pro', 'team-manager-free' ); ?></span></label>

										<input type="radio" id="multicolor_false" name="team_manager_free_multicolor_hide" value="0" <?php if ( $team_manager_free_multicolor_hide == '0' || $team_manager_free_multicolor_hide == '' ) echo 'checked'; ?>/>
										<label for="multicolor_false" class="multicolor_false"><?php _e( 'No', 'team-manager-free' ); ?></label>
									</div><br>
								</td>
							</tr>
							<!-- End Show/Hide Multicolor -->

							<tr valign="top">
								<th scope="row">
									<label for="team_fbackground_color"><?php echo __('Member Background Color', 'team-manager-free'); ?></label>
									<span class="team_manager_hint toss"><?php echo __('Set all team item background color.', 'team-manager-free'); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input type="text" name="team_fbackground_color" id="team_fbackground_color" class="timezone_string" value="<?php  if($team_fbackground_color !=''){echo $team_fbackground_color; }else{ echo '#f8f8f8';} ?>">
								</td>
							</tr>
							<!-- End Member Background Color -->

							<tr valign="top">
								<th scope="row">
									<label style="color:red" for="team_infoicons_hide"><?php _e( 'Show/Hide Icon', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Show/Hide the info icon.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="info_icons_true" name="team_infoicons_hide" disabled value="1" <?php if ( $team_infoicons_hide == '1' || $team_infoicons_hide == '') echo 'checked'; ?>/>
										<label for="info_icons_true"><?php _e( 'Show', 'team-manager-free' ); ?><span class="mark"><?php _e( 'Pro', 'team-manager-free' ); ?></span></label>

										<input type="radio" id="info_icons_false" name="team_infoicons_hide" value="0" <?php if ( $team_infoicons_hide == '0' ) echo 'checked'; ?>/>
										<label for="info_icons_false" class="info_icons_false"><?php _e( 'Hide', 'team-manager-free' ); ?></label>
									</div><br>
								</td>
							</tr>
							<!-- End hide Icon popup page -->

						</table>
					</div>
				</div>
			</li>
			
			<!-- Tab 3 -->
			<li style="<?php if($nav_value == 3){echo "display: block;";} else{ echo "display: none;"; }?>" class="box3 tab-box <?php if($nav_value == 3){echo "active";}?>">
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
									<label for="team_manager_free_show_all"><?php _e( 'Show/Hide All', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Show/Hide All Button.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="show_all_true" name="team_manager_free_show_all" value="1" <?php if ( $team_manager_free_show_all == '1' || $team_manager_free_show_all == '') echo 'checked'; ?>/>
										<label for="show_all_true"><?php _e( 'Show', 'team-manager-free' ); ?></label>

										<input type="radio" id="show_all_false" name="team_manager_free_show_all" value="0" <?php if ( $team_manager_free_show_all == '0' ) echo 'checked'; ?>/>
										<label for="show_all_false" class="show_all_false"><?php _e( 'Hide', 'team-manager-free' ); ?></label>
									</div>
								</td>
							</tr>
							<!-- End Show/Hide Designation -->

							<tr valign="top">
								<th scope="row">
									<label for="filter_free_all_text"><?php esc_html_e( 'All Button Text:', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Set All button text.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align:middle;">
    								<input type="text" id="filter_free_all_text" name="filter_free_all_text" value="<?php echo esc_attr( $filter_free_all_text ); ?>" />
								</td>
							</tr>
							<!-- End Filter Menu Text -->

							<tr valign="top">
								<th scope="row">
									<label for="filter_bg_color"><?php echo __( 'Menu Background', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Set color for filter menu.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input size='10' name='filter_bg_color' class='team-manager-free-header-font-color' type='text' id="filter_bg_color" value="<?php if($filter_bg_color !=''){echo $filter_bg_color;} else{ echo "#efefef";} ?>" />
								</td>
							</tr>
							<!-- End Filter Menu Background -->

							<tr valign="top">
								<th scope="row">
									<label for="filter_mfont_color"><?php echo __( 'Menu Font Color', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Set color for filter menu text.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input size='10' name='filter_mfont_color' class='team-manager-free-header-font-color' type='text' id="filter_mfont_color" value="<?php if($filter_mfont_color !=''){echo $filter_mfont_color;} else{ echo "#000000";} ?>" />
								</td>
							</tr>
							<!-- End Filter Menu Menu Font Color -->

							<tr valign="top">
								<th scope="row">
									<label for="filter_border_color"><?php echo __( 'Menu Border', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Set color for filter Menu border.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input size='10' name='filter_border_color' class='team-manager-free-header-font-color' type='text' id="filter_border_color" value="<?php if($filter_border_color !=''){echo $filter_border_color;} else{ echo "#dddddd";} ?>" />
								</td>
							</tr>
							<!-- End Filter Menu Menu Border Color -->

							<tr valign="top">
								<th scope="row">
									<label for="filter_active_color"><?php echo __( 'Menu Active', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Set color for filter Menu active background Color.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input size='10' name='filter_active_color' class='team-manager-free-header-font-color' type='text' id="filter_active_color" value="<?php if($filter_active_color !=''){echo $filter_active_color;} else{ echo "#222f3d";} ?>" /><br>
								</td>
							</tr>
							<!-- End Menu Active Background Color -->

							<tr valign="top">
								<th scope="row">
									<label for="filter_active_font"><?php echo __( 'Menu Active Font', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Set color for filter Menu active font Color.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input size='10' name='filter_active_font' class='team-manager-free-header-font-color' type='text' id="filter_active_font" value="<?php if($filter_active_font !=''){echo $filter_active_font;} else{ echo "#ffffff";} ?>" /><br>
								</td>
							</tr>
							<!-- End Menu Active Font Color -->

							<tr valign="top">
								<th scope="row">
									<label for="filter_hover_color"><?php echo __( 'Menu Hover', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Set color for filter Menu hover background Color.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input size='10' name='filter_hover_color' class='team-manager-free-header-font-color' type='text' id="filter_hover_color" value="<?php if($filter_hover_color !=''){echo $filter_hover_color;} else{ echo "#222f3d";} ?>" /><br>
								</td>
							</tr>
							<!-- End Menu Hover Background Color -->

							<tr valign="top">
								<th scope="row">
									<label for="filter_hover_tcolor"><?php echo __( 'Menu Hover Font', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Set color for filter Menu hover text Color.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input size='10' name='filter_hover_tcolor' class='team-manager-free-header-font-color' type='text' id="filter_hover_tcolor" value="<?php if($filter_hover_tcolor !=''){echo $filter_hover_tcolor;} else{ echo "#ffffff";} ?>" /><br>
								</td>
							</tr>
							<!-- End Menu Hover Font Color -->

							<tr valign="top">
								<th scope="row">
									<label for="filter_border_radius"><?php _e( 'Border Radius', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Set Buttom Border Radius.', 'team-manager-free' ); ?></span>
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

			<!-- Tab 4 -->
			<li style="<?php if($nav_value == 4){echo "display: block;";} else{ echo "display: none;"; }?>" class="box4 tab-box <?php if($nav_value == 4){echo "active";}?>">
				<div class="wrap">
					<div class="option-box">
						<p class="option-title"><?php _e('Slider Settings','team-manager-free'); ?> <a href="https://themepoints.com/product/team-showcase-pro/" target="_blank"><?php _e('Upgrade To Pro!', 'team-manager-free');?></a></p>
						<table class="form-table">
							<tr valign="top">
								<th scope="row">
									<label for="autoplay"><?php _e( 'Autoplay', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Enable/Disable auto play.', 'team-manager-free' ); ?></span>
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
									<span class="team_manager_hint toss"><?php echo __( 'Enable/Disable slider pause on hover.', 'team-manager-free' ); ?></span>
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
									<span class="team_manager_hint toss"><?php echo __( 'Select an option for autoplay time out.', 'team-manager-free' ); ?></span></th>
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
							        <label for="item_no"><?php echo __('Member Per Slide', 'team-manager-free'); ?></label>
							        <span class="team_manager_hint toss"><?php echo __('Set members per slide at a time.', 'team-manager-free'); ?></span>
							    </th>
							    <td style="vertical-align:middle;">
									<div class="pic-device-columns">
									    <!-- Desktop Columns -->
									    <label for="item_no" class="tp-device-label">
									        <div class="tp-device-header">
									            <span class="dashicons dashicons-desktop"></span>
									            <span>Desktop</span>
									        </div>
									        <input type="number" name="item_no" id="item_no" value="<?php echo esc_attr($item_no); ?>" min="1" max="10">
									    </label>

									    <!-- Laptop Columns -->
									    <label for="itemsdesktop" class="tp-device-label">
									        <div class="tp-device-header">
									            <span class="dashicons dashicons-laptop"></span>
									            <span>Laptop</span>
									        </div>
									        <input type="number" name="itemsdesktop" id="itemsdesktop" value="<?php echo esc_attr($itemsdesktop); ?>" min="1" max="10">
									    </label>

									    <!-- Tablet Columns -->
									    <label for="itemsdesktopsmall" class="tp-device-label">
									        <div class="tp-device-header">
									            <span class="dashicons dashicons-tablet"></span>
									            <span>Tablet</span>
									        </div>
									        <input type="number" name="itemsdesktopsmall" id="itemsdesktopsmall" value="<?php echo esc_attr($itemsdesktopsmall); ?>" min="1" max="10">
									    </label>

									    <!-- Mobile Columns -->
									    <label for="itemsmobile" class="tp-device-label">
									        <div class="tp-device-header">
									            <span class="dashicons dashicons-smartphone"></span>
									            <span>Mobile</span>
									        </div>
									        <input type="number" name="itemsmobile" id="itemsmobile" value="<?php echo esc_attr($itemsmobile); ?>" min="1" max="10">
									    </label>
									</div>
							    </td>
							</tr>
							<!-- End Choose Team Column -->

							<tr valign="top">
								<th scope="row">
									<label for="loop"><?php _e( 'Loop', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Enable/Disable infinite loop mode.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="loop_true" name="loop" value="true" <?php if ( $loop == 'true' || $loop == '' ) echo 'checked'; ?>/>
										<label for="loop_true"><?php _e( 'Yes', 'team-manager-free' ); ?></label>
										<input type="radio" id="loop_false" name="loop" value="false" <?php if ( $loop == 'false' ) echo 'checked'; ?>/>
										<label for="loop_false" class="loop_false"><?php _e( 'No', 'team-manager-free' ); ?></label>
									</div>
								</td>
							</tr>
							<!-- End Loop -->

							<tr valign="top">
							    <th scope="row">
							        <label for="autoheight"><?php _e( 'autoHeight', 'team-manager-free' ); ?></label>
							        <span class="team_manager_hint toss"><?php echo __( 'Enable/Disable autoheight mode.', 'team-manager-free' ); ?></span>
							    </th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="autoheight_true" name="autoheight" value="1" <?php if ( $autoheight == '1' || $autoheight == '') echo 'checked'; ?>/>
										<label for="autoheight_true"><?php _e( 'Yes', 'team-manager-free' ); ?></label>

										<input type="radio" id="autoheight_false" name="autoheight" value="0" <?php if ( $autoheight == '0' ) echo 'checked'; ?>/>
										<label for="autoheight_false" class="autoheight_false"><?php _e( 'No', 'team-manager-free' ); ?></label>
									</div><br>
								</td>
							</tr>
							<!-- End autoHeight -->

							<tr valign="top">
								<th scope="row">
									<label for="lazyload"><?php _e( 'LazyLoad', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Enable/Disable lazyload mode.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="lazyload_true" name="lazyload" value="1" <?php if ( $lazyload == '1' || $lazyload == '') echo 'checked'; ?>/>
										<label for="lazyload_true"><?php _e( 'Yes', 'team-manager-free' ); ?></label>

										<input type="radio" id="lazyload_false" name="lazyload" value="0" <?php if ( $lazyload == '0' ) echo 'checked'; ?>/>
										<label for="lazyload_false" class="lazyload_false"><?php _e( 'No', 'team-manager-free' ); ?></label>
									</div><br>
								</td>
							</tr>
							<!-- End LazyLoad -->

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
									<span class="team_manager_hint toss"><?php echo __( 'Set the alignment of navigation arrows.', 'team-manager-free' ); ?></span>		
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
									<span class="team_manager_hint toss"><?php echo __( 'Set style for navigation arrows.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<div class="switch-field">
										<input type="radio" id="navigation_btn_1" name="navigation_btn_style" value="0" <?php if ( $navigation_btn_style == '0' ) echo 'checked'; ?>/>
										<label for="navigation_btn_1"><?php _e( 'Square', 'team-manager-free' ); ?></label>
										<input type="radio" id="navigation_btn_2" name="navigation_btn_style" value="50" <?php if ( $navigation_btn_style == '50' || $navigation_btn_style == '' ) echo 'checked'; ?>/>
										<label for="navigation_btn_2"><?php _e( 'Round', 'team-manager-free' ); ?></label>
									</div>
								</td>
							</tr>
							<!-- End Navigation Button Style -->

							<tr valign="top">
								<th scope="row">
									<label for="nav_text_color"><?php echo __( 'Navigation Color', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Set color for the navigation arrows.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input size='10' name='nav_text_color' class='team-manager-free-header-font-color' type='text' id="nav_text_color" value="<?php if($nav_text_color !=''){echo $nav_text_color;} else{ echo "#000000";} ?>" /><br>
								</td>
							</tr>
							<!-- End Navigation Color -->

							<tr valign="top">
								<th scope="row">
									<label for="nav_bg_color"><?php echo __( 'Navigation Background', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Set Background color for the navigation arrows.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input size='10' name='nav_bg_color' class='team-manager-free-header-font-color' type='text' id="nav_bg_color" value="<?php if($nav_bg_color !=''){echo $nav_bg_color;} else{ echo "#dddddd";} ?>" /><br>
								</td>
							</tr>
							<!-- End Navigation Background Color -->

							<tr valign="top">
								<th scope="row">
									<label for="nav_hover_text_color"><?php echo __( 'Navigation Hover Color', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Set hover color for the navigation arrows.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input size='10' name='nav_hover_text_color' class='team-manager-free-header-font-color' type='text' id="nav_hover_text_color" value="<?php if($nav_hover_text_color !=''){echo $nav_hover_text_color;} else{ echo "#000000";} ?>" /><br>
								</td>
							</tr>
							<!-- End Navigation Hover Text Color -->

							<tr valign="top">
								<th scope="row">
									<label for="nav_hover_bg_color"><?php echo __( 'Navigation Hover Background', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Set background hover color for the navigation arrows.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input size='10' name='nav_hover_bg_color' class='team-manager-free-header-font-color' type='text' id="nav_hover_bg_color" value="<?php if($nav_hover_bg_color !=''){echo $nav_hover_bg_color;} else{ echo "#dddddd";} ?>" /><br>
								</td>
							</tr>
							<!-- End Navigation Hover Background -->

							<tr valign="top">
								<th scope="row">
									<label for="pagination"><?php _e( 'Pagination', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Show/Hide Pagination.', 'team-manager-free' ); ?></span>	
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
									<span class="team_manager_hint toss"><?php echo __( 'Set the alignment of pagination dots.' ); ?></span>
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
							        <label for="tmffree_pagination_style"><?php _e( 'Pagination Style', 'team-manager-free' ); ?></label>
							        <span class="team_manager_hint toss"><?php esc_html_e( 'Set style for pagination.', 'team-manager-free' ); ?></span>
							    </th>
							    <td style="vertical-align: middle;">
							        <div class="tmffree-pagination-options">
							            <label class="tmffree-pagination-option">
							                <input type="radio" name="tmffree_pagination_style" value="1" data-value="1" <?php checked($tmffree_pagination_style, '1'); ?>>
							                <img src="<?php echo esc_url(plugin_dir_url(__FILE__) . 'assets/pagination-style-one.png'); ?>" class="tmffree-pagination-image">
							            </label>
							            <label class="tmffree-pagination-option">
							                <input type="radio" name="tmffree_pagination_style" value="2" data-value="2" <?php checked($tmffree_pagination_style, '2'); ?>>
							                <img src="<?php echo esc_url(plugin_dir_url(__FILE__) . 'assets/pagination-style-two.png'); ?>" class="tmffree-pagination-image">
							            </label>
							            <label class="tmffree-pagination-option">
							                <input type="radio" name="tmffree_pagination_style" value="3" data-value="3" <?php checked($tmffree_pagination_style, '3'); ?>>
							                <img src="<?php echo esc_url(plugin_dir_url(__FILE__) . 'assets/pagination-style-three.png'); ?>" class="tmffree-pagination-image">
							            </label>
							            <label class="tmffree-pagination-option">
							                <input type="radio" name="tmffree_pagination_style" value="4" data-value="4" <?php checked($tmffree_pagination_style, '4'); ?>>
							                <img src="<?php echo esc_url(plugin_dir_url(__FILE__) . 'assets/pagination-style-four.png'); ?>" class="tmffree-pagination-image">
							            </label>
							        </div>
							    </td>
							</tr>

							<script>
							jQuery(document).ready(function($) {
							    $('.tmffree-pagination-option input').on('change', function() {
							        $('.tmffree-pagination-image').css('border-color', 'transparent'); // Reset border
							        $(this).siblings('.tmffree-pagination-image').css('border-color', '#0073aa'); // Add border to selected
							    });

							    // Set the initial selected border on page load
							    $('.tmffree-pagination-option input:checked').siblings('.tmffree-pagination-image').css('border-color', '#0073aa');
							});
							</script>

							<tr valign="top">
								<th scope="row">
									<label for="pagination_bg_color"><?php echo __('Pagination Background', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Set background color for the pagination dots.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align:middle;">
									<input size='10' name='pagination_bg_color' class='team-manager-free-header-font-color' type='text' id="pagination_bg_color" value="<?php if($pagination_bg_color !=''){echo $pagination_bg_color;} else{ echo "#ddd";} ?>" /><br>
								</td>
							</tr>
							<!-- End Pagination Background Color -->

							<tr valign="top">
								<th scope="row">
									<label for="pagination_active_color"><?php echo __( 'Pagination Active Color', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Set active color for the pagination dots.', 'team-manager-free' ); ?></span>
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

			<!-- Tab 5 -->
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

			<!-- Tab 6 -->
			<li style="<?php if($nav_value == 6){echo "display: block;";} else{ echo "display: none;"; }?>" class="box6 tab-box <?php if($nav_value == 6){echo "active";}?>">
				<div class="wrap">
					<div class="option-box">
						<p class="option-title"><?php _e('Social Icon Settings','team-manager-free'); ?> <a href="https://themepoints.com/product/team-showcase-pro/" target="_blank"><?php _e('Upgrade To Pro!', 'team-manager-free'); ?></a></p>

						<table class="form-table">
							<tr valign="top">
								<th scope="row">
									<label for="team_manager_free_socialicons_hide"><?php _e('Show/Hide Social', 'team-manager-free'); ?></label>
									<span class="team_manager_hint toss"><?php echo __('Show/Hide Social Icons.', 'team-manager-free'); ?></span>
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
                                    <label for="tmffree_social_style"><?php _e( 'Icon Style', 'team-manager-free' ); ?></label>
                                    <span class="team_manager_hint toss"><?php esc_html_e( 'Set social icon style.', 'team-manager-free' ); ?></span>
                                </th>
                                <td style="vertical-align: middle;">
							        <div class="tmffree-pagination-options">
							            <label class="tmffree-pagination-option">
							                <input type="radio" name="tmffree_social_style" value="1" data-value="1" <?php checked($tmffree_social_style, '1'); ?>>
							                <img src="<?php echo esc_url(plugin_dir_url(__FILE__) . 'assets/social-square.png'); ?>" class="tmffree-pagination-image">
							            </label>
							            <label class="tmffree-pagination-option">
							                <input type="radio" name="tmffree_social_style" value="2" data-value="2" <?php checked($tmffree_social_style, '2'); ?>>
							                <img src="<?php echo esc_url(plugin_dir_url(__FILE__) . 'assets/social-round.png'); ?>" class="tmffree-pagination-image">
							            </label>
							        </div>
                                </td>
                            </tr>
                            <!-- End Icon Style -->

                            <tr valign="top">
                                <th scope="row">
                                    <label for="tmffree_social_color"><?php _e( 'Icon Color Style', 'team-manager-free' ); ?></label>
                                    <span class="team_manager_hint toss"><?php esc_html_e( 'Set social icon style.', 'team-manager-free' ); ?></span>
                                </th>
                                <td style="vertical-align: middle;">
							        <div class="tmffree-social-color-options">
							            <label class="tmffree-social-color-option">
							                <input type="radio" name="tmffree_social_color" value="1" data-value="1" <?php checked($tmffree_social_color, '1'); ?>>
							                <img src="<?php echo esc_url(plugin_dir_url(__FILE__) . 'assets/default-color.png'); ?>" class="tmffree-social-color-image">
							            </label>
							            <label class="tmffree-social-color-option">
							                <input type="radio" name="tmffree_social_color" value="2" data-value="2" <?php checked($tmffree_social_color, '2'); ?>>
							                <img src="<?php echo esc_url(plugin_dir_url(__FILE__) . 'assets/custom-color.png'); ?>" class="tmffree-social-color-image">
							            </label>
							        </div>
                                </td>
                            </tr>
                            <!-- End Icon Style -->

							<tr valign="top">
								<th scope="row">
									<label for="tmffree_social_font_size"><?php _e('Icon Font Size', 'team-manager-free'); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Social Icon Font Size.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input type="number" name="tmffree_social_font_size" id="tmffree_social_font_size" maxlength="4" class="timezone_string" value="<?php  if($tmffree_social_font_size !=''){echo $tmffree_social_font_size; }else{ echo '12';} ?>">
								</td>
							</tr>
							<!-- End Icon Font Size -->

							<tr valign="top">
								<th scope="row">
									<label for="tmffree_social_icon_color"><?php _e('Icon Color', 'team-manager-free'); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Set Social Icon Color.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input size='10' name='tmffree_social_icon_color' class='team-manager-free-header-font-color' type='text' id="tmffree_social_icon_color" value="<?php if($tmffree_social_icon_color !=''){echo $tmffree_social_icon_color;} else{ echo "#000000";} ?>" />
								</td>
							</tr> <!-- End Social Icon Color -->

							<tr valign="top">
								<th scope="row">
									<label for="tmffree_social_bg_color"><?php _e('Icon Background Color', 'team-manager-free'); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Set Social Icon Background Color.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input size='10' name='tmffree_social_bg_color' class='team-manager-free-header-font-color' type='text' id="tmffree_social_bg_color" value="<?php if($tmffree_social_bg_color !=''){echo $tmffree_social_bg_color;} else{ echo "#ffffff";} ?>" />
								</td>
							</tr> <!-- End Social Icon Color -->

							<tr valign="top">
								<th scope="row">
									<label for="tmffree_social_hover_color"><?php _e('Icon Hover Color', 'team-manager-free'); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Set Social Icon Hover Color.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input size='10' name='tmffree_social_hover_color' class='team-manager-free-header-font-color' type='text' id="tmffree_social_hover_color" value="<?php if($tmffree_social_hover_color !=''){echo $tmffree_social_hover_color;} else{ echo "#dd3333";} ?>" />
								</td>
							</tr> <!-- End Social Icon Hover Color -->

							<tr valign="top">
								<th scope="row">
									<label for="tmffree_social_hoverbg_color"><?php _e( 'Icon Hover Background Color', 'team-manager-free' ); ?></label>
									<span class="team_manager_hint toss"><?php echo __( 'Set Social Icon Hover Background Color.', 'team-manager-free' ); ?></span>
								</th>
								<td style="vertical-align: middle;">
									<input size='10' name='tmffree_social_hoverbg_color' class='team-manager-free-header-font-color' type='text' id="tmffree_social_hoverbg_color" value="<?php if($tmffree_social_hoverbg_color !=''){echo $tmffree_social_hoverbg_color;} else{ echo "#ffffff";} ?>" />
								</td>
							</tr>
							<!-- End Social Icon Hover Color -->

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

							<tr valign="top">
								<th scope="row">
									<label for="team_manager_social_nofollow"><?php _e( 'Add rel="nofollow" to social links', 'team-manager-free' ); ?></label>
								</th>
								<td style="vertical-align: middle;">
									<input type="checkbox" name="team_manager_social_nofollow" id="team_manager_social_nofollow" value="1" <?php checked($team_manager_social_nofollow, '1'); ?>>
								</td>
							</tr>
							<!-- End Open Social Link -->

						</table>
					</div>
				</div>
			</li>

		</ul>
	</div>
	<script type="text/javascript">
		jQuery(document).ready(function(jQuery){
			jQuery('#team_manager_free_header_font_color,#team_manager_free_biography_font_color,#team_manager_free_name_hover_font_color,#team_manager_free_designation_font_color,#team_manager_free_overlay_bg_color, #team_fbackground_color, #team_manager_free_emails_font_color, #team_manager_free_emails_hover_color, #team_manager_free_numbers_font_color, #team_manager_free_numbers_hover_color, #team_manager_free_addresss_font_color, #team_manager_free_website_hover_color, #team_manager_free_website_font_color, #filter_bg_color, #filter_border_color, #filter_mfont_color, #filter_active_color, #filter_hover_tcolor, #filter_hover_color, #filter_active_font, #pagination_bg_color, #pagination_active_color, #nav_text_color, #nav_bg_color, #nav_hover_bg_color, #nav_hover_text_color, #tmffree_social_bg_color, #tmffree_social_hover_color, #tmffree_social_icon_color, #tmffree_social_hoverbg_color').wpColorPicker();
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

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST['team_manager_free_category_select'] ) ) {
		    if ( is_array( $_POST['team_manager_free_category_select'] ) ) {
		        // Sanitize each value in the array
		        $sanitized_cats = array_map( 'sanitize_text_field', $_POST['team_manager_free_category_select'] );
		    } else {
		        // Sanitize the single value if not an array
		        $sanitized_cats = sanitize_text_field( $_POST['team_manager_free_category_select'] );
		    }
		    update_post_meta( $post_id, 'team_manager_free_category_select', $sanitized_cats );
		} else {
		    update_post_meta( $post_id, 'team_manager_free_category_select', 'unchecked' );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_manager_free_post_themes' ] ) ) {
			$team_manager_free_post_themes = sanitize_text_field( $_POST['team_manager_free_post_themes'] );
			update_post_meta( $post_id, 'team_manager_free_post_themes', $team_manager_free_post_themes );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_manager_free_theme_style' ] ) ) {
			$team_manager_free_theme_style = sanitize_text_field( $_POST['team_manager_free_theme_style'] );
			update_post_meta( $post_id, 'team_manager_free_theme_style', $team_manager_free_theme_style );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_manager_free_limits' ] ) ) {
			$team_manager_free_limits = intval( $_POST['team_manager_free_limits'] );
			update_post_meta( $post_id, 'team_manager_free_limits', $team_manager_free_limits );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'teamf_orderby' ] ) ) {
			$teamf_orderby = sanitize_text_field( $_POST['teamf_orderby'] );
			update_post_meta( $post_id, 'teamf_orderby', $teamf_orderby );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'teamf_order' ] ) ) {
			$teamf_order = sanitize_text_field( $_POST['teamf_order'] );
			update_post_meta( $post_id, 'teamf_order', $teamf_order );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_manager_free_post_column' ] ) ) {
			$team_manager_free_post_column = sanitize_text_field( $_POST['team_manager_free_post_column'] );
			update_post_meta( $post_id, 'team_manager_free_post_column', $team_manager_free_post_column );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_manager_free_laptop_columns' ] ) ) {
			$team_manager_free_laptop_columns = sanitize_text_field( $_POST['team_manager_free_laptop_columns'] );
			update_post_meta( $post_id, 'team_manager_free_laptop_columns', $team_manager_free_laptop_columns );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_manager_free_tablet_columns' ] ) ) {
			$team_manager_free_tablet_columns = sanitize_text_field( $_POST['team_manager_free_tablet_columns'] );
			update_post_meta( $post_id, 'team_manager_free_tablet_columns', $team_manager_free_tablet_columns );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_manager_free_mobile_columns' ] ) ) {
			$team_manager_free_mobile_columns = sanitize_text_field( $_POST['team_manager_free_mobile_columns'] );
			update_post_meta( $post_id, 'team_manager_free_mobile_columns', $team_manager_free_mobile_columns );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_manager_free_margin_bottom' ] ) ) {
			$team_manager_free_margin_bottom = sanitize_text_field( $_POST['team_manager_free_margin_bottom'] );
			update_post_meta( $post_id, 'team_manager_free_margin_bottom', $team_manager_free_margin_bottom );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_manager_free_padding_left' ] ) ) {
			$team_manager_free_padding_left = sanitize_text_field( $_POST['team_manager_free_padding_left'] );
			update_post_meta( $post_id, 'team_manager_free_padding_left', $team_manager_free_padding_left );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_manager_free_margin_lfr' ] ) ) {
			$team_manager_free_margin_lfr = sanitize_text_field( $_POST['team_manager_free_margin_lfr'] );
			update_post_meta( $post_id, 'team_manager_free_margin_lfr', $team_manager_free_margin_lfr );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_manager_free_text_alignment' ] ) ) {
			$team_manager_free_text_alignment = sanitize_text_field( $_POST['team_manager_free_text_alignment'] );
			update_post_meta( $post_id, 'team_manager_free_text_alignment', $team_manager_free_text_alignment );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_manager_free_multicolor_hide' ] ) ) {
			$team_manager_free_multicolor_hide = sanitize_text_field( $_POST['team_manager_free_multicolor_hide'] );
			update_post_meta( $post_id, 'team_manager_free_multicolor_hide', $team_manager_free_multicolor_hide );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_manager_free_biography_option' ] ) ) {
			$team_manager_free_biography_option = sanitize_text_field( $_POST['team_manager_free_biography_option'] );
			update_post_meta( $post_id, 'team_manager_free_biography_option', $team_manager_free_biography_option );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_manager_free_header_font_size' ] ) ) {
			$team_manager_free_header_font_size = sanitize_text_field( $_POST['team_manager_free_header_font_size'] );
			update_post_meta( $post_id, 'team_manager_free_header_font_size', $team_manager_free_header_font_size );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_manager_name_font_weight' ] ) ) {
			$team_manager_name_font_weight = sanitize_text_field( $_POST['team_manager_name_font_weight'] );
			update_post_meta( $post_id, 'team_manager_name_font_weight', $team_manager_name_font_weight );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_manager_name_font_style' ] ) ) {
			$team_manager_name_font_style = sanitize_text_field( $_POST['team_manager_name_font_style'] );
			update_post_meta( $post_id, 'team_manager_name_font_style', $team_manager_name_font_style );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_manager_free_image_hide' ] ) ) {
			$team_manager_free_image_hide = sanitize_text_field( $_POST['team_manager_free_image_hide'] );
			update_post_meta( $post_id, 'team_manager_free_image_hide', $team_manager_free_image_hide );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'tmf_selected_image_size' ] ) ) {
			$tmf_selected_image_size = sanitize_text_field( $_POST['tmf_selected_image_size'] );
			update_post_meta( $post_id, 'tmf_selected_image_size', $tmf_selected_image_size );
		}

		// Checks for input and sanitizes/saves if needed
	    if ( isset( $_POST['tmf_custom_width'] ) && isset( $_POST['tmf_custom_height'] ) ) {
	        update_post_meta( $post_id, '_tmf_custom_width', intval( $_POST['tmf_custom_width'] ) );
	        update_post_meta( $post_id, '_tmf_custom_height', intval( $_POST['tmf_custom_height'] ) );
	    }

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_manager_free_image_zoom' ] ) ) {
			$team_manager_free_image_zoom = sanitize_text_field( $_POST['team_manager_free_image_zoom'] );
			update_post_meta( $post_id, 'team_manager_free_image_zoom', $team_manager_free_image_zoom );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_manager_free_image_mode' ] ) ) {
			$team_manager_free_image_mode = sanitize_text_field( $_POST['team_manager_free_image_mode'] );
			update_post_meta( $post_id, 'team_manager_free_image_mode', $team_manager_free_image_mode );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_manager_free_designation_hide' ] ) ) {
			$team_manager_free_designation_hide = sanitize_text_field( $_POST['team_manager_free_designation_hide'] );
			update_post_meta( $post_id, 'team_manager_free_designation_hide', $team_manager_free_designation_hide );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_manager_free_designation_font_size' ] ) ) {
			$team_manager_free_designation_font_size = sanitize_text_field( $_POST['team_manager_free_designation_font_size'] );
			update_post_meta( $post_id, 'team_manager_free_designation_font_size', $team_manager_free_designation_font_size );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_manager_free_header_font_color' ] ) ) {
			$team_manager_free_header_font_color = sanitize_hex_color( $_POST['team_manager_free_header_font_color'] );
			update_post_meta( $post_id, 'team_manager_free_header_font_color', $team_manager_free_header_font_color );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_manager_free_name_hover_font_color' ] ) ) {
			$team_manager_free_name_hover_font_color = sanitize_hex_color( $_POST['team_manager_free_name_hover_font_color'] );
			update_post_meta( $post_id, 'team_manager_free_name_hover_font_color', $team_manager_free_name_hover_font_color );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_manager_name_font_case' ] ) ) {
			$team_manager_name_font_case = sanitize_text_field( $_POST['team_manager_name_font_case'] );
			update_post_meta( $post_id, 'team_manager_name_font_case', $team_manager_name_font_case );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_manager_free_designation_font_color' ] ) ) {
			$team_manager_free_designation_font_color = sanitize_hex_color( $_POST['team_manager_free_designation_font_color'] );
			update_post_meta( $post_id, 'team_manager_free_designation_font_color', $team_manager_free_designation_font_color );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_manager_desig_font_case' ] ) ) {
			$team_manager_desig_font_case = sanitize_text_field( $_POST['team_manager_desig_font_case'] );
			update_post_meta( $post_id, 'team_manager_desig_font_case', $team_manager_desig_font_case );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_manager_desig_font_style' ] ) ) {
			$team_manager_desig_font_style = sanitize_text_field( $_POST['team_manager_desig_font_style'] );
			update_post_meta( $post_id, 'team_manager_desig_font_style', $team_manager_desig_font_style );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_manager_free_emails_hide' ] ) ) {
			$team_manager_free_emails_hide = sanitize_text_field( $_POST['team_manager_free_emails_hide'] );
			update_post_meta( $post_id, 'team_manager_free_emails_hide', $team_manager_free_emails_hide );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_manager_free_emails_font_color' ] ) ) {
			$team_manager_free_emails_font_color = sanitize_text_field( $_POST['team_manager_free_emails_font_color'] );
			update_post_meta( $post_id, 'team_manager_free_emails_font_color', $team_manager_free_emails_font_color );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_manager_free_emails_hover_color' ] ) ) {
			$team_manager_free_emails_hover_color = sanitize_hex_color( $_POST['team_manager_free_emails_hover_color'] );
			update_post_meta( $post_id, 'team_manager_free_emails_hover_color', $team_manager_free_emails_hover_color );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_manager_free_emails_font_size' ] ) ) {
			$team_manager_free_emails_font_size = sanitize_text_field( $_POST['team_manager_free_emails_font_size'] );
			update_post_meta( $post_id, 'team_manager_free_emails_font_size', $team_manager_free_emails_font_size );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_manager_free_numbers_hide' ] ) ) {
			$team_manager_free_numbers_hide = sanitize_text_field( $_POST['team_manager_free_numbers_hide'] );
			update_post_meta( $post_id, 'team_manager_free_numbers_hide', $team_manager_free_numbers_hide );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_manager_free_numbers_font_size' ] ) ) {
			$team_manager_free_numbers_font_size = sanitize_text_field( $_POST['team_manager_free_numbers_font_size'] );
			update_post_meta( $post_id, 'team_manager_free_numbers_font_size', $team_manager_free_numbers_font_size );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_manager_free_numbers_hover_color' ] ) ) {
			$team_manager_free_numbers_hover_color = sanitize_hex_color( $_POST['team_manager_free_numbers_hover_color'] );
			update_post_meta( $post_id, 'team_manager_free_numbers_hover_color', $team_manager_free_numbers_hover_color );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_manager_free_numbers_font_color' ] ) ) {
			$team_manager_free_numbers_font_color = sanitize_hex_color( $_POST['team_manager_free_numbers_font_color'] );
			update_post_meta( $post_id, 'team_manager_free_numbers_font_color', $team_manager_free_numbers_font_color );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_manager_free_address_hide' ] ) ) {
			$team_manager_free_address_hide = sanitize_text_field( $_POST['team_manager_free_address_hide'] );
			update_post_meta( $post_id, 'team_manager_free_address_hide', $team_manager_free_address_hide );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_manager_free_addresss_font_color' ] ) ) {
			$team_manager_free_addresss_font_color = sanitize_hex_color( $_POST['team_manager_free_addresss_font_color'] );
			update_post_meta( $post_id, 'team_manager_free_addresss_font_color', $team_manager_free_addresss_font_color );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_manager_free_addresss_font_size' ] ) ) {
			$team_manager_free_addresss_font_size = sanitize_text_field( $_POST['team_manager_free_addresss_font_size'] );
			update_post_meta( $post_id, 'team_manager_free_addresss_font_size', $team_manager_free_addresss_font_size );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_manager_free_website_hide' ] ) ) {
			$team_manager_free_website_hide = sanitize_text_field( $_POST['team_manager_free_website_hide'] );
			update_post_meta( $post_id, 'team_manager_free_website_hide', $team_manager_free_website_hide );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_manager_free_website_font_size' ] ) ) {
			$team_manager_free_website_font_size = sanitize_text_field( $_POST['team_manager_free_website_font_size'] );
			update_post_meta( $post_id, 'team_manager_free_website_font_size', $team_manager_free_website_font_size );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_manager_free_website_hover_color' ] ) ) {
			$team_manager_free_website_hover_color = sanitize_hex_color( $_POST['team_manager_free_website_hover_color'] );
			update_post_meta( $post_id, 'team_manager_free_website_hover_color', $team_manager_free_website_hover_color );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_manager_free_website_font_color' ] ) ) {
			$team_manager_free_website_font_color = sanitize_hex_color( $_POST['team_manager_free_website_font_color'] );
			update_post_meta( $post_id, 'team_manager_free_website_font_color', $team_manager_free_website_font_color );
		}

		// Sanitize and save 'team_mf_short_desc_char_limit' field
		if ( isset( $_POST[ 'team_mf_short_desc_char_limit' ] ) ) {
			$team_mf_short_desc_char_limit = sanitize_text_field( $_POST['team_mf_short_desc_char_limit'] );
			update_post_meta( $post_id, 'team_mf_short_desc_char_limit', $team_mf_short_desc_char_limit );
		}

		// Sanitize and save 'team_mf_short_desc_char_limit' field
		if ( isset( $_POST[ 'team_manager_free_biography_font_size' ] ) ) {
			$team_manager_free_biography_font_size = sanitize_text_field( $_POST['team_manager_free_biography_font_size'] );
			update_post_meta( $post_id, 'team_manager_free_biography_font_size', $team_manager_free_biography_font_size );
		}

		#Checks for input and sanitizes/saves if needed 
		if ( isset( $_POST[ 'autoplay' ] ) ) {
			$autoplay = sanitize_text_field( $_POST['autoplay'] );
			update_post_meta( $post_id, 'autoplay', $autoplay );
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

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST['stop_hover'] ) && !empty( $_POST['stop_hover'] ) ) {
		    $stop_hover = sanitize_text_field( $_POST['stop_hover'] );
		    update_post_meta( $post_id, 'stop_hover', $stop_hover );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'item_no' ] ) ) {
			$item_no = sanitize_text_field( $_POST['item_no'] );
			update_post_meta( $post_id, 'item_no', $item_no );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'itemsdesktop' ] ) ) {
			$itemsdesktop = sanitize_text_field( $_POST['itemsdesktop'] );
			update_post_meta( $post_id, 'itemsdesktop', $itemsdesktop );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'itemsdesktopsmall' ] ) ) {
			$itemsdesktopsmall = sanitize_text_field( $_POST['itemsdesktopsmall'] );
			update_post_meta( $post_id, 'itemsdesktopsmall', $itemsdesktopsmall );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'itemsmobile' ] ) ) {
			$itemsmobile = sanitize_text_field( $_POST['itemsmobile'] );
			update_post_meta( $post_id, 'itemsmobile', $itemsmobile );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST['autoplaytimeout'] ) && !empty( $_POST['autoplaytimeout'] ) ) {
		    $autoplaytimeout = sanitize_text_field( $_POST['autoplaytimeout'] );
		    update_post_meta( $post_id, 'autoplaytimeout', $autoplaytimeout );
		}

		// Checks for input and sanitizes/saves if needed  
		if ( isset( $_POST['loop'] ) && !empty( $_POST['loop'] ) ) {
		    $loop = sanitize_text_field( $_POST['loop'] );
		    update_post_meta( $post_id, 'loop', $loop );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'lazyload' ] ) ) {
			$lazyload = sanitize_text_field( $_POST['lazyload'] );
			update_post_meta( $post_id, 'lazyload', $lazyload );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'autoheight' ] ) ) {
			$autoheight = sanitize_text_field( $_POST['autoheight'] );
			update_post_meta( $post_id, 'autoheight', $autoheight );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'nav_text_color' ] ) ) {
			$nav_text_color = sanitize_hex_color( $_POST['nav_text_color'] );
			update_post_meta( $post_id, 'nav_text_color', $nav_text_color );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'nav_hover_bg_color' ] ) ) {
			$nav_hover_bg_color = sanitize_hex_color( $_POST['nav_hover_bg_color'] );
			update_post_meta( $post_id, 'nav_hover_bg_color', $nav_hover_bg_color );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'nav_hover_text_color' ] ) ) {
			$nav_hover_text_color = sanitize_hex_color( $_POST['nav_hover_text_color'] );
			update_post_meta( $post_id, 'nav_hover_text_color', $nav_hover_text_color );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'pagination_bg_color' ] ) ) {
			$pagination_bg_color = sanitize_hex_color( $_POST['pagination_bg_color'] );
			update_post_meta( $post_id, 'pagination_bg_color', $pagination_bg_color );
		}

		#Checks for input and sanitizes/saves if needed    
		if ( isset( $_POST['tmffree_pagination_style'] ) && !empty( $_POST['tmffree_pagination_style'] ) ) {
		    $tmffree_pagination_style = sanitize_text_field( $_POST['tmffree_pagination_style'] );
		    update_post_meta( $post_id, 'tmffree_pagination_style', $tmffree_pagination_style );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'pagination_active_color' ] ) ) {
			$pagination_active_color = sanitize_hex_color( $_POST['pagination_active_color'] );
			update_post_meta( $post_id, 'pagination_active_color', $pagination_active_color );
		}

		#Checks for input and sanitizes/saves if needed    
		if ( isset( $_POST['filter_align'] ) && !empty( $_POST['filter_align'] ) ) {
		    $filter_align = sanitize_text_field( $_POST['filter_align'] );
		    update_post_meta( $post_id, 'filter_align', $filter_align );
		}

		#Checks for input and sanitizes/saves if needed    
		if ( isset( $_POST['filter_free_all_text'] ) && !empty( $_POST['filter_free_all_text'] ) ) {
		    $filter_free_all_text = sanitize_text_field( $_POST['filter_free_all_text'] );
		    update_post_meta( $post_id, 'filter_free_all_text', $filter_free_all_text );
		}

		// Sanitize and save 'team_manager_free_show_all' field
		if ( isset( $_POST[ 'team_manager_free_show_all' ] ) ) {
			$team_manager_free_show_all = sanitize_text_field( $_POST['team_manager_free_show_all'] );
			update_post_meta( $post_id, 'team_manager_free_show_all', $team_manager_free_show_all );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'filter_bg_color' ] ) ) {
			$filter_bg_color = sanitize_hex_color( $_POST['filter_bg_color'] );
			update_post_meta( $post_id, 'filter_bg_color', $filter_bg_color );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'filter_border_color' ] ) ) {
			$filter_border_color = sanitize_hex_color( $_POST['filter_border_color'] );
			update_post_meta( $post_id, 'filter_border_color', $filter_border_color );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'filter_mfont_color' ] ) ) {
			$filter_mfont_color = sanitize_hex_color( $_POST['filter_mfont_color'] );
			update_post_meta( $post_id, 'filter_mfont_color', $filter_mfont_color );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'filter_active_color' ] ) ) {
			$filter_active_color = sanitize_hex_color( $_POST['filter_active_color'] );
			update_post_meta( $post_id, 'filter_active_color', $filter_active_color );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'filter_hover_color' ] ) ) {
			$filter_hover_color = sanitize_hex_color( $_POST['filter_hover_color'] );
			update_post_meta( $post_id, 'filter_hover_color', $filter_hover_color );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'filter_active_font' ] ) ) {
			$filter_active_font = sanitize_hex_color( $_POST['filter_active_font'] );
			update_post_meta( $post_id, 'filter_active_font', $filter_active_font );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'nav_bg_color' ] ) ) {
			$nav_bg_color = sanitize_hex_color( $_POST['nav_bg_color'] );
			update_post_meta( $post_id, 'nav_bg_color', $nav_bg_color );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'filter_hover_tcolor' ] ) ) {
			$filter_hover_tcolor = sanitize_hex_color( $_POST['filter_hover_tcolor'] );
			update_post_meta( $post_id, 'filter_hover_tcolor', $filter_hover_tcolor );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'filter_border_radius' ] ) ) {
			$filter_border_radius = sanitize_text_field( $_POST['filter_border_radius'] );
			update_post_meta( $post_id, 'filter_border_radius', $filter_border_radius );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_manager_free_overlay_bg_color' ] ) ) {
			$team_manager_free_overlay_bg_color = sanitize_hex_color( $_POST['team_manager_free_overlay_bg_color'] );
			update_post_meta( $post_id, 'team_manager_free_overlay_bg_color', $team_manager_free_overlay_bg_color );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_manager_free_biography_font_color' ] ) ) {
			$team_manager_free_biography_font_color = sanitize_hex_color( $_POST['team_manager_free_biography_font_color'] );
			update_post_meta( $post_id, 'team_manager_free_biography_font_color', $team_manager_free_biography_font_color );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_infoicons_hide' ] ) ) {
			$team_infoicons_hide = sanitize_text_field( $_POST['team_infoicons_hide'] );
			update_post_meta( $post_id, 'team_infoicons_hide', $team_infoicons_hide );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_fbackground_color' ] ) ) {
			$team_fbackground_color = sanitize_hex_color( $_POST['team_fbackground_color'] );
			update_post_meta( $post_id, 'team_fbackground_color', $team_fbackground_color );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_manager_free_popupbox_hide' ] ) ) {
			$team_manager_free_popupbox_hide = sanitize_text_field( $_POST['team_manager_free_popupbox_hide'] );
			update_post_meta( $post_id, 'team_manager_free_popupbox_hide', $team_manager_free_popupbox_hide );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_manager_free_popupbox_positions' ] ) ) {
			$team_manager_free_popupbox_positions = sanitize_text_field( $_POST['team_manager_free_popupbox_positions'] );
			update_post_meta( $post_id, 'team_manager_free_popupbox_positions', $team_manager_free_popupbox_positions );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_popup_title_hide' ] ) ) {
			$team_popup_title_hide = sanitize_text_field( $_POST['team_popup_title_hide'] );
			update_post_meta( $post_id, 'team_popup_title_hide', $team_popup_title_hide );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_popup_designatins_hide' ] ) ) {
			$team_popup_designatins_hide = sanitize_text_field( $_POST['team_popup_designatins_hide'] );
			update_post_meta( $post_id, 'team_popup_designatins_hide', $team_popup_designatins_hide );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_popup_emails_hide' ] ) ) {
			$team_popup_emails_hide = sanitize_text_field( $_POST['team_popup_emails_hide'] );
			update_post_meta( $post_id, 'team_popup_emails_hide', $team_popup_emails_hide );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_popup_contacts_hide' ] ) ) {
			$team_popup_contacts_hide = sanitize_text_field( $_POST['team_popup_contacts_hide'] );
			update_post_meta( $post_id, 'team_popup_contacts_hide', $team_popup_contacts_hide );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_popup_address_hide' ] ) ) {
			$team_popup_address_hide = sanitize_text_field( $_POST['team_popup_address_hide'] );
			update_post_meta( $post_id, 'team_popup_address_hide', $team_popup_address_hide );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_manager_free_socialicons_hide' ] ) ) {
			$team_manager_free_socialicons_hide = sanitize_text_field( $_POST['team_manager_free_socialicons_hide'] );
			update_post_meta( $post_id, 'team_manager_free_socialicons_hide', $team_manager_free_socialicons_hide );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'tmffree_social_style' ] ) ) {
			$tmffree_social_style = sanitize_text_field( $_POST['tmffree_social_style'] );
			update_post_meta( $post_id, 'tmffree_social_style', $tmffree_social_style );
		}

		// Sanitize and save 'tmffree_social_color' field
		if ( isset( $_POST[ 'tmffree_social_color' ] ) ) {
			$tmffree_social_color = sanitize_text_field( $_POST['tmffree_social_color'] );
			update_post_meta( $post_id, 'tmffree_social_color', $tmffree_social_color );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'tmffree_social_font_size' ] ) ) {
			$tmffree_social_font_size = sanitize_text_field( $_POST['tmffree_social_font_size'] );
			update_post_meta( $post_id, 'tmffree_social_font_size', $tmffree_social_font_size );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'tmffree_social_icon_color' ] ) ) {
			$tmffree_social_icon_color = sanitize_hex_color( $_POST['tmffree_social_icon_color'] );
			update_post_meta( $post_id, 'tmffree_social_icon_color', $tmffree_social_icon_color );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'tmffree_social_hover_color' ] ) ) {
			$tmffree_social_hover_color = sanitize_hex_color( $_POST['tmffree_social_hover_color'] );
			update_post_meta( $post_id, 'tmffree_social_hover_color', $tmffree_social_hover_color );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'tmffree_social_hoverbg_color' ] ) ) {
			$tmffree_social_hoverbg_color = sanitize_hex_color( $_POST['tmffree_social_hoverbg_color'] );
			update_post_meta( $post_id, 'tmffree_social_hoverbg_color', $tmffree_social_hoverbg_color );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'tmffree_social_bg_color' ] ) ) {
			$tmffree_social_bg_color = sanitize_hex_color( $_POST['tmffree_social_bg_color'] );
			update_post_meta( $post_id, 'tmffree_social_bg_color', $tmffree_social_bg_color );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_manager_free_social_target' ] ) ) {
			$team_manager_free_social_target = sanitize_text_field( $_POST['team_manager_free_social_target'] );
			update_post_meta( $post_id, 'team_manager_free_social_target', $team_manager_free_social_target );
		}

	    $team_manager_social_nofollow = isset($_POST['team_manager_social_nofollow']) ? '1' : '0';
	    update_post_meta($post_id, 'team_manager_social_nofollow', $team_manager_social_nofollow);

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_popup_website_hide' ] ) ) {
			$team_popup_website_hide = sanitize_text_field( $_POST['team_popup_website_hide'] );
			update_post_meta( $post_id, 'team_popup_website_hide', $team_popup_website_hide );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_popup_infoicons_hide' ] ) ) {
			$team_popup_infoicons_hide = sanitize_text_field( $_POST['team_popup_infoicons_hide'] );
			update_post_meta( $post_id, 'team_popup_infoicons_hide', $team_popup_infoicons_hide );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_manager_mbgcolor_color' ] ) ) {
			$team_manager_mbgcolor_color = sanitize_hex_color( $_POST['team_manager_mbgcolor_color'] );
			update_post_meta( $post_id, 'team_manager_mbgcolor_color', $team_manager_mbgcolor_color );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_manager_mborder_color' ] ) ) {
			$team_manager_mborder_color = sanitize_hex_color( $_POST['team_manager_mborder_color'] );
			update_post_meta( $post_id, 'team_manager_mborder_color', $team_manager_mborder_color );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'team_manager_mbcontent_color' ] ) ) {
			$team_manager_mbcontent_color = sanitize_hex_color( $_POST['team_manager_mbcontent_color'] );
			update_post_meta( $post_id, 'team_manager_mbcontent_color', $team_manager_mbcontent_color );
		}

		// Checks for input and sanitizes/saves if needed
		if( isset( $_POST[ 'sort_array' ] ) ) {
			update_post_meta( $post_id, 'sort_array', array_map( 'sanitize_text_field', $_POST[ 'sort_array' ] ) );
		}

		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST[ 'nav_value' ] ) ) {
		    $nav_value = sanitize_text_field( $_POST['nav_value'] ); // Sanitize nav_value input
		    update_post_meta( $post_id, 'nav_value', $nav_value );
		} else {
		    update_post_meta( $post_id, 'nav_value', 1 ); // Default value
		}

	} // end save_notice
	add_action('save_post', 'save_notice');