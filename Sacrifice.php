<?php
class Sacrifice
{
	public function __construct($theCard)
	{
		$this->theCard = $theCard;
	}
	
	public function isSupported()
	{
		return true;
	}
	
	public function thisCard()
	{
		return $this->theCard;
	}
	
	// sacrifice this card
	private $theCard = false;
}
?>
