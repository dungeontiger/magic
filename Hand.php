<?php
include_once "CardCollection.php";
class Hand extends CardCollection
{
	public function drawHand($deck)
	{
		// TODO: Mulligan?
		for ($i = 0; $i < 7; $i++)
		{
			$this->addCard($deck->drawCard());
		}
	}
	
	public function drawCard($deck)
	{
		return $this->addCard($deck->drawCard());
	}
	
	public function playPermanent($card, $battlefield)
	{
		// TODO: opponent response
		// TODO: triggered effects
		$battlefield->addCard($card);
		$this->removeCard($card);
	}
}
?>
