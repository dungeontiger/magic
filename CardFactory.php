<?php
/**
 * Creates Card objects by card name
 */
include_once "Card.php";
include_once "CardType.php";
include_once "CardSubType.php";
include_once "Ability.php";
include_once "TapCost.php";
include_once "ProduceManaEffect.php"; 

class CardFactory
{
	static public function createCard($cardName)
	{
		if (strcasecmp($cardName, "Swamp") == 0)
		{
			return CardFactory::createSwamp();
		}
		else if (strcasecmp($cardName, "Plains") == 0)
		{
			return CardFactory::createPlains();
		}
		else if (strcasecmp($cardName, "Island") == 0)
		{
			return CardFactory::createIsland();
		}
		else if (strcasecmp($cardName, "Forest") == 0)
		{
			return CardFactory::createForest();
		}
		else if (strcasecmp($cardName, "Mountain") == 0)
		{
			return CardFactory::createMountain();
		}
		else if (strcasecmp($cardName, "_blank") == 0)
		{
			return CardFactory::createBlank();
		}
		else
		{
			throw Exception("Unknown or unsupported card name: " . $cardName);
		}
	}
		
	private function __construct()
	{
		// class cannot be abstract final unfortunately
	}
	
	private static function createBlank()
	{
		return new Card("_blank", CardType::BLANK);
	}

	private static function createSwamp()
	{
		$card = new Card("Swamp", CardType::BASIC_LAND, new CardSubType("Swamp"));
		$card->addAbility(new Ability(array(new TapCost()), array(new ProduceManaEffect("B"))));
		return $card;
	}

	private static function createPlains()
	{
		$card = new Card("Plains", CardType::BASIC_LAND, new CardSubType("Plains"));
		$card->addAbility(new Ability(array(new TapCost()), array(new ProduceManaEffect("W"))));
		return $card;
	}

	private static function createIsland()
	{
		$card = new Card("Island", CardType::BASIC_LAND, new CardSubType("Island"));
		$card->addAbility(new Ability(array(new TapCost()), array(new ProduceManaEffect("U"))));
		return $card;
	}

	private static function createForest()
	{
		$card = new Card("Forest", CardType::BASIC_LAND, new CardSubType("Forest"));
		$card->addAbility(new Ability(array(new TapCost()), array(new ProduceManaEffect("G"))));
		return $card;
	}

	private static function createMountain()
	{
		$card = new Card("Mountain", CardType::BASIC_LAND, new CardSubType("Mountain"));
		$card->addAbility(new Ability(array(new TapCost()), array(new ProduceManaEffect("R"))));
		return $card;
	}
}
?>
