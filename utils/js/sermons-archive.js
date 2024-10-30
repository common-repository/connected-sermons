;(function($){
	$(document).ready(function (){
		$( '.cs_preachers, .cs_series, .cs_topics, .cs_books' ).change( ( e ) => {
			cs_type              = e.target.name;
			cs_value             = e.target.options[ e.target.options.selectedIndex ].value;
			window.location.href = location.protocol + '//' + location.host + location.pathname + '?cs_type=' + cs_type + "&cs_value=" + cs_value;
		});

		function cs_remove_iframe_wrapper() {
			$( ".fluid-width-video-wrapper > iframe" ).each( () => {
				$( ".fluid-width-video-wrapper > iframe" ).unwrap();
				$( "fluid-width-video-wrapper" ).css('padding-bottom: 56.25%');
				clearTimeout( cs_iframe_timer );
			});
		}
		
		cs_iframe_timer = setInterval( cs_remove_iframe_wrapper, 2000 );

	});
})(jQuery);