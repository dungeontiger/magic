<?php
include_once "Effect.php";
include_once "Mana.php";
/**
 * Not needed?  Can just use the mana class...
 * 
 * Yes use this, just simplify and make it just mana
 */
class ProduceManaEffect extends Effect
{
	public function __construct($mana)
	{
		$this->mana = $mana;
	}
	
	public function getProducedMana()
	{
		return $this->mana;
	}
	
	private $mana;
}
?>
