<?php

	if ( ! defined( 'ABSPATH' ) ) {
		exit; // Exit if accessed directly.
	}

      ?>

	<div id="team-popup-area-<?php echo esc_attr( $random_team_id ); ?>" class="mfp-hide white-popup style-one">
            <div class="team-manager-container">
                  <div class="team-manager-row">
                  	<div class="tsrow-col-md-4">
                  		<div class="team-manager-popup-left-area">
                  			<div class="left-box-thumbnail">
                  				<?php the_post_thumbnail('large'); ?>
                  			</div>
                  			<div class="left-box-client-information">
							<h3 class="team-manager-popup-designation">
								<?php echo esc_html( $team_manager_free_client_designation );?>
							</h3>
                  				<?php include __DIR__ . '/client-popup-info.php'; ?>
                  			</div>
						<ul class="left-box-social-items">
							<?php include __DIR__ . '/social-info-short.php'; ?>
						</ul>
                  		</div>
                  	</div>
                  	<div class="tsrow-col-md-8">
                  		<div class="team-manager-popup-right-area">
                  			<h2 class="left-box-title"><?php the_title(); ?></h2>
                  			<?php echo wpautop( get_the_content() ); ?>
                  		</div>
                  	</div>
                  </div>
            </div>
	</div>