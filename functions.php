<?php 

/******************************************************************************************
 * Include Shortcode Files
 ******************************************************************************************/
foreach (glob(__DIR__ . "/includes/shortcodes/*.php") as $filename) {
  include $filename;
}

require 'includes/hm-core-functions.php';

/******************************************************************************************
 * Define theme version number so we can force use updated scripts/styles
 ******************************************************************************************/
$theme = wp_get_theme();
define('THEME_VERSION', $theme->Version);

/******************************************************************************************
 * CSS / JS
 ******************************************************************************************/
add_action( 'wp_enqueue_scripts', 'my_enqueue_assets' ); 
function my_enqueue_assets() { 
	
	global $post;
  $initial_page_colour = get_field('initial_page_colour', get_queried_object_id(  )) ? "black" : 'white';
  if(is_category()) $initial_page_colour = 'black';

  	wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css', array(), THEME_VERSION);
	
	wp_enqueue_style( 'main-theme-style', get_stylesheet_directory_uri().'/css/main.css', array(), THEME_VERSION);
	wp_enqueue_script( 'global_js', get_stylesheet_directory_uri() . '/js/all-pages.js', array(), THEME_VERSION);
	wp_localize_script( 'global_js', 'initial_page_colour', $initial_page_colour );
	
	wp_enqueue_style( 'aos-style', 'https://unpkg.com/aos@2.3.1/dist/aos.css');
	wp_enqueue_script( 'aos_js', 'https://unpkg.com/aos@2.3.1/dist/aos.js');

	if( is_front_page() ) {
		wp_enqueue_style( 'homepage-styles', get_stylesheet_directory_uri().'/css/homepage-styles.css', array(), THEME_VERSION); 
	}
	
	if ( !( is_page(341) || is_category() ) ) {
		wp_enqueue_style( 'scrolling-style', get_stylesheet_directory_uri() . '/css/scrolling.css', array(), THEME_VERSION);
	}

  if(is_category()) {
    wp_enqueue_script( 'category_js', get_stylesheet_directory_uri() . '/js/category-pages.js', array(), THEME_VERSION);
  }

  if(is_singular('case-studies') || is_singular())  {
    wp_enqueue_style( 'flickity-style', 'https://cdnjs.cloudflare.com/ajax/libs/flickity/2.2.2/flickity.min.css' );
    wp_enqueue_script( 'flickity-script', 'https://cdnjs.cloudflare.com/ajax/libs/flickity/2.2.2/flickity.pkgd.min.js', array('jquery'), '', true );
  }

}


/******************************************************************************************
 * Google MAPS JS
 ******************************************************************************************/
function enqueue_custom_scripts() {

  if ( is_front_page() || is_singular('services') || is_page(916) ) :

    $projects = get_projects_data();

    wp_enqueue_script( 'map_js', get_stylesheet_directory_uri() . '/js/projects-map.js', array('jquery'), THEME_VERSION);

    wp_enqueue_script('google-maps', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyDILFB7Q95lN4TH65KDQSIwNcz_f5ZDlis&libraries=places&callback=initMap', array(), null, true);
//     wp_enqueue_script('marker-clusterer', 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js', array('jquery'), THEME_VERSION);
// 	wp_enqueue_script('marker-clusterer', 'https://unpkg.com/@googlemaps/markerclusterer/dist/index.min.js', array('jquery'), THEME_VERSION);
    wp_enqueue_script('marker-clusterer', get_stylesheet_directory_uri() . '/js/markerclusterer.js', array(), THEME_VERSION);
    
    // Localize the script with the projects data
    wp_localize_script('map_js', 'projectsData', array(
      'projects' => $projects,
    ));

  endif;
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');

function get_projects_data() {

  $meta_query = array();

  $args = array(
    'post_type' => 'he-projects',
    'posts_per_page' => -1,
    'post_status' => 'publish',
    'orderby' => 'menu_order',
    'order' => 'ASC',
    'meta_query' => $meta_query,
  );

  $projects_query = new WP_Query($args);
  $projects_data = array();

  if ($projects_query->have_posts()) {

    while ($projects_query->have_posts()) {

      $projects_query->the_post();

      $post_id = get_the_ID();

      // Get the location name from the project
      $location_name = get_field('project_specific_location_name');

      // Get latitude and longitude fields
      $latitude = get_field('project_latitude_coordinate');
      $longitude = get_field('project_longitude_coordinate');

      // Get project type for filter
      $project_type = get_field('project_type');
		
	  // Get project info
	  $project_info = get_field('project_info');

      // Get project status for filter
      $statuses = get_the_terms($post_id, 'project-status');
      $project_status = $statuses[0]->term_id;
	  $project_status_name = $statuses[0]->name;

      // Build the project data array
      $project_data = array(
        'project_title' => get_the_title(),
        'location_name' => $location_name,
        'latitude' => floatval($latitude),
        'longitude' => floatval($longitude),
        'type' => $project_type,
        'status' => $project_status,
		'statusName' => $project_status_name,
		'info' => $project_info
      );

      // Add the project data to the projects_data array
      $projects_data[] = $project_data;
    }

    // Restore the original post data
    wp_reset_postdata();

  }

  return $projects_data;
}

/******************************************************************************************
 * Remove WP Logo
 ******************************************************************************************/
function remove_wp_logo_toolbar() {
  global $wp_admin_bar;

  // Remove the WordPress logo from the toolbar
  $wp_admin_bar->remove_menu('wp-logo');
}
add_action('wp_before_admin_bar_render', 'remove_wp_logo_toolbar', 0);

/******************************************************************************************
 * Remove Stuff
 ******************************************************************************************/
function hide_comments_menu() {
	remove_menu_page( 'edit-comments.php' );
	remove_submenu_page('edit.php', 'edit-tags.php?taxonomy=post_tag');
}
add_action( 'admin_menu', 'hide_comments_menu' );

/******************************************************************************************
 * Options Pages
 ******************************************************************************************/
add_action('acf/init', 'my_acf_op_init');
function my_acf_op_init() {

  // Check function exists.
  if( function_exists('acf_add_options_page') ) {
		
    // Register Info page.
    $info_page = acf_add_options_page(array(
      'page_title'    => __('HE Information'),
      'menu_title'    => __('HE Information'),
      'menu_slug'     => 'he-info',
  	  'icon_url' 		=> '/wp-content/uploads/2023/09/favicon-16x16-1.png',
      'position' 		=> 30
    ));

	}

} 

/******************************************************************************************
 * Case Study - Select Featured
 ******************************************************************************************/
function service_case_study_post_object_query( $args, $field, $post_id ) {

	// only show case studies of the current service being edited
	$meta_query[]	= array(
		'relation' => 'AND',
		array(
			'key'		=> 'service',
			'value'		=> $post_id,
			'compare'	=> 'LIKE'
		)
	);
	
	$args['meta_query'] = $meta_query;

	return $args;

}
add_filter('acf/fields/post_object/query/name=featured_case_study', 'service_case_study_post_object_query', 10, 3);

/******************************************************************************************
 * Populate Form - Process
 ******************************************************************************************/
function acf_load_form_select_choices( $field ) {
    
  // Reset choices
  $field['choices'] = array();

  // Make sure Gravity Forms is active
  if (class_exists('GFForms')) {

    // Get a list of forms
    $forms = GFAPI::get_forms();

    // Check if there are forms available
    if (!empty($forms)) {

      if( is_array($forms) ) {
      
        foreach( $forms as $form ) {

          // Exclude forms with IDs 4, 5, and 6
          // if ($form['id'] !== 4 && $form['id'] !== 5 && $form['id'] !== 6) {
            $field['choices'][ $form['id'] ] = $form['title'];
          // }
            
        }
        
      }
    } else {
      echo 'No forms found.';
    }

  } else {
    echo 'Gravity Forms is not active.';
  }

  // Return the field
  return $field;
  
}
add_filter('acf/load_field/name=process_form', 'acf_load_form_select_choices');

function display_warning_message() {
  $screen = get_current_screen();

  echo '<div class="notice notice-warning">';
  echo '<p>Please note, because this website automatically changes the colour as you scroll down, setting text colours in Divi Modules or background colours on Divi sections, will cause these elements NOT to transition when. Only set background colours or colours on text if you\'re sure you don\'t want the element to transition. <br><br> It is advised however, to set a colour on text if you set a section to have a background image. This is because the transitions for colours may conflict with an image when overlaid onto it. Setting the colour on these elements will ensure they don\'t change and conflict with an image</p>';
  echo '</div>';
}

// Added 13th Feb by RM for Wglot code
add_filter( 'weglot_add_json_keys',  'custom_weglot_add_json_keys' );
function custom_weglot_add_json_keys(  $keys  ){
 
    $keys[]  =  'position';
    $keys[]  =  'content';
 
    return $keys;
}

add_action('admin_notices', 'display_warning_message');

// function create_team_member_posts($team_members) {
//   $location_ids = [
//       'United Kingdom' => 525,
//       'France' => 527,
//       'Germany' => 528,
//       'Poland' => 529,
//       'New Zealand' => 530
//   ];

//   foreach ($team_members as $member) {
//       // Check if post already exists by title
//       $existing_post = get_page_by_title($member['name'], OBJECT, 'people');
//       if ($existing_post) {
//           // If post exists, skip to the next team member
//           continue;
//       }

//       // Create post object
//       $post_data = [
//           'post_title'    => wp_strip_all_tags($member['name']),
//           'post_content'  => $member['bio'],
//           'post_status'   => 'publish',
//           'post_type'     => 'people',
//           // Add other post data as needed
//       ];

//       // Insert the post into the database
//       $post_id = wp_insert_post($post_data);

//       // Check for errors
//       if (is_wp_error($post_id)) {
//           // Handle error, log it, or display message
//           continue;
//       }

//       // Update ACF fields
//       $location_id = $location_ids[$member['location']] ?? null;
//       update_field('office', $location_id, $post_id);
//       update_field('position', $member['role'], $post_id);
//   }
// }

// // Usage
// $team_members_json = '[
//   {
//       "name": "Peter Kavanagh",
//       "role": "CEO",
//       "location": "UK",
//       "bio": "Peter founded Harmony Energy in 2010 having spent ten years in finance. He has over 16 years’ experience in the renewable energy sector, in financing and development. Peter is also a Director of Jones Food Company, Europe’s largest high care Hydroponics facility now majority owned by Ocado Group."
//   },
//   {
//       "name": "Alex Thornton",
//       "role": "Operations Director",
//       "location": "UK",
//       "bio": "Alex has over 14 years’ experience managing fast growing businesses in the UK energy sector. He co-founded WindCare Limited – a leading Balance of Plant contractor to the onshore wind market."
//   },
//   {
//       "name": "Pete Grogan",
//       "role": "Commercial Director",
//       "location": "UK",
//       "bio": "Pete is a former projects lawyer and has worked in a broad range of energy businesses including start-ups, hi-tech/high-growth companies and large corporates. He has extensive renewable energy project development experience and is currently based in New Zealand, where he is focused on developing a 500 MW+ pipeline of utility scale solar projects."
//   },
//   {
//       "name": "James Ritchie",
//       "role": "Board Director",
//       "location": "UK",
//       "bio": "James is an award-winning serial entrepreneur with a strong background in renewables. He has over 12 years’ experience as an executive in the energy sector and worked supplying some of the largest companies in the industry. He was formerly founder and CEO of Tekmar Group Plc and is currently Chairman of Energi Coast and CEO of Ritchie Bland Energy Ltd."
//   },
//   {
//       "name": "Paul Mason",
//       "role": "CIO",
//       "location": "UK",
//       "bio": "Paul has 12 years’ experience in the energy sector. In 2018, he co-founded REMAP with Max Slade, a specialist UK battery storage consultancy with a specific focus on revenue forecasting and financial modelling"
//   },
//   {
//       "name": "Max Slade",
//       "role": "General Counsel",
//       "location": "UK",
//       "bio": "Max has 7 years’ experience in the energy sector, three of which were spent at REMAP advising investors & developers on commercial aspects of UK battery storage sector."
//   },
//   {
//       "name": "Gary Camplejohn",
//       "role": "Technical Director",
//       "location": "UK",
//       "bio": "Prior to joining Harmony Gary was a Commercial Engineer with Northern Powergrid where he worked with developers on new connections throughout Yorkshire and the North East England. He is an electrical engineer having spent his early career specialising in military avionic systems in locations around the world, before moving into the energy sector."
//   },
//   {
//       "name": "Frances Nicholson",
//       "role": "Head of Development",
//       "location": "UK",
//       "bio": "Frances is a qualified Chartered Surveyor with 9 years’ experience in developing and gaining consents for large scale renewable energy infrastructure projects. Prior to joining Harmony, Frances worked at EDF Renewables UK where she supported them to develop their first green hydrogen plant and led on a pipeline of utility scale solar at varying stages of the development cycle exceeding 1000MWs."
//   },
//   {
//       "name": "Ked Shayer",
//       "role": "Head of Engineering",
//       "location": "UK",
//       "bio": "Ked has 10 years’ experience in the renewable energy sector, working on offshore and onshore wind, solar and energy storage projects. From a consultancy background, his experience includes due diligence for project financing and Owner’s Engineering."
//   },
//   {
//       "name": "Catherine Strickland",
//       "role": "Head of Property",
//       "location": "UK",
//       "bio": "Catherine has over 15 years’ experience as a property lawyer including 6 years’ experience in the energy sector working both with landowners and developers and 3 years’ experience working in-house, including roles in asset management and financial services."
//   },
//   {
//       "name": "Paul Osborne",
//       "role": "Head of Construction",
//       "location": "UK",
//       "bio": "Paul has over 30 years’ experience in the electrical industry of which 8 have been in renewables, having worked for H&MV Engineering and Smith Brothers."
//   },
//   {
//       "name": "Lucie Peralta-Agass",
//       "role": "Head of Sustainability",
//       "location": "UK",
//       "bio": "Lucie is a sustainability specialist with almost a decade of experience in sustainability strategy development, implementation and reporting at large private and FTSE listed companies. Prior to joining Harmony, Lucie worked in sustainability consulting with Deloitte and most recently in industry with OVO Energy."
//   },
//   {
//       "name": "Alberto Buffa",
//       "role": "Company Secretary and Head of Governance",
//       "location": "UK",
//       "bio": "Alberto is a UK-qualified Company Secretary with significant international experience. He has covered a number of roles in different organisations, ranging from FTSE100 companies to start-ups. Alberto has experience in managing complex international governance arrangements, both in regulated and non-regulated markets, and has a strong understanding of both civil and common law systems."
//   },
//   {
//       "name": "Jamie Vernon",
//       "role": "Head of Asset Management",
//       "location": "UK",
//       "bio": "Having managed the UK’s first commercial-sized battery installed in late-2014, Jamie has built up extensive battery experience in his previous roles before joining Harmony Energy in 2022 to create an asset management team. Working on both the technical and commercial parts of asset management, Jamie has also managed both solar and hydropower assets. Prior to entering the renewable energy sector Jamie worked in energy management and carbon reporting."
//   },
//   {
//       "name": "Emily Taylor",
//       "role": "Graduate Asset Manager",
//       "location": "UK",
//       "bio": "Emily joined the asset management team in 2023 and works on both the commercial and operational sides of the business.  Before entering the renewable energy sector, she spent 3 years at a fintech start-up and graduated in 2022 with a First Class (Hons) degree in Mathematics, Statistics and Economics."
//   },
//   {
//       "name": "Gary Murray",
//       "role": "Senior Project Manager",
//       "location": "UK",
//       "bio": "Gary has over 15 years’ experience in the electrical industry. A time served electrician, Gary has worked his way through to management and has led the delivery of major substation and battery storage projects in the UK and The Nordics.\nPrior to joining Harmony, Gary was a Project Manager for H&MV Engineering, where his latest project included the construction of a 100MW battery storage system."
//   },
//   {
//       "name": "Adil Kuzhi Kandathil",
//       "role": "Project Manager",
//       "location": "UK",
//       "bio": "Adil is a Chartered Mechanical Engineer with 10 years of experience in the renewable energy sector, working on gas peaking plants, energy from waste (EfW), waste heat recovery and district heating projects. Prior to joining Harmony, Adil worked delivering SSE’s district heating schemes in London and delivered UK’s first industrial waste heat recovery project using Organic Rankine Cycle generating technology. Also involved in the development of new EfW facilities & gas peaking projects in the UK."
//   },
//   {
//       "name": "Elliott Lewis",
//       "role": "Project Engineer",
//       "location": "UK",
//       "bio": "Prior to joining Harmony Elliott was a Mechanical Design Engineer at TGA Consultant Engineers where he worked on various projects ranging from school developments to residential builds. Following on from a placement at WSP, Elliott was offered an academic scholarship by the company for his final year of studying where he created a microbial fuel cell which ran on waste coffee grounds."
//   },
//   {
//       "name": "Verity Woodward",
//       "role": "Finance Manager",
//       "location": "UK",
//       "bio": "Verity is a qualified Chartered Accountant. Prior to joining Harmony Verity trained at Mazars, working with both the Corporate tax compliance and advisory teams."
//   },
//   {
//       "name": "Phoebe Gregg",
//       "role": "Assistant Finance Manager",
//       "location": "UK",
//       "bio": "Phoebe is an exam qualified Chartered Accountant and trained with PwC where she previously worked in Audit and Assurance. She has a BSc degree in International Business, Finance and Economics from the University of Manchester."
//   },
//   {
//       "name": "Sarah Kelly",
//       "role": "Junior Management Accountant",
//       "location": "UK",
//       "bio": "Sarah has spent 8 years in education, as a primary school teacher and Senco. She is now working in Harmony’s finance team and embarking on studying for her AAT qualifications."
//   },
//   {
//       "name": "Jack Kelly",
//       "role": "Marketing and Communications Manager",
//       "location": "UK",
//       "bio": "Jack has over 10 years of marketing and communications experience having managed and delivered projects across various industries including Higher Education, sports and renewable energy. In 2019 he delivered Leeds Law School’s best-ever application rates, and at UK Coaching he managed Born2Coach; a nationwide incentive to encourage and inspire diversity and opportunity in sports. He has worked with numerous broadcasters including the BBC, Sky, Mirror and Daily Mail."
//   },
//   {
//       "name": "Hannah Chapman",
//       "role": "Planning Manager",
//       "location": "UK",
//       "bio": "Hannah is a qualified chartered Town Planner with over 7 years’ experience in the planning sector. Prior to joining Harmony Hannah worked at a private planning consultancy helping to deliver planning consents on a range of projects from large scale residential developments to smaller tourism schemes."
//   },
//   {
//       "name": "Tessa Fletcher",
//       "role": "Planning Manager",
//       "location": "UK",
//       "bio": "Tessa is a qualified chartered Town Planner with 2 years of experience in the public sector and over 12 years of experience in the private sector. Prior to joining Harmony, Tessa worked at a planning consultancy helping to prepare, manage and deliver planning consents on a range of residential, commercial and environmental projects."
//   },
//   {
//       "name": "Tim Brewis",
//       "role": "Property Manager",
//       "location": "UK",
//       "bio": "Tim is a Chartered Surveyor with over 36 years’ experience in the Electricity Supply Industry, with extensive knowledge of working for and alongside DNOs and renewable energy companies to obtain wayleave and property related consents. Tim is a farmer’s son and has utility construction and overhead line experience. Prior to joining Harmony, Tim was Property Consultancy Manager for Babcock International Group and Dalcour Maclaren where he delivered large infrastructure projects, BESS facilities and both onshore and offshore windfarm projects."
//   },
//   {
//       "name": "Akbar Lutfullah",
//       "role": "Senior Data Scientist",
//       "location": "UK",
//       "bio": "Akbar is a Data Scientist with experience across data engineering, analytics, modelling, software, and full stack development. He has previously worked at EY for 5 years across the FS Mobility Advisory and Assurance Innovation workstreams."
//   },
//   {
//       "name": "Catherine Drury",
//       "role": "Office Manager",
//       "location": "UK",
//       "bio": "Catherine has spent over 20 years in event management, starting her career as a legal secretary and cashier.  She is an experienced administrator responsible for managing the office on a day to day basis."
//   },
//   {
//       "name": "Andy Symonds",
//       "role": "CEO Harmony Energy France",
//       "location": "",
//       "bio": "Andy has been working in the renewable energy industry since 2005. He has experience in hydro, wind, solar and storage, having worked in New Zealand, the UK and for the last 11 years in France. Qualified in engineering, Andy’s background first had a technical focus, before more recently specialising in contracts and purchasing for renewable energy projects. Over recent years Andy headed up solar pv and battery procurement activities for RES France."
//   },
//   {
//       "name": "Clément Girard",
//       "role": "Directeur Commercial",
//       "location": "",
//       "bio": "Clément has over ten years’ experience in the electricity market. Qualified in engineering and energy, he has since worked in various commercial and consulting roles specialising in smart grid applications, before more recently heading up the development activities for large scale battery energy storage projects at the major renewable energy developer RES France."
//   },
//   {
//       "name": "Cyril Rouquet",
//       "role": "Responsable Ingénierie",
//       "location": "",
//       "bio": "Cyril is a qualified electrical engineer who has specialised in battery energy storage and photovoltaic systems. He heads up the activities for grid connections, electrical studies and project design and optimisation for Harmony’s operations in France."
//   },
//   {
//       "name": "Matthieu Bienvenu",
//       "role": "Développeur Projets Agrivoltaïques",
//       "location": "",
//       "bio": "Matthieu has over 12 years’ experience in various markets, including energy and agricultural sectors. Qualified in business administration and economics, he has been supervising his family-based farming company for the last five years. Matthieu joined Harmony Energy in 2023 to develop the agriPV operations in France."
//   },
//   {
//       "name": "Olivier Amestoy",
//       "role": "Responsable Développement Projets",
//       "location": "",
//       "bio": "Olivier is an experienced business development manager with 7 years of experience acquired in the Australian renewable energy sector (including 3.5 years at Tesla)."
//   },
//   {
//       "name": "Pete Grogan",
//       "role": "Commercial Director",
//       "location": "",
//       "bio": "Pete is a former projects lawyer and has worked in a broad range of energy businesses including start-ups, hi-tech/high-growth companies and large corporates. He has extensive renewable energy project development experience and is currently based in New Zealand, where he is focused on developing a 500 MW+ pipeline of utility scale solar projects."
//   },
//   {
//       "name": "Garth Elmes",
//       "role": "Managing Director",
//       "location": "",
//       "bio": "Garth joined Harmony Energy in September 2022 following eight years at MUFG Bank, a global Japanese bank at which he led a team responsible for a $1.5bn debt book covering a portfolio of clients in the resource, utilities, infrastructure and transport sectors. In that role he was involved in several large transactions in the NZ market, across debt capital markets, project finance, leverage finance and M&A."
//   },
//   {
//       "name": "Jonathon Earl",
//       "role": "General Counsel",
//       "location": "",
//       "bio": "Jonathan is an experienced General Counsel who operates at an executive level. Prior to joining Harmony Energy, he was General Counsel at Kiwi Rail. He has extensive infrastructure expertise in rail and construction. Jonathan has a background in corporate and commercial law and has worked as a senior solicitor at premier law firms in London and Auckland."
//   },
//   {
//       "name": "Gary Freedman",
//       "role": "Operations Director",
//       "location": "",
//       "bio": "Gary is a renewable energy specialist with over two decades of experience developing wind and solar projects in the UK and New Zealand. Prior to Harmony, Gary developed solar and EV projects for Meridian Energy. In the UK he was with Ecotricity and RES before becoming the Commercial Director of Airvolution, successfully delivering 11 wind farms across the country."
//   },
//   {
//       "name": "Sarel Peens",
//       "role": "Technical Director",
//       "location": "",
//       "bio": "With 16 years of consulting experience in the electrical power systems industry, Sarel has worked on numerous projects related to power system network studies, substation, powerline and cable feeder designs. He has managed major turnkey projects throughout South Africa and New Zealand from initiation to final handover, overseeing design and project management components."
//   },
//   {
//       "name": "Christiaan Mostert",
//       "role": "Project Director",
//       "location": "",
//       "bio": "Christiaan is a project management professional with a broad range of experience in complex environments. His areas of expertise include solar, wind, gas turbines, heat capture technologies and transmission systems. He has delivered energy projects in New Zealand, the Emirates, Oman, Turkey, South Africa, the Democratic Republic of the Congo, and Swaziland. He also has extensive O&M experience including the implementation of remote inspection technology."
//   },
//   {
//       "name": "Dariusz Kolasiński",
//       "role": "Executive Director",
//       "location": "",
//       "bio": "Dariusz has been working in the renewable energy industry since 2000. He gained experience in biomass, wind and solar PV, having worked in Poland, Balkans and the GCC (Kuwait, Bahrain, Qatar and Oman)."
//   },
//   {
//       "name": "Michał Maćkowiak",
//       "role": "Executive Director",
//       "location": "",
//       "bio": "A graduate of MBA studies at the University of Aalto in Finland and the prestigious SIMP Norhern Europe program in Stockholm."
//   },
//   {
//       "name": "Tobias Kriete",
//       "role": "Executive Director",
//       "location": "",
//       "bio": "After having worked for more than 10 years in landscape architecture and urban planning in Germany, the United States and Singapore, Tobias moved into the renewable energy industry in 2010. He has been responsible for the development and implementation of several utility-scale solar parks partly with co-located BESS, spearheaded the UK market entry for BayWa r.e’s solar projects business and built the presence of BayWa r.e. in Africa. Tobias has studied landscape architecture and urban planning at TU Dresden."
//   }
// ]'; // Your JSON data here
// $team_members = json_decode($team_members_json, true);
// create_team_member_posts($team_members);





?>