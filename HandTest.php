<?php
include_once "Hand.php";
include_once "CardFactory.php";
class HandTest extends PHPUnit_Framework_TestCase
{
	public function testRemoveCard()
	{
		$swamp = CardFactory::createCard("Swamp");
		$mountain = CardFactory::createCard("Mountain");
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
