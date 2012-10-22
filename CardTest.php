<?php

include_once "Card.php";
include_once "CardType.php";
include_once "TapCost.php";
include_once "ProduceManaEffect.php";
class CardTest extends PHPUnit_Framework_TestCase
{
	// TODO:  Need a lot more tests here
	
	public function testCardThing()
	{
	} 
/*
	public function testCardAbility()
	{
		$card = new Card("Some Card", CardType::CREATURE, "RU");
		$ability = new Ability(new TapCost(), new ProduceManaEffect("R"));
		$card->addAbility($ability);
		assert(count($card->getAbilities()) == 1);
	}
*/ 
}
?>
