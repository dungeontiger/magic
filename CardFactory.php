<?php
/**
 * Creates Card objects by card name
 */
include_once "Card.php";
include_once "CardType.php";
include_once "Ability.php";
include_once "TapCost.php";
include_once "ProduceManaEffect.php"; 

//TODO: Dual lands are not handled properly, need to look at sub type to determine 'rules'

class CardFactory
{
	// when reading in card information
	// information is separated by lines
	// 0: name
	// 1: casting cost - null for lands
	// 2: type (all types)
	// 3: first line of card text, each 'rule' is separated by a line
	// n: all rules, includes flying, infect and all that
	// n+1: null to mark end of rules or no rules
	// last: power / toughness (null for none, * for special)
	
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
			
			// the next lines are considers rules until we encounter a line with null
			$index = 3;
			while(strcasecmp($lines[$index], "null") != 0)
			{
				$this->addRule($card, $lines[$index]);
				$index++;
			}
			
			// the next line is power and toughness separated by a slash
			$index++;
			$this->setPowerToughness($card, $lines[$index]);
			
			// put the card in the cache
			$this->cardCache[$normalizedName] = clone $card;
			return $card;
		}
		
		throw new Exception("Unknown or unsupported card name: " . $cardName . " (file: " . $cardFile . ")");
	}
	
	private function setCastingCost($card, $line)
	{
		if (strcasecmp($line, "null") == 0)
		{
			$card->setCastingCost(null);
		}
		else
		{
			throw new Exception("Unknown casting cost: " . $line);
		}
	}
	
	private function setTypes($card, $line)
	{
		// basic type — sub_types
		$index = strpos($line, $this->dash);
		
		// get the basic type first
		$type = "";
		if ($index === FALSE)
		{
			$type = $line;
		}
		else
		{
			// there is always a space before the dash
			$type = substr($line, 0, $index - 1);
		}
		
		if (strcasecmp($type, "null") == 0)
		{
			$card->setType(CardType::BLANK);
		}
		else if (strcasecmp($type, "Basic Land") == 0)
		{
			$card->setType(CardType::BASIC_LAND);
		}
		else
		{
			throw new Exception("Unknown card type: " . $type);
		}
		
		// get the list of sub types, they are space separated
		// find first space and start from there, dash is always followed by a space
		$space = strpos($line, " ", $index);
		$subTypeText = substr($line, $space + 1);
		$subTypes = explode(" ", $subTypeText);
		foreach($subTypes as $subType)
		{
			$card->addSubType($subType);
		}
	}
	
	private function addRule($card, $rule)
	{
		// of one character, this is a basic land
		if (count($rule) == 1)
		{
			$ability = new Ability(new TapCost(), new ProduceManaEffect($rule));
			$card->addAbility($ability);
		}
		else
		{
			throw new Exception("Unknown or unsupported rule: " . $rule);
		}
	}
	
	private function setPowerToughness($card, $line)
	{
		// power and toughness is always separated by slash with a leading and trailing space
		$space = strpos($line, " ");
		$power = substr($line, 0, $space);
		if (strcasecmp($power, "*") == 0 || ctype_digit($power) == true || strcasecmp($power, "null") == 0)
		{
			if (strcasecmp($power, "null") == 0)
			{
				$card->setPower(null);
			}
			else
			{
				$card->setPower($power);
			}
		}
		else
		{
			throw new Exception("Unknown power in power / toughenss string: " . $power . " (" . $line . ")");
		}
		
		$space2 = strpos($line, " ", $space + 1);
		$toughness = substr($line, $space2 + 1);
		if (strcasecmp($toughness, "*") == 0 || ctype_digit($toughness) == true || strcasecmp($toughness, "null") == 0)
		{
			if (strcasecmp($toughness, "null") == 0)
			{
				$card->setToughness(null);
			}
			else
			{
				$card->setToughness($toughness);
			}
		}
		else
		{
			throw new Exception("Unknown toughness in power / toughenss string: " . $toughness . " (" . $line . ")");
		}
	}
	
	private function getNormalizedName($cardName)
	{
		// make lower case
		// TODO: remove spaces
		// TODO: remove non file name characters
		return strtolower($cardName);
	}
	
	private $cardCache = array();
	private $dash = "—"; 	// dash used to separate types from Oracle output
}
?>
