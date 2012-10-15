<?php
include_once "ManaVector.php";
/**
 * This class represents an effect that generates mana
 * This could be anything from a basic land to a Mox
 */
class ProduceManaEffect
{
	public function __construct($mana)
	{
		$this->mana = new ManaVector($mana);
	}
	
	public function getProducedMana()
	{
		return $this->mana;
	}
	
	private $mana;
}
?>
