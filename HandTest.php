<?php
include_once "Hand.php";
include_once "CardFactory.php";
class HandTest extends PHPUnit_Framework_TestCase
{
	public function testRemoveCard()
	{
		$factory = new CardFactory();
		$swamp = $factory->createCard("Swamp");
		$mountain = $factory->createCard("Mountain");
		$hand = new Hand();
		$hand->addCard($swamp);
		$hand->addCard($mountain);
		assert($hand->getCardCount() == 2);
		$removed = $hand->removeCard($mountain);
		assert($removed != null);
		assert($hand->getCardCount() == 1);
		
	}
}
?>
