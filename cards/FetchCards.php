<?php
class FetchCards
{
	public function getPageForCard($name)
	{
		$page = "";
		$attempts = 0;
		$found = false;
		while ($attempts < 3 && $found == false)
		{
			try
			{
				$page = file_get_contents($this->baseURL . "name=+[%22" . urlencode($name) . "%22]");
				$found = true;
			}
			catch (Exception $e)
			{
				$attempts++;
			}
		}
		
		if (strpos($page, "Your search returned zero results") > 0)
		{
			throw new Exception("Search failed to return results for " . $name);
		}
		
		if (strpos($page, "cardItemTable") > 0)
		{
			throw new Exception("Search returned multiple results for " . $name);
		}
		
		if ($found === false || $page == false)
		{
			throw new Exception("Cannot get page for: " . $name);
		}
		
		$cardName = $this->getCardName($page);
		$manaCost = $this->getManaCost($page);
		$type = $this->getCardType($page);
		$cardText = $this->getCardText($page);
		$pt = $this->getCardPowerToughness($page);
		
		print PHP_EOL;
		print $cardName . PHP_EOL;
		print $manaCost . PHP_EOL;
		print $type . PHP_EOL;
		foreach($cardText as $text)
		{
			print $text . PHP_EOL;
		}
		print $pt . PHP_EOL;
	}
	
	private function getCardName($page)
	{
		// first find Card Name label in html
		$this->offset = strpos($page, "Card Name:");
		if ($this->offset == false)
		{
			throw new Exception("Cannot find text in page: " . "Card Name:");
		}
		
		// the next div contains the actual name
		//
		// the s is to allow . to eat newlines
		// U is for non-greedy matching
		//
		if (!preg_match("/<div class=\"value\">(.*)<\/div>/Us", $page, $matches, 0, $this->offset))
		{
			throw new Exception("Failed to match name: " . $page);
		}
		return ltrim($matches[1]);
	}
	
	private function getManaCost($page)
	{
		$offset = strpos($page, "Mana Cost:", $this->offset);
		if ($offset === false)
		{
			return "null";
		}
		
		$this->offset = $offset;

		if (!preg_match("/<div class=\"value\">(.*)<\/div>/Us", $page, $matches, 0, $this->offset))
		{
			throw new Exception("Failed to match types.");
		}

		return $this->fixManaSymbols(ltrim($matches[1]));
	}
	
	private function getCardType($page)
	{
		$this->offset = strpos($page, "Types:", $this->offset);
		if ($this->offset == false)
		{
			throw new Exception("Cannot find Types: in page.");
		}

		if (!preg_match("/<div class=\"value\">(.*)<\/div>/Us", $page, $matches, 0, $this->offset))
		{
			throw new Exception("Failed to match types.");
		}
		$type = ltrim($matches[1]);
		$type = str_replace("  ", " ", $type);
		$type = str_replace("—", "-", $type); 
		return $type;
	}
	
	private function getCardText($page)
	{
		$offset = strpos($page, "Card Text:", $this->offset);
		if ($offset === false)
		{
			return array("null");
		}

		$this->offset = $offset;

		$cardText = array();
		while(preg_match("/<div class=\"cardtextbox\">(.*)<\/div>/Us", $page, $matches, 0, $this->offset))
		{
			$this->offset = strpos($page, $matches[1], $this->offset);
			$temp = ltrim($matches[1]);
			$temp = preg_replace("/<i>(.*)<\/i>/", "", $temp);
			$temp = $this->fixManaSymbols($temp);
			$temp = str_replace("—", "-", $temp); 
			if (strlen($temp) > 0)
			{
				array_push($cardText, $temp);
			}
		}
		
		return $cardText;
	}
	
	private function getCardPowerToughness($page)
	{
		$offset = strpos($page, "P/T:", $this->offset);
		if ($offset == false)
		{
			$offset = strpos($page, "Loyalty:", $this->offset);
			if ($offset == false)
			{
				return "null";
			}
			$this->offset = $offset;
		}

		$this->offset = $offset;

		if (!preg_match("/<div class=\"value\">(.*)<\/div>/Us", $page, $matches, 0, $this->offset))
		{
			throw new Exception("Failed to match P/T.");
		}
		$pt = ltrim($matches[1]);
		$pt = str_replace(" ", "", $pt);
		return $pt;
	}
	
	private function fixManaSymbols($rawMana)
	{
		$rawMana = $this->fixSingleManaSymbol($rawMana, "B", "Black", "B");
		$rawMana = $this->fixSingleManaSymbol($rawMana, "G", "Green", "G");
		$rawMana = $this->fixSingleManaSymbol($rawMana, "R", "Red", "R");
		$rawMana = $this->fixSingleManaSymbol($rawMana, "U", "Blue", "U");
		$rawMana = $this->fixSingleManaSymbol($rawMana, "W", "White", "W");
		
		$rawMana = $this->fixSingleManaSymbol($rawMana, "X", "Variable Colorless", "X");
		
		$rawMana = $this->fixSingleManaSymbol($rawMana, "tap", "Tap", "T");
		
		$rawMana = $this->fixSingleManaSymbol($rawMana, "BR", "Black or Red", "b/r");
		$rawMana = $this->fixSingleManaSymbol($rawMana, "BG", "Black or Green", "b/g");
		$rawMana = $this->fixSingleManaSymbol($rawMana, "WU", "White or Blue", "w/u");
		$rawMana = $this->fixSingleManaSymbol($rawMana, "UR", "Blue or Red", "u/r");
		$rawMana = $this->fixSingleManaSymbol($rawMana, "GW", "Green or White", "g/w");
		
		$rawMana = $this->fixSingleManaSymbol($rawMana, "BP", "Phyrexian Black", "b/p");
		$rawMana = $this->fixSingleManaSymbol($rawMana, "GP", "Phyrexian Green", "g/p");
		$rawMana = $this->fixSingleManaSymbol($rawMana, "RP", "Phyrexian Red", "r/p");
		$rawMana = $this->fixSingleManaSymbol($rawMana, "UP", "Phyrexian Blue", "u/p");
		$rawMana = $this->fixSingleManaSymbol($rawMana, "WP", "Phyrexian White", "w/p");

		for($i = 0; $i < 21; $i++)
		{
			$rawMana = $this->fixSingleManaSymbol($rawMana, $i, $i, $i);
		}
		return $rawMana;
	}
	
	private function fixSingleManaSymbol($rawMana, $symbol, $altSymbol, $replace)
	{
		$imageMedium = "<img src=\"/Handlers/Image.ashx?size=medium&amp;name=$symbol&amp;type=symbol\" alt=\"$altSymbol\" align=\"absbottom\" />";
		$imageSmall = "<img src=\"/Handlers/Image.ashx?size=small&amp;name=$symbol&amp;type=symbol\" alt=\"$altSymbol\" align=\"absbottom\" />";
		$temp = str_replace($imageMedium, $replace, $rawMana);
		$temp = str_replace($imageSmall, $replace, $temp); 
		return $temp;
	}
	
	//http://gatherer.wizards.com/Pages/Search/Default.aspx?name=+[%22Goblin%20King%22]
	private $baseURL = "http://gatherer.wizards.com/Pages/Search/Default.aspx?";
	private $offset = 0;
}
?>
