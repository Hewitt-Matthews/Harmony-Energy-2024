<?php

// // // // // // // // // // // // 
// 
// Shortcode Functions
// 
//  // // // // // // // // // // // 

//Build Shortcode to return the site Logo
add_shortcode( 'logo', 'logo_func' );
function logo_func(  ) {
	
	ob_start();
	$website_logo = et_get_option( 'divi_logo' );
	$website_title = get_bloginfo( 'name' ); 
	?>

		<img src="<?= esc_attr( $website_logo ) ?>" alt="<?= $website_title ?> Logo">

	<?php
    return ob_get_clean();
	
}

//Build Shortcode to output email
add_shortcode( 'contactEmail', 'global_email' );
function global_email(  ) {
	
	ob_start();

	get_template_part('template-parts/global/global-email'); 
	
  return ob_get_clean();
	
}

//Build Shortcode to output Telephone
add_shortcode( 'contactTel', 'global_telephone' );
function global_telephone(  ) {
	
	ob_start();

	get_template_part('template-parts/global/global-tel'); 
	
  return ob_get_clean();
	
}

//Build Shortcode to output social media accounts icons only
add_shortcode( 'socialAccountsIcons', 'global_socials_icons' );
function global_socials_icons(  ) {
	
	ob_start();

	get_template_part('template-parts/global/global-social-icons'); 
	
  return ob_get_clean();
	
}

//Build Shortcode to produce the modified date
add_shortcode( 'getModifiedDate', 'global_modified_date' );
function global_modified_date(  ) {
	
	ob_start();

	$id = get_the_ID();
	$date = get_the_modified_date( 'F j, Y', $id );
	echo $date;
	
	return ob_get_clean();
	
}

//Build Shortcode to output the people list
add_shortcode( 'officeBlocks', 'office_blocks' );
function office_blocks(  ) {
	
	ob_start();

	get_template_part('template-parts/global/global-office-blocks'); 
	
  return ob_get_clean();
	
}

//Build Shortcode to output the company logos
add_shortcode( 'companyLogos', 'company_logos' );
function company_logos(  ) {
	
	ob_start();

	get_template_part('template-parts/global/global-company-logos'); 
	
  return ob_get_clean();
	
}

 //Build Shortcode to output the stats
 add_shortcode( 'stats', 'stats' );
 function stats(  ) {
	
 	ob_start();

 	get_template_part('template-parts/global/global-stats'); 
	
   return ob_get_clean();
	
 }
 


// Build Shortcode to output page stats
add_shortcode( 'page_stats', 'page_stats' );
function page_stats() {
    ob_start();

    // Get the repeater field for the current page
    $stats = get_field('page_statistics', get_queried_object_id());

    if ($stats) : ?>
        <div class="stats-container">
            <?php foreach ($stats as $stat) : ?>
                <div class="stat">
                    <div class="number-container">
                        <span class="number"><?= esc_html($stat['stat_number']) ?></span>
                        <span><?= esc_html($stat['stat_number_append_text']) ?></span>
                    </div>
                    <div class="description">
                        <?= esc_html($stat['stat_description']) ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif;

    return ob_get_clean();
}

//Build Shortcode to output the faqs
add_shortcode( 'faqs', 'faqs' );
function faqs(  ) {
	
	ob_start();

	get_template_part('template-parts/global/global-faqs'); 
	
  return ob_get_clean();
	
}

// // // // // // // // // // // // 
// 
// About Shortcodes
// 
// // // // // // // // // // // // 

//Build Shortcode to output the tabbed content
add_shortcode( 'tabbedContent', 'tabbed_content' );
function tabbed_content(  ) {
	
	ob_start();

	get_template_part('template-parts/about/tabbed-content'); 
	
  return ob_get_clean();
	
}

//Build Shortcode to output the tabbed content
add_shortcode( 'tabbedVerContent', 'vertical_tabbed_content' );
function vertical_tabbed_content(  ) {
	
	ob_start();

	get_template_part('template-parts/about/vertical-tabbed-content'); 
	
  return ob_get_clean();
	
}

//Build Shortcode to output the timeline
add_shortcode( 'timeline', 'timeline' );
function timeline(  ) {
	
	ob_start();

	get_template_part('template-parts/about/timeline'); 
	
  return ob_get_clean();
	
}

//Build Shortcode to output the timeline
add_shortcode( 'graphStats', 'graph_stats' );
function graph_stats(  ) {
	
	ob_start();

	get_template_part('template-parts/about/graph-stats'); 
	
  return ob_get_clean();
	
}

// // // // // // // // // // // // 
// 
// Services Shortcodes
// 
// // // // // // // // // // // // 

//Build Shortcode to output the services blocks
add_shortcode( 'servicesBlocks', 'services_blocks' );
function services_blocks(  ) {
	
	ob_start();

	get_template_part('template-parts/services/archive-services-blocks'); 
	
  return ob_get_clean();
	
}

//Build Shortcode to output the service featured case study
add_shortcode( 'featuredCaseStudy', 'featured_case_study' );
function featured_case_study(  ) {
	
	ob_start();

	get_template_part('template-parts/services/single-case-study'); 
	
  return ob_get_clean();
	
}

// // // // // // // // // // // // 
// 
// Offices Shortcodes
// 
// // // // // // // // // // // // 

//Build Shortcode to output the offices list
add_shortcode( 'officesListing', 'offices_list' );
function offices_list( $atts ) {
	
	ob_start();

	get_template_part('template-parts/offices/archive-offices-post-listing', '', array( 'atts' => $atts )); 
	
  return ob_get_clean();
	
}

//Build Shortcode to output the offices tabbed
add_shortcode( 'officesTabbed', 'offices_tabbed' );
function offices_tabbed( ) {
	
	ob_start();

	get_template_part('template-parts/offices/archive-offices-post-tabbed'); 
	
  return ob_get_clean();
	
}

//Build Shortcode to output the office address
add_shortcode( 'officeAddress', 'office_address' );
function office_address(  ) {
	
	ob_start();

	get_template_part('template-parts/offices/single-office-address'); 
	
  return ob_get_clean();
	
}

//Build Shortcode to output the office email
add_shortcode( 'officeEmail', 'office_email' );
function office_email(  ) {
	
	ob_start();

	$currentID = get_the_ID();

  $office_email = get_field('office_email', $currentID);

  if ( $office_email ) :

    echo '<a href="mailto:' . $office_email . '" class="">' . $office_email . '</a>';

  endif;
	
  return ob_get_clean();
	
}

//Build Shortcode to output the office telephone
add_shortcode( 'officeTelephone', 'office_telephone' );
function office_telephone(  ) {
	
	ob_start();

	$currentID = get_the_ID();

  $office_telephone = get_field('office_telephone', $currentID);

  if ( $office_telephone ) :

    echo '<a href="tel:' . $office_telephone . '" class="">' . $office_telephone . '</a>';

  endif;
	
  return ob_get_clean();
	
}

//Build Shortcode to output the office stats
add_shortcode( 'officeStats', 'office_stats' );
function office_stats(  ) {
	
	ob_start();

	get_template_part('template-parts/offices/single-office-stats'); 
	
  return ob_get_clean();
	
}

// // // // // // // // // // // // 
// 
// People/Team Shortcodes
// 
// // // // // // // // // // // // 

//Build Shortcode to output the people list
add_shortcode( 'teamListing', 'team_list' );
function team_list(  ) {
	
	ob_start();

	get_template_part('template-parts/people/archive-people-post-listing'); 
	
  	return ob_get_clean();
	
}

//Build Shortcode to output the people list
add_shortcode( 'ceoHighlight', 'ceo_highlight' );
function ceo_highlight(  ) {
	
	ob_start();

	get_template_part('template-parts/people/ceo-highlight'); 
	
  return ob_get_clean();
	
}

// Build Shortcode to output the people filter bar
add_shortcode( 'filterPeopleBar', 'filter_people_bar' );
function filter_people_bar(  ) {
	
	ob_start();

	?>

	<style>	
		.filters .teams-list {
			display: none;
		}
	</style>
	
	<div class="filters">

		<?= do_shortcode("[filterPeopleLocation]"); ?>
		
		<?= do_shortcode("[filterPeopleTeam]"); ?>

	</div>

	<?php
	
  	return ob_get_clean();
	
}

// Build Shortcode to output the people location filter
add_shortcode( 'filterPeopleLocation', 'filter_people_location' );
function filter_people_location(  ) {
	
	ob_start();

	get_template_part('template-parts/people/filter', 'location'); 
	
  return ob_get_clean();
	
}

// Build Shortcode to output the people team filter
add_shortcode( 'filterPeopleTeam', 'filter_people_team' );
function filter_people_team(  ) {
	
	ob_start();

	get_template_part('template-parts/people/filter', 'team'); 
	
  return ob_get_clean();
	
}

// // // // // // // // // // // // 
// 
// Careers Shortcodes
// 
// // // // // // // // // // // // 

//Build Shortcode to output the careers list
add_shortcode( 'careersList', 'careers_list' );
function careers_list(  ) {
	
	ob_start();

	get_template_part('template-parts/careers/archive-careers-post-listing'); 
	
  return ob_get_clean();
	
}

//Build Shortcode to output the careers list
add_shortcode( 'careerDetailsGrid', 'career_details_grid' );
function career_details_grid(  ) {
	
	ob_start();

	get_template_part('template-parts/careers/single-career-details-grid'); 
	
  return ob_get_clean();
	
}

//Build Shortcode to output the offset info
add_shortcode( 'valuesOffsetInfo', 'careers_offset_info' );
function careers_offset_info(  ) {
	
	ob_start();

	get_template_part('template-parts/careers/offset-info'); 
	
  return ob_get_clean();
	
}

//Build Shortcode to output the offset info
add_shortcode( 'benefitsCardGrid', 'careers_card_grid' );
function careers_card_grid(  ) {
	
	ob_start();

	get_template_part('template-parts/careers/card-grid'); 
	
  return ob_get_clean();
	
}

// // // // // // // // // // // // 
// 
// Projects Shortcodes
// 
// // // // // // // // // // // // 

// Build Shortcode to output the projects filter bar
add_shortcode( 'filterProjectsBar', 'filter_projects_bar' );
function filter_projects_bar(  ) {
	
	ob_start();

	?>

		<div class="search-filters">
		
			<?=  do_shortcode("[filterProjectsLocation]"); ?>

			<?=  do_shortcode("[filterProjectsType]"); ?>

			<?= do_shortcode("[filterProjectsStatus]"); ?>

		</div>

	<?php
  
	return ob_get_clean();
	
}

// Build Shortcode to output the projects location filter
add_shortcode( 'filterProjectsLocation', 'filter_projects_location' );
function filter_projects_location(  ) {
	
	ob_start();

	get_template_part('template-parts/projects/filter', 'location'); 
	
  return ob_get_clean();
	
}

// Build Shortcode to output the projects type filter
add_shortcode( 'filterProjectsType', 'filter_projects_type' );
function filter_projects_type(  ) {
	
	ob_start();

	get_template_part('template-parts/projects/filter', 'type'); 
	
  return ob_get_clean();
	
}

// Build Shortcode to output the projects status filter
add_shortcode( 'filterProjectsStatus', 'filter_projects_status' );
function filter_projects_status(  ) {
	
	ob_start();

	get_template_part('template-parts/projects/filter', 'status'); 
	
  return ob_get_clean();
	
}

// Build Shortcode to output the projects filter bar
add_shortcode( 'projectsList', 'projects_list' );
function projects_list(  ) {
	
	ob_start();
	
	get_template_part('template-parts/projects/archive-projects-post-listing'); 
	
  return ob_get_clean();
	
}

// Build Shortcode to output the projects map
add_shortcode( 'projectsMap', 'projects_map' );
function projects_map(  ) {
	
	ob_start();
	
	get_template_part('template-parts/projects/projects-map'); 
	
  return ob_get_clean();
	
}

// // // // // // // // // // // // 
// 
// News Shortcodes
// 
// // // // // // // // // // // // 

add_shortcode( 'highlightedPost', 'highlighted_post' );
function highlighted_post(  ) {
	
	ob_start();

	get_template_part('template-parts/news/highlighted-post'); 
	
  return ob_get_clean();
	
}

add_shortcode( 'blogLoop', 'blog_loop' );
function blog_loop(  ) {
	
	ob_start();

	get_template_part('template-parts/news/archive', 'loop'); 
	
  return ob_get_clean();
	
}

add_shortcode( 'categories', 'posts_categories' );
function posts_categories(  ) {
	
	ob_start();
	
	get_template_part('template-parts/news/archive', 'categories'); 
	
  return ob_get_clean();
	
}

add_shortcode( 'postAuthor', 'post_author' );
function post_author(  ) {
	
	ob_start();

  $author = get_field('post_author');

  if($author) {
	  $name = get_the_title($author);
	  echo $name;
  } else {
	  echo 'Harmony Energy';
  }

	
  return ob_get_clean();
	
}

// //Build Shortcode to display share links for single blog page
add_shortcode( 'socialShare', 'social_buttons' );
function social_buttons() {

	ob_start();

	global $post;
	$permalink = get_permalink($post->ID);
	$title = get_the_title();

	if(is_single() && !is_page()) { ?>

		<div class="share">

      <div class="icons">
        <a target="_blank"  href="https://www.facebook.com/sharer/sharer.php?u=<?= $permalink ?>"
			onclick="window.open(this.href, \'facebook-share\',\'width=580,height=296\');return false;"><span class='et-pb-icon'>&#xe093;</span></a>
			  <a target="_blank"  href="http://twitter.com/share?text=<?= $title ?>&url=<?= $permalink ?>"
			onclick="window.open(this.href, \'twitter-share\', \'width=550,height=235\');return false;"><span class='et-pb-icon'>&#xe094;</span></a>
			  <a target="_blank" href="https://www.linkedin.com/sharing/share-offsite/?url=<?= $permalink ?>"
			onclick="window.open(this.href, \'linkedin-share\', \'width=490,height=530\');return false;"><span class='et-pb-icon'>&#xe09d;</span></a>
      </div>
			
		</div>

    <?php $myvariable = ob_get_clean();
    return $myvariable;
  }
}

// // // // // // // // // // // // 
// 
// Case Studies Shortcodes
// 
// // // // // // // // // // // // 

add_shortcode( 'caseStudyContentImage', 'case_study_content_image' );
function case_study_content_image(  ) {
	
	ob_start();

	get_template_part('template-parts/case-studies/single', 'content-image'); 
	
  return ob_get_clean();
	
}

//Build Shortcode to output the offset info
add_shortcode( 'caseStudyOffsetInfo', 'case_study_summary_info' );
function case_study_summary_info(  ) {
	
	ob_start();

	get_template_part('template-parts/case-studies/single-summary-info'); 
	
  return ob_get_clean();
	
}

//Build Shortcode to output the gallery
add_shortcode( 'caseStudyGallery', 'case_study_gallery' );
function case_study_gallery(  ) {
	
	ob_start();

	get_template_part('template-parts/case-studies/single-gallery'); 
	
  return ob_get_clean();
	
}

// // // // // // // // // // // // 
// 
// Processes Shortcodes
// 
// // // // // // // // // // // // 

//Build Shortcode to output the process stepped content
add_shortcode( 'steppedContentProcess', 'stepped_content_process' );
function stepped_content_process(  ) {
	
	ob_start();

	get_template_part('template-parts/processes/single-stepped-content'); 
	
  return ob_get_clean();
	
}

//Build Shortcode to output the process form
add_shortcode( 'processForm', 'process_form' );
function process_form( ) {
	
	ob_start();

  // Get survey_form of current survey
  $form_id = get_field('process_form');

  echo do_shortcode('[gravityform id="' . $form_id . '" title="true" description="true" ajax="true"]');

  return ob_get_clean();
    
}

// // // // // // // // // // // // 
// 
// ESG Shortcodes
// 
// // // // // // // // // // // // 

//Build Shortcode to output the tabbed content
add_shortcode( 'tabbedContentESG', 'tabbed_content_esg' );
function tabbed_content_esg(  ) {
	
	ob_start();

	get_template_part('template-parts/esg/tabbed-content'); 
	
  return ob_get_clean();
	
}

//Build Shortcode to output the offset content
add_shortcode( 'offsetInfoESG', 'offset_info_esg' );
function offset_info_esg(  ) {
	
	ob_start();

	get_template_part('template-parts/esg/offset-info'); 
	
  return ob_get_clean();
	
}

//Build Shortcode to output the offset content
add_shortcode( 'causesESG', 'causes_esg' );
function causes_esg(  ) {
	
	ob_start();

	get_template_part('template-parts/esg/causes'); 
	
  return ob_get_clean();
	
}

// // // // // // // // // // // // 
// 
// Testimonials Shortcodes
// 
// // // // // // // // // // // // 

add_shortcode( 'testimonialsList', 'testimonials_list' );
function testimonials_list(  ) {
	
	ob_start();

	get_template_part('template-parts/testimonials/archive', 'testimonials-post-listing'); 
	
  return ob_get_clean();
	
}

add_shortcode( 'testimonialSlider', 'testimonial_slider' );
function testimonial_slider(  ) {
	
	ob_start();

	get_template_part('template-parts/testimonials/archive', 'testimonials-slider'); 
	
  return ob_get_clean();
	
}

// // // // // // // // // // // // 
// 
// Layout Shortcodes
// 
// // // // // // // // // // // // 

//Build Shortcode to create header
add_shortcode( 'header', 'header_func' );
function header_func(  ) {
    
	ob_start();
	wp_enqueue_script( 'nav_menu_js', get_stylesheet_directory_uri() . '/js/nav-menu.js', array(), THEME_VERSION, true );
	wp_enqueue_style( 'nav_styles', get_stylesheet_directory_uri() . '/css/nav-menu.css', array(), THEME_VERSION);
	?>	

	<nav class="header-nav desktop">

		<div class="logo-container">
		   <a href="/"><?= do_shortcode('[logo]') ?></a>
		</div>

		<?php wp_nav_menu( array( 'menu' => "Primary Menu" ) ); ?>

	</nav>

	<div class="header-nav mobile">
		
		<div class="logo-container">
		   <a href="/"><?= do_shortcode('[logo]') ?></a>
		</div>
		
		<div class="toggle">
			<div class="line one"></div>
			<div class="line two"></div>
			<div class="line three"></div>
		</div>
		
		<nav class="mobile-nav">

			<?php wp_nav_menu( array( 'menu' => "Primary Menu" ) ); ?>

		</nav>

	</div>

    <?php return ob_get_clean();
};

//Build Shortcode to Grab Footer Menus
add_shortcode( 'footerMenu', 'footer_menu_func' );
function footer_menu_func( $atts ) {
    
	ob_start();

	$menuID = 12;
	
	if($atts['menu'] == "6") {
		$menuID = 6;
	}  elseif($atts['menu'] == "7") {
		$menuID = 7;
	}  elseif($atts['menu'] == "8") {
		$menuID = 8;
	}   elseif($atts['menu'] == "9") {
		$menuID = 9;
	} ?>

	  <div class="footer-menu">
		
		  <?php wp_nav_menu( array( 'menu' => $menuID ) );?>
		  
	  </div>

  <?php $myvariable = ob_get_clean();
  return $myvariable;
};


?>