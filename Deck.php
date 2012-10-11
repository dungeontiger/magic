<?php
include_once "CardCollection.php";
include_once "CardFactory.php";
class Deck extends CardCollection
{
	public function __construct($deckString)
	{
		$factory = new CardFactory();
		// $deckString is in the format of #,CardName
		$lines = explode(PHP_EOL, $deckString);
		foreach($lines as $line)
		{
			$pieces = explode(",", $line);
			for($i = 0; $i < $pieces[0]; $i++)
			$this->addCard($factory->createCard($pieces[1]));
		}
	}
	
	public function drawCard()
	{
		return $this->drawTopCard();
	}	
}
?>
