// Create an array to store your markers
var markers = [];
var markerClusterer;
var filteredMarkers = [];

async function initMap() {

  const { Map, InfoWindow } = await google.maps.importLibrary("maps");
  //const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");

  const infoWindow = new google.maps.InfoWindow({
    content: "",
    disableAutoPan: true,
  });

  // Create the map
  var map = new Map(document.getElementById("map"), {
    center: { lat: 51.5072, lng: 0.1276 },
    zoom: 7,
    //disableDefaultUI: true,
    //mapId: "HARMONY_ENERGY",
    styles: [
      {
        "featureType": "water",
        "elementType": "geometry",
        "stylers": [{"color": "#004577"}]
      },
      {
        "featureType": "road",
        "elementType": "geometry",
        "stylers": [{"color": "#397b9a"}]
      },
      {
        "featureType": "road",
        "elementType": "labels",
        "stylers": [{"visibility": "off"}]
      },
      {
        "featureType": "administrative",
        "elementType": "labels",
        "stylers": [{"visibility": "off"}]
      },
      {
        "featureType": "poi",
        "elementType": "labels",
        "stylers": [{"visibility": "off"}]
      },
      {
        "featureType": "transit",
        "elementType": "labels",
        "stylers": [{"visibility": "off"}]
      }
    ]
  });

  // Options to pass along to the marker clusterer
  const clusterOptions = {
    imagePath: "https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m",
    gridSize: 100,
    zoomOnClick: false,
    maxZoom: 8,
  };

  // Add a marker clusterer to manage the markers.
  markerClusterer = new MarkerClusterer(map, markers, clusterOptions);
	
	// Define the getGoogleClusterInlineSvg function
	function getGoogleClusterInlineSvg(color) {
		return `<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="white" stroke="#004577" stroke-width="2">
			<circle cx="20" cy="20" r="18" />
			<text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" font-size="18" fill="#004577" font-family="Arial"></text>
		</svg>`;
	}

  // Change styles after cluster is created
  const styles = markerClusterer.getStyles();
  for (let i = 0; i < styles.length; i++) {
		styles[i].textColor = "#004577";
		styles[i].textSize = 18;
	  	styles[i].url = 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(getGoogleClusterInlineSvg('white'));
	  	styles[i].height = 40; // Adjust the height of the cluster marker
    	styles[i].width = 40; // Adjust the width of the cluster marker
  }

  // Add an event listener to the cluster for handling clicks
  google.maps.event.addListener(markerClusterer, "clusterclick", function (cluster) {
    map.setCenter(cluster.getCenter());
    // Zoom in when a cluster is clicked to see individual markers
    map.fitBounds(cluster.getBounds());
  });

  // Create filter elements
  const statusFilter = document.getElementById("status-filter");
  const typeFilter = document.getElementById("type-filter");

  var selectedStatus = statusFilter.value;
  var selectedType = typeFilter.value;

  function filterMarkers() {

    selectedStatus = Number(statusFilter.value);
    selectedType = Number(typeFilter.value);

    // Filter markers based on selected status and type
    filteredMarkers = markers.filter(function (marker) {

      const statusMatch = selectedStatus === 0 || marker.status === selectedStatus;
      const typeMatch = selectedType === 0 || marker.type === selectedType;

      return statusMatch && typeMatch;
    });

    // Clear the current marker clusterer
    if (markerClusterer) {
      markerClusterer.clearMarkers();
    }

    // Create a new marker clusterer with filtered markers
    markerClusterer = new MarkerClusterer(map, filteredMarkers, clusterOptions);

    // Change styles after cluster is created
    const styles = markerClusterer.getStyles();
    for ( let i = 0; i < styles.length; i++ ) {
		styles[i].textColor = "#004577";
		styles[i].textSize = 18;
		styles[i].url = 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(getGoogleClusterInlineSvg('white'));
		styles[i].height = 40; // Adjust the height of the cluster marker
    	styles[i].width = 40; // Adjust the width of the cluster marker
    }

    // Add an event listener to the cluster for handling clicks
    google.maps.event.addListener(markerClusterer, "clusterclick", function (cluster) {
      map.setCenter(cluster.getCenter());
      map.setZoom(map.getZoom()+3);
      // Zoom in when a cluster is clicked to see individual markers
      //map.fitBounds(cluster.getBounds());
    });

  }


  async function initMarkers() {
    // Access the projects data from the localized script
    var projects = projectsData.projects;

    const projectTypeIDs = {
      321: "Solar",
      322: "Battery",
      323: "Wind"
    }

    const projectStatusImages = {
      18: "Pre-Application-Stage",
      19: "In-planning",
      20: "Consented",
      21: "Under-Construction",
      22: "Operational",
    }


    // Loop through the projects and create a map marker for each one
    projects.forEach(function (project) {
  
      var projectName = project.project_title;
      var locationName = project.location_name;

      const position = { lat: project.latitude, lng: project.longitude };

      const marker = new google.maps.Marker({
        map: null, // Markers will be added to the map later
        position: position,
//         icon: `/wp-content/uploads/2023/10/${projectStatusImages[project.status]}.png`,
		icon: `/wp-content/uploads/2023/11/${projectStatusImages[project.status]}.png`,
        title: locationName,
        status: project.status,
        type: project.type,
		info: project.info
      });

      const projectType = project.type;
		
		const infoWindowContent = `
         <h2>${projectName}</h2>
         <p style="padding: 0;"><b>Location:</b> ${locationName}</p>
         <p style="padding: 0;"><b>Project Type:</b> ${projectTypeIDs[projectType]}</p>
		 <p style="padding: 0;"><b>Project Info:</b> ${project.info}</p>
		 <p><b>Project Status:</b> ${project.statusName}</p>
       `;

      marker.addListener("click", () => {
        infoWindow.setContent(infoWindowContent);
        infoWindow.open(map, marker);
      });

      markers.push(marker);
    });
  }

  // Call the initMarkers function to initialize markers asynchronously
  initMarkers().then(() => {
    // Add event listeners for filter changes
    filterMarkers();
    statusFilter.addEventListener("change", filterMarkers);
    typeFilter.addEventListener("change", filterMarkers);

    // Initialize the map after markers are loaded
    //map.fitBounds(markerClusterer.getBounds()); // Fit the initial map bounds
  });

}