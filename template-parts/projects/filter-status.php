<?php

$current_status = isset($_GET["status"]) ? $_GET["status"] : NULL;
$site_url = get_site_url();

$statuses = get_terms(array(
  'taxonomy' => 'project-status',
  'hide_empty' => false,
));


// Function to build URL preserving other parameters
function build_status_url($site_url, $new_status = NULL) {
    // Get existing parameters
    $params = $_GET;
    
    // Update status parameter
    if ($new_status) {
        $params['status'] = $new_status;
    } else {
        unset($params['status']);
    }
    
    // Build URL
    $url = $site_url . "/projects/";
    if (!empty($params)) {
        $url .= '?' . http_build_query($params);
    }
    return $url;
}

?>

<select name="status-dropdown" class="cat-list statuses-list" onchange="window.location.href=this.value">

	<option 
		value="<?= build_status_url($site_url) ?>"
		<?php echo empty($current_status) ? 'selected' : ''; ?>
	><?php esc_attr( _e( 'Filter by Status', 'textdomain' ) ); ?></option>
	
  <?php foreach ( $statuses as $status ) :
	
    $slug = $status->slug;
    $title = $status->name;
    $url = build_status_url($site_url, $slug);
        
  ?>

    <option 
        value="<?= esc_url($url) ?>"
        <?php echo ($slug === $current_status) ? 'selected' : ''; ?>
    ><?= $title ?></option>	

  <?php endforeach; ?>
	
</select>