<?php

$socials = get_field('social_media_links', 'option');
$twitter = $socials['twitter_link'];
$linkedin = $socials['linkedin_link'];
$facebook = $socials['facebook_link'];

if ( $socials ) : ?>

<style>

	.social-container {
		display: flex;
		align-items: center;
		flex-wrap: wrap;
		gap: 1em;
	}
	
	.social-container a:hover {
		overflow: hidden;
	}

	.social-container a:hover img {
		filter: drop-shadow(2em 0px 0px rgb(var(--primary)));
		transform: translateX(-2em);
	}

</style>

<div class="social-container">
	
	<?php if ( $twitter ) :

		$twitterIcon = '/wp-content/uploads/2023/07/twitter.svg';
		
	?>
	
		<a href="<?= $twitter ?>" target="_blank">
			<img src="<?= $twitterIcon ?>" alt="Twitter Icon" />
		</a>
	
	<?php endif; ?>
	
	<?php if ( $linkedin ) : 
	
		$linkedinIcon = '/wp-content/uploads/2023/07/linkedin.svg';
	
	?>
	
		<a href="<?= $linkedin ?>" target="_blank">
			<img src="<?= $linkedinIcon ?>" alt="LinkedIn Icon" />
		</a>
	
	<?php endif; ?>
	
	<?php if ( $facebook ) : 
	
		$facebookIcon = '/wp-content/uploads/2023/07/facebook.svg';
	
	?>
	
		<a href="<?= $facebook ?>" target="_blank">
			<img src="<?= $facebookIcon ?>" alt="Facebook Icon" />
		</a>
	
	<?php endif; ?>
	
</div>

<?php endif; ?>