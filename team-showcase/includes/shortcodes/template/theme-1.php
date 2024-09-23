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

		<?php if( $team_manager_free_imagesize == 1 ){ ?>
			.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .team-manager-free-items-pic img{
				width:100%;
				height: auto;
				transition: .5s linear;
				transform: scale(1);
			}
		<?php }elseif( $team_manager_free_imagesize == 2 ){ ?>
			.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .team-manager-free-items-pic img{
				width:100%;
				height: <?php echo esc_attr( $team_manager_free_img_height ); ?>px;
				transition: .5s linear;
				transform: scale(1);
			}
		<?php } ?>
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .team-manager-free-items .team-manager-free-items-over-laye p {
		    margin: 0;
		    padding: 0;
			font-size: <?php echo esc_attr( $team_manager_free_biography_font_size); ?>px;
			color:<?php echo esc_attr( $team_manager_free_biography_font_color); ?>;
		}
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .team-manager-free-items .team-manager-free-items-pic {
			position: relative;
			overflow: hidden;
		}
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .team-manager-free-items:hover .team-manager-free-items-pic img {
		    -webkit-transform: scale(1.10);
		    -moz-transform: scale(1.10);
		    transform: scale(1.10);
		}
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
			background: #<?php echo esc_attr( $tmffree_social_bg_color); ?>;
			height: 30px;
		    width: 30px;
		    display: inline-block;
		    line-height: 30px;
		    color: #<?php echo esc_attr( $tmffree_social_icon_color); ?>;
		    margin: 0 1px;
			transition: all 0.3s;
		}
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .team-manager-free-items-social li a {
		    color: #<?php echo esc_attr( $tmffree_social_icon_color); ?>;
		    text-decoration: none;
		    outline: none;
		    box-shadow: none;
		}
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .team-manager-free-items-social li:hover {
		    border-radius: 50px;
		    transition: all 0.3s;
		}
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .team-manager-free-items-social li:hover a {
			color:#<?php echo esc_attr( $tmffree_social_hover_color); ?>;
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

				$team_manager_free_client_designation 		= get_post_meta(get_the_ID(), 'client_designation', true);
				$team_manager_free_client_shortdescription 	= get_post_meta(get_the_ID(), 'client_shortdescription', true);
				$team_manager_free_client_email 			= get_post_meta(get_the_ID(), 'contact_email', true);
				$team_manager_free_client_number 			= get_post_meta(get_the_ID(), 'contact_number', true);
				$team_manager_free_client_address 			= get_post_meta(get_the_ID(), 'company_address', true);
				$team_manager_free_client_website 			= get_post_meta(get_the_ID(), 'client_website', true);
				$team_manager_free_social_facebook 			= get_post_meta(get_the_ID(), 'social_facebook', true);
				$team_manager_free_social_twitter 			= get_post_meta(get_the_ID(), 'social_twitter', true);
				$team_manager_free_social_googleplus 		= get_post_meta(get_the_ID(), 'social_googleplus', true);
				$team_manager_free_social_instagram 		= get_post_meta(get_the_ID(), 'social_instagram', true);
				$team_manager_free_social_pinterest 		= get_post_meta(get_the_ID(), 'social_pinterest', true);
				$team_manager_free_social_linkedin 			= get_post_meta(get_the_ID(), 'social_linkedin', true);
				$team_manager_free_social_dribbble 			= get_post_meta(get_the_ID(), 'social_dribbble', true);
				$team_manager_free_social_youtube 			= get_post_meta(get_the_ID(), 'social_youtube', true);
				$team_manager_free_social_skype 			= get_post_meta(get_the_ID(), 'social_skype', true);

				$tpteamfree_social_iconbox_repeat = get_post_meta( get_the_ID(), 'tpteamfree_social_iconbox_repeat', true);

				$thumb_id 		= get_post_thumbnail_id();
				$thumb_url 		= wp_get_attachment_image_src($thumb_id,'thumbnail-size', true);
				$random_team_id = rand();
				?>

				<div class="teamshowcasefree-col-lg-<?php echo esc_attr( $team_manager_free_post_column ); ?> teamshowcasefree-col-md-2 teamshowcasefree-col-sm-2 teamshowcasefree-col-xs-1">
			        <div class="team-manager-free-items">
				        <div class="team-manager-free-items-pic">
				            <a href="#team-popup-area-<?php echo esc_attr( $random_team_id ); ?>" class="open-popup-link" data-effect="mfp-zoom-in">
				              <?php the_post_thumbnail(); ?>
				            </a>
			            	<div class="team-manager-free-items-over-laye">
			            		<?php if( !empty( $team_manager_free_client_shortdescription ) ){ ?>
			              			<p><?php echo esc_html( $team_manager_free_client_shortdescription ); ?></p>
			              		<?php } ?>
				              	<ul class="team-manager-free-items-social">
									<?php include __DIR__ . '/social-info-short.php'; ?>
				              	</ul>
			            	</div>
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