<?php

$table = [
	'location' => get_field('position_location'),
	'type' => get_field('position_type')[0],
	'job posted' => get_the_date('F j, Y')
]

?>

<style>
	.info-bar-container {
		position: relative;
    	padding-top: 2em;
		display: grid;
		grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
		gap: 2em;
	}

	.info-bar-container::before {
    	content: "";
		position: absolute;
		top: 0;
		left: 0;
		width: calc(100vw - calc(calc(100vw - min(1250px, 80vw)) / 2));
		height: 1px;
		background-color: rgb(var(--white));
	}

	.info-bar-container h3.title {
		font-size: 18px;
		font-weight: bold;
    	padding-bottom: 0px;
	}

	.info-bar-container h3.title + p {
		font-size: 18px;
	}

	.info-bar-container :is(h3, p) {
		color: rgb(var(--white));
	}
</style>

<div class="info-bar-container">
	
	<?php foreach ( $table as $column_title => $content ) : ?>
	
		<?php if ( $content ) : ?>
	
			<div class="column">
				
				<h3 class="title"><?= ucfirst($column_title) ?></h3>
				<p><?= $content ?></p>
				
			</div>
	
		<?php endif; ?>
	
	<?php endforeach; ?>
	
</div>