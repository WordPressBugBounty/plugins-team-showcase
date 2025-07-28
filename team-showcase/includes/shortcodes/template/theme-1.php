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
			font-style: <?php echo $team_manager_name_font_style;?>;
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
			font-style: <?php echo $team_manager_desig_font_style;?>;
			text-transform: <?php echo $team_manager_desig_font_case;?>;
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
	        .team-manager-free-main-area-<?php echo esc_attr($post_id); ?> .team-manager-free-items:hover .team-manager-free-items-pic img {
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
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .team-manager-free-items .team-manager-free-items-social {
			list-style-type: none;
			padding: 0;
			margin: 0;
			position: absolute;
			bottom: 20px;
			left: 20px;
			right: 20px;
			opacity: 0; /* Initially hide the social icons */
			transition: opacity 0.3s ease; /* Add smooth transition for opacity */
		}
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .team-manager-free-items:hover .team-manager-free-items-social {
		  opacity: 1; /* Show the social icons */
		}
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .team-manager-free-items-social li {
			display: inline-block;
			margin:5px 0px 0px 0px;
		}
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .team-manager-free-items-social li a{
		    display: flex;
		    -webkit-box-align: center;
		    -ms-flex-align: center;
		    align-items: center;
		    justify-content: center;
			background: <?php echo esc_attr( $tmffree_social_bg_color); ?>;
		    color: <?php echo esc_attr( $tmffree_social_icon_color); ?>;
		    border-radius: <?php echo esc_attr( $social_radius ); ?>;
			height: 30px;
		    width: 30px;
			transition: all 0.3s;
		    text-decoration: none;
		    outline: none;
		    box-shadow: none;
		}
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .team-manager-free-items-social li:hover {
		    transition: all 0.3s;
		}
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .team-manager-free-items-social li a:hover {
			color: <?php echo esc_attr( $tmffree_social_hover_color); ?>;
			background: <?php echo esc_attr( $tmffree_social_hoverbg_color); ?>;
		}

		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .teamshowcasefree-col-lg-1,
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .teamshowcasefree-col-lg-2,
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .teamshowcasefree-col-lg-3,
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .teamshowcasefree-col-lg-4,
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .teamshowcasefree-col-lg-5,
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .teamshowcasefree-col-lg-6,
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .teamshowcasefree-col-md-1,
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .teamshowcasefree-col-md-2,
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .teamshowcasefree-col-md-3,
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .teamshowcasefree-col-md-4,
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .teamshowcasefree-col-md-5,
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .teamshowcasefree-col-md-6,
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .teamshowcasefree-col-sm-1,
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .teamshowcasefree-col-sm-2,
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .teamshowcasefree-col-sm-3,
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .teamshowcasefree-col-sm-4,
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .teamshowcasefree-col-sm-5,
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .teamshowcasefree-col-sm-6,
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .teamshowcasefree-col-xs-1,
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .teamshowcasefree-col-xs-2,
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .teamshowcasefree-col-xs-3,
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .teamshowcasefree-col-xs-4,
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .teamshowcasefree-col-xs-5,
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .teamshowcasefree-col-xs-6 {
			float: left;
			margin-bottom: <?php echo $team_manager_free_margin_bottom;?>px !important;
			min-height: 1px;
			padding-left: <?php echo $team_manager_free_padding_left;?>px !important;
			padding-right: <?php echo $team_manager_free_padding_left;?>px !important;
			position: relative;
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

	<div class="team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?>">
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
				
				$tpteamfree_social_iconbox_repeat          = get_post_meta( get_the_ID(), 'tpteamfree_social_iconbox_repeat', true);
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
				              	<ul class="team-manager-free-items-social">
									<?php include __DIR__ . '/social-info-short.php'; ?>
				              	</ul>
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