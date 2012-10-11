<?php
include_once "CardFactory.php";
class CardFactoryTest extends PHPUnit_Framework_TestCase
{
	public function testCardsExists()
	{
		// will throw an exception for any unknown or unsupported cards
		$factory = new CardFactory();
		$factory->createCard("swamp");
		$factory->createCard("mountain");
		$factory->createCard("island");
		$factory->createCard("swamp");
		$factory->createCard("forest");
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

	public function testCreateBlank()
	{
		$factory = new CardFactory();
		$card = $factory->createCard("_blank");
		assert(strcmp($card->getName(), "_blank") == 0);
		assert($card->getType() == CardType::BLANK);
		assert(count($card->getAbilities()) == 0);
	}
	
	public function testCreateSwamp()
	{
		$factory = new CardFactory();
		$card = $factory->createCard("Swamp");
		assert(strcmp($card->getName(), "Swamp") == 0);
		assert($card->getType() == CardType::BASIC_LAND);
		assert($card->isASubType("Swamp"));
		$abilities = $card->getAbilities();
		assert(count($abilities) == 1);
		$ability = $abilities[0];
		assert(is_a($ability, "Ability"));
		$costs = $ability->getCosts();
		assert(count($costs) == 1);
		$cost = $costs[0];
		assert(is_a($cost, "TapCost"));
		$effects = $ability->getEffects();
		assert(count($effects) == 1);
		$effect = $effects[0];
		assert(is_a($effect, "ProduceManaEffect"));
		assert(strcmp($effect->getProducedMana()->getManaString(), "B") == 0);
		assert($effect->getProducedMana()->get(Color::BLACK) == 1);
	}

	public function testCreatePlains()
	{
		$factory = new CardFactory();
		$card = $factory->createCard("Plains");
		assert(strcmp($card->getName(), "Plains") == 0);
		assert($card->getType() == CardType::BASIC_LAND);
		assert($card->isASubType("Plains"));
		$abilities = $card->getAbilities();
		assert(count($abilities) == 1);
		$ability = $abilities[0];
		assert(is_a($ability, "Ability"));
		$costs = $ability->getCosts();
		assert(count($costs) == 1);
		$cost = $costs[0];
		assert(is_a($cost, "TapCost"));
		$effects = $ability->getEffects();
		assert(count($effects) == 1);
		$effect = $effects[0];
		assert(is_a($effect, "ProduceManaEffect"));
		assert(strcmp($effect->getProducedMana()->getManaString(), "W") == 0);
	}
	
	public function testCreateIsland()
	{
		$factory = new CardFactory();
		$card = $factory->createCard("Island");
		assert(strcmp($card->getName(), "Island") == 0);
		assert($card->getType() == CardType::BASIC_LAND);
		assert($card->isASubType("Island"));
		$abilities = $card->getAbilities();
		assert(count($abilities) == 1);
		$ability = $abilities[0];
		assert(is_a($ability, "Ability"));
		$costs = $ability->getCosts();
		assert(count($costs) == 1);
		$cost = $costs[0];
		assert(is_a($cost, "TapCost"));
		$effects = $ability->getEffects();
		assert(count($effects) == 1);
		$effect = $effects[0];
		assert(is_a($effect, "ProduceManaEffect"));
		assert(strcmp($effect->getProducedMana()->getManaString(), "U") == 0);
	}
	
	public function testCreateForest()
	{
		$factory = new CardFactory();
		$card = $factory->createCard("Forest");
		assert(strcmp($card->getName(), "Forest") == 0);
		assert($card->getType() == CardType::BASIC_LAND);
		assert($card->isASubType("Forest"));
		$abilities = $card->getAbilities();
		assert(count($abilities) == 1);
		$ability = $abilities[0];
		assert(is_a($ability, "Ability"));
		$costs = $ability->getCosts();
		assert(count($costs) == 1);
		$cost = $costs[0];
		assert(is_a($cost, "TapCost"));
		$effects = $ability->getEffects();
		assert(count($effects) == 1);
		$effect = $effects[0];
		assert(is_a($effect, "ProduceManaEffect"));
		assert(strcmp($effect->getProducedMana()->getManaString(), "G") == 0);
	}
	
	public function testCreateMountain()
	{
		$factory = new CardFactory();
		$card = $factory->createCard("Mountain");
		assert(strcmp($card->getName(), "Mountain") == 0);
		assert($card->getType() == CardType::BASIC_LAND);
		assert($card->isASubType("Mountain"));
		$abilities = $card->getAbilities();
		assert(count($abilities) == 1);
		$ability = $abilities[0];
		assert(is_a($ability, "Ability"));
		$costs = $ability->getCosts();
		assert(count($costs) == 1);
		$cost = $costs[0];
		assert(is_a($cost, "TapCost"));
		$effects = $ability->getEffects();
		assert(count($effects) == 1);
		$effect = $effects[0];
		assert(is_a($effect, "ProduceManaEffect"));
		assert(strcmp($effect->getProducedMana()->getManaString(), "R") == 0);
	}
}
?>
