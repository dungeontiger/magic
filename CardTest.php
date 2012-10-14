<?php

include_once "Card.php";
include_once "CardType.php";
include_once "Ability.php";
include_once "TapCost.php";
include_once "ProduceManaEffect.php";
class CardTest extends PHPUnit_Framework_TestCase
{
	// TODO:  Need a lot more tests here
	
	public function testCardThing()
	{
		$card = new Card("Some Card", CardType::CREATURE, "RU");
		$card->addSubType("Goblin");
		$card->addSubType("Wizard");
		assert(strcmp($card->getName(), "Some Card") == 0);
		assert($card->getType() == CardType::CREATURE);
		assert(strcmp($card->getCastingCost()->getManaString(), "RU") == 0);
		assert($card->isASubType("Goblin") ==  true);
		assert($card->isASubType("Wizard") == true);
		assert($card->isASubType("Human") == false);
	} 

	public function testCardAbility()
	{
		$card = new Card("Some Card", CardType::CREATURE, "RU");
		$ability = new Ability(new TapCost(), new ProduceManaEffect("R"));
		$card->addAbility($ability);
		assert(count($card->getAbilities()) == 1);
	} 
}
?>
