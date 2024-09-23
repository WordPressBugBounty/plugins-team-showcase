<?php

	if ( ! defined( 'ABSPATH' ) ) {
		exit; // Exit if accessed directly.
	}

?>

	<ul class="tp-tmffree-popup-info">
		<?php if( !empty( $team_manager_free_client_email )) { ?>
			<li class="tp-tmffree-popup-email">
				<i class="fa fa-envelope"></i>
				<a href="mailto:<?php echo sanitize_email($team_manager_free_client_email);?>"><?php echo sanitize_email( $team_manager_free_client_email );?></a>
			</li>
		<?php } ?>
		<?php if( !empty( $team_manager_free_client_number )) { ?>
			<li class="tp-tmffree-popup-contact">
				<i class="fa fa-phone"></i>
				<a href="tel:<?php echo esc_attr($team_manager_free_client_number);?>"><?php echo esc_html( $team_manager_free_client_number );?></a>
			</li>
		<?php } ?>
		<?php if( !empty( $team_manager_free_client_address )) { ?>
			<li class="tp-tmffree-popup-address">
				<i class="fa fa-map-marker"></i>
				<?php echo esc_attr( $team_manager_free_client_address );?>
			</li>
		<?php } ?>
		<?php if( !empty( $team_manager_free_client_website )) { ?>
			<li class="tp-tmffree-popup-website">
				<i class="fa fa-globe"></i>
				<a href="<?php echo esc_url( $team_manager_free_client_website );?>"><?php echo esc_html( $team_manager_free_client_website );?></a>
			</li>
		<?php } ?>
	</ul>