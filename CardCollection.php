<?php
abstract class CardCollection
{
	public function addCard($card)
	{
		array_push($this->cards, $card);
	}
	
	public function getCards()
	{
		return $this->cards;
	}
	
	public function getCardCount()
	{
		return count($this->cards);
	}
	
	private $cards = array();
}
?>
