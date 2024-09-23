<?php
	/*
	* @Author 		Themepoints
	* Copyright: 	2016 Themepoints
	* Version : 2.0.3
	*/

	if ( ! defined( 'ABSPATH' ) ) {
	    exit;
	}
	// Exit if accessed directly

	# Redirect Page
	function team_free_redirect_options_page( $plugin ) {
		if ( $plugin == plugin_basename( __FILE__ ) ) {
			exit( wp_redirect( admin_url( 'options-general.php' ) ) );
		}
	}
	add_action( 'activated_plugin', 'team_free_redirect_options_page' );	

	# admin menu
	function team_free_plugins_options_framwrork() {
		add_options_page( 'Team Showcase Pro Version Help & Features', 'Team Showcase Info', 'manage_options', 'team-pro-features', 'team_free_plugins_options_framwrork_inc' );
	}
	add_action( 'admin_menu', 'team_free_plugins_options_framwrork' );

	if ( is_admin() ) : // Load only if we are viewing an admin page

		function team_free_plugins_options_framwrork_settings() {
			// Register settings and call sanitation functions
			register_setting( 'teams_free_options', 'team_free_options', 'tms_free_options' );
		}
		add_action( 'admin_init', 'team_free_plugins_options_framwrork_settings' );

		function team_free_plugins_options_framwrork_inc() {

			if ( ! isset( $_REQUEST['updated'] ) ) {
				$_REQUEST['updated'] = false;
			}
			?>
				<div class="wrap about-wrap">
					<div class="team-versions">
						<h1><?php echo esc_html__('Welcome to Team Showcase V2.3', 'team-manager-free'); ?></h1>
					</div>
					<div class="teamcontainerfree">
						<p class="teamcontainerfreetext"><?php echo wp_kses_post( 'You have been using <b> Team Showcase </b> for a while. Would you please show us a little love by rating us in the <a href="https://wordpress.org/support/plugin/team-showcase/reviews/#new-post" target="_blank"><strong>WordPress.org</strong></a>?', 'team-manager-free' ); ?></p>
						<p>
							<div class="reviewteam">
								<a target="_blank" href="https://wordpress.org/plugins/team-showcase/">
									<span class="dashicons dashicons-star-filled"></span>
									<span class="dashicons dashicons-star-filled"></span>
									<span class="dashicons dashicons-star-filled"></span>
									<span class="dashicons dashicons-star-filled"></span>
									<span class="dashicons dashicons-star-filled"></span>
								</a>
							</div>
						</p>

						<div class="team-free-setup-area">
							<div class="single-team-setup"><h3><a href="https://themepoints.com/teamshowcase/documentation/" target="_blank"><?php echo esc_html__('Team Installation Guide', 'team-manager-free'); ?></a></h3> </div>
							<div class="single-team-setup"><h3><a href="https://themepoints.com/teamshowcase/team-sortable/" target="_blank"><?php echo esc_html__('Team Member Order', 'team-manager-free'); ?></a> </h3></div>
						</div>

						<div class="why-choose-proversion">
							<h3><?php echo esc_html__('Why Choose Pro?', 'team-manager-free');?></h3>
						</div>
						<p class="choose_details">We create a <a target="_blank" href="https://themepoints.com/product/team-showcase-pro/">Premium Version</a> of this plugin with some amazing cool features.</p>

						<div class="features-team-container">
							<div class="features-team-services">
								<div class="single-features">
									<h4><?php echo esc_html__('Fully Responsive', 'team-manager-free'); ?></h4>
									<p><?php echo esc_html__('Team Showcase is fully responsive in mobile & Desktop devices. It can adapt any screen sizes for achieving best viewing case.', 'team-manager-free'); ?></p>
								</div>
								<div class="single-features">
									<h4><?php echo esc_html__('Unlimited Team Support', 'team-manager-free'); ?></h4>
									<p><?php echo esc_html__('Team Showcase allows you to create unlimited number of team member as you need. We have no limits for create team members.', 'team-manager-free'); ?></p>
								</div>
								<div class="single-features">
									<h4><?php echo esc_html__('All Browsers Compatible', 'team-manager-free'); ?></h4>
									<p><?php echo esc_html__('Team Showcase work\'s properly in all most popular stable versions of the browsers: IE, Firefox, Safari, Opera, Chrome etc.', 'team-manager-free'); ?></p>
								</div>
								<div class="single-features">
									<h4><?php echo esc_html__('Powerful Setting panel', 'team-manager-free'); ?></h4>
									<p><?php echo esc_html__('Team Showcase Plugin comes with a powerfull admin panel which allows you to deeply customize to fit your website. no need to required any coding skill.', 'team-manager-free'); ?></p>
								</div>
								<div class="single-features">
									<h4><?php echo esc_html__('25 Unique Team Styles', 'team-manager-free'); ?></h4>
									<p><?php echo esc_html__('Team Showcase Plugin comes with 25 different unique layouts with multiple columns support (1/6).', 'team-manager-free'); ?></p>
								</div>
								<div class="single-features">
									<h4><?php echo esc_html__('Lifetime Free Updates', 'team-manager-free'); ?></h4>
									<p><?php echo esc_html__('All future updates and developments to the Team showcase will be completely free once you have bought the project one time.', 'team-manager-free'); ?></p>
								</div>
								<div class="single-features">
									<h4><?php echo esc_html__('Custom Color', 'team-manager-free'); ?></h4>
									<p><?php echo esc_html__('Team Showcase Plugin comes with a custom color which allows you to customize background color hover color, title color or overlay color etc.', 'team-manager-free'); ?></p>
								</div>
								<div class="single-features">
									<h4><?php echo esc_html__('24/7 Dedicated Support', 'team-manager-free'); ?></h4>
									<p><?php echo esc_html__('We are available for support in case you have any questions, problems or need any help implementing the Team Showcase. We will do our best to respond as soon as possible.', 'team-manager-free'); ?></p>
								</div>
								<div class="single-features">
									<h4><?php echo esc_html__('Quick & Easy Setup', 'team-manager-free'); ?></h4>
									<p><?php echo esc_html__('Team Showcase is Fully documented and video tutorials step-by-step guide provided to help you.', 'team-manager-free');?></p>
								</div>
							</div>
						</div>

						<div class="purchasepro-vers">
							<a target="_blank" href="https://themepoints.com/product/team-showcase-pro"><?php echo esc_html__('Purchase Now', 'team-manager-free'); ?></a>
						</div>
						<br>
					</div>
				</div>
			<?php
		}
	endif;
	// EndIf is_admin()