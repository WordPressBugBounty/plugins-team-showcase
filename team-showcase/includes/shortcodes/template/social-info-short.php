<?php
	if ( ! defined( 'ABSPATH' ) ) {
		exit; // Exit if accessed directly.
	}
?>

<?php
	// Check if social profiles exist
	if (!empty($tpteamfree_social_iconbox_repeat)) {
		if (is_array($tpteamfree_social_iconbox_repeat) || is_object($tpteamfree_social_iconbox_repeat)) { ?>
		    <?php foreach ($tpteamfree_social_iconbox_repeat as $scsingleicons) { ?>
		        <li>
		            <a target="<?php echo esc_attr($team_manager_free_social_target); ?>" href="<?php echo esc_url($scsingleicons['sciconsurl']); ?>">
		            	<i class="fa fa-<?php echo esc_attr(strtolower($scsingleicons['select'])); ?>"></i>
		            </a>
		        </li>
		    <?php 
			}
		}
	}else{ ?>
		<?php if(!empty($team_manager_free_social_facebook)){ ?>
			<li><a target="<?php echo esc_attr( $team_manager_free_social_target ); ?>" href="<?php echo esc_url($team_manager_free_social_facebook); ?>" class="fa fa-facebook"></a></li>
		<?php } ?>
		<?php if(!empty($team_manager_free_social_twitter)){ ?>
			<li><a target="<?php echo esc_attr( $team_manager_free_social_target ); ?>" href="<?php echo esc_url($team_manager_free_social_twitter ); ?>" class="fa fa-twitter"></a></li>
		<?php } ?>
		<?php if(!empty($team_manager_free_social_googleplus)){ ?>
			<li><a target="<?php echo esc_attr( $team_manager_free_social_target ); ?>" href="<?php echo esc_url($team_manager_free_social_googleplus); ?>" class="fa fa-google-plus"></a></li>
		<?php } ?>
		<?php if(!empty($team_manager_free_social_instagram)){ ?>
			<li><a target="<?php echo esc_attr( $team_manager_free_social_target ); ?>" href="<?php echo esc_url($team_manager_free_social_instagram); ?>" class="fa fa-instagram"></a></li>
		<?php } ?>
		<?php if(!empty($team_manager_free_social_pinterest)){ ?>
			<li><a target="<?php echo esc_attr( $team_manager_free_social_target ); ?>" href="<?php echo esc_url($team_manager_free_social_pinterest); ?>" class="fa fa-pinterest"></a></li>
		<?php } ?>
		<?php if(!empty($team_manager_free_social_linkedin)){ ?>
			<li><a target="<?php echo esc_attr( $team_manager_free_social_target ); ?>" href="<?php echo esc_url($team_manager_free_social_linkedin); ?>" class="fa fa-linkedin"></a></li>
		<?php } ?>
		<?php if(!empty($team_manager_free_social_dribbble)){ ?>
			<li><a target="<?php echo esc_attr( $team_manager_free_social_target ); ?>" href="<?php echo esc_url($team_manager_free_social_dribbble); ?>" class="fa fa-dribbble"></a></li>
		<?php } ?>
		<?php if(!empty($team_manager_free_social_youtube)){ ?>
			<li><a target="<?php echo esc_attr( $team_manager_free_social_target ); ?>" href="<?php echo esc_url($team_manager_free_social_youtube); ?>" class="fa fa-youtube"></a></li>
		<?php } ?>
		<?php if(!empty($team_manager_free_social_skype)){ ?>
			<li><a target="<?php echo esc_attr( $team_manager_free_social_target ); ?>" href="<?php echo esc_url($team_manager_free_social_skype); ?>" class="fa fa-skype"></a></li>
		<?php } ?>
	<?php
	}
?>