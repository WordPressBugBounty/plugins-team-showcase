<?php
	if ( ! defined( 'ABSPATH' ) ) {
	    exit;
	}
	// Exit if accessed directly

	/*
	* @Author 		Themepoints
	* Copyright: 	2016 Themepoints
	* Version : 3.0.1
	*/

	# Add Team Meta Box
	function team_manager_free_custom_post_meta_box() {
		add_meta_box(
			'custom_meta_box', // $id
			'Member Personal Information', // $title
			'team_manager_free_custom_inner_custom_boxes', // $callback
			'team_mf', 
			'normal', 
			'high'
		);
	    add_meta_box(
	        'custom_greeting_metabox',
	        'Member Social Profiles',
	        'display_tptmfee_social_metasbox',
	        'team_mf',
	        'normal',
	        'default'
	    );
	    add_meta_box(
	        'team_skills_meta',
	        'Team Member Skills',
	        'team_skills_meta_box_callback',
	        'team_mf',
	        'normal',
	        'default'
	    );
		add_meta_box(
			'team_meta_idmulticolor_02',                            # Metabox
			__( 'Multi Color Team', 'team-manager-free' ),          # Title
			'multicolor_add_meta2',                             	# Call Back func
			'team_mf',                             					# post type
			'normal'                                       			# Text Content
		);
	    add_meta_box(
	        'team_mf_team_sidebar_metabox', // Metabox ID
	        __('Team Info Sorting', 'team-manager-free'), // Metabox Title
	        'team_mf_team_sidebar_metabox_callback', // Callback function
	        'team_mf_team', // Post type
	        'side', // Position (sidebar)
	        'low' // Priority
	    );
	}
	add_action('add_meta_boxes', 'team_manager_free_custom_post_meta_box');

	/*----------------------------------------------------------------------
		Content Options Meta Box 
	----------------------------------------------------------------------*/
	
	function team_manager_free_custom_inner_custom_boxes( $post ) {

		// Retrieve meta values with proper sanitization
		$client_designation      = get_post_meta($post->ID, 'client_designation', true);
		$company_address         = get_post_meta($post->ID, 'company_address', true);
		$contact_number          = get_post_meta($post->ID, 'contact_number', true);
		$contact_email           = get_post_meta($post->ID, 'contact_email', true);
		$client_website          = get_post_meta($post->ID, 'client_website', true);
		$client_shortdescription = get_post_meta($post->ID, 'client_shortdescription', true);

		// Add nonce field for security
		wp_nonce_field( 'team_manager_free_custom_meta_save', 'team_manager_free_custom_meta_nonce' );
		?>

		<div id="details_profiles_area">
			<div class="details_profiles_cols">
				<!-- Designation -->
				<p><label for="post_title_designation"><strong><?php _e('Designation:', 'team-manager-free'); ?></strong></label></p>
				<input type="text" name="post_title_designation" placeholder="Designation" id="post_title_designation" value="<?php echo esc_attr( $client_designation ); ?>" />

				<!-- Address  -->
				<p><label for="client_address_input"><strong><?php _e('Address/Location:', 'team-manager-free'); ?></strong></label></p>
				<input type="text" name="client_address_input" placeholder="Winston Salem, NC" id="client_address_input" value="<?php echo esc_attr( $company_address ); ?>" />

				<!-- Contact Number -->
				<p><label for="contact_number_input"><strong><?php _e('Contact Number:', 'team-manager-free'); ?></strong></label></p>
				<input type="text" name="contact_number_input" placeholder="xxx-xxx-xxxx" id="contact_number_input" value="<?php echo esc_attr( $contact_number ); ?>" />
			</div>
			<div class="details_profiles_cols">
				<!-- Contact Email -->
				<p><label for="contact_email_input"><strong><?php _e('Email Address:', 'team-manager-free'); ?></strong></label></p>
				<input type="text" name="contact_email_input" placeholder="email@example.com" id="contact_email_input" value="<?php echo esc_attr( $contact_email ); ?>" />
				
				<!-- Website -->
				<p><label for="client_website_input"><strong><?php _e('Website:', 'team-manager-free'); ?></strong></label></p>
				<input type="text" name="client_website_input" placeholder="example.com" id="client_website_input" value="<?php echo esc_attr( $client_website ); ?>" />

				<!-- Description -->
				<p><label for="short_description_input"><strong><?php _e('Short Description (Max 140 characters):', 'team-manager-free');?></strong></label></p>
				<textarea name="short_description_input" id="short_description_input" cols="30" rows="3" maxlength="140"><?php echo esc_textarea( $client_shortdescription ); ?></textarea>
			</div>
		</div>

		<?php
	}

	# Save Options Meta Box Function
	function team_manager_free_custom_inner_custom_boxes_save($post_id){

		// Verify nonce
		if ( ! isset( $_POST['team_manager_free_custom_meta_nonce'] ) || 
		     ! wp_verify_nonce( $_POST['team_manager_free_custom_meta_nonce'], 'team_manager_free_custom_meta_save' ) ) {
			return;
		}

	    // Check if autosave
	    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
	        return;
	    }

	    // Check if current user has permission to edit the post
	    if ( ! current_user_can( 'edit_post', $post_id ) ) {
	        return;
	    }

		if(isset($_POST['post_title_designation'])) {
			update_post_meta($post_id, 'client_designation', sanitize_text_field( $_POST['post_title_designation'] ) );
		}

		if(isset($_POST['client_address_input'])) {
			update_post_meta($post_id, 'company_address', sanitize_text_field( $_POST['client_address_input'] ) );
		}

		if(isset($_POST['contact_number_input'])) {
			update_post_meta($post_id, 'contact_number', sanitize_text_field( $_POST['contact_number_input'] ) );
		}

		if(isset($_POST['contact_email_input'])) {
			update_post_meta($post_id, 'contact_email', sanitize_email( $_POST['contact_email_input'] ) );
		}

		#Checks for input and saves if needed
		if(isset($_POST['client_website_input'])) {
			update_post_meta($post_id, 'client_website', esc_url_raw( $_POST['client_website_input'] ) );
		}

		if(isset($_POST['short_description_input'])) {
			update_post_meta($post_id, 'client_shortdescription', sanitize_textarea_field( $_POST['short_description_input'] ) );
		}
	}
	add_action('save_post', 'team_manager_free_custom_inner_custom_boxes_save');

	function get_tp_tmfree_social_icons_list() {
	    return array(
			'Facebook'       => 'facebook',
			'X (Twitter)'    => 'twitter',
			'Instagram'      => 'instagram',
			'Linkedin'       => 'linkedin',
			'Pinterest'      => 'Pinterest',
			'Youtube'        => 'youTube',
			'Youtube Play'   => 'youtube-play',
			'Google'         => 'google',
			'Github'         => 'gitHub',
			'Tumblr'         => 'tumblr',
			'Snapchat'       => 'snapchat',
			'Reddit'         => 'reddit',
			'WhatsApp'       => 'whatsapp',
			'Slack'          => 'slack',
			'Twitch'         => 'twitch',
			'Vimeo'          => 'vimeo',
			'SoundCloud'     => 'soundcloud',
			'Dribbble'       => 'dribbble',
			'Behance'        => 'behance',
			'Flickr'         => 'flickr',
			'RSS'            => 'rss',
			'Email'          => 'envelope',
			'Spotify'        => 'spotify',
			'Apple'          => 'apple',
			'Amazon'         => 'amazon',
			'Medium'         => 'medium',
			'Stack Overflow' => 'stack-overflow',
			'Quora'          => 'quora',
			'Product Hunt'   => 'product-hunt',
			'Bitbucket'      => 'bitbucket',
			'GitLab'         => 'gitlab',
			'PayPal'         => 'paypal',
			'Digg'           => 'digg',
			'Wechat'         => 'wechat',
			'Xing'           => 'xing',
			'Yelp'           => 'yelp',
			'WordPress'      => 'wordpress',
			'Clipboard'      => 'clipboard',
			'Tumblr'         => 'tumblr',
			'Telegram'       => 'telegram',
			'Slideshare'     => 'slideshare',
			'Vine'           => 'vine',
			'LastFM'         => 'lastfm',
			'Meetup'         => 'meetup',
			'Marker'         => 'map-marker',
			'Website'        => 'globe',
			'Link'           => 'link',
			'Skype'          => 'skype',
			'Stumbleupon'    => 'stumbleupon',
			'Weibo'          => 'weibo',
			'Windows'        => 'windows',
			'Wpbeginner'     => 'wpbeginner',
			'MixCloud'       => 'mixcloud',
			'Html5'          => 'html5',
			'Google Plus'    => 'google-plus',
			'Android'        => 'android',
			'VK'             => 'vk',
			'Threads'        => 'icon-tmf-threads-icon',
			'Mastodon'       => 'icon-tmf-mastodon',
			'Bluesky'        => 'icon-tmf-bluesky-icon',
			'TikTok'         => 'icon-tmf-tiktok-icon',
	        // Add more social icons as needed
	    );
	}
	
	# Neta Box
	function display_tptmfee_social_metasbox( $post, $args) {
		global $post;

		$tpteamfree_social_iconbox_repeat	= get_post_meta( $post->ID, 'tpteamfree_social_iconbox_repeat', true );
		$totlacionsarray 					= get_tp_tmfree_social_icons_list();
		wp_nonce_field( 'tpteamfree_socialmetabox_nonces', 'tpteamfree_socialmetabox_nonces' );
		?>
		
		<div id="repeatable_socialicons">
			<div class="allicolist">
				<?php
				if ( $tpteamfree_social_iconbox_repeat ) :
				foreach ( $tpteamfree_social_iconbox_repeat as $sciconsfield ) { ?>
					<div class="removescicons">
						<div class="sciconsdrag"><a class="sorticonlists"><span class="dashicons dashicons-move"></span></a></div>
						<div class="socialicons_field"><input type="text" class="widefat" name="sciconsurl[]" value="<?php if($sciconsfield['sciconsurl'] != '') echo esc_url( $sciconsfield['sciconsurl'] ); ?>" /></div>

						<div class="socialicons_select_field">
							<select name="select[]">
							<?php foreach ( $totlacionsarray as $label => $value ) : ?>
							<option value="<?php echo $value; ?>"<?php selected( $sciconsfield['select'], $value ); ?>><?php echo $label; ?></option>
							<?php endforeach; ?>
							</select>
						</div>
						<div class="icondeletemove"><a class="button removeiconcolumns" href="#"><span class="dashicons dashicons-trash"></span></a></div>
					</div>
				<?php
				}
				else :
				// show a blank one
				?>
				<?php endif; ?>
				<!-- empty hidden one for jQuery -->
				<div class="emptyicons screen-reader-text removescicons">
					<div class="sciconsdrag"><a class="sorticonlists"><span class="dashicons dashicons-move"></span></a></div>
					<div class="socialicons_field"><input type="text" placeholder="https://example.com/username" class="widefat" name="sciconsurl[]" /></div>
					<div class="socialicons_select_field">
						<select name="select[]">
						<?php foreach ( $totlacionsarray as $label => $value ) : ?>
						<option value="<?php echo $value; ?>"><?php echo $label; ?></option>
						<?php endforeach; ?>
						</select>
					</div>
					<div class="icondeletemove"><a class="button removeiconcolumns" href="#"><span class="dashicons dashicons-trash"></span></a></div>
				</div>
			</div>
		</div>

		<div class="addsocialbtn"><a id="addsocialicons" class="button" href="#">Add Social Profile</a></div>

		<?php
	}

	function tp_tmffree_social_icons_metasaves($post_id) {
	    // Verify nonce
	    $nonce = isset($_POST['tpteamfree_socialmetabox_nonces']) ? sanitize_text_field($_POST['tpteamfree_socialmetabox_nonces']) : '';
	    if (!wp_verify_nonce($nonce, 'tpteamfree_socialmetabox_nonces')) {
	        return;
	    }

	    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
	        return;
	    }

	    if (!current_user_can('edit_post', $post_id)) {
	        return;
	    }

	    // Sanitize and validate POST data
	    $sciconsurls = isset($_POST['sciconsurl']) ? $_POST['sciconsurl'] : array();
	    $selectsicon = isset($_POST['select']) ? $_POST['select'] : array();
	    $sciconsurls = array_map('esc_url_raw', $sciconsurls); // Sanitize URLs
	    $selectsicon = array_map('sanitize_text_field', $selectsicon); // Sanitize select options
	    $sciconrepeat = get_post_meta($post_id, 'tpteamfree_social_iconbox_repeat', true);
	    $sciconsarray = array();
	    $totlacionsarray = get_tp_tmfree_social_icons_list();

	    $sccount = count($sciconsurls);

	    for ($i = 0; $i < $sccount; $i++) {
	        if (!empty($sciconsurls[$i])) {
	            $sciconsarray[$i]['sciconsurl'] = $sciconsurls[$i];

	            if (in_array($selectsicon[$i], $totlacionsarray)) {
	                $sciconsarray[$i]['select'] = $selectsicon[$i];
	            } else {
	                $sciconsarray[$i]['select'] = '';
	            }
	        }
	    }

	    // Update post meta
	    if (!empty($sciconsarray) && $sciconsarray != $sciconrepeat) {
	        update_post_meta($post_id, 'tpteamfree_social_iconbox_repeat', $sciconsarray);
	    } elseif (empty($sciconsarray) && $sciconrepeat) {
	        delete_post_meta($post_id, 'tpteamfree_social_iconbox_repeat', $sciconrepeat);
	    }
	}
	add_action('save_post', 'tp_tmffree_social_icons_metasaves');

	// Save Metabox
	function team_skills_meta_box_callback($post) {
		
	    wp_nonce_field('tp_team_skills_save', 'tp_team_skills_nonce');

	    $skills = get_post_meta($post->ID, '_team_skills', true);
	    if (!is_array($skills)) $skills = [];

	    echo '<div id="team-skills-wrapper" class="sortable">';
	    foreach ($skills as $i => $skill) {
	        echo '<div class="team-skill-row">';
	        echo '<span class="dashicons dashicons-move handle"></span>';
	        echo '<input type="text" name="team_skills['.$i.'][name]" value="'.esc_attr($skill['name']).'" placeholder="Skill Name" />';
	        echo '<input type="number" name="team_skills['.$i.'][value]" value="'.esc_attr($skill['value']).'" placeholder="Value (0-100)" min="0" max="100" />';
	        echo '<button class="remove-skill button">Remove</button>';
	        echo '</div>';
	    }
	    echo '</div>';
	    echo '<button id="add-skill" class="button">Add Skill</button>';
	}

	// Save Metabox
	function tp_save_team_skills($post_id) {

	    if (
	        ! isset($_POST['tp_team_skills_nonce']) ||
	        ! wp_verify_nonce($_POST['tp_team_skills_nonce'], 'tp_team_skills_save')
	    ) {
	        return;
	    }

	    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
	        return;
	    }

	    if (!current_user_can('edit_post', $post_id)) {
	        return;
	    }

	    // Save skills
	    if (isset($_POST['team_skills']) && is_array($_POST['team_skills'])) {
	        $skills = [];

	        foreach ($_POST['team_skills'] as $skill) {
	            // Only save non-empty skills
	            if (!empty($skill['name']) && isset($skill['value'])) {
	                $skills[] = [
	                    'name'  => sanitize_text_field($skill['name']),
	                    'value' => intval($skill['value']),
	                ];
	            }
	        }

	        // Update post meta
	        update_post_meta($post_id, '_team_skills', $skills);

	    } else {
	        // Delete meta if no skills are provided
	        delete_post_meta($post_id, '_team_skills');
	    }
	}
	add_action('save_post', 'tp_save_team_skills');

	function multicolor_add_meta2( $post, $args ) {

		wp_nonce_field('tp_team_multicolor_save', 'tp_team_multicolor_nonce');
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

	// Save Metabox
	function tp_save_multicolor_data($post_id) {

	    if (
	        ! isset($_POST['tp_team_multicolor_nonce']) ||
	        ! wp_verify_nonce($_POST['tp_team_multicolor_nonce'], 'tp_team_multicolor_save')
	    ) {
	        return;
	    }

	    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
	        return;
	    }

	    if (!current_user_can('edit_post', $post_id)) {
	        return;
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

	}
	add_action('save_post', 'tp_save_multicolor_data');

	function tmffree_team_review_notice_message() {
	    // Show only to Admins
	    if ( ! current_user_can( 'manage_options' ) ) {
	        return;
	    }

	    $installed = get_option( 'tmffree_team_activation_time' );
	    if ( !$installed ) {
	        update_option( 'tmffree_team_activation_time', time() );
	        $installed = time(); // Initialize $installed if not set
	    }

	    $dismiss_notice  = get_option( 'tmffree_team_review_notice_dismiss', 'no' );
	    $activation_time = get_option( 'tmffree_team_activation_time' ); // Retrieving activation time
	    $days_installed = floor((time() - $activation_time) / (60 * 60 * 24)); // Calculating days since installation

	    $plugin_url      = 'https://wordpress.org/support/plugin/team-showcase/reviews/#new-post';

	    // Nonce field
	    $nonce_field = wp_nonce_field( 'tmffree_team_dismiss_review_notice_nonce', '_nonce', true, false );

	    // check if it has already been dismissed
	    if ( 'yes' === $dismiss_notice ) {
	        return;
	    }

	    if ( time() - $activation_time < 604800 ) {
	        return;
	    }

	    ?>

	    <div id="tmffree_team-review-notice" class="tmffree_team-review-notice">
	        <div class="testimonial-review-text">
	            <h3><?php echo wp_kses_post( 'Enjoying Team Showcase?', 'team-manager-free' ); ?></h3>
	            <p><?php echo wp_kses_post( 'Awesome, you\'ve been using <strong>Team Showcase Plugin</strong> for more than 1 week. May we ask you to give it a <strong>5-star rating</strong> on Wordpress? </br>
	                    This will help to spread its popularity and to make this plugin a better one.
	                    <br><br>Your help is much appreciated. Thank you very much,<br> Themepoints', 'team-manager-free' ); ?></p>
	            <ul class="testimonial-review-ul">
	                <li><a href="<?php echo esc_url( $plugin_url ); ?>" target="_blank"><span class="dashicons dashicons-external"></span><?php esc_html_e( 'Sure! I\'d love to!', 'team-manager-free' ); ?></a></li>
	                <li><a href="#" class="notice-dismiss" data-nonce="<?php echo esc_attr(wp_create_nonce('tmffree_team_dismiss_review_notice_nonce')); ?>"><span class="dashicons dashicons-smiley"></span><?php esc_html_e( 'I\'ve already left a review', 'team-manager-free' ); ?></a></li>
	                <li><a href="#" class="notice-dismiss" data-nonce="<?php echo esc_attr(wp_create_nonce('tmffree_team_dismiss_review_notice_nonce')); ?>"><span class="dashicons dashicons-dismiss"></span><?php esc_html_e( 'Never show again', 'team-manager-free' ); ?></a></li>
	            </ul>
	        </div>
	    </div>

        <style type="text/css">
            #tmffree_team-review-notice .notice-dismiss{
                padding: 0 0 0 26px;
            }
            #tmffree_team-review-notice .notice-dismiss:before{
                display: none;
            }
            #tmffree_team-review-notice.tmffree_team-review-notice {
                padding: 15px;
                background-color: #fff;
                border-radius: 3px;
                margin: 30px 20px 0 0;
                border-left: 4px solid transparent;
            }
            #tmffree_team-review-notice .testimonial-review-text {
                overflow: hidden;
            }
            #tmffree_team-review-notice .testimonial-review-text h3 {
                font-size: 24px;
                margin: 0 0 5px;
                font-weight: 400;
                line-height: 1.3;
            }
            #tmffree_team-review-notice .testimonial-review-text p {
                font-size: 15px;
                margin: 0 0 10px;
            }
            #tmffree_team-review-notice .testimonial-review-ul {
                margin: 0;
                padding: 0;
            }
            #tmffree_team-review-notice .testimonial-review-ul li {
                display: inline-block;
                margin-right: 15px;
            }
            #tmffree_team-review-notice .testimonial-review-ul li a {
                display: inline-block;
                color: #2271b1;
                text-decoration: none;
                padding-left: 26px;
                position: relative;
            }
            #tmffree_team-review-notice .testimonial-review-ul li a span {
                position: absolute;
                left: 0;
                top: -2px;
            }
        </style>

	    <script>
	        jQuery(document).ready(function($) {
	            // Dismiss notice
	            $('.notice-dismiss').on('click', function(e) {
	                e.preventDefault();

	                var nonce = $(this).data('nonce');
	                var data = {
	                    action: 'tmffree_team_dismiss_review_notice',
	                    _nonce: nonce,
	                    dismissed: true // Indicate that the notice is being dismissed
	                };

	                $.post(ajaxurl, data, function(response) {
	                    $('#tmffree_team-review-notice').remove();
	                });
	            });
	        });
	    </script>
	    <?php
	}
	add_action( 'admin_notices', 'tmffree_team_review_notice_message' );

	function tmffree_team_dismiss_review_notice() {
	    check_ajax_referer( 'tmffree_team_dismiss_review_notice_nonce', '_nonce' ); // Verifying nonce

	    if ( ! current_user_can( 'manage_options' ) ) {
	        wp_send_json_error( __( 'Unauthorized operation', 'team-manager-free' ) );
	    }

	    if ( ! isset( $_POST['_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['_nonce'] ), 'tmffree_team_dismiss_review_notice_nonce' ) ) {
	        wp_send_json_error( __( 'Unauthorized operation', 'team-manager-free' ) );
	    }

	    if ( isset( $_POST['dismissed'] ) ) {
	        update_option( 'tmffree_team_review_notice_dismiss', 'yes' );
	        wp_send_json_success( __( 'Notice dismissed successfully', 'team-manager-free' ) );
	    } else {
	        wp_send_json_error( __( 'Dismissal data missing', 'team-manager-free' ) );
	    }
	}
	add_action( 'wp_ajax_tmffree_team_dismiss_review_notice', 'tmffree_team_dismiss_review_notice' );

	function tmfshowcase_shortcode_section($post) {
	    // Show only for 'team_mf_team' post type
	    if ($post->post_type !== 'team_mf_team') {
	        return;
	    }

	    // Generate the dynamic shortcode
	    $shortcode = "[tmfshortcode id='" . $post->ID . "']";
	    $php_code = '<?php echo do_shortcode("[tmfshortcode id=' . $post->ID . ']"); ?>';

	    ?>
	    <div style="padding: 15px 15px 25px 15px; border: 1px solid #ddd; background: #f9f9f9; margin-top: 15px;">
		    <div style="display: flex; gap: 20px;">
			    <div style="width: 50%;">
			        <p>
			            <strong><?php _e( 'Shortcode','team-manager-free' ); ?>:</strong>
			            <span id="shortcode-notice" style="color: green; display: none; margin-left: 10px;"><?php _e( 'Shortcode copied!','team-manager-free' ); ?></span>
			        </p>
			        <p class="option-info"><?php _e('Click to copy the shortcode and paste it into a page or post to display Team Showcase.','team-manager-free' ); ?></p>
			        <input type="text" id="shortcode-text" style="width:100%; cursor:pointer; box-shadow: none; border:none;outline:none;border-radius: 0" value="<?php echo esc_attr($shortcode); ?>" readonly onclick="copyToClipboard(this, 'shortcode-notice')">
			    </div>
			    <div style="width: 50%;">
			        <p>
			            <strong><?php _e( 'PHP Code for Theme Files','team-manager-free' ); ?>:</strong>
			            <span id="php-notice" style="color: green; display: none; margin-left: 10px;"><?php _e( 'PHP code copied!','team-manager-free' ); ?></span>
			        </p>
			        <p class="option-info"><?php _e('Click to copy the PHP code and use it in your theme files to display Team Showcase.','team-manager-free' ); ?></p>
			        <input type="text" id="php-code-text" style="width:100%; cursor:pointer; box-shadow: none; border:none;outline:none;border-radius: 0" value="<?php echo esc_attr($php_code); ?>" readonly onclick="copyToClipboard(this, 'php-notice')">
			    </div>
		    </div>
	    </div>

	    <script>
	        function copyToClipboard(inputField, noticeId) {
	            inputField.select();
	            navigator.clipboard.writeText(inputField.value);

	            // Show copied message beside the label
	            var notice = document.getElementById(noticeId);
	            notice.style.display = "inline";

	            // Hide the message after 2 seconds
	            setTimeout(function() {
	                notice.style.display = "none";
	            }, 2000);
	        }
	    </script>
	    <?php
	}
	add_action('edit_form_after_title', 'tmfshowcase_shortcode_section');