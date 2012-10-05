<?php
/**
 * This represents a mana cost, not just a simple mana symbol.  
 * So, although it can represent B, it can also represent 3BU or 2WW
 * 
 * Note that the mana must be passed on the constructor and must be 
 * in the order of number first followed by color symbols
 * 
 * TODO: Deal with X (variable colorless mana)
 * 
 */ 
class Mana
{
	public function __construct($mana)
	{
		if ($mana == null)
		{
			throw new Exception("Mana symbol cannot be null.");
		}
		
		$this->mana = array();
		$colorless = "";
		$manaSplit = str_split($mana);
		foreach($manaSplit as $symbol)
		{
			if (ctype_digit($symbol))
			{
				if ($colorless === null)
				{
					throw new Exception("Malformed mana: " . $mana);
				}
				$colorless .= $symbol;
			}
			else
			{
				if ($colorless != null && count($colorless) > 0)
				{
					$this->addSymbol($colorless);
					$colorless = null;
				}
				$this->addSymbol($symbol);
			}
		}
		
		if ($colorless != null && count($colorless) > 0)
		{
			$this->addSymbol($colorless);
		}
	}
	
	public function getMana()
	{
		return implode("", $this->mana);
	}
	
	public function getConvertedTotal()
	{
		$converted = 0;
		foreach($this->mana as $symbol)
		{
			if (ctype_digit($symbol))
			{
				$converted += $symbol;
			}
			else
			{
				$converted++;
			}
		}
		return $converted;
	}
	
	private function addSymbol($symbol)
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
		array_push($this->mana, $symbol);
	}
	
	private $mana;
}
?>
