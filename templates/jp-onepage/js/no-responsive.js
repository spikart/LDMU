(function($){  

    $(document).ready(function() {  

		var config = $('body').data('config') || {};
	
        // Accordion menu  
        $('.menu-sidebar').accordionMenu({ mode:'slide' });  

        // Dropdown menu  
        $('#menu').dropdownMenu({ mode: 'slide', dropdownSelector: 'div.dropdown'});  

        // Smoothscroller  
		$('a[href="#page"]').smoothScroller({ duration: 500 });
		$('a[href="#mainsite"]').smoothScroller({ duration: 500 });
		$('a[href="#top-a"]').smoothScroller({ duration: 500 });
		$('a[href="#top-b"]').smoothScroller({ duration: 500 });
		$('a[href="#top-c"]').smoothScroller({ duration: 500 });
		$('a[href="#top-d"]').smoothScroller({ duration: 500 });
		$('a[href="#main"]').smoothScroller({ duration: 500 });
		$('a[href="#bottom-a"]').smoothScroller({ duration: 500 });
		$('a[href="#bottom-b"]').smoothScroller({ duration: 500 });
		$('a[href="#bottom-c"]').smoothScroller({ duration: 500 });
		$('a[href="#bottom-d"]').smoothScroller({ duration: 500 });

        // Social buttons  
        $('article[data-permalink]').socialButtons(config);  

        // Match height and widths  
        var match = function() {  
			$.matchWidth('grid-block', '.grid-block', '.grid-h').match();
			$.matchHeight('main', '#maininner, #sidebar-a, #sidebar-b').match();
			$.matchHeight('top-a', '#top-a .grid-h', '.deepest').match();
			$.matchHeight('top-b', '#top-b .grid-h', '.deepest').match();
			$.matchHeight('top-c', '#top-c .grid-h', '.deepest').match();
			$.matchHeight('top-d', '#top-d .grid-h', '.deepest').match();
			$.matchHeight('bottom-a', '#bottom-a .grid-h', '.deepest').match();
			$.matchHeight('bottom-b', '#bottom-b .grid-h', '.deepest').match();
			$.matchHeight('bottom-c', '#bottom-c .grid-h', '.deepest').match();
			$.matchHeight('bottom-d', '#bottom-d .grid-h', '.deepest').match();
			$.matchHeight('innertop', '#innertop .grid-h', '.deepest').match();
			$.matchHeight('innerbottom', '#innerbottom .grid-h', '.deepest').match();
        };  

        match();  

        $(window).bind('load', match);  

    });  

})(jQuery);