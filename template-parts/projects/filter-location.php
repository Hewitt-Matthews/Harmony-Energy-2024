<?php
// Get current filter values from URL
$current_location = isset($_GET["location"]) ? $_GET["location"] : NULL;
$site_url = get_site_url();

// Get all locations
$locations = get_terms(array(
  'taxonomy' => 'project-location',
  'hide_empty' => false,
));

// Function to build URL preserving other parameters
function build_filter_url($site_url, $new_location = NULL) {
    // Get existing parameters
    $params = $_GET;
    
    // Update location parameter
    if ($new_location) {
        $params['location'] = $new_location;
    } else {
        unset($params['location']);
    }
    
    // Build URL
    $url = $site_url . "/projects/";
    if (!empty($params)) {
        $url .= '?' . http_build_query($params);
    }
    return $url;
}
?>

<select name="location-dropdown" class="cat-list locations-list" onchange="window.location.href=this.value">
    <option 
        value="<?= build_filter_url($site_url) ?>"
        <?php echo empty($current_location) ? 'selected' : ''; ?>
    ><?php esc_attr( _e( 'All Locations', 'textdomain' ) ); ?></option>
    
    <?php foreach ( $locations as $location ) :
        $slug = $location->slug;
        $title = $location->name;
        $url = build_filter_url($site_url, $slug);
    ?>
        <option 
            value="<?= $url ?>"
            <?php echo ($slug === $current_location) ? 'selected' : ''; ?>
        ><?= $title ?></option>
    <?php endforeach; ?>
</select>