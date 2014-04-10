$(document).ready(
		function() {
			
			$('#next').live(
					'click',
					function(e) {						
						$('html, body').stop().animate({
							scrollTop: $(this).parent().nextAll('div.well-small:first').offset().top - 50
						}, 1000);
					
					e.preventDefault();
			});
			
			$('#prev').live(
					'click',
					function() {
						$('html, body').stop().animate({							
							scrollTop: $(this).parent().prevAll('div.well-small:first').offset().top - 50
						}, 1000);
						
					return false;
					e.preventDefault();	
			});
			
			$('#top').live(
					'click',
					function() {
						$('html, body').animate({
							scrollTop: $(this).parent().prevAll('div.well-small:last').offset().top - 50
						}, 1000);
						
					return false;
					e.preventDefault();	
			});
			
			$('#bott').live(
					'click',
					function() {
						$('html, body').stop().animate({
							scrollTop: $(this).parent().nextAll('div.well-small:last').offset().top - 50
						}, 1000);
					
					e.preventDefault();	
			});
			
	
});
