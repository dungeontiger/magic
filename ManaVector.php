<?php
/**
 * Map that contains mana.
 * 
 * TODO: Handle X mana
 */
include_once "Color.php";
class ManaVector
{
	public function __construct($symbols = null)
	{
		$this->mana[Color::BLACK] = null;
		$this->mana[Color::BLUE] = null;
		$this->mana[Color::GREEN] = null;
		$this->mana[Color::RED] = null;
		$this->mana[Color::WHITE] = null;
		$this->mana[Color::COLORLESS] = null;
		if ($symbols != null)
		{
			$colorless = "";
			$manaSplit = str_split($symbols);
			foreach($manaSplit as $symbol)
			{
				if (ctype_digit($symbol))
				{
					if ($colorless === null)
					{
						throw new Exception("Malformed mana: " . $symbols);
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
	}
	
	static public function areValidSymbols($symbols)
	{
		$manaSplit = str_split($symbols);
		foreach($manaSplit as $symbol)
		{
			if (!ctype_digit($symbol) &&
				strcasecmp($symbol, "B") != 0 &&
				strcasecmp($symbol, "G") != 0 &&
				strcasecmp($symbol, "R") != 0 &&
				strcasecmp($symbol, "U") != 0 &&
				strcasecmp($symbol, "W") != 0)
			{
				return false;
			}
		}
		return true;
	}
	
	public function getArray()
	{
		return $this->mana;
	}
	
	public function get($color)
	{
		return $this->mana[$color];
	}
	
	public function add($color, $value)
	{
		if ($this->mana[$color] != null)
		{
			$this->mana[$color] += $value;
		}
		else
		{
			$this->mana[$color] = $value;
		}
	}
	
	public function addVector($mana2)
	{
		$this->add(Color::BLACK, $mana2->get(Color::BLACK));
		$this->add(Color::BLUE, $mana2->get(Color::BLUE));
		$this->add(Color::GREEN, $mana2->get(Color::GREEN));
		$this->add(Color::RED, $mana2->get(Color::RED));
		$this->add(Color::WHITE, $mana2->get(Color::WHITE));
		$this->add(Color::COLORLESS, $mana2->get(Color::COLORLESS));
	}
	
	public function divideBy($value)
	{
		$this->mana[Color::BLACK] = $this->mana[Color::BLACK] / $value;
		$this->mana[Color::BLUE] = $this->mana[Color::BLUE] / $value;
		$this->mana[Color::GREEN] = $this->mana[Color::GREEN] / $value;
		$this->mana[Color::RED] = $this->mana[Color::RED] / $value;
		$this->mana[Color::WHITE] = $this->mana[Color::WHITE] / $value;
		$this->mana[Color::COLORLESS] = $this->mana[Color::COLORLESS] / $value;
	}
	
	public function getConvertedTotal()
	{
		$total = 0;
		
		if ($this->mana[Color::BLACK] != null)
		{
			$total += $this->mana[Color::BLACK];
		}
		
		if ($this->mana[Color::BLUE] != null)
		{
			$total += $this->mana[Color::BLUE];
		}

		if ($this->mana[Color::GREEN] != null)
		{
			$total += $this->mana[Color::GREEN];
		}

		if ($this->mana[Color::RED] != null)
		{
			$total += $this->mana[Color::RED];
		}

		if ($this->mana[Color::WHITE] != null)
		{
			$total += $this->mana[Color::WHITE];
		}

		if ($this->mana[Color::COLORLESS] != null)
		{
			$total += $this->mana[Color::COLORLESS];
		}

		return $total;
	}
	
	public function getColorCount()
	{
		$count = 0;
		
		if ($this->mana[Color::BLACK] > 0)
		{
			$count++;
		}
		
		if ($this->mana[Color::BLUE] > 0)
		{
			$count++;
		}
		
		if ($this->mana[Color::GREEN] > 0)
		{
			$count++;
		}
		
		if ($this->mana[Color::RED] > 0)
		{
			$count++;
		}
		
		if ($this->mana[Color::WHITE] > 0)
		{
			$count++;
		}
		
		return $count;
	}
	
	public function getColors()
	{
		$colors = array();
		if ($this->mana[Color::BLACK] > 0)
		{
			array_push($colors, Color::BLACK);
		}
		
		if ($this->mana[Color::BLUE] > 0)
		{
			array_push($colors, Color::BLUE);
		}
		
		if ($this->mana[Color::GREEN] > 0)
		{
			array_push($colors, Color::GREEN);
		}
		
		if ($this->mana[Color::RED] > 0)
		{
			array_push($colors, Color::RED);
		}
		
		if ($this->mana[Color::WHITE] > 0)
		{
			array_push($colors, Color::WHITE);
		}
		return $colors;
	}
	
	public function getManaString()
	{
		$str = "";

		if ($this->mana[Color::COLORLESS] != null)
		{
			$str .= $this->mana[Color::COLORLESS];
		}

		if ($this->mana[Color::BLACK] != null)
		{
			for ($i = 0; $i < $this->mana[Color::BLACK]; $i++)
			{
				$str .= "B";
			}
		}
		
		if ($this->mana[Color::GREEN] != null)
		{
			for ($i = 0; $i < $this->mana[Color::GREEN]; $i++)
			{
				$str .= "G";
			}
		}
		
		if ($this->mana[Color::RED] != null)
		{
			for ($i = 0; $i < $this->mana[Color::RED]; $i++)
			{
				$str .= "R";
			}
		}
		
		if ($this->mana[Color::BLUE] != null)
		{
			for ($i = 0; $i < $this->mana[Color::BLUE]; $i++)
			{
				$str .= "U";
			}
		}
		
		if ($this->mana[Color::WHITE] != null)
		{
			for ($i = 0; $i < $this->mana[Color::WHITE]; $i++)
			{
				$str .= "W";
			}
		}
		
		return $str;
	}
	
	private function addSymbol($symbol)
	{
		if (strcmp($symbol, "B") == 0)
		{
			$this->add(Color::BLACK, 1);
		}
		else if (strcmp($symbol, "U") == 0)
		{
			$this->add(Color::BLUE, 1);
		}
		else if (strcmp($symbol, "G") == 0)
		{
			$this->add(Color::GREEN, 1);
		}
		else if (strcmp($symbol, "R") == 0)
		{
			$this->add(Color::RED, 1);
		}
		else if (strcmp($symbol, "W") == 0)
		{
			$this->add(Color::WHITE, 1);
		}
		else if (ctype_digit($symbol))
		{
			$this->add(Color::COLORLESS, $symbol);
		}
		else
		{
			throw new Exception("Invalid mana symbol: " . $symbol);
		}
	}
	
	private $mana = array();
}
?>
