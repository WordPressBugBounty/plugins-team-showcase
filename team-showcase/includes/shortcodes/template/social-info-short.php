<?php
	if ( ! defined( 'ABSPATH' ) ) {
		exit; // Exit if accessed directly.
	}
?>

<?php
	// Check if social profiles exist
	if (!empty($tpteamfree_social_iconbox_repeat)) {
		if (is_array($tpteamfree_social_iconbox_repeat) || is_object($tpteamfree_social_iconbox_repeat)) { 
		    foreach ($tpteamfree_social_iconbox_repeat as $scsingleicons) { 
	            $icon_name = strtolower($scsingleicons['select']);
	            
	            // Define icons that should not have the "fa-" prefix
	            $nonbrand_icons = ['icon-tmf-threads-icon', 'icon-tmf-bluesky-icon', 'icon-tmf-tiktok-icon', 'icon-tmf-mastodon'];

	            // Check if the icon is in the non-brand list
	            if (in_array($icon_name, $nonbrand_icons, true)) {
	                $icon_class = esc_attr($icon_name);
	            } else {
	                $icon_class = 'fa fa-' . esc_attr($icon_name);
	            }

	            ?>
	            <li>
	                <a target="<?php echo esc_attr($team_manager_free_social_target); ?>" href="<?php echo esc_url($scsingleicons['sciconsurl']); ?>" <?php echo $rel_attr; ?>>
	                    <i class="<?php echo $icon_class; ?>"></i>
	                </a>
	            </li>
				<?php
		    } 
		}
	}
?>