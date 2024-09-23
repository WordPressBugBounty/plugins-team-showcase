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
		$team_manager_free_post_column            = get_post_meta( $post_id, 'team_manager_free_post_column', true);
		$team_manager_free_margin_bottom          = get_post_meta( $post_id, 'team_manager_free_margin_bottom', true);
		$team_manager_free_padding_left           = get_post_meta( $post_id, 'team_manager_free_padding_left', true);
		$team_manager_free_padding_right          = get_post_meta( $post_id, 'team_manager_free_padding_right', true);
		$team_manager_free_imagesize              = get_post_meta( $post_id, 'team_manager_free_imagesize', true);
		$team_manager_free_designation_font_size  = get_post_meta( $post_id, 'team_manager_free_designation_font_size', true);
		$team_manager_free_biography_option       = get_post_meta( $post_id, 'team_manager_free_biography_option', true);
		$team_manager_free_biography_font_size    = get_post_meta( $post_id, 'team_manager_free_biography_font_size', true);
		$team_manager_free_social_target          = get_post_meta( $post_id, 'team_manager_free_social_target', true);

		# Social Icons Settings
		$team_manager_free_socialicons_hide       = get_post_meta( $post_id, 'team_manager_free_socialicons_hide', true);
		$tmffree_social_icon_color                = get_post_meta( $post_id, 'tmffree_social_icon_color', true);
		$tmffree_social_bg_color                  = get_post_meta( $post_id, 'tmffree_social_bg_color', true);
		$tmffree_social_hover_color               = get_post_meta( $post_id, 'tmffree_social_hover_color', true);
		$tmffree_social_font_size                 = get_post_meta( $post_id, 'tmffree_social_font_size', true);
			
		// Biography
		$team_manager_free_biography_font_color   = get_post_meta( $post_id, 'team_manager_free_biography_font_color', true);
		$team_manager_free_overlay_bg_color       = get_post_meta( $post_id, 'team_manager_free_overlay_bg_color', true);
		$team_manager_free_text_alignment         = get_post_meta( $post_id, 'team_manager_free_text_alignment', true);
		$team_manager_free_multicolor_hide        = get_post_meta( $post_id, 'team_manager_free_multicolor_hide', true);
		
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
		
		// Slider
		$item_no                                  = get_post_meta( $post_id, 'item_no', true );
		$loop                                     = get_post_meta( $post_id, 'loop', true );
		$margin                                   = get_post_meta( $post_id, 'margin', true );
		$navigation                               = get_post_meta( $post_id, 'navigation', true );
		$pagination                               = get_post_meta( $post_id, 'pagination', true );
		$autoplay                                 = get_post_meta( $post_id, 'autoplay', true );
		$autoplay_speed                           = get_post_meta( $post_id, 'autoplay_speed', true );
		$stop_hover                               = get_post_meta( $post_id, 'stop_hover', true );
		$autoplaytimeout                          = get_post_meta( $post_id, 'autoplaytimeout', true );
		$itemsdesktop                             = get_post_meta( $post_id, 'itemsdesktop', true );
		$itemsdesktopsmall                        = get_post_meta( $post_id, 'itemsdesktopsmall', true );
		$itemsmobile                              = get_post_meta( $post_id, 'itemsmobile', true );
		$nav_text_color                           = get_post_meta( $post_id, 'nav_text_color', true );	
		$nav_bg_color                             = get_post_meta( $post_id, 'nav_bg_color', true );
		$nav_hover_text_color                     = get_post_meta( $post_id, 'nav_hover_text_color', true );
		$nav_hover_bg_color                       = get_post_meta( $post_id, 'nav_hover_bg_color', true );
		$navigation_align                         = get_post_meta( $post_id, 'navigation_align', true );
		$navigation_btn_style                     = get_post_meta( $post_id, 'navigation_btn_style', true );
		$pagination_bg_color                      = get_post_meta( $post_id, 'pagination_bg_color', true );
		$pagination_active_color                  = get_post_meta( $post_id, 'pagination_active_color', true );
		$pagination_align                         = get_post_meta( $post_id, 'pagination_align', true );
		
		// Filter Menu
		$filter_align                             = get_post_meta( $post_id, 'filter_align', true );
		$filter_bg_color                          = get_post_meta( $post_id, 'filter_bg_color', true );
		$filter_border_color                      = get_post_meta( $post_id, 'filter_border_color', true );
		$filter_mfont_color                       = get_post_meta( $post_id, 'filter_mfont_color', true );
		$filter_active_color                      = get_post_meta( $post_id, 'filter_active_color', true );
		$filter_active_font                       = get_post_meta( $post_id, 'filter_active_font', true );
		$filter_hover_color                       = get_post_meta( $post_id, 'filter_hover_color', true );
		$filter_hover_tcolor                      = get_post_meta( $post_id, 'filter_hover_tcolor', true );
		$filter_border_radius                     = get_post_meta( $post_id, 'filter_border_radius', true );

		$team_popup_title_hide              	  = get_post_meta( $post_id, 'team_popup_title_hide', true);
		$team_popup_designatins_hide              = get_post_meta( $post_id, 'team_popup_designatins_hide', true);
		$team_popup_emails_hide                   = get_post_meta( $post_id, 'team_popup_emails_hide', true);
		$team_popup_contacts_hide                 = get_post_meta( $post_id, 'team_popup_contacts_hide', true);
		$team_popup_address_hide                  = get_post_meta( $post_id, 'team_popup_address_hide', true);
		$team_popup_website_hide                  = get_post_meta( $post_id, 'team_popup_website_hide', true);
		$team_popup_infoicons_hide                = get_post_meta( $post_id, 'team_popup_infoicons_hide', true);

		$team_manager_free_popupbox_positions     = get_post_meta( $post_id, 'team_manager_free_popupbox_positions', true);
		$team_manager_free_img_height             = get_post_meta( $post_id, 'team_manager_free_img_height', true);
		$team_fbackground_color                   = get_post_meta( $post_id, 'team_fbackground_color', true);
		$teamf_orderby                            = get_post_meta( $post_id, 'teamf_orderby', true);
		$teamf_order                              = get_post_meta( $post_id, 'teamf_order', true);

	    if( is_array( $team_manager_free_category_select ) ){
			$tmfree =  array();
			$num 	= count((array)$team_manager_free_category_select);
			for($j=0; $j<$num; $j++){
				array_push($tmfree, $team_manager_free_category_select[$j]);
			}

			$args = array(
				'post_type' => 'team_mf',
				'post_status' => 'publish',
				'posts_per_page' => 10,
				'orderby'	=> $teamf_orderby,
			    'tax_query' => [
			        'relation' => 'OR',
			        [
			            'taxonomy' => 'team_mfcategory',
			            'field' => 'id',
			            'terms' => $tmfree,
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
				'post_type' => 'team_mf',
				'post_status' => 'publish',
				'posts_per_page' => 10,
				'orderby'	=> $teamf_orderby,
			);
	    }

	  	$tmf_query = new WP_Query( $args );

		ob_start();
		switch ( $team_manager_free_post_themes ) {
		    case 'theme1':

		    	include __DIR__ . '/template/theme-1.php';

		        break;
		    case 'theme2':

		    	include __DIR__ . '/template/theme-2.php';

		        break;
		    case 'theme3':

				include __DIR__ . '/template/theme-3.php';
			
		        break; 
		    case 'theme4':

				include __DIR__ . '/template/theme-4.php';

		    break;
		}
		return ob_get_clean();
	}
	add_shortcode( 'tmfshortcode', 'team_manager_free_register_shortcode' );