<?php
/**
 * Creates Card objects by card name
 */
include_once "Card.php";
include_once "CardType.php";
include_once "Ability.php";
include_once "TapCost.php";
include_once "ProduceManaEffect.php"; 
include_once "Keywords.php";

//TODO: Dual lands are not handled properly, need to look at sub type to determine 'rules'

class CardFactory
{
	public function __construct()
	{
		$this->keywords = new Keywords();
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
			
			// 3: Power and Toughness or loyalty
			$this->setPowerToughness($card, $lines[3]);

			// the next lines are considers rules until we encounter a line with null
			$index = 4;
			while(array_key_exists($index, $lines))
			{
				$this->addRule($card, $lines[$index]);
				$index++;
			}
			
			// put the card in the cache
			$this->cardCache[$normalizedName] = clone $card;
			return $card;
		}
		
		throw new Exception("Unknown or unsupported card name: " . $cardName . " (file: " . $cardFile . ")");
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
			$castingCost = new ManaVector($line);
		}
		$card->setCastingCost($castingCost);
	}
	
	private function setTypes($card, $line)
	{
		// basic type — sub_types
		$index = strpos($line, "-");
		
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
		else if (strcasecmp($type, "Creature") == 0)
		{
			$card->setType(CardType::CREATURE);
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
		if (strlen($rule) == 1)
		{
			$ability = new Ability(new TapCost(), new ProduceManaEffect($rule));
			$card->addAbility($ability);
			return;
		}
		else if (strcasecmp("null", $rule) == 0)
		{
			// nothing to do (is this required?)
			return;
		}
		else if ($this->isAllKeywords($card, $rule))
		{
			// handled by isAllKeywords
			return;
		}
		
		print "Unknown rule: $rule";
		$card->addUnknownRule($rule);
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
		throw new Exception("Does not understand p/t or loyalty:" . $line);
	}
	
	private function isAllKeywords($card, $rule)
	{
		// keywords can come in as single lines or can come in comma separated
		
		// normalize the string by removing commas
		$test = str_replace(",", "", $rule);

		// go through all the possible key words and remove them from the string if found
		$keywords = $this->keywords->getKeywords();
		$foundKeywords = array();
		foreach($keywords as $key => $value)
		{
			$index = stripos($test, $key);
			if ($index === false)
			{
			}
			else
			{
				array_push($foundKeywords, $value);
				$test = str_ireplace($key, "", $test);
			}
		}
		
		// now remove all spaces
		$test = str_replace(" ", "", $test);
		
		// if test is empty it means we found only keywords, this rule is solved
		if (strlen($test) == 0)
		{
			// apply the keywords we found to the card
			foreach($foundKeywords as $keyword)
			{
				$card->addKeyword($keyword);
			}
			return true;
		}
		return false;
	}
	
	private $cardCache = array();
	private $keywords;
}
?>
