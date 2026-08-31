<?php
	if ( ! defined( 'ABSPATH' ) ) {
		exit; // Exit if accessed directly.
	}
?>

<?php if ( ! empty( $team_manager_free_skills_hide ) ) : ?>
  <?php if ( ! empty( $skills ) ) : ?>
    <div class="skill-bars">
      <?php foreach ( $skills as $skill ) : ?>
        <div class="skill">
          <div class="skill-title">
            <?php echo esc_html( $skill['name'] ); ?>
          </div>
          <div class="skill-bar wow slideInLeft" style="<?php echo esc_attr( 'width:' . intval( $skill['value'] ) . '%;' ); ?>">
            <span class="skill-count1">
              <?php echo esc_html( intval( $skill['value'] ) ); ?>%
            </span>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
<?php endif; ?>