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

	public function testAddTwoCard()
	{
		$deck = new Deck($this->deck1);
		assert($deck->getCardCount() == 2);
		$cards = $deck->getCards();
		assert(strcmp($cards[0]->getName(), "Swamp") == 0);
		assert(strcmp($cards[1]->getName(), "Mountain") == 0);
	}

	public function testAddMultipleCard()
	{
		$deck = new Deck($this->deck2);
		assert($deck->getCardCount() == 16);
		$cards = $deck->getCards();
		assert(strcmp($cards[0]->getName(), "Island") == 0);
		assert(strcmp($cards[4]->getName(), "Forest") == 0);
		assert(strcmp($cards[10]->getName(), "_blank") == 0);
	}

	public function testAddRedBlack()
	{
		$deck = new Deck($this->deckBlackRed);
		assert($deck->getCardCount() == 60);
		$cards = $deck->getCards();
		assert(strcmp($cards[0]->getName(), "Swamp") == 0);
		assert(strcmp($cards[10]->getName(), "Mountain") == 0);
		assert(strcmp($cards[20]->getName(), "_blank") == 0);
	}
	
	public function testShuffle()
	{
		$deck = new Deck($this->deckBlackRed);
		assert($deck->getCardCount() == 60);
		$deck->shuffle();
		assert($deck->getCardCount() == 60);
		$deck->dump();
	}

	public function testDrawCard()
	{
		$deck = new Deck($this->deck1);
		assert($deck->getCardCount() == 2);
		$card = $deck->drawCard();
		assert(strcmp($card->getName(), "Swamp") == 0);
		assert($deck->getCardCount() == 1);
	}

	private $deck1 = <<<EOD
1,Swamp
1,Mountain
EOD;

	private $deck2 = <<<EOD
2,Island
4,Forest
10,_blank
EOD;

	private $deckBlackRed = <<<EOD
10,Swamp
10,Mountain
40,_blank
EOD;
}
?>
