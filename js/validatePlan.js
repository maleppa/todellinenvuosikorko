function validatePaymentPlan() {
	if (isNaN($('#loan_amount').val()) || isNaN($('#instalment').val()) || isNaN($('#parts').val())) {
		alert('Kaikkien arvojen tulee olla numeerisia');
		return false;
	}
	
	if (!$("input[name='payment_interval']:checked").val()) {
		alert('Valitse maksuaikataulu');
		return false;
	}
	
	if ($('#loan_amount').val() < $('#instalment').val() * $('#parts').val()) {
		return true;
	}
	else {
		alert('Velan tulee olla vähemmän kuin lyhennysten summa');
		return false;
	}
}
