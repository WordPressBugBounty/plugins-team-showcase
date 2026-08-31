<?php

if ( ! defined( 'ABSPATH' ) ) {
      exit; // Exit if accessed directly.
}

?>

<div id="team-popup-area-<?php echo esc_attr( $random_team_id ); ?>" class="mfp-hide white-popup style-three">
      <div class="team-manager-container">
            <div class="team-manager-row">
                  <div class="tsrow-col-md-12">
                        <div class="team-manager-popup-left-area">
                              <div class="left-box-thumbnail">
                                    <?php the_post_thumbnail('large'); ?>
                                    <div class="client-info-box">
                                          <h2 class="left-box-title"><?php the_title(); ?></h2>
                                          <h3 class="team-manager-popup-designation">
                                                <?php echo esc_html( $team_manager_free_client_designation ); ?>
                                          </h3>
                                    </div>
                              </div>
                        </div>
                        <div class="team-manager-popup-right-area">
                              
                              <?php echo wpautop( get_the_content() ); ?>

                              <?php if ( ! empty( $team_popup_skills_hide ) ) : ?>
                                    <?php if ( ! empty( $skills ) ) : ?>
                                          <div class="skill-bars">
                                                <?php foreach ( $skills as $skill ) : ?>
                                                      <div class="skill">
                                                            <div class="skill-title">
                                                                  <?php echo esc_html( $skill['name'] ); ?>
                                                            </div>

                                                            <div class="skill-bar wow slideInLeft"
                                                               style="<?php echo esc_attr( 'width:' . intval( $skill['value'] ) . '%;' ); ?>">
                                                              <span class="skill-count1">
                                                                  <?php echo esc_html( intval( $skill['value'] ) ); ?>%
                                                              </span>
                                                            </div>
                                                      </div>
                                                <?php endforeach; ?>
                                          </div>
                                    <?php endif; ?>
                              <?php endif; ?>
                              
                              <div class="left-box-client-information">
                                    <?php include __DIR__ . '/client-popup-info.php'; ?>
                              </div>
                              <ul class="left-box-social-items">
                                    <?php include __DIR__ . '/social-info-short.php'; ?>
                              </ul>
                        </div>
                  </div>
            </div>
      </div>
</div>