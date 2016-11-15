<?php
class Loan {
	
	const year = 365; 

	public static function calculateRealInterest()
	{
		$loan = 75000;
		$loan_time = 15; // years;
		$interest = 7.5;
		
		$interest = 100;
		$precission = 0.1;
		
		$loan = new Loan();
		$result = $loan->approximateInterest(0.3);
		
		echo 'Result is ' . $result;
		return $result;
		
	}
	
	// Max iterations
	// return value
	public function approximateInterest($interest, $min = 0, $max = 100)
	{
		$result   = 1000;
		$interval = 365;
		$installment = 600;
		$parts = 2;
		$precission = 3;
		
		
		for($part = 1; $part < $parts + 1; $part++)
		{
			$result -= $installment / pow((1+$interest), ($part*$interval)/Loan::year);
		}
		
		
		echo 'End ' .  $result . "<br>";
		echo 'Interest ' . $interest  . ' Min '
. $min . ' Max ' . $max . '<br>';	
		if (abs($result) < $precission)
		{
			// Necessary precission has been reached return result
			echo 'Found ' . $interest;
			return $interest;
		}
		else
		if ($result > 0)
		{
			// Interest is too large, reduce interest
			Loan::approximateInterest($interest - ($interest - $min) / 2, $min, $interest);
		}
		else
		if ($result < 0)
		{
			// Interest is too small, increase interest
			Loan::approximateInterest($interest + ($max - $interest) / 2,  $interest, $max);
		}
		
	}
}

echo 'Effective interest is ' . Loan::calculateRealInterest();
?>