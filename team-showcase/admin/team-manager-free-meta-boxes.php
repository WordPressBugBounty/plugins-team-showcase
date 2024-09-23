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
	        'Member Social Profiles - New Features',
	        'display_tptmfee_social_metasbox',
	        'team_mf',
	        'normal',
	        'default'
	    );
		add_meta_box(
			'custom_meta_box2', // $id
			'Member Social Profiles', // $title
			'team_manager_free_custom_inner_custom_boxess', // $callback
			'team_mf', 
			'normal'
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
		?>

		<div id="details_profiles_area">
			<div class="details_profiles_cols">
				<!-- Designation -->
				<p><label for="post_title_designation"><strong><?php _e('Designation', 'team-manager-free'); ?></strong></label></p>
				<input type="text" name="post_title_designation" placeholder="Designation" id="post_title_designation" value="<?php echo esc_attr( $client_designation ); ?>" />

				<!-- Address  -->
				<p><label for="client_address_input"><strong><?php _e('Address', 'team-manager-free'); ?></strong></label></p>
				<input type="text" name="client_address_input" placeholder="Winston Salem, NC" id="client_address_input" value="<?php echo esc_attr( $company_address ); ?>" />

				<!-- Contact Number -->
				<p><label for="contact_number_input"><strong><?php _e('Contact Number', 'team-manager-free'); ?></strong></label></p>
				<input type="text" name="contact_number_input" placeholder="xxx-xxx-xxxx" id="contact_number_input" value="<?php echo esc_attr( $contact_number ); ?>" />
			</div>
			<div class="details_profiles_cols">
				<!-- Contact Email -->
				<p><label for="contact_email_input"><strong><?php _e('Email', 'team-manager-free'); ?></strong></label></p>
				<input type="text" name="contact_email_input" placeholder="email@exapmle.com" id="contact_email_input" value="<?php echo esc_attr( $contact_email ); ?>" />
				
				<!-- Website -->
				<p><label for="client_website_input"><strong><?php _e('Website:', 'team-manager-free'); ?></strong></label></p>

				<input type="text" name="client_website_input" placeholder="exapmle.com" id="client_website_input" value="<?php echo esc_attr( $client_website ); ?>" />

				<!-- Description -->
				<p><label for="short_description_input"><strong><?php _e('Short Description (Max 140 characters)', 'team-manager-free');?></strong></label></p>
				<textarea name="short_description_input" id="short_description_input" cols="30" rows="3" maxlength="140"><?php echo esc_textarea( $client_shortdescription ); ?></textarea>
			</div>
		</div>

		<?php
	}
	
	function team_manager_free_custom_inner_custom_boxess( $post ) { 

		// Retrieve meta values with proper sanitization
		$social_facebook   = get_post_meta($post->ID, 'social_facebook', true);
		$social_twitter    = get_post_meta($post->ID, 'social_twitter', true);
		$social_googleplus = get_post_meta($post->ID, 'social_googleplus', true);
		$social_instagram  = get_post_meta($post->ID, 'social_instagram', true);
		$social_pinterest  = get_post_meta($post->ID, 'social_pinterest', true);
		$social_linkedin   = get_post_meta($post->ID, 'social_linkedin', true);
		$social_dribbble   = get_post_meta($post->ID, 'social_dribbble', true);
		$social_youtube    = get_post_meta($post->ID, 'social_youtube', true);
		$social_skype      = get_post_meta($post->ID, 'social_skype', true);

		?>
		<div id="details_profiles_area">
			<div class="team-backend-socialprofiles">

				<div class="single-team-social-icons">
					<!-- Facebook -->
					<p><label for="facebook_social_input"><strong><?php _e('Facebook', 'team-manager-free');?></strong></label></p>
					<input type="text" name="facebook_social_input" placeholder="https://example.com/username" id="facebook_social_input" value="<?php echo esc_url( $social_facebook ); ?>" />
				</div>

				<div class="single-team-social-icons">
					<!-- Twitter -->
					<p><label for="twitter_social_input"><strong><?php _e('Twitter', 'team-manager-free');?></strong></label></p>
					<input type="text" name="twitter_social_input" placeholder="https://example.com/username" id="twitter_social_input" value="<?php echo esc_url( $social_twitter ); ?>" />
				</div>

				<div class="single-team-social-icons">
					<!-- Google plus -->
					<p><label for="googleplus_social_input"><strong><?php _e('Google Plus', 'team-manager-free');?></strong></label></p>
					<input type="text" name="googleplus_social_input" placeholder="https://example.com/username" id="googleplus_social_input" value="<?php echo esc_url( $social_googleplus ); ?>" />
				</div>

				<div class="single-team-social-icons">
					<!-- Instagram -->
					<p><label for="instagram_social_input"><strong><?php _e('Instagram', 'team-manager-free');?></strong></label></p>
					<input type="text" name="instagram_social_input" placeholder="https://example.com/username" id="instagram_social_input" value="<?php echo esc_url( $social_instagram ); ?>" />
				</div>

				<div class="single-team-social-icons">
					<!-- Pinterest -->
					<p><label for="pinterest_social_input"><strong><?php _e('Pinterest', 'team-manager-free');?></strong></label></p>
					<input type="text" name="pinterest_social_input" placeholder="https://example.com/username" id="pinterest_social_input" value="<?php echo esc_url( $social_pinterest ); ?>" />
				</div>

				<div class="single-team-social-icons">
					<!-- LinkedIn -->
					<p><label for="linkedIn_social_input"><strong><?php _e('LinkedIn', 'team-manager-free');?></strong></label></p>
					<input type="text" name="linkedIn_social_input" placeholder="https://example.com/username" id="linkedIn_social_input" value="<?php echo esc_url( $social_linkedin ); ?>" />
				</div>

				<div class="single-team-social-icons">
					<!-- Dribbble -->
					<p><label for="dribbble_social_input"><strong><?php _e('Dribbble', 'team-manager-free');?></strong></label></p>
					<input type="text" name="dribbble_social_input" placeholder="https://example.com/username" id="dribbble_social_input" value="<?php echo esc_url( $social_dribbble ); ?>" />
				</div>

				<div class="single-team-social-icons">
					<!-- Youtube -->
					<p><label for="youtube_social_input"><strong><?php _e('Youtube', 'team-manager-free');?></strong></label></p>
					<input type="text" name="youtube_social_input" placeholder="https://example.com/username" id="youtube_social_input" value="<?php echo esc_url( $social_youtube ); ?>" />
				</div>

				<div class="single-team-social-icons">
					<!-- Youtube -->
					<p><label for="skype_social_input"><strong><?php _e('Skype', 'team-manager-free');?></strong></label></p>
					<input type="text" name="skype_social_input" placeholder="https://example.com/username" id="skype_social_input" value="<?php echo esc_url( $social_skype ); ?>" />
				</div>

			</div>
		</div>
		<?php
	}

	# Save Options Meta Box Function
	function team_manager_free_custom_inner_custom_boxes_save($post_id){

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

		if(isset($_POST['facebook_social_input'])) {
			update_post_meta($post_id, 'social_facebook', esc_url_raw( $_POST['facebook_social_input'] ) );
		}

		if(isset($_POST['twitter_social_input'])) {
			update_post_meta($post_id, 'social_twitter', esc_url_raw( $_POST['twitter_social_input'] ) );
		}

		if(isset($_POST['googleplus_social_input'])) {
			update_post_meta($post_id, 'social_googleplus', esc_url_raw( $_POST['googleplus_social_input'] ) );
		}

		if(isset($_POST['instagram_social_input'])) {
			update_post_meta($post_id, 'social_instagram', esc_url_raw( $_POST['instagram_social_input'] ) );
		}

		if(isset($_POST['pinterest_social_input'])) {
			update_post_meta($post_id, 'social_pinterest', esc_url_raw( $_POST['pinterest_social_input'] ) );
		}

		if(isset($_POST['linkedIn_social_input'])) {
			update_post_meta($post_id, 'social_linkedin', esc_url_raw( $_POST['linkedIn_social_input'] ) );
		}

		if(isset($_POST['dribbble_social_input'])) {
			update_post_meta($post_id, 'social_dribbble', esc_url_raw( $_POST['dribbble_social_input'] ) );
		}

		if(isset($_POST['youtube_social_input'])) {
			update_post_meta($post_id, 'social_youtube', esc_url_raw( $_POST['youtube_social_input'] ) );
		}

		if(isset($_POST['skype_social_input'])) {
			update_post_meta($post_id, 'social_skype', esc_url_raw( $_POST['skype_social_input'] ) );
		}
	}
	add_action('save_post', 'team_manager_free_custom_inner_custom_boxes_save');
	

	function get_tp_tmfree_social_icons_list() {
	    return array(
			'Facebook'       => 'facebook',
			'Twitter'        => 'twitter',
			'Instagram'      => 'instagram',
			'Linkedin'       => 'linkedIn',
			'Pinterest'      => 'Pinterest',
			'Youtube'        => 'youTube',
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
			'YouTube Play'   => 'youtube-play',
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
			'Tripadvisor'    => 'tripadvisor',
			'Stumbleupon'    => 'stumbleupon',
			'Weibo'          => 'weibo',
			'Windows'        => 'windows',
			'Wpbeginner'     => 'wpbeginner',
			'MixCloud'       => 'mixcloud',
			'Html5'          => 'html5',
			'Google Plus'    => 'google-plus',
			'Android'        => 'android',
			'VK'             => 'vk',
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

		<style>
		    #repeatable_socialicons {
		        margin-top: 20px;
		    }
		    .removescicons {
				display: flex;
				flex-wrap: wrap;
		        border: 1px solid #ccc;
		        padding: 10px;
		        margin-bottom: 10px;
		        background-color: transparent;
		    }
		    .sciconsdrag {
		        display: inline-block;
		        margin-right: 10px;
		        cursor: move;
		    }
		    .socialicons_field,
		    .socialicons_select_field {
		        display: inline-block;
		        margin-right: 10px;
		    }
			.socialicons_field input,
			.socialicons_select_field select {
			    border-radius: 0;
			    border: 1px solid #ccc;
			}
		    .icondeletemove {
		        /*display: inline-block;*/
		    }
			.icondeletemove a.button.removeiconcolumns {
			    background: #ddd;
			    border-radius: 0;
			    border: none;
			}
		    .removeiconcolumns {
		        color: #d9534f;
		        text-decoration: none;
		        cursor: pointer;
		    }
		    .addsocialbtn {
		        margin-top: 10px;
		    }
		    .removeiconcolumns span {
		        font-size: 20px;
		        line-height: 30px;
		        color: red;
		        outline:none;
		    }
		</style>

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

		<script>
			jQuery(document).ready(function($){
				$('#addsocialicons').on('click', function() {
					var row = $('.emptyicons.screen-reader-text').clone(true);
					row.removeClass('emptyicons screen-reader-text');
					row.insertBefore('#repeatable_socialicons .allicolist>.removescicons:last');
					return false;
				});
				$('.removeiconcolumns').on('click', function() {
					$(this).parents('.removescicons').remove();
					return false;
				});
			 	$('#repeatable_socialicons .allicolist').sortable({
					opacity: 0.6,
					revert: true,
					cursor: 'move',
					handle: '.sorticonlists'
				}); 
			});
		</script>
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