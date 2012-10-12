<?php
class FetchCards
{
	// the cards array is an array of cards
	// each card is itself an array where each index means something
	//	0: name
	//	1: casting cost (can be 'null')
	//	2: type
	//	3: power and toughness or loyalty (can be 'null')
	public function getCardsForExpansion($expansion)
	{
		print "Fetching cards for..." . $expansion . PHP_EOL;
		$url = $this->baseURL_Expansions . "[\"" . urlencode($expansion) . "\"]";
		$page = file_get_contents($url);
		
		// advance offset to beginning of details
		$this->offset = strpos($page, "textspoiler");
		while($this->processCard($page))
		{
		}
	}

	public function getCards()
	{
		return $this->cards;
	}
	
	private function cleanText($text)
	{
		$temp = ltrim($text);
		$temp = rtrim($temp);
		$temp = str_replace("  ", " ", $temp);
		$temp = str_replace("—", "-", $temp);
		if (strlen($temp) <= 0)
		{
			$temp = "null";
		}
		return $temp; 
	}
	
	private function processCard($page)
	{
		// Name, if we don't find the name it means we have no more cards
		$name =  $this->getName($page);
		if ($name === false)
		{
			return false;
		}

		// all the details of the card will be put as an array, each index meaning something
		$card = array();
		print PHP_EOL . $name . PHP_EOL;
		array_push($card, $name);
		
		// now look for the casting cost
		$castingCost = $this->getCost($page);
		if ($castingCost === false)
		{
			return false;
		}
		print $castingCost . PHP_EOL;
		array_push($card, $castingCost);
		
		// now look for type
		$type = $this->getType($page);
		if ($type === false)
		{
			return false;
		}
		print $type . PHP_EOL;
		array_push($card, $type);
		
		// now look for power and toughness
		$pt = $this->getPT($page);
		if ($pt === false)
		{
			return false;
		}
		print $pt . PHP_EOL;
		array_push($card, $pt);
		
		// now look for rules
		$rule = $this->getRules($page);
		
		// rules are separated by <br />
		$rules = explode("<br />\n", $rule);
		foreach($rules as $r)
		{
			// need to be careful here, this can wipe out (w/p) which is valid
			// these 'sentences' always end with a period, so adding that to the search
			$r = preg_replace("/ \((.*)\.\)/", "", $r);
			$r = preg_replace("/\((.*)\.\)/", "", $r);
			if (strlen($r) > 0)
			{
				print $r . PHP_EOL;
				array_push($card, $r);
			}
		}
		
		array_push($this->cards, $card);
		return true;
	}
	
	private function getRules($page)
	{
		// look for the cost
		$offset = strpos($page, "Rules Text:", $this->offset);
		if ($offset === false)
		{
			return false;
		}
		$this->offset = $offset + 1;
		
		if (!preg_match("/<td>(.*)<\/td>/Us", $page, $matches, 0, $this->offset))
		{
			throw new Exception("Failed to match rules: " . $page);
		}
		
		return $this->cleanText($matches[1]);
	}
	
	private function getPT($page)
	{
		// it could be either Pow/Tgh: or Loyalty:
		// need to find the closer one and use that 
		$offset1 = strpos($page, "Pow/Tgh:", $this->offset);
		$offset2 = strpos($page, "Loyalty:", $this->offset);
		
		if ($offset1 === false && $offset2 === false)
		{
			return false;
		}
	
		if ($offset2 > 0 && $offset2 < $offset1)
		{
			$this->offset = $offset2 + 1;
		}
		else
		{
			$this->offset = $offset1 + 1;
		}
		
		
		if (!preg_match("/<td>(.*)<\/td>/Us", $page, $matches, 0, $this->offset))
		{
			throw new Exception("Failed to match power and toughness or loyalty: " . $page);
		}
		
		return $this->cleanText($matches[1]);
	}
	
	private function getType($page)
	{
		// look for the Name
		$offset = strpos($page, "Type:", $this->offset);
		if ($offset === false)
		{
			return false;
		}
		$this->offset = $offset + 1;
		
		if (!preg_match("/<td>(.*)<\/td>/Us", $page, $matches, 0, $this->offset))
		{
			throw new Exception("Failed to match type: " . $page);
		}
		
		return $this->cleanText($matches[1]);
	}
	
	private function getCost($page)
	{
		// look for the cost
		$offset = strpos($page, "Cost:", $this->offset);
		if ($offset === false)
		{
			return false;
		}
		$this->offset = $offset + 1;
		
		if (!preg_match("/<td>(.*)<\/td>/Us", $page, $matches, 0, $this->offset))
		{
			throw new Exception("Failed to match cost: " . $page);
		}
		
		return $this->cleanText($matches[1]);
	}
	
	private function getName($page)
	{
		// look for the Name
		$offset = strpos($page, "Name:", $this->offset);
		if ($offset === false)
		{
			return false;
		}
		$this->offset = $offset + 1;
		
		if (!preg_match("/<td>(.*)<\/td>/Us", $page, $matches, 0, $this->offset))
		{
			throw new Exception("Failed to match name: " . $page);
		}
		
		if (!preg_match("/>(.*)<\/a>/", $matches[1], $newMatches))
		{
			throw new Exception("Failed to match name from subpiece: " . $$matches[1]);
		}
		return $this->cleanText($newMatches[1]);
	}
	
	private $offset = 0;
	private $baseURL_Expansions = "http://gatherer.wizards.com/Pages/Search/Default.aspx?output=spoiler&method=text&action=advanced&set=%7c";
	private $cards = array();
}
?>