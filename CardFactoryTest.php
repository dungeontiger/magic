<?php
include_once "CardFactory.php";
class CardFactoryTest extends PHPUnit_Framework_TestCase
{
	// TODO: somehow test the cache
	
	public function testSwamp()
	{
		$factory = new CardFactory();
		$card = $factory->createCard("Swamp");
		$rules = $card->getRules();
		
		assert($card->getType() == CardType::BASIC_LAND);
		assert($card->isASubType("Swamp"));
		assert($card->getCastingCost() == null);
		assert($card->getPower() == null);
		assert($card->getToughness() == null);
		assert($card->getLoyalty() == null);
		assert(count($rules) == 1);
		$ability = $rules[0];
		$costs = $ability->getActivationCosts();
		$effects = $ability->getEffects();
		assert(count($costs) == 1);
		assert(count($effects) == 1);
		assert(is_a($costs[0], "TapCost"));
		assert(is_a($effects[0], "ProduceManaEffect"));
		assert($effects[0]->getProducedMana()->get(Color::BLACK) == 1);
	}
	
	public function testMountain()
	{
		$factory = new CardFactory();
		$card = $factory->createCard("Mountain");
		$rules = $card->getRules();
		
		assert($card->getType() == CardType::BASIC_LAND);
		assert($card->isASubType("Mountain"));
		assert(count($rules) == 1);
		$ability = $rules[0];
		$costs = $ability->getActivationCosts();
		$effects = $ability->getEffects();
		assert(count($costs) == 1);
		assert(count($effects) == 1);
		assert(is_a($costs[0], "TapCost"));
		assert(is_a($effects[0], "ProduceManaEffect"));
		assert(strcmp($effects[0]->getProducedMana()->getManaString(), "R") == 0);
	}

	public function testForest()
	{
		$factory = new CardFactory();
		$card = $factory->createCard("Forest");
		$rules = $card->getRules();
		
		assert($card->getType() == CardType::BASIC_LAND);
		assert($card->isASubType("Forest"));
		$ability = $rules[0];
		$costs = $ability->getActivationCosts();
		$effects = $ability->getEffects();
		assert(count($costs) == 1);
		assert(count($effects) == 1);
		assert(is_a($costs[0], "TapCost"));
		assert(is_a($effects[0], "ProduceManaEffect"));
		assert(strcmp($effects[0]->getProducedMana()->getManaString(), "G") == 0);
	}

	public function testIsland()
	{
		$factory = new CardFactory();
		$card = $factory->createCard("Island");
		$rules = $card->getRules();
		
		assert($card->getType() == CardType::BASIC_LAND);
		assert($card->isASubType("Island"));
		$ability = $rules[0];
		$costs = $ability->getActivationCosts();
		$effects = $ability->getEffects();
		assert(count($costs) == 1);
		assert(count($effects) == 1);
		assert(is_a($costs[0], "TapCost"));
		assert(is_a($effects[0], "ProduceManaEffect"));
		assert(strcmp($effects[0]->getProducedMana()->getManaString(), "U") == 0);
	}

	public function testPlains()
	{
		$factory = new CardFactory();
		$card = $factory->createCard("Plains");
		$rules = $card->getRules();

		assert($card->getType() == CardType::BASIC_LAND);
		assert($card->isASubType("Plains"));
		$ability = $rules[0];
		$costs = $ability->getActivationCosts();
		$effects = $ability->getEffects();
		assert(count($costs) == 1);
		assert(count($effects) == 1);
		assert(is_a($costs[0], "TapCost"));
		assert(is_a($effects[0], "ProduceManaEffect"));
		assert(strcmp($effects[0]->getProducedMana()->getManaString(), "W") == 0);
	}

	public function testInvalid()
	{
		// will throw an exception for any unknown or unsupported cards
		$factory = new CardFactory();
		$exception = false;
		try
		{
			$factory->createCard("dungeontiger");
		}
		catch(Exception $e)
		{
			$exception = true;
		}
		assert($exception == true);
	}
	
	public function testSimpleCreature()
	{
		$factory = new CardFactory();
		$card = $factory->createCard("Amphin Cutthroat");
		$cost = $card->getCastingCost();
		
		assert($card->getType() == CardType::CREATURE);
		assert($cost->getConvertedTotal() == 4);
		assert($cost->get(Color::BLUE) == 1);
		assert($card->getPower() == 2);
		assert($card->getToughness() == 4);
	}
	
	public function testMoreSimpleCreatures()
	{
		$factory = new CardFactory();
		$factory->createCard("Armored Warhorse");
		$factory->createCard("Bonebreaker Giant");
		$factory->createCard("Coral Merfolk");
		$factory->createCard("Elite Vanguard");
		$factory->createCard("Goblin Piker");
		$factory->createCard("Runeclaw Bear");
		$factory->createCard("Siege Mastodon");
		$factory->createCard("Warpath Ghoul");
	}

	public function testFlyingCreature()
	{
		$factory = new CardFactory();
		$card = $factory->createCard("Stormfront Pegasus");
		assert($card->hasKeyword(Keywords::FLYING));
	}
	
	public function testLifelinkCreature()
	{
		$factory = new CardFactory();
		$card = $factory->createCard("Ajani's Sunstriker");
		assert($card->hasKeyword(Keywords::LIFELINK));
	}
	
	public function testMultipleKeywordsDifferentLinesCreature()
	{
		$factory = new CardFactory();
		$card = $factory->createCard("Aven Squire");
		assert($card->hasKeyword(Keywords::FLYING));
		assert($card->hasKeyword(Keywords::EXALTED));
	}
	
	public function testMultipleKeywordsSameLineCreature()
	{
		$factory = new CardFactory();
		$card = $factory->createCard("Archweaver");
		assert($card->hasKeyword(Keywords::REACH));
		assert($card->hasKeyword(Keywords::TRAMPLE));
	}
	
	public function testUnsupported()
	{
		$factory = new CardFactory();
		$card = $factory->createCard("Abattoir Ghoul");
		assert(!$card->isSupportedRules());
	}
/*		
	public function testCounterSpell()
	{
		$factory = new CardFactory();
		$card = $factory->createCard("Cancel");
		$abilities = $card->getAbilities();
		assert($card->isSupportedRules());
		assert(count($abilities) == 1);
		assert($card->getType() == CardType::INSTANT);
		assert(is_a($abilities[0], "CounterSpell"));
	}
*/	
	// TODO: Destroy, multiple things, all, some creatures, etc...
}
?>
