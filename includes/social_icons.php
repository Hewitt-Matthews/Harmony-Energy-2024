<ul class="social-icons">
<?php $open_newtab = ' target="_blank' ?>
	
<?php if ( 'on' === et_get_option( 'divi_show_facebook_icon', 'on' ) ) : ?>
	<li class="et-social-icon et-social-facebook">
		<a href="<?php echo esc_url( et_get_option( 'divi_facebook_url', '#' ) ) . '"' . $open_newtab; ?>" class="icon">
			<span><?php esc_html_e( 'Facebook', 'Divi' ); ?></span>
		</a>
	</li>
<?php endif; ?>
	
<?php if ( 'on' === et_get_option( 'divi_show_twitter_icon', 'on' ) ) : ?>
	<li class="et-social-icon et-social-twitter">
		<a href="<?php echo esc_url( et_get_option( 'divi_twitter_url', '#' ) ) . '"' . $open_newtab; ?>" class="icon">
			<span><?php esc_html_e( 'Twitter', 'Divi' ); ?></span>
		</a>
	</li>
<?php endif; ?>
	
<?php if ( 'on' === et_get_option( 'divi_show_linkedin_icon', 'on' ) ) : ?>
	<li class="et-social-icon et-social-linkedin">
		<a href="<?php echo esc_url( et_get_option( 'divi_linkedin_url', '#' ) ) . '"' . $open_newtab; ?>" class="icon">
			<span><?php esc_html_e( 'LinkedIn', 'Divi' ); ?></span>
		</a>
	</li>
<?php endif; ?>
	
<?php if ( 'on' === et_get_option( 'divi_show_instagram_icon', 'on' ) ) : ?>
	<li class="et-social-icon et-social-instagram">
		<a href="<?php echo esc_url( et_get_option( 'divi_instagram_url', '#' ) ) . '"' . $open_newtab; ?>" class="icon">
			<span><?php esc_html_e( 'Instagram', 'Divi' ); ?></span>
		</a>
	</li>
<?php endif; ?>

</ul>