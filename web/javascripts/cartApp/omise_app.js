$("#checkout").submit(function () {
	// Open domwindow
	openDomWindow();

	var form = $(this);

	// Disable the submit button to avoid repeated click.
	form.find("input[type=submit]").prop("disabled", true);

	// Serialize the form fields into a valid card object.

	var expiration_year = "20"+form.find("[data-omise=expiration_year]").val();

	var card = {
		"name": form.find("[data-omise=holder_name]").val(),
		"number": form.find("[data-omise=number]").val(),
		"expiration_month": form.find("[data-omise=expiration_month]").val(),
		"expiration_year": expiration_year,
		"security_code": form.find("[data-omise=security_code]").val()
	};

	// Send a request to create a token then trigger the callback function once
	// a response is received from Omise.
	//
	// Note that the response could be an error and this needs to be handled within
	// the callback.
	Omise.createToken("card", card, function (statusCode, response) {
		if (response.object == "error") {
			// Display an error message.
			var message_text = "SET YOUR SECURITY CODE CHECK FAILED MESSAGE";
			if(response.object == "error") {
				message_text = response.message;
			}
			$("#token_errors").html(message_text);

			// Re-enable the submit button.
			form.find("input[type=submit]").prop("disabled", false);

			// Close domwindow
	        closeDomWindow();
		} else {

			// Then fill the omise_token.
			form.find("[name=omise_token]").val(response.id);

			// Remove card number from form before submiting to server.
			form.find("[data-omise=number]").val("");
			form.find("[data-omise=security_code]").val("");

			// submit token to server. by credit-payment form
			// form.get(0).submit();

			// submit token to server. by checkout_place_order_form form
			var checkout_place_order_form = $('form[name="checkout_place_order_form"]');
			checkout_place_order_form.find("[name=place_order\\[omise_token\\]]").val(response.id);
			checkout_place_order_form.get(0).submit();
		};
	});

	// Prevent the form from being submitted;
	return false;

});
