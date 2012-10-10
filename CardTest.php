<?php

include_once "Card.php";
include_once "CardType.php";
include_once "CardSubType.php";
include_once "Ability.php";
include_once "TapCost.php";
include_once "ProduceManaEffect.php";
class CardTest extends PHPUnit_Framework_TestCase
{
	public function testCreateBlank()
	{
		$card = new Card("_blank", CardType::BLANK);
		assert(strcmp($card->getName(), "_blank") == 0);
		assert($card->getType() == CardType::BLANK);
		assert($card->getCastingCost() == null);
		assert($card->getSubType() == null);
	}
	
	public function testCardThing()
	{
		$card = new Card("Some Card", CardType::CREATURE, new CardSubType("Goblin Wizard"), "RU");
		assert(strcmp($card->getName(), "Some Card") == 0);
		assert($card->getType() == CardType::CREATURE);
		assert(strcmp($card->getCastingCost()->getManaString(), "RU") == 0);
		assert($card->getSubType()->isA("Goblin"));
		assert($card->getSubType()->isA("Wizard"));
	} 

	public function testCardAbility()
	{
		$card = new Card("Some Card", CardType::CREATURE, new CardSubType("Goblin Wizard"), "RU");
		$ability = new Ability(new TapCost(), new ProduceManaEffect("R"));
		$card->addAbility($ability);
		assert(count($card->getAbilities()) == 1);
	} 
}
?>
