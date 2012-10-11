<?php
/**
 * This corresponds to an activated ability on a card.  One line costs: effects
 * is represented by one object of this class.  Note that Basic Lands are
 * considered to have an activated ability, T:B for example
 */
class Ability
{
	// parameters can be array or not
	public function __construct($costs, $effects)
	{
		if (is_array($costs))
		{
			$this->costs = $costs;
		}
		else
		{
			$this->costs = array();
			array_push($this->costs, $costs);
		}
		
		if (is_array($effects))
		{
			$this->effects = $effects;
		}
		else
		{
			$this->effects = array();
			array_push($this->effects, $effects);
		}
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
