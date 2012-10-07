<?php
include_once "Deck.php";
class DeckTest extends PHPUnit_Framework_TestCase
{
	public function testAddCard()
	{
		$deck = new Deck("1,Swamp");
		assert($deck->getCardCount() == 1);
		$cards = $deck->getCards();
		assert(strcmp($cards[0]->getName(), "Swamp") == 0);
	}
}
?>
