<?php
require_once('filter-helpers.php');

$current_type = isset($_GET["type"]) ? $_GET["type"] : NULL;
$site_url = get_site_url();

$projectsTypesQuery = new WP_Query( array(
	'post_type' => 'services',
	'posts_per_page' => -1,
	'orderby' => 'title',
  'order' => 'ASC'
));

// Function to build URL preserving other parameters
function build_type_url($site_url, $new_type = NULL) {
    $params = $_GET;
    if ($new_type) {
        $params['type'] = $new_type;
    } else {
        unset($params['type']);
    }
    
    $current_lang = get_current_language_prefix();
    $url = $site_url . "/" . $current_lang . "projects/";
    if (!empty($params)) {
        $url .= '?' . http_build_query($params);
    }
    return $url;
}

$options = sprintf(
    '<option value="%s"%s>%s</option>',
    build_type_url($site_url),
    empty($current_type) ? ' selected' : '',
    __('Filter by Type', 'textdomain')
);

if ($projectsTypesQuery->have_posts()) {
    while ($projectsTypesQuery->have_posts()) {
        $projectsTypesQuery->the_post();
        $title = get_the_title();
        $slug = basename(get_the_permalink());
        $url = build_type_url($site_url, $slug);
        $selected = ($slug === $current_type) ? ' selected' : '';
        $options .= sprintf(
            '<option value="%s"%s>%s</option>',
            $url,
            $selected,
            $title
        );
    }
    wp_reset_postdata();
}

printf(
    '<select name="type-dropdown" class="cat-list types-list" onchange="window.location.href=this.value">%s</select>',
    $options
);