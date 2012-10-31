<?php
include_once "CardCollection.php";
include_once "CardFactory.php";
class Deck extends CardCollection
{
	public function __construct($deckString)
	{
		$factory = new CardFactory();
		// $deckString is in the format of #,CardName
		$lines = explode(PHP_EOL, $deckString);
		foreach($lines as $line)
		{
			$pieces = explode(",", $line);
			for($i = 0; $i < $pieces[0]; $i++)
			$this->addCard($factory->createCard($pieces[1]));
		}
		
		$this->computeStatistics();
	}
	
	public function drawCard()
	{
		return $this->drawTopCard();
	}
	
	public function getBasicLandsStats()
	{
		return $this->basicLands;
	}
	
	public function getUniqueCardCount()
	{
		return $this->uniqueCardCount;
	}
	
	public function getCardTypes()
	{
		return $this->types;
	}
	
	public function getStartingCardCount()
	{
		return $this->totalNumberOfCards;
	}
	
	public function getNumberOfColors()
	{
		return $this->numberOfColors;
	}
	
	public function getCardsByCastingCost()
	{
		return $this->castingCost;
	}
	
	public function getCardColors()
	{
		return $this->colors;
	}
	
	public function getSubTypes()
	{
		return $this->subTypes;
	}
	
	private function computeStatistics()
	{
		$cards = $this->getCards();
		
		// record the basic land counts
		$this->basicLands = array();
		
		// count how many of each card, generally should be a max of 4 each
		$this->uniqueCardCount = array();
		
		// count each type, cards might count more than once
		$this->types = array();
		
		// count number of cards by number of colors
		$this->numberOfColors = array();
		
		// record the total number of cards.  Should be 60
		$this->totalNumberOfCards = count($cards);
		
		// count cards by casting cost, 0, 1, 2, etc...
		$this->castingCost = array();
		
		// colors of each card, multicolored cards will count more than once
		$this->colors = array();
		
		// count the subtypes, again a card might count more than once
		$this->subTypes = array();
		
		// process all the cards
		foreach($cards as $card)
		{
			// count the basic lands
			if ($card->isType(CardType::BASIC_LAND))
			{
				if ($card->isASubType("Swamp"))
				{
					$this->incrementCount($this->basicLands, "Swamp");
				}
				else if ($card->isASubType("Forest"))
				{
					$this->incrementCount($this->basicLands, "Forest");
				}
				else if ($card->isASubType("Mountain"))
				{
					$this->incrementCount($this->basicLands, "Mountain");
				}
				else if ($card->isASubType("Island"))
				{
					$this->incrementCount($this->basicLands, "Island");
				}
				else if ($card->isASubType("Plains"))
				{
					$this->incrementCount($this->basicLands, "Plains");
				}
			}
			else
			{
				// more detailed stats for cards other than basic lands
				if (array_key_exists($card->getName(), $this->uniqueCardCount))
				{
					$this->uniqueCardCount[$card->getName()]++;
				}
				else
				{
					$this->uniqueCardCount[$card->getName()] = 1;
				}
				
				// count types, cards may count more than once
				if ($card->isType(CardType::ARTIFACT))
				{
					$this->incrementCount($this->types, CardType::ARTIFACT);
				}
				
				if ($card->isType(CardType::CREATURE))
				{
					$this->incrementCount($this->types, CardType::CREATURE);
				}

				if ($card->isType(CardType::LAND))
				{
					$this->incrementCount($this->types, CardType::LAND);
				}

				if ($card->isType(CardType::ENCHANTMENT))
				{
					$this->incrementCount($this->types, CardType::ENCANTMENT);
				}

				if ($card->isType(CardType::INSTANT))
				{
					$this->incrementCount($this->types, CardType::INSTANT);
				}

				if ($card->isType(CardType::SORCERY))
				{
					$this->incrementCount($this->types, CardType::SORCERY);
				}

				if ($card->isType(CardType::PLANESWALKER))
				{	
					$this->incrementCount($this->types, CardType::PLANESWALKER);
				}
				
				$cost = $card->getCastingCost();
				if ($cost)
				{
					// count the cards by number of colors...mono color, dual color, tricolor, etc...
					$this->incrementCount($this->numberOfColors, $cost->getColorCount());

					// measure converted casting cost
					$this->incrementCount($this->castingCost, $cost->getConvertedTotal());
					
					// record the number of cards of each color
					$cardColors = $card->getCardColors();
					if (count($cardColors) == 0)
					{
						$this->incrementCount($this->colors, Color::COLORLESS);
					}
					else
					{
						foreach($cardColors as $cardColor)
						{
							$this->incrementCount($this->colors, $cardColor);
						}
					}
				}
			}
			
			$subTypes = $card->getSubTypes();
			foreach($subTypes as $subType)
			{
				$this->incrementCount($this->subTypes, $subType);
			}
		}
	}
	
	private function incrementCount(&$array, $key)
	{
		if (array_key_exists($key, $array))
		{
			$array[$key]++;
		}
		else
		{
			$array[$key] = 1;
		}
	}

	private $colors;
	private $basicLands;
	private $uniqueCardCount;
	private $types;
	private $numberOfColors;
	private $totalNumberOfCards;
	private $castingCost;
	private $subTypes;
}
?>
