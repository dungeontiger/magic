<?php
/**
 * This corresponds to an activated ability on a card.  One line costs: effects
 * is represented by one object of this class.  Note that Basic Lands are
 * considered to have an activated ability, T:B for example
 */
class Ability
{
	public function __construct($costs, $effects)
	{
		$this->effects = $effects;
		$this->costs = $costs;
	}
	
	public function getCosts()
	{
		return $this->costs;
	}
	
	public function getEffects()
	{
		return $this->effects;
	}
	
	private $effects;
	private $costs;
}
?>
