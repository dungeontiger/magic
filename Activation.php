<?php
/**
 * The Activation class represents an activation cost for an ability.  Typically this is
 * the cost before a colon, like T: Deal one damage to target creature or 3W: Give target creature flying until end of turn
 * So the activation is a combination of mana, tapping and other things like sacrfice
 */
class Activation
{
	public __construct($mana = null, $tap = false, $selfSacrifice = false)
	{
		$this->mana = $mana;
		$this->tap = $tap;
		$this->selfSacrifice = $selfSacrifice;
	}
	
	private boolean $tap;
	private boolean $selfSacrifice;
	private $mana;
}
?>
