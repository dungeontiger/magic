<?php

	// any single rule on a card, as separated by a newline on 
	// this could be : 
	//	keyword - Flying
	//	effect - Destroy target black creature.  It cannot be regenerated.
	//	activated ability - {T} : Add B to mana pool.
	//	triggered effect - When comes into play sacrifice a creature.
	//	ends - Target creature gains haste until end of turn.;  Exile it at the beginning of the next end step.

class Rule
{
	public function Rule($effects, $activationCost, $trigger, $ends)
	{
		if (is_array($effects))
		{
			array_push($this->effects, $effects);
		}
		else
		{
			$this->effects[] = $effects;
		}
		
		if ($activationCost != null)
		{
			if (is_array($activationCost))
			{
				$this->activationCost = $activationCost;
			}
			else
			{
				$this->activationCost = array();
				$this->activationCost[] = $activationCost;
			}
		}
		$this->trigger = $trigger;
		$this->ends = $ends;
	}
	
	public function setUnsupported()
	{
		$this->unsupported = true;
	}
	
	public function isSupported()
	{
		return !$this->unsupported;
	}
	
	public function getEffects()
	{
		return $this->effects;
	}
	
	public function getActivationCosts()
	{
		return $this->activationCost;
	}
	
	// list of effects, can be more than once since many effects are
	// linked, basically this is either a single keyword or one 
	// paragraph of text from the card
	private $effects = array();
	
	// if null, effect does not trigger; it is permanent 
	private $trigger = null;
	
	// if null, the effect cannot be activated; it is permanent
	private $activationCost = null;
	
	// if null, the effect does not end; it is permanent
	private $ends = null;
	
	// indicates we do not understand or support this rule
	private $unsupported = false;
}
?>
