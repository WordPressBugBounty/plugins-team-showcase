<?php
	if ( ! defined( 'ABSPATH' ) ) {
	    exit;
	}
?>

	<style type="text/css">
		<?php ob_start(); // Start output buffering ?>
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> {
			display: block;
			overflow: hidden;
		}
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .team-manager-free-container{
		    display: -webkit-box;
		    display: -ms-flexbox;
		    display: flex;
		    -ms-flex-wrap: wrap;
		    flex-wrap: wrap;
		}
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .team-manager-free-items {
			background: <?php echo esc_attr( $team_fbackground_color); ?>;
			border-radius: 0px;
			padding: 0px;
			text-align: center;
		}
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .team-manager-free-items-profiles .team-manager-free-items-title, 
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .team-manager-free-items-profiles .team-manager-free-items-title a {
		    margin: 0;
		    padding: 0;
			color: <?php echo esc_attr( $team_manager_free_header_font_color); ?>;
			font-size: <?php echo esc_attr( $team_manager_free_header_font_size); ?>px;
			font-style: <?php echo esc_attr( $team_manager_name_font_style); ?>;
			text-transform: <?php echo esc_attr( $team_manager_name_font_case); ?>;
			box-shadow: none;
			outline: medium none;
			text-decoration: none;
		}
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .team-manager-free-items-profiles .team-manager-free-items-title a:hover {
			text-decoration:none;
			color:<?php echo esc_attr( $team_manager_free_name_hover_font_color); ?>;
		}
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .team-manager-free-items-profiles .team-manager-free-items-designation {
			color:<?php echo esc_attr( $team_manager_free_designation_font_color); ?>;
			font-size:<?php echo esc_attr( $team_manager_free_designation_font_size); ?>px;
			font-style: <?php echo esc_attr( $team_manager_desig_font_style); ?>;
			text-transform: <?php echo esc_attr( $team_manager_desig_font_case); ?>;
		}
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .team-manager-free-items-profiles {
		    padding: 15px;
		}
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .team-manager-free-items-pic img{
			width:100%;
			height: auto;
			transition: all 0.3s ease-in-out;
		}
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .team-manager-free-items .team-manager-free-items-over-laye p {
		    margin: 0;
		    padding: 0;
			font-size: <?php echo esc_attr( $team_manager_free_biography_font_size); ?>px;
			color:<?php echo esc_attr( $team_manager_free_biography_font_color); ?>;
			line-height: 24px;
		}
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .team-manager-free-items .team-manager-free-items-pic {
			position: relative;
			overflow: hidden;
			line-height: 0;
		}
	    /* Zoom In */
	    <?php if ($team_manager_free_image_zoom == '2') : ?>
	        .team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .team-manager-free-items:hover .team-manager-free-items-pic img {
	            transform: scale(1.10);
	        }
	    <?php endif; ?>
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .team-manager-free-items:hover .team-manager-free-items-over-laye {
			height: 100%; /* Expand the height of the overlay on hover */
			transform: translateY(0); /* Move the overlay into view */
			opacity: 0.9; /* Show the overlay */
		}
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .team-manager-free-items .team-manager-free-items-over-laye {
			display: block;
			position: absolute;
			bottom: 0;
			left: 0;
			width: 100%;
			height: 0;
			background-color:<?php echo esc_attr( $team_manager_free_overlay_bg_color); ?>;
			color: #fff; /* Text color */
			padding: 20px;
			box-sizing: border-box; /* Ensure padding is included in width */
			transition: height 0.3s ease, opacity 0.3s ease, transform 0.3s ease; /* Add smooth transition for height, opacity, and transform */
			transform: translateY(100%); /* Initially move the overlay out of view */
			opacity: 0; /* Initially set opacity to 0 */
		}

		<?php
	    // Get the buffered content
	    $styles = ob_get_clean();
	    // Remove newlines and extra spaces
	    $styles = preg_replace('/\s+/', ' ', $styles);
	    // Output inline styles
	    echo $styles;
	    ?>
	</style>

	<div class="tmf-wrapper <?php echo esc_attr( $team_manager_free_post_themes ); ?>" data-style="<?php echo esc_attr( $team_manager_free_post_themes ); ?>"
     style="
		--tmf-main-padding: <?php echo esc_attr($team_manager_free_margin_bottom); ?>px;
		--tmf-main-padding-left: <?php echo esc_attr($team_manager_free_padding_left); ?>px;
		--tmf-main-padding-right: <?php echo esc_attr($team_manager_free_padding_left); ?>px;
        --tmf-filter-text: <?php echo esc_attr($filter_mfont_color); ?>;
        --tmf-filter-bg: <?php echo esc_attr($filter_bg_color); ?>;
        --tmf-filter-border: <?php echo esc_attr($filter_border_color); ?>;
        --tmf-filter-radius: <?php echo esc_attr($filter_border_radius); ?>px;
        --tmf-filter-activebg: <?php echo esc_attr($filter_active_color); ?>;
        --tmf-filter-activecolor: <?php echo esc_attr($filter_active_font); ?>;
        --tmf-filter-hover-bg: <?php echo esc_attr($filter_hover_color); ?>;
        --tmf-filter-hover-text: <?php echo esc_attr($filter_hover_tcolor); ?>;
        --tmf-filter-padding: <?php echo esc_attr($team_manager_free_padding_left); ?>px;
        --tmf-filter-align: <?php echo esc_attr($filter_align); ?>;
        --tmf-skill-font-size: <?php echo esc_attr($team_manager_free_skills_font_size); ?>px;
        --tmf-skill-font-color: <?php echo esc_attr($team_manager_free_skills_font_color); ?>;
        --tmf-skill-bg: <?php echo esc_attr($team_manager_free_skills_bg_color); ?>;
        --tmf-skill-line: <?php echo esc_attr($team_manager_free_skills_line_color); ?>;
        --tmf-skill-percent-color: <?php echo esc_attr($team_manager_free_percentage_color); ?>;
        --tmf-social-h-color: <?php echo esc_attr($tmffree_social_hover_color); ?>;
        --tmf-social-h-bg-color: <?php echo esc_attr($tmffree_social_hoverbg_color); ?>;
        --tmf-social-icon-size: <?php echo esc_attr($tmffree_social_font_size); ?>px;
        --tmf-social-icon-color: <?php echo esc_attr($tmffree_social_icon_color); ?>;
        --tmf-social-icon-bg: <?php echo esc_attr($tmffree_social_bg_color); ?>;
        --tmf-social-icon-radius: <?php echo esc_attr($social_radius); ?>;
        --tmf-items-alignment: <?php echo esc_attr($team_manager_free_text_alignment); ?>;
		--tmf-img-grayscale: <?php echo ($team_manager_free_image_mode == '1') ? '100%' : '0%'; ?>;
		--tmf-img-hover-grayscale: <?php echo ($team_manager_free_image_mode == '2') ? '100%' : '0%'; ?>;
		--tmf-img-zoom: <?php echo ($team_manager_free_image_zoom == '2') ? '1.10' : '1'; ?>;
     ">

		<div class="team-manager-free-main-area team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?>">
			<div class="team-manager-free-container">
				<?php
				// Creating a new side loop
				while ( $tmf_query->have_posts() ) : $tmf_query->the_post(); global $post;

					$team_manager_free_client_designation      = get_post_meta(get_the_ID(), 'client_designation', true);
					$team_manager_free_client_shortdescription = get_post_meta(get_the_ID(), 'client_shortdescription', true);
					$team_manager_free_client_email            = get_post_meta(get_the_ID(), 'contact_email', true);
					$team_manager_free_client_number           = get_post_meta(get_the_ID(), 'contact_number', true);
					$team_manager_free_client_address          = get_post_meta(get_the_ID(), 'company_address', true);
					$team_manager_free_client_website          = get_post_meta(get_the_ID(), 'client_website', true);
					$tpteamfree_social_iconbox_repeat          = get_post_meta(get_the_ID(), 'tpteamfree_social_iconbox_repeat', true);
					$skills                                    = get_post_meta(get_the_ID(), '_team_skills', true);
					$random_team_id                            = rand();
					?>

					<div class="teamshowcasefree-col-lg-<?php echo esc_attr( $team_manager_free_post_column ); ?> teamshowcasefree-col-md-<?php echo esc_attr( $team_manager_free_laptop_columns ); ?> teamshowcasefree-col-sm-<?php echo esc_attr( $team_manager_free_tablet_columns ); ?> teamshowcasefree-col-xs-<?php echo esc_attr( $team_manager_free_mobile_columns ); ?>">
				        <div class="team-manager-free-items">
					        <div class="team-manager-free-items-pic">
					            <a href="#team-popup-area-<?php echo esc_attr( $random_team_id ); ?>" class="open-popup-link" data-effect="mfp-zoom-in">
					             	<?php
										if ($selected_size === 'custom' && !empty($custom_width) && !empty($custom_height)) {
										    the_post_thumbnail($selected_size);
										} else {
										    the_post_thumbnail($selected_size);
										}
					              	?>
					            </a>
					            <?php if ( !empty( $team_manager_free_client_shortdescription ) || !empty( $tpteamfree_social_iconbox_repeat ) ) { ?>
					            	<div class="team-manager-free-items-over-laye">
					            		<?php if( !empty( $team_manager_free_client_shortdescription ) ){ ?>
					              			<p><?php echo esc_html( $team_manager_free_client_shortdescription ); ?></p>
					              		<?php } ?>

		                              	<?php include __DIR__ . '/skill-bars.php'; ?>

								        <?php if (!empty($tpteamfree_social_iconbox_repeat) && $team_manager_free_socialicons_hide == 1) { ?>
								            <div class="team-manager-social-area">
									            <ul class="team-manager-free-items-social">
									                <?php include __DIR__ . '/social-info-short.php'; ?>
									            </ul>
								            </div>
								        <?php } ?>
					            	</div>
				            	<?php } ?>
				          	</div>

					        <div class="team-manager-free-items-profiles">
					            <div class="team-manager-free-items-title">
					            	<a href="#team-popup-area-<?php echo esc_attr( $random_team_id ); ?>" class="open-popup-link" data-effect="mfp-zoom-in">
					            		<?php the_title(); ?>
					            	</a>
					            </div>

					            <?php if ($team_manager_free_designation_hide == '1' && !empty($team_manager_free_client_designation)) { ?>
					            	<div class="team-manager-free-items-designation"><?php echo esc_html( $team_manager_free_client_designation ); ?></div>
					        	<?php } ?>

								<?php
									switch ($team_manager_free_popupbox_positions) {
									    case '1':
									    		include __DIR__ . '/popup-style-one.php';
									        break;
									    case '2':
									        	include __DIR__ . '/popup-style-two.php';
									        break;
									    case '3':
									        	include __DIR__ . '/popup-style-three.php';
									        break;
									    case '4':
									        	include __DIR__ . '/popup-style-four.php';
									        break;
									}
								?>
					        </div>
				        </div>
					</div>
				<?php endwhile; wp_reset_postdata(); ?>
			</div>
		</div>
	</div>