<?php
include_once "Cost.php";
class ManaCost extends Cost
{
	public function __construct($mana)
	{
		$this->mana = $mana;
	}
	
	private $mana;
}
?>
