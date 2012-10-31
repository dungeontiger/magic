<?php
/**
 * Any card.  If an attribute is null it does not apply to this card
 */
include_once "ManaVector.php";
include_once "CardType.php";

class Card
{
	public function __construct($name, $type = null, $castingCost = null) 
	{
		$this->name = $name;
		$this->type = $type;
		if ($castingCost != null)
		{
			$this->castingCost = new ManaVector($castingCost);
		}
		else
		{
			$this->castingCost = null;
		}
		$this->power = null;
		$this->toughness = null;
	}
	
	public function getName()
	{
		return $this->name;
	}
	
	public function getCastingCost()
	{
		return $this->castingCost;
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
	
	public function getLoyalty()
	{
		return $this->loyalty;
	}
	
	public function setLoyalty($loyalty)
	{
		$this->loyalty = $loyalty;
	}
	
	public function setCastingCost($castingCost)
	{
		$this->castingCost = $castingCost;
	}
	
	public function setType($type)
	{
		$this->cardType = $type;
	}
	
	public function getType()
	{
		return $this->cardType;
	}
	
	public function isType($type)
	{
		return $this->cardType->isType($type);
	}
	
	public function isASubType($subType)
	{
		return $this->cardType->isSubType($subType);
	}
	
	public function getSubTypes()
	{
		return $this->cardType->getSubTypes();
	}
	
	public function setPower($power)
	{
		$this->power = $power;
	}
	
	public function setToughness($toughness)
	{
		$this->toughness = $toughness;
	}
	
	public function getPower()
	{
		return $this->power;
	}
	
	public function getToughness()
	{
		return $this->toughness;
	}
	
	public function isSupportedRules()
	{
		return !$this->unsupportedRules;
	}

	public function setUnsupportedCastingCost()
	{
		$this->unsupportedCastingCost = true;
	}
	
	public function isSupportedCastingCost()
	{
		return !$this->unsupportedCastingCost;
	}
	
	public function setUnsupportedType()
	{
		$this->unsupportedType = true;
	}
	
	public function addRule($rule)
	{
		array_push($this->rules, $rule);
		if (!$rule->isSupported())
		{
			$this->unsupportedRules = true;
		}
	}
	
	public function getRules()
	{
		return $this->rules;
	}
	
	public function hasKeyword($keyword)
	{
		foreach($this->rules as $rule)
		{
			if (is_a($rule, "KeywordRule"))
			{
				if ($rule->getKeyword() == $keyword)
				{
					return true;
				}
			}
		}
		return false;
	}
	
	public function getCardColors()
	{
		if ($this->castingCost != null)
		{
			return $this->castingCost->getColors();
		}
		// this is a land
		return null;
	}
	
	// TODO: clean up the rules members
	private $castingCost = null;
	private $name;
	private $power = null;
	private $toughness = null;
	private $loyalty = null;
	private $tapped = false;
	private $unsupportedRules = false;
	private $unsupportedCastingCost = false;
	private $unsupportedType = false;
	private $subTypes;
	
	private $rules = array();
	
}
?>
