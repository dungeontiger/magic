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
		assert(strcmp($cards[10]->getName(), "Air Elemental") == 0);
	}

	public function testAddRedBlack()
	{
		$deck = new Deck($this->deckBlackRed);
		assert($deck->getCardCount() == 60);
		$cards = $deck->getCards();
		assert(strcmp($cards[0]->getName(), "Swamp") == 0);
		assert(strcmp($cards[10]->getName(), "Mountain") == 0);
		assert(strcmp($cards[20]->getName(), "Warpath Ghoul") == 0);
	}
	
	//TODO: How to test if it was shuffled?  Hash the contents?
	public function testShuffle()
	{
		$deck = new Deck($this->deckBlackRed);
		assert($deck->getCardCount() == 60);
		$deck->shuffle();
		assert($deck->getCardCount() == 60);
	}

	public function testDrawCard()
	{
		$deck = new Deck($this->deck1);
		assert($deck->getCardCount() == 2);
		$card = $deck->drawCard();
		assert(strcmp($card->getName(), "Swamp") == 0);
		assert($deck->getCardCount() == 1);
		assert($deck->getStartingCardCount() == 2);
	}
	
	public function testBasicLandCount()
	{
		$deck = new Deck($this->deckBlackRed);
		$basicLands = $deck->getBasicLandsStats(); 
		assert($basicLands["Swamp"] == 10);
		assert($basicLands["Mountain"] == 10);
	}
	
	public function testCardCount()
	{
		$deck = new Deck($this->deckRealBlackRed);
		$uniqueCards = $deck->getUniqueCardCount();
		assert($deck->getStartingCardCount() == 60);
		assert($uniqueCards["Cathedral of War"] == 4);
		assert($uniqueCards["Chandra's Fury"] == 4);
	}

	public function testCardTypes()
	{
		$deck = new Deck($this->deckRealBlackRed);
		$types = $deck->getCardTypes();
		assert($types[CardType::LAND] == 4);
		assert($types[CardType::CREATURE] == 8);
		assert($types[CardType::INSTANT] == 8);
	}
	
	public function testColorCount()
	{
		$deck = new Deck($this->multiColors);
		$colors = $deck->getNumberOfColors();
		assert($colors[0] == 4);
		assert($colors[1] == 8);
		assert($colors[2] == 4);
		assert($colors[3] == 2);
	}
	
	public function testCastingCost()
	{
		$deck = new Deck($this->deckRealBlackRed);
		$castingCost = $deck->getCardsByCastingCost();
		assert($castingCost[3] == 4);
		assert($castingCost[4] == 8);
		assert($castingCost[5] == 4);
	}
	
	public function testCardColors()
	{
		$deck = new Deck($this->multiColors);
		$colors = $deck->getCardColors();
		assert($colors[Color::COLORLESS] == 4);
		assert($colors[Color::BLACK] == 8);
		assert($colors[Color::RED] == 4);
		assert($colors[Color::BLUE] == 6);
		assert($colors[Color::GREEN] == 2);
		assert($colors[Color::WHITE] == 2);
	}
	
	public function testSubTypes()
	{
		$deck = new Deck($this->subTypeDeck);
		$subTypes = $deck->getSubTypes();
		assert($subTypes["Goblin"] == 4);
		assert($subTypes["Zombie"] == 6);
		assert($subTypes["Warrior"] == 6);
		assert($subTypes["Wizard"] == 3);
		assert($subTypes["Human"] == 3);
	}
	
	private $deck1 = <<<EOD
1,Swamp
1,Mountain
EOD;

	private $deck2 = <<<EOD
2,Island
4,Forest
10,Air Elemental
EOD;

	private $deckBlackRed = <<<EOD
10,Swamp
10,Mountain
40,Warpath Ghoul
EOD;

	private $multiColors = <<<EOD
10,Swamp
2,Sarkhan the Mad
4,Fabricate
2,Novablast Wurm
2,Cruel Ultimatum
4,Eldrazi Monument
4,Blood Seeker
EOD;

	private $deckRealBlackRed = <<<EOD
20,Swamp
20,Mountain
4,Bloodhunter Bat
4,Bladetusk Boar
4,Cathedral of War
4,Chandra's Fury
4,Cower in Fear
EOD;


	private $subTypeDeck = <<<EOD
10,Swamp
10,Island
2,Blackcleave Goblin
2,Goblin Artillery
4,Armored Skaab
3,Æther Adept
EOD;
}
?>
