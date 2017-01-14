<?php
class Loan {
	
	const YEAR = 360;  // Number of days in year to use in calculations
	
	const INTERVAL_YEARLY  = 'yearly';
	const INTERVAL_MONTHLY = 'monthly';

	public static function calculateEffectiveInterest()
	{	
		$loan = new Loan();
		$result = $loan->approximateInterest(0.3);
	
		return $result;
	}
	
	protected function resolveInterval($interval)
	{
		switch ($interval)
		{
			case self::INTERVAL_MONTHLY:
				return 30;
			case self::INTERVAL_YEARLY:
				return Loan::YEAR;
			default:
				throw new Exception('Unexpected loan payment interval ' . $interval);
		}
	}
	
	public function approximateInterest($interest, $min = 0, $max = 100, $max_iterations = 100)
	{
		$result   = $_POST['loan_amount'];
		$interval = $this->resolveInterval($_POST['payment_interval']);
		$instalment = $_POST['instalment'];
		$parts = $_POST['parts'];
		$precission = 0.00001;
		
		for($part = 1; $part <= $parts; $part++)
		{
			$result -= $instalment * pow((1 + $interest), -($part * $interval) / Loan::YEAR);
		}
		
		
		if ($max_iterations == 0)
		{
			return false;
		}
		
		if (abs($max - $min) < $precission)
		{
			// Necessary precission has been reached return result
			return $interest;
		}
		else
		if ($result > 0)
		{
			// Interest is too large, reduce interest with half of remaining range
			return $this->approximateInterest($interest - ($interest - $min) / 2, $min, $interest, --$max_iterations);
		}
		else
		if ($result < 0)
		{
			// Interest is too small, increase interest with half of remaining range
			return $this->approximateInterest($interest + ($max - $interest) / 2,  $interest, $max, --$max_iterations);
		}
	}
}
