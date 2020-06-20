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
			$('#login-alert').slideDown(1500).delay(1000).slideToggle(1500);
		}else {
			var action = $(this).attr('action');

			$.ajax({
				type : 'GET',
				url : action,
				data : $(this).serialize(),
				success : function(msg) {
					if(msg == 'CONNECTED') {
						location.reload();
					}else if(msg == 'WRONG_PASSWORD'){
						$('#login-alert ').html('Mot de passe incorrect');
						$('#login-alert').slideDown(1500).delay(1000).slideToggle(1500);
					}else if(msg == 'NO_ACCOUNT') {
						$('#login-alert ').html('Voyez créer un compte d\'abord');
						$('#login-alert').slideDown(1500).delay(1000).slideToggle(1500);
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
		
		if(pseudo.val().length < 2) {
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
				$('#signin-alert').removeClass('d-none').hide();
				if(msg == 'Existant') {
					$('#iden').val('');
					$('#iden').removeClass('success');
					$('#iden').addClass('error');
					if($('#signin-alert').hasClass('success')) {
						$('#signin-alert').removeClass('success');
					}
					$('#signin-alert').addClass('alert');
					$('#signin-alert').html('Pseudo utilisé');
					$('#signin-alert').slideDown(1500).delay(1000).slideToggle(1500);
				}else if(msg == 'OK') {
					$('#signin-form input').val('');
					$('#state option').val("Candidat (e)");
					$('#subject option').val("L2");
					if($('#signin-alert').hasClass('alert')) {
						$('#signin-alert').removeClass('alert');
					}
					$('#signin-alert').addClass('success');
					$('#signin-alert').html('Compte créé avec succès');
					$('#signin-alert').slideDown(1500).delay(1000).slideToggle(1500);
				}
			}
		});

	});


	/* 	Validation for discuss form 	*/
	$('.tous').click(function() {
		$('.pastous').attr('checked', '');
		$('.pastous').attr('disabled', '');

		if(!$(this).is(':checked')) {
			$('.pastous').removeAttr('checked');
			$('.pastous').removeAttr('disabled');
		}
	});



	
		
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

	/* 	Validation for chat post form 	*/
	$('#chat-form').submit(function(e) {
		e.preventDefault();

		if($('#msg').val() == '') {
			$('#msg').addClass('error');
			return false;
		}else if($('#msg').hasClass('error')){
			$('#msg').removeClass('error');
		}
		

		var message = $(this).serialize();
		var action = $(this).attr('action');

		$.ajax({
			type: 'POST',
			url : action,
			data : message,
			success : function(msg) {
				if(msg=='OK') {
					location.reload();
				}else if(msg=='Modifie') {
					location.replace('./chats.php?id='+$('#iddiscuss').val());
				}
			}
		});
	});

	/* 	Validation for chat post form 	*/
	$(".mobile-ans #mobile-chat-form").submit(function(e) {
		e.preventDefault();


		if($('.mobile-ans #msg-mobile').val() == '') {
			$('.mobile-ans #msg-mobile').addClass('error');
			return false;
		}else if($('.mobile-ans #msg-mobile').hasClass('error')){
			$('.mobile-ans #msg-mobile').removeClass('error');
		}
			

		var message = $(this).serialize();
		var action = $(this).attr('action');

		$.ajax({
			type: 'POST',
			url : action,
			data : message,
			success : function(msg) {
				if(msg=='OK') {
					location.reload();
				}else if(msg=='Modifie') {
					location.replace('./chats.php?id='+$('#mobile-iddiscuss').val());
				}
				
			}
		});
	});

})(jQuery);
