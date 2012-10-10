<?php
include_once "CardFactory.php";
class CardFactoryTest extends PHPUnit_Framework_TestCase
{
	public function testCreateBlank()
	{
		$card = CardFactory::createCard("_blank");
		assert(strcmp($card->getName(), "_blank") == 0);
		assert($card->getType() == CardType::BLANK);
		assert(count($card->getAbilities()) == 0);
	}
	
	public function testCreateSwamp()
	{
		$card = CardFactory::createCard("Swamp");
		assert(strcmp($card->getName(), "Swamp") == 0);
		assert($card->getType() == CardType::BASIC_LAND);
		assert($card->getSubType()->isA("Swamp"));
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
	}

	public function testCreatePlains()
	{
		$card = CardFactory::createCard("Plains");
		assert(strcmp($card->getName(), "Plains") == 0);
		assert($card->getType() == CardType::BASIC_LAND);
		assert($card->getSubType()->isA("Plains"));
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
		$card = CardFactory::createCard("Island");
		assert(strcmp($card->getName(), "Island") == 0);
		assert($card->getType() == CardType::BASIC_LAND);
		assert($card->getSubType()->isA("Island"));
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
		$card = CardFactory::createCard("Forest");
		assert(strcmp($card->getName(), "Forest") == 0);
		assert($card->getType() == CardType::BASIC_LAND);
		assert($card->getSubType()->isA("Forest"));
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
		$card = CardFactory::createCard("Mountain");
		assert(strcmp($card->getName(), "Mountain") == 0);
		assert($card->getType() == CardType::BASIC_LAND);
		assert($card->getSubType()->isA("Mountain"));
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
