$(document).ready(function() {
	
	/* off canvas menu ======================================= */
	$('.menu-link, .close-menu').on('click', function(){
		$('#wrap').toggleClass('menu-open');
		return false;
	});

	$('.submenu a').click(function(){
		$(this).parent().toggleClass('submenu-open');
		//return false;
	});

	/* wow ======================================= */
	new WOW().init({
		offset: 20 
	});

	/* Bootstrap Affix ======================================= */		
	$('#modal-bar').affix({
		offset: {
			top: 10,
		}
	});
});