const navMenuInit = () => {
	
	//Mobile nav menu toggle
	
	const navToggles = document.querySelectorAll('.header-nav.mobile .toggle');
	const toggleLines = document.querySelectorAll('.header-nav.mobile .toggle .line');
	const fixedHeader = document.querySelector('header');
	const fixedHeaderBG = fixedHeader.style.backgroundColor;
	const contentArea = document.querySelector('#et-main-area');
	
	const toggleMenu = (e) => {
		
		let toggle; 
		
		if( e.target.classList.contains('line') ) {
			toggle = e.target.parentElement;
		} else if (e.target.classList.contains('header-nav')) {
			toggle = e.target.children[1];
		} else {
			toggle = e.target;
		}
		
		const mobileNav = document.querySelector('header .mobile-nav .menu-primary-menu-container');
		
		fixedHeader.classList.toggle('active');
		
		if(fixedHeader.classList.contains('active')) {
			fixedHeader.setAttribute('style', 'background-color: #fff!important;')
		} else {
			fixedHeader.setAttribute('style', `background-color: ${fixedHeaderBG}!important;`)
		}
		
		mobileNav.classList.toggle('active');
		contentArea.classList.toggle('pop-up');
		
		toggleLines.forEach((line) => {
			line.classList.toggle('active');
		})
		
	}
	
	navToggles.forEach((toggle) => {
		toggle.addEventListener('click', toggleMenu);
	})
	
}

window.addEventListener('load', navMenuInit);