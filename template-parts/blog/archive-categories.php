<?php

$categories = get_categories();
$current_category = get_query_var('category');

?>

<style>

	.categories-container {
		display: flex;
		flex-wrap: wrap;
		gap: 1em;
		justify-content: flex-end;
	}
	
	.categories-container li {
		list-style: none;
	}

	.categories-container a {
		color: rgb(var(--skDark));
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
	
	<li>
		<a href='<?= get_post_type_archive_link( 'post' ); ?>'
		   <?= !$current_category ? 'class="active"' : "" ?>
		   >All</a>
	</li>
	
	<?php foreach($categories as $category) : ?>
	
		<li><a href='<?= get_post_type_archive_link( 'post' ); ?>?category=<?= $category->slug ?>'
			   <?= $current_category == $category->slug ? 'class="active"' : "" ?>
			   ><?= $category->name ?></a>
	</li>
	
	<?php endforeach; ?>
	
</ul>