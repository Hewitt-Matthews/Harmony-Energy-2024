<?php

$categories = get_categories();

?>

<style>
	.categories-container {
		display: flex;
		flex-wrap: wrap;
		gap: 1em;
		justify-content: flex-start;
		padding: 0!important;
	}
	.categories-container li {
		list-style: none;
	}
	.categories-container a {
		color: #ffffff;
		opacity: 0.7;
	}
	.categories-container a:hover {
		text-decoration: underline;
		opacity: 0.9;
	}
	.categories-container a.active {
		text-decoration: underline;
		font-weight: 600;
		opacity: 1;
	}
</style>

<ul class="categories-container">
	
	<?php foreach($categories as $category) : ?>
	
		<li>
			<a class="btn-primary" href='/category/<?= $category->slug ?>'>
				<?= $category->name ?>
			</a>
		</li>
	
	<?php endforeach; ?>
	
</ul>