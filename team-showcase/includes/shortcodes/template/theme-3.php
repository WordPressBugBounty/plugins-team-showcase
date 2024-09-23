<?php
	if( !defined( 'ABSPATH' ) ){
	    exit;
	}
	?>

	<style type="text/css">
		<?php ob_start(); // Start output buffering ?>
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> {
			text-align:center;
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
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .team-manager-free-items-thumbnail{
			position: relative;
			border-radius: 100px;
			width: 200px;
			height: 200px;
			overflow: hidden;
			margin: 0 auto;
		}
		<?php if($team_manager_free_imagesize == 1){ ?>
			.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .team-manager-free-items-thumbnail img{
				width: 100%;
				height: auto;
			}
		<?php }elseif($team_manager_free_imagesize == 2){ ?>
			.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .team-manager-free-items-thumbnail img{
				width: 100%;
				height: <?php echo esc_attr( $team_manager_free_img_height); ?>px;
			}
		<?php } ?>
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .team-manager-free-items .pic-bottom{
			border-radius: 100px;
			box-shadow: none;
			outline: medium none;
			position: absolute;
			left: 0;
			right: 0;
			top: 0;
			transition: all 0.3s ease 0s;
			height: 200px;
			width: 200px;
		}
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .team-manager-free-items .pic-bottom:after{
			content: "\f002";
			font-family: "FontAwesome";
			position: relative;
			top:45%;
			left:0;
			opacity: 0;
			color:#fff;
			font-size: 35px;
			transition:all 0.3s ease 0s;
		}
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .team-manager-free-items .team-manager-free-items-thumbnail:hover .pic-bottom{
			background: <?php echo esc_attr( $team_manager_free_overlay_bg_color ); ?>;
			opacity: 0.9;
		}
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .team-manager-free-items .team-manager-free-items-thumbnail:hover .pic-bottom:after{
			opacity: 1;
		}
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .team-manager-free-items-title a,
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .team-manager-free-items .team-manager-free-items-title{
			color: <?php echo esc_attr( $team_manager_free_header_font_color); ?>;
			font-size: <?php echo esc_attr( $team_manager_free_header_font_size); ?>px;
			font-style: <?php echo $team_manager_name_font_style;?>;
			text-transform: <?php echo esc_attr( $team_manager_name_font_case); ?>;
			font-weight: 600;
			line-height: 1.2;
			margin-bottom: 5px;
			margin-top: 15px;
			outline: medium none;
			text-decoration: none;
			transition: all 0.3s ease 0s;
		}
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .team-manager-free-items-title a:hover{
			color:<?php echo esc_attr( $team_manager_free_name_hover_font_color); ?>;
			text-decoration: none;
		}
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .team-manager-free-items-designation{
			display: block;
			margin-bottom: 10px;
			color:<?php echo esc_attr( $team_manager_free_designation_font_color); ?>;
			font-size:<?php echo esc_attr( $team_manager_free_designation_font_size); ?>px;
			font-style: <?php echo $team_manager_desig_font_style;?>;
			text-transform: <?php echo $team_manager_desig_font_case;?>;
		}
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .team-manager-free-items-social{
			list-style: none;
			padding: 0;
		}
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .team-manager-free-items-social li{
			display: inline-block;
			margin: 2px;
			padding: 0;
			margin: 0;
		}
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .team-manager-free-items-social li a{
			background: #<?php echo esc_attr( $tmffree_social_bg_color); ?>;
			color: #<?php echo esc_attr( $tmffree_social_icon_color); ?>;
			border-radius: 50%;
			box-shadow: none;
			display: block;
			width: 30px;
			height: 30px;
			line-height: 30px;
			outline: medium none;
			text-decoration: none;
			transition: all 0.3s ease 0s;
			border:none;
		}
		.team-manager-free-main-area-<?php echo esc_attr( $post_id ); ?> .team-manager-free-items-social li a:hover{
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
			while ( $tmf_query->have_posts() ) : $tmf_query->the_post();
				$team_manager_free_client_designation 			= get_post_meta(get_the_ID(), 'client_designation', true);
				$team_manager_free_client_shortdescription 		= get_post_meta(get_the_ID(), 'client_shortdescription', true);
				$team_manager_free_client_email 				= get_post_meta(get_the_ID(), 'contact_email', true);
				$team_manager_free_client_number 				= get_post_meta(get_the_ID(), 'contact_number', true);
				$team_manager_free_client_address 				= get_post_meta(get_the_ID(), 'company_address', true);
				$team_manager_free_client_website 				= get_post_meta(get_the_ID(), 'client_website', true);
				$team_manager_free_social_facebook 				= get_post_meta(get_the_ID(), 'social_facebook', true);
				$team_manager_free_social_twitter 				= get_post_meta(get_the_ID(), 'social_twitter', true);
				$team_manager_free_social_googleplus 			= get_post_meta(get_the_ID(), 'social_googleplus', true);
				$team_manager_free_social_instagram 			= get_post_meta(get_the_ID(), 'social_instagram', true);
				$team_manager_free_social_pinterest 			= get_post_meta(get_the_ID(), 'social_pinterest', true);
				$team_manager_free_social_linkedin 				= get_post_meta(get_the_ID(), 'social_linkedin', true);
				$team_manager_free_social_dribbble 				= get_post_meta(get_the_ID(), 'social_dribbble', true);
				$team_manager_free_social_youtube 				= get_post_meta(get_the_ID(), 'social_youtube', true);
				$team_manager_free_social_skype 				= get_post_meta(get_the_ID(), 'social_skype', true);

				$tpteamfree_social_iconbox_repeat = get_post_meta( get_the_ID(), 'tpteamfree_social_iconbox_repeat', true);
				$thumb_id 			= get_post_thumbnail_id();
				$thumb_url 			= wp_get_attachment_image_src($thumb_id,'thumbnail-size', true);
				$random_team_id 	= rand();
				?>

				<div class="teamshowcasefree-col-lg-<?php echo esc_attr( $team_manager_free_post_column ); ?> teamshowcasefree-col-md-2 teamshowcasefree-col-sm-2 teamshowcasefree-col-xs-1">
					<div class="team-manager-free-items">
						<div class="team-manager-free-items-thumbnail">
							<img src="<?php echo esc_url( $thumb_url[0] );?>" alt="" />
							<a href="#team-popup-area-<?php echo esc_attr( $random_team_id ); ?>" class="open-popup-link pic-bottom" data-effect="mfp-zoom-in"></a>
						</div>
						<div class="team-manager-free-items-profiles">
							<h3 class="team-manager-free-items-title">
								<a href="#team-popup-area-<?php echo esc_attr( $random_team_id ); ?>" class="open-popup-link" data-effect="mfp-zoom-in"><?php the_title(); ?></a>
							</h3>

							<?php if ($team_manager_free_designation_hide == '1' && !empty($team_manager_free_client_designation)) { ?>
								<div class="team-manager-free-items-designation">
									<?php echo esc_html( $team_manager_free_client_designation ); ?>
								</div>
							<?php } ?>

							<ul class="team-manager-free-items-social">
								<?php include __DIR__ . '/social-info-short.php'; ?>
							</ul>
						</div>

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
			<?php endwhile; wp_reset_postdata(); ?>
		</div>
	</div>