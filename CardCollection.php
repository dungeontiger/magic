<?php
abstract class CardCollection
{
	public function addCard($card)
	{
		array_push($this->cards, $card);
		return $card;
	}
	
	public function getCards()
	{
		return $this->cards;
	}
	
	public function getCardCount()
	{
		return count($this->cards);
	}
	
	public function shuffle()
	{
		shuffle($this->cards);
	}
	
	public function drawTopCard()
	{
		return array_shift($this->cards);
	}

	public function removeCard($card)
	{
		$index = array_search($card, $this->getCards());
		return array_splice($this->cards, $index, 1);
	}
	
	public function dump()
	{
		$i = 1;
		foreach($this->cards as $card)
		{
			print $i++ . ": " . $card->getName() . PHP_EOL;
		}
	}
	
	private $cards = array();
}
?>
