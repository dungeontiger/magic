<?php
/**
 * Any card.  If an attribute is null it does not apply to this card
 */
include_once "ManaVector.php";
class Card
{
	public function __construct($name, $type, $subType = null, $castingCost = null) 
	{
		$this->name = $name;
		$this->type = $type;
		$this->subType = $subType;
		if ($castingCost != null)
		{
			$this->castingCost = new ManaVector($castingCost);
		}
		else
		{
			$this->castingCost = null;
		}
		$this->abilities = array();
		$this->effects = array();
		$this->power = null;
		$this->toughness = null;
	}
	
	public function getName()
	{
		return $this->name;
	}
	
	public function getType()
	{
		return $this->type;
	}
	
	public function getSubType()
	{
		return $this->subType;
	}
	
	public function getCastingCost()
	{
		return $this->castingCost;
	}
	
	public function addAbility($ability)
	{
		array_push($this->abilities, $ability);
	}
	
	public function getAbilities()
	{
		return $this->abilities;
	}
	
	public function tap()
	{
		$this->tapped = true;
	}
	
	public function untap()
	{
		$this->tapped = false;
	}

	public function isTapped()
	{
		return $this->tapped;
	}
	

	private $castingCost;
	private $name;
	private $type;
	private $subType;
	private $abilities;
	private $effects;
	private $power;
	private $toughness;
	private $tapped;
}
?>
