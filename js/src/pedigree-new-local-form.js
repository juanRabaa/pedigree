jQuery(document).ready(function($){
	function manageError( response ){
		if( !response ){
			activateFormSentStatus(true);
			return false;
		}

		var message = response.responseText;

		if( message ){
			message = message.trim();
			//Message is JSON
			if(message[0] == '{'){
				message = JSON.parse(message);

				//error_data
				if(message.error && message.error.error_data){
					//TERM EXISTS
					if(message.error.error_data.term_exists){
						window.alert("El nombre de fantasía que ingreso ya existe. Por favor, ingrese otro o seleccione uno de la lista");
						$('html, body').animate({
					        scrollTop: $("#new-ndf-name").offset().top - 100
					    },400, function(){
							$("#new-ndf-name").addClass('input-error');
							$('#new-ndf-name').focus();
						});
						return true;
					}
				}
			}
		}

		activateFormSentStatus(true);
	}

	function activateFormSentStatus( error ){
		$("#main-content").addClass("form-submited");
		$("#new-vet-form").slideUp(400);
		$('html, body').animate({
	        scrollTop: $(".post-content-box").offset().top - 100
	    },400);
		if(!error)
			$(".form-response.success-message").slideDown(400);
		else
			$(".form-response.error-message").slideDown(400);
	}

	function toggleFantasyFields(){
		var campoSelectFantasiaVal = $('#ndf').val();
		if( campoSelectFantasiaVal == 'otro' ){
			$('#new-ndf-name').attr('required', '');
			$('.new-ndf').stop().slideDown();
		}
		else{
			$('#new-ndf-name').removeAttr('required');
			$('.new-ndf').stop().slideUp();
		}
	}

	$('#ndf').change(function(){
		toggleFantasyFields();
	});
	/**
         * The file is enqueued from inc/admin/class-admin.php.
	 */
	$( '#new-vet-form' ).submit( function( event ) {

		event.preventDefault(); // Prevent the default form submit.

		// serialize the form data
		var ajax_form_data = $("#new-vet-form").serialize();

		//add our own ajax check as X-Requested-With is not always reliable
		ajax_form_data = ajax_form_data+'&ajaxrequest=true&submit=Submit+Form';

		$.ajax({
			url:    wp_data.ajaxurl, // domain/wp-admin/admin-ajax.php
			type:   'post',
			data:   ajax_form_data
		})

		.done( function( response ){
			console.log(response);
			activateFormSentStatus();
			//event.target.reset();
		})
		.fail( function(response){
			manageError(response);
			console.log(response);
		})
		.always( function(response){
			console.log(response);
		});

	});
});
