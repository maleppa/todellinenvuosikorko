<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<?php include_once("loan.php"); ?>
	
<title>Todellinen vuosikorko</title>

<script type="text/javascript" src="/js/jquery/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="js/validatePlan.js"></script>

<link rel="stylesheet" href="css/loan.css">
	
</head>

<body>
	
<h1>Todellinen vuosikorko</h1>
<a href="https://fi.wikipedia.org/wiki/Todellinen_vuosikorko">
	<img src="images/info-.png" alt="Wiki">
</a>

<div class="form">
<form method="post" id="effective_interest" name="effective_interest" action="index.php"  onsubmit="return validatePaymentPlan()" >

	<div class="input_field">
		<label>Laina määrä</label> 
		<input type="text" value="<?php echo isset($_POST['loan_amount']) ? $_POST['loan_amount'] : 1000 ?>" size="30" id="loan_amount" name="loan_amount"/>
	</div>
	
	<div class="input_field">
		<label>Lyhennys</label>
		<input type="text" value="<?php echo isset($_POST['instalment']) ? $_POST['instalment'] : 600 ?>" size="30" id="instalment" name="instalment"/>
	</div>
	
	<div class="input_field">
		<label>Lyhennys eriä</label>
		<input type="text" value="<?php echo isset($_POST['parts']) ? $_POST['parts'] : 2 ?>" size="30" id="parts" name="parts"/>
	</div>

	<div class="input_field">
		<input type="radio" <?php echo (isset($_POST['payment_interval']) && $_POST['payment_interval'] == Loan::INTERVAL_MONTHLY) ? 'checked="checked"' : '' ?> name="payment_interval" value="monthly" /> Kuukausittain
		<input type="radio" <?php echo (isset($_POST['payment_interval']) && $_POST['payment_interval'] == Loan::INTERVAL_YEARLY)  ? 'checked="checked"' : '' ?> name="payment_interval" value="yearly" /> Vuosittain
	</div>
   
	<div class="action">
		<button id="calculate_effective_interest" type="submit">Laske</button>
	</div>

</form>
</div>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
	$loan = new Loan();
	try
	{
		$interest = $loan->calculateEffectiveInterest();
		
		if ($interest !== false)
		{
			echo "Todellinen vuosikorko lainalle on " . round($interest * 100, 2) . '%';
		}
		else
		{
			echo "Todellista vuosikorkoa ei pystytty ratkaisemaan";
		}
	}
	catch (Exception $e)
	{
		echo "Odottamaton virhe, asetitko kaikki arvot?";
	}
}

?>
	
</body>
</html>

