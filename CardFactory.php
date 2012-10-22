<?php
/**
 * Creates Card objects by card name
 */
include_once "Card.php";
include_once "CardType.php";
include_once "RulesFactory.php";

class CardFactory
{
	public function __construct()
	{
		$this->rulesFactory = new RulesFactory();
	}
	
	// when reading in card information
	// information is separated by lines
	// 0: name
	// 1: casting cost (can be null)
	// 2: type (all types)
	// 3: power and toughness or loyalty (can be null)
	// 4+: rules, one per line (can be null)
	
	// TODO: Have to think about the clones here, are the necessary
	// and if yes, are they going to the correct depth?
	
	public function createCard($cardName)
	{
		// if the card is in the cache, clone and return it
		$normalizedName = $this->getNormalizedName($cardName);
		if (array_key_exists($normalizedName, $this->cardCache))
		{
			return clone $this->cardCache[$normalizedName];
		}

		// look for a file name for that card
		$cardFile = "./cards/" . $normalizedName . ".txt";
		$card = $this->createCardFromFile($cardFile);
		if ($card == null)
		{
			throw new Exception("Unknown or unsupported card name: " . $cardName . " (file: " . $cardFile . ")");
		}
	
		// put the card in the cache
		$this->cardCache[$normalizedName] = clone $card;
		return $card;
	}

	// mostly for testing / reporting, cards are not put in the cache
	public function createCardFromFile($cardFile)
	{
		if (file_exists($cardFile))
		{
			$card = null;
			
			// read in the lines of the card
			$file = file_get_contents($cardFile);
			$lines = explode(PHP_EOL, $file);
			
			// 0: Card name
			$card = new Card($lines[0]);
			
			// 1: casting cost as printed on the card
			$this->setCastingCost($card, $lines[1]);
			
			// 2: Type - subtypes
			$this->setTypes($card, $lines[2]);
			
			// if the subtype is a basic land type, create a tap to produce mana rule
			$basicLandRules = $this->rulesFactory->makeBasicLandRules($card->getType()->getSubTypes());
			foreach($basicLandRules as $basicLandRule)
			{
				$card->addRule($basicLandRule);
			}
			
			// 3: Power and Toughness or loyalty
			$this->setPowerToughness($card, $lines[3]);

			// the next lines are considers rules until we encounter a line with null
			$index = 4;
			while(array_key_exists($index, $lines))
			{
				$this->addRule($card, $lines[$index]);
				$index++;
			}
			
			return $card;
		}
		return null;
	}
	
	public function getNormalizedName($cardName)
	{
		// make the name safe for file system
		$normal = str_replace(" ", "_", $cardName);
		$normal = str_replace(",", "_", $normal);
		$normal = str_replace("'", "_", $normal);
		return $normal;
	}
	
	private function setCastingCost($card, $line)
	{
		$castingCost = null;
		if (strcasecmp($line, "null") != 0)
		{
			try
			{
				$castingCost = new ManaVector($line);
			}
			catch(Exception $e)
			{
				$card->setUnsupportedCastingCost();
			}
		}
		$card->setCastingCost($castingCost);
	}
	
	private function setTypes($card, $line)
	{
		$card->setType(new CardType($line));
	}
	
	private function addRule($card, $rule)
	{
		// because of multiple keywords on one line
		// it is possible to get an array of rules back
		// null is returned if there are no rules
		// unknown rules are recorded as such
		// when added to the card, it adjusts its unsupported status automatically
		
		$ruleResults = $this->rulesFactory->makeRule($card->getName(), $rule);
		if ($ruleResults != null)
		{
			if (is_array($ruleResults))
			{
				foreach($ruleResults as $item)
				{
					$card->addRule($item);
				}
			}
			else
			{
				$card->addRule($ruleResults);
			}
		}
	}
	
	private function setPowerToughness($card, $line)
	{
		// power, toughness and loyalty have no meaning for this card
		if (strcasecmp($line, "null") == 0)
		{
			$card->setPower(null);
			$card->setToughness(null);
			$card->setLoyalty(null);
			return;
		}
		
		// look for power and toughness first, in the form (x/y), could be */* as well
		if (preg_match("/\((.*)\/(.*)\)/U", $line, $matches) == 1)
		{
			$card->setPower($matches[1]);
			$card->setToughness($matches[2]);
			return;
		}

		// still here? look for loyalty, in the form (n)
		if (preg_match("/\((.*)\)/U", $line, $matches) == 1)
		{
			$card->setLoyalty($matches[1]);
			return;
		}
		throw new Exception("Does not understand p/t or loyalty: " . $line);
	}
	
	private $cardCache = array();
	private $rulesFactory;
}
?>
