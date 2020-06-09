!(function($) {
	'use strict';

	/*		Validation for login formular 	*/
	$('#login-form').submit(function(e) {
		e.preventDefault();

		var identifiant = $('#identifiant');
		var psswd = $('#motDePasse');

		$('#login-alert').removeClass('d-none').hide();

		if(identifiant.val() == '' || psswd.val() == '') {
			$('#login-alert ').html('Aucun champs ne doit être vide.');
			$('#login-alert').slideDown(1500);
		}else {
			var action = $(this).attr('action');

			$.ajax({
				type : 'GET',
				url : action,
				data : $(this).serialize(),
				success : function(msg) {
					if(msg == 'CONNECTED') {
						location.reload();
					}
					else {
						alert(msg);
					}
				} 
			});
		}
	});


	/* 	Validation for sign in formular 	*/
	var ierror = false;
	$('#signin-form input').on('blur change', function() {
		var pseudo =  $('#iden'),
			psswd = $('#password'),
			rpsswd = $('#psswd-conf');
		
		if(pseudo.val() != '' && pseudo.val().length < 2) {
			pseudo.removeClass('success')
			pseudo.addClass('error');
		}else {
			pseudo.removeClass('error');
			pseudo.addClass('success');
		}

		if(psswd.val().length < 8) {
			psswd.removeClass('success')
			psswd.addClass('error');
		}else{
			psswd.removeClass('error');
			psswd.addClass('success');
		}

		if(rpsswd.val() != psswd.val()){
			rpsswd.removeClass('success');
			rpsswd.addClass('error');
		}else if(rpsswd.val() == ''){
			rpsswd.removeClass('error');
			rpsswd.removeClass('success');
		}else {
			rpsswd.removeClass('error');
			rpsswd.addClass('success');
		}
	});

	$('#signin-form').submit(function(e) {
		e.preventDefault();
		var pseudo =  $('#iden'),
			psswd = $('#password'),
			rpsswd = $('#psswd-conf');
		
		if(pseudo.hasClass('error') || psswd.hasClass('error') ||
			rpsswd.hasClass('error')) return false;
		else  var donnees = $(this).serialize();
		
		var action = $(this).attr('action');

		$.ajax({
			type : "POST",
			url : action,
			data : donnees,
			success : function(msg) {
				alert(msg);
				if(msg == 'Existant') {
					$('#iden').val('');
					$('#iden').removeClass('success');
					$('#iden').addClass('error');
				}else if(msg == 'OK') {
					$('#signin-form input').val('');
					$('#state option').val("Candidat (e)");
					$('#subject option').val("L2");
				}
			}
		});

	});


	/* 	Validation for discuss form 	*/
	$('#discuss-form').submit(function(e) {
		e.preventDefault();

		if($('#pro').val() == '') {
			$('#pro').addClass('error');
			return false;
		}else if($('#pro').hasClass('error')){
			$('#pro').removeClass('error');
		}

		var chat = $(this).serialize();
		var action = $(this).attr('action');

		$.ajax({
			type: 'POST',
			url : action,
			data : chat,
			success : function(msg) {
				//alert(msg);
				location.reload();
			}
		});
	});

})(jQuery);
