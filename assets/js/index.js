!(function($) {
	'use strict';

	//Deconnexion
	$('#disconnect-btn').on('click', function() {
		$.ajax({
			type : 'GET',
			data : 'end=1',
			success : function(msg) {
				location.reload();
			}
		});
	});
	
})(jQuery);