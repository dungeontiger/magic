<?php
class Mana
{
	public function __construct($symbol)
	{
		if ($symbol != "B" &&
			$symbol != "U" &&
			$symbol != "R" &&
			$symbol != "W" &&
			$symbol != "G" &&
			!ctype_digit($symbol))
		{
			throw new Exception("Invalid mana symbol: " . $symbol);
		}
		$this->color = $symbol;
	}
	
	public function getMana()
	{
		return $this->color;
	}
	
	private $color;
}
?>
