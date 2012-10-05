<?php
include_once "Effect.php";
include_once "Mana.php";
/**
 * Not needed?  Can just use the mana class...
 */
class ProduceManaEffect extends Effect
{
	public function __construct($mana = null)
	{
		$this->mana = array();
		$this->addMana($mana);
	}
	
	public function addMana($mana)
	{
		if ($mana != null)
		{
			if (is_array($mana))
			{
				foreach($mana as $single)
				{
					array_push($this->mana, $single);
				}
			}
			else
			{
				array_push($this->mana, $mana);
			}
		}
	}
	
	public function getProducedMana()
	{
		return $this->mana;
	}
	
	public function getProducedManaString()
	{
		$text = "";
		foreach($this->mana as $single)
		{
			$text .= $single->getMana();
		}
		return $text;
	}
	
	private $mana;
}
?>
