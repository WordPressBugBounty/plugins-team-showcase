<?php
	if ( ! defined( 'ABSPATH' ) ) {
	    exit;
	}

	# shortocde
	function team_manager_free_register_shortcode( $atts, $content = null ) {
		$atts = shortcode_atts(
			array(
				'id' => "",
			),
			$atts
		);

		global $post, $paged, $query;

		$post_id = $atts['id'];

		$team_manager_free_category_select        = get_post_meta( $post_id, 'team_manager_free_category_select', true);
		$team_manager_free_post_themes            = get_post_meta( $post_id, 'team_manager_free_post_themes', true);
		$team_manager_free_theme_style            = get_post_meta( $post_id, 'team_manager_free_theme_style', true);
		$team_manager_free_limits                 = get_post_meta( $post_id, 'team_manager_free_limits', true);
		// Set the limit (if empty, show all)

		$limit                                    = ! empty( $team_manager_free_limits ) ? (int) $team_manager_free_limits : -1;
		$team_manager_free_post_column            = get_post_meta( $post_id, 'team_manager_free_post_column', true) ?: '4';
		$team_manager_free_laptop_columns         = get_post_meta( $post_id, 'team_manager_free_laptop_columns', true) ?: '3';
		$team_manager_free_tablet_columns         = get_post_meta( $post_id, 'team_manager_free_tablet_columns', true) ?: '2';
		$team_manager_free_mobile_columns         = get_post_meta( $post_id, 'team_manager_free_mobile_columns', true) ?: '1';
		$team_manager_free_margin_bottom          = get_post_meta( $post_id, 'team_manager_free_margin_bottom', true);
		$team_manager_free_padding_left           = get_post_meta( $post_id, 'team_manager_free_padding_left', true);
		$team_manager_free_designation_font_size  = get_post_meta( $post_id, 'team_manager_free_designation_font_size', true);
		$team_manager_free_biography_option       = get_post_meta( $post_id, 'team_manager_free_biography_option', true);
		$team_manager_free_biography_font_size    = get_post_meta( $post_id, 'team_manager_free_biography_font_size', true);
		$team_mf_short_desc_char_limit            = get_post_meta( $post_id, 'team_mf_short_desc_char_limit', true);
		$team_manager_free_social_target          = get_post_meta( $post_id, 'team_manager_free_social_target', true);
		$team_manager_social_nofollow             = get_post_meta( $post_id, 'team_manager_social_nofollow', true);
		$rel_attr                                 = ($team_manager_social_nofollow === '1') ? 'rel="nofollow"' : '';

		// Social Icons Settings
		$team_manager_free_socialicons_hide       = get_post_meta( $post_id, 'team_manager_free_socialicons_hide', true);
		$tmffree_social_style                     = get_post_meta( $post_id, 'tmffree_social_style', true);
		$social_radius                            = ($tmffree_social_style == '1') ? '0px' : '50px';
		$tmffree_social_color                     = get_post_meta( $post_id, 'tmffree_social_color', true);
		$use_inline_style                         = ($tmffree_social_color !== '2'); // Only use inline styles if NOT custom color
		$tmffree_social_icon_color                = get_post_meta( $post_id, 'tmffree_social_icon_color', true);
		$tmffree_social_bg_color                  = get_post_meta( $post_id, 'tmffree_social_bg_color', true);
		$tmffree_social_hover_color               = get_post_meta( $post_id, 'tmffree_social_hover_color', true);
		$tmffree_social_hoverbg_color             = get_post_meta( $post_id, 'tmffree_social_hoverbg_color', true);
		$tmffree_social_font_size                 = get_post_meta( $post_id, 'tmffree_social_font_size', true);
		
		// Biography
		$team_manager_free_biography_font_color   = get_post_meta( $post_id, 'team_manager_free_biography_font_color', true);
		$team_manager_free_overlay_bg_color       = get_post_meta( $post_id, 'team_manager_free_overlay_bg_color', true);
		$team_manager_free_text_alignment         = get_post_meta( $post_id, 'team_manager_free_text_alignment', true);
		$team_manager_free_multicolor_hide        = get_post_meta( $post_id, 'team_manager_free_multicolor_hide', true);
		$team_infoicons_hide                      = get_post_meta( $post_id, 'team_infoicons_hide', true);
		
		// Name
		$team_manager_free_header_font_size       = get_post_meta( $post_id, 'team_manager_free_header_font_size', true);
		$team_manager_name_font_case              = get_post_meta( $post_id, 'team_manager_name_font_case', true);
		$team_manager_name_font_style             = get_post_meta( $post_id, 'team_manager_name_font_style', true);
		$team_manager_name_font_weight            = get_post_meta( $post_id, 'team_manager_name_font_weight', true);
		$team_manager_free_header_font_color      = get_post_meta( $post_id, 'team_manager_free_header_font_color', true);
		$team_manager_free_name_hover_font_color  = get_post_meta( $post_id, 'team_manager_free_name_hover_font_color', true);
		
		// Designation
		$team_manager_free_designation_hide       = get_post_meta( $post_id, 'team_manager_free_designation_hide', true );
		$team_manager_free_designation_font_size  = get_post_meta( $post_id, 'team_manager_free_designation_font_size', true );
		$team_manager_free_designation_font_color = get_post_meta( $post_id, 'team_manager_free_designation_font_color', true);
		$team_manager_desig_font_case             = get_post_meta( $post_id, 'team_manager_desig_font_case', true);
		$team_manager_desig_font_style            = get_post_meta( $post_id, 'team_manager_desig_font_style', true);
		
		// email
		$team_manager_free_emails_hide            = get_post_meta( $post_id, 'team_manager_free_emails_hide', true );
		$team_manager_free_emails_font_color      = get_post_meta( $post_id, 'team_manager_free_emails_font_color', true );
		$team_manager_free_emails_hover_color     = get_post_meta( $post_id, 'team_manager_free_emails_hover_color', true );
		$team_manager_free_emails_font_size       = get_post_meta( $post_id, 'team_manager_free_emails_font_size', true );
		
		// Number
		$team_manager_free_numbers_hide           = get_post_meta( $post_id, 'team_manager_free_numbers_hide', true );
		$team_manager_free_numbers_font_size      = get_post_meta( $post_id, 'team_manager_free_numbers_font_size', true );
		$team_manager_free_numbers_font_color     = get_post_meta( $post_id, 'team_manager_free_numbers_font_color', true );
		$team_manager_free_numbers_hover_color    = get_post_meta( $post_id, 'team_manager_free_numbers_hover_color', true );
		
		// Address
		$team_manager_free_address_hide           = get_post_meta( $post_id, 'team_manager_free_address_hide', true );
		$team_manager_free_addresss_font_color    = get_post_meta( $post_id, 'team_manager_free_addresss_font_color', true );
		$team_manager_free_addresss_font_size     = get_post_meta( $post_id, 'team_manager_free_addresss_font_size', true );
		
		// website
		$team_manager_free_website_hide           = get_post_meta( $post_id, 'team_manager_free_website_hide', true );
		$team_manager_free_website_font_size      = get_post_meta( $post_id, 'team_manager_free_website_font_size', true );
		$team_manager_free_website_font_color     = get_post_meta( $post_id, 'team_manager_free_website_font_color', true );
		$team_manager_free_website_hover_color    = get_post_meta( $post_id, 'team_manager_free_website_hover_color', true );

		// Skills
		$team_manager_free_skills_hide            = get_post_meta( $post_id, 'team_manager_free_skills_hide', true );
		$team_manager_free_skills_font_size       = get_post_meta( $post_id, 'team_manager_free_skills_font_size', true );
		$team_manager_free_skills_font_color      = get_post_meta( $post_id, 'team_manager_free_skills_font_color', true );
		$team_manager_free_percentage_color       = get_post_meta( $post_id, 'team_manager_free_percentage_color', true );
		$team_manager_free_skills_bg_color        = get_post_meta( $post_id, 'team_manager_free_skills_bg_color', true );
		$team_manager_free_skills_line_color      = get_post_meta( $post_id, 'team_manager_free_skills_line_color', true );
		
		// image
		$team_manager_free_image_hide             = get_post_meta( $post_id, 'team_manager_free_image_hide', true );
		$team_manager_free_image_zoom             = get_post_meta( $post_id, 'team_manager_free_image_zoom', true );
		$team_manager_free_image_mode             = get_post_meta( $post_id, 'team_manager_free_image_mode', true );
		
		// Slider settings
		$item_no                                  = get_post_meta( $post_id, 'item_no', true );
		$itemsdesktop                             = get_post_meta( $post_id, 'itemsdesktop', true );
		$itemsdesktopsmall                        = get_post_meta( $post_id, 'itemsdesktopsmall', true );
		$itemsmobile                              = get_post_meta( $post_id, 'itemsmobile', true );
		$autoplaytimeout                          = get_post_meta( $post_id, 'autoplaytimeout', true );
		$loop                                     = get_post_meta( $post_id, 'loop', true );
		$lazyload                                 = get_post_meta( $post_id, 'lazyload', true );
		$autoheight                               = get_post_meta( $post_id, 'autoheight', true );
		$margin                                   = get_post_meta( $post_id, 'margin', true );
		$autoplay                                 = get_post_meta( $post_id, 'autoplay', true );
		$autoplay_speed                           = get_post_meta( $post_id, 'autoplay_speed', true );
		$stop_hover                               = get_post_meta( $post_id, 'stop_hover', true );

		// navigation
		$navigation                               = get_post_meta( $post_id, 'navigation', true );
		$navigation_align                         = get_post_meta( $post_id, 'navigation_align', true );
		$navigation_btn_style                     = get_post_meta( $post_id, 'navigation_btn_style', true );
		$nav_text_color                           = get_post_meta( $post_id, 'nav_text_color', true );
		$nav_bg_color                             = get_post_meta( $post_id, 'nav_bg_color', true );
		$nav_hover_text_color                     = get_post_meta( $post_id, 'nav_hover_text_color', true );
		$nav_hover_bg_color                       = get_post_meta( $post_id, 'nav_hover_bg_color', true );

		// Pagination
		$pagination                               = get_post_meta( $post_id, 'pagination', true );
		$pagination_align                         = get_post_meta( $post_id, 'pagination_align', true );
		$tmffree_pagination_style                 = get_post_meta( $post_id, 'tmffree_pagination_style', true );
		$pagination_bg_color                      = get_post_meta( $post_id, 'pagination_bg_color', true );
		$pagination_active_color                  = get_post_meta( $post_id, 'pagination_active_color', true );

		// Filter Menu settings
		$tmffree_filtermenu_style                 = get_post_meta( $post_id, 'tmffree_filtermenu_style', true );
		$filter_align                             = get_post_meta( $post_id, 'filter_align', true );
		$filter_bg_color                          = get_post_meta( $post_id, 'filter_bg_color', true );
		$filter_border_color                      = get_post_meta( $post_id, 'filter_border_color', true );
		$filter_mfont_color                       = get_post_meta( $post_id, 'filter_mfont_color', true );
		$filter_active_color                      = get_post_meta( $post_id, 'filter_active_color', true );
		$filter_active_font                       = get_post_meta( $post_id, 'filter_active_font', true );
		$filter_hover_color                       = get_post_meta( $post_id, 'filter_hover_color', true );
		$filter_hover_tcolor                      = get_post_meta( $post_id, 'filter_hover_tcolor', true );
		$filter_border_radius                     = get_post_meta( $post_id, 'filter_border_radius', true );
		$team_manager_free_sortbtn                = get_post_meta( $post_id, 'team_manager_free_sortbtn', true );
		$team_manager_free_pagination             = get_post_meta( $post_id, 'team_manager_free_pagination', true );
		$tmf_pagination_type             		  = get_post_meta( $post_id, 'tmf_pagination_type', true );
		$pagination_color                         = get_post_meta( $post_id, 'pagination_color', true );
		$pagination_hover_color                   = get_post_meta( $post_id, 'pagination_hover_color', true );
		$pagination_background                    = get_post_meta( $post_id, 'pagination_background', true );
		$pagination_background_hover              = get_post_meta( $post_id, 'pagination_background_hover', true );
		$pagination_border_color                  = get_post_meta( $post_id, 'pagination_border_color', true );
		$pagination_border_hover_color            = get_post_meta( $post_id, 'pagination_border_hover_color', true );
		$pagination_activep_color                 = get_post_meta( $post_id, 'pagination_activep_color', true );
		$pagination_active_bg                     = get_post_meta( $post_id, 'pagination_active_bg', true );
		$pagination_active_border                 = get_post_meta( $post_id, 'pagination_active_border', true );
		$tmf_pagination_alignment                 = get_post_meta( $post_id, 'tmf_pagination_alignment', true );
		$team_popup_title_hide                    = get_post_meta( $post_id, 'team_popup_title_hide', true);
		$team_popup_designatins_hide              = get_post_meta( $post_id, 'team_popup_designatins_hide', true);
		$team_popup_emails_hide                   = get_post_meta( $post_id, 'team_popup_emails_hide', true);
		$team_popup_contacts_hide                 = get_post_meta( $post_id, 'team_popup_contacts_hide', true);
		$team_popup_address_hide                  = get_post_meta( $post_id, 'team_popup_address_hide', true);
		$team_popup_website_hide                  = get_post_meta( $post_id, 'team_popup_website_hide', true);
		$team_popup_infoicons_hide                = get_post_meta( $post_id, 'team_popup_infoicons_hide', true);
		$team_popup_skills_hide                   = get_post_meta( $post_id, 'team_popup_skills_hide', true);
		$details_type 						      = get_post_meta( $post_id,'team_manager_free_details_page_type',true);
		$layout 								  = get_post_meta( $post_id,'team_manager_free_single_layout',true);

		# Popup Box Settings
		$team_manager_free_popupbox_hide          = get_post_meta( $post_id, 'team_manager_free_popupbox_hide', true);
		$team_manager_free_popupbox_positions     = get_post_meta( $post_id, 'team_manager_free_popupbox_positions', true);
		$team_fbackground_color                   = get_post_meta( $post_id, 'team_fbackground_color', true);
		$teamf_orderby                            = get_post_meta( $post_id, 'teamf_orderby', true);
		$teamf_order                              = get_post_meta( $post_id, 'teamf_order', true);
		$selected_size                            = get_post_meta( $post_id, '_tmf_selected_image_size', true);
		$custom_width                             = get_post_meta( $post_id, '_tmf_custom_width', true);
		$custom_height                            = get_post_meta( $post_id, '_tmf_custom_height', true);

	    if( is_array( $team_manager_free_category_select ) ){
			$tmfree =  array();
			$num 	= count((array)$team_manager_free_category_select);
			for($j=0; $j<$num; $j++){
				array_push($tmfree, $team_manager_free_category_select[$j]);
			}

			$args = array(
				'post_type'      => 'team_mf',
				'post_status'    => 'publish',
				'posts_per_page' => $limit,
				'orderby'        => $teamf_orderby,
				'order'          => $teamf_order,
			    'tax_query' => [
			        'relation' => 'OR',
			        [
			            'taxonomy' => 'team_mfcategory',
			            'field' => 'id',
			            'terms' => $tmfree,
			            'include_children' => false, // 👈 This controls subcategories
			        ],
			        // [
			        //     'taxonomy' => 'team_mfcategory',
			        //     'field' => 'id',
			        //     'operator' => 'NOT EXISTS',
			        // ],
			    ],
			);
	    }else{
			$args = array(
				'post_type'      => 'team_mf',
				'post_status'    => 'publish',
				'posts_per_page' => $limit,
				'orderby'        => $teamf_orderby,
				'order'          => $teamf_order,
			);
	    }

	  	$tmf_query = new WP_Query( $args );

		$allowed_themes = array(
		    'theme1' => 'theme-1.php',
		    'theme2' => 'theme-2.php',
		    'theme3' => 'theme-3.php',
		    'theme4' => 'theme-4.php',
		);

		if ( ! isset( $allowed_themes[ $team_manager_free_post_themes ] ) ) {
		    $team_manager_free_post_themes = 'theme1';
		}

		ob_start();
		include __DIR__ . '/template/' . $allowed_themes[ $team_manager_free_post_themes ];
		return ob_get_clean();

	}
	add_shortcode( 'tmfshortcode', 'team_manager_free_register_shortcode' );