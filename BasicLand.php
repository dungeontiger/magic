<?php
include_once "Card.php";
include_once "Mana.php";
class BasicLand extends Card
{
	public function __construct($name)
	{
		if (strcasecmp($name, "swamp") == 0)
		{
			$this->producesMana = new Mana("B");
		}
		else if (strcasecmp($name, "island") == 0)
		{
			$this->producesMana = new Mana("U");
		}
		else if (strcasecmp($name, "plains") == 0)
		{
			$this->producesMana = new Mana("W");
		}
		else if (strcasecmp($name, "mountain") == 0)
		{
			$this->producesMana = new Mana("R");
		}
		else if (strcasecmp($name, "forest") == 0)
		{
			$this->producesMana = new Mana("G");
		}
		else
		{
			throw new Exception("Unknown basic land type: " . $name);
		}
	}
	
	public function providesMana()
	{
		return $this->producesMana->getMana();
	}
	
	private $producesMana;
}
?>
