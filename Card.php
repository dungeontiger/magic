<?php
/**
 * Any card.  If an attribute is null it does not apply to this card
 */
include_once "ManaVector.php";
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
	
	public function getType()
	{
		return $this->type;
	}
	
	public function setType($type)
	{
		$this->type = $type;
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
	
	public function addSubType($subType)
	{
		array_push($this->subTypes, $subType);
	}
	
	public function getSubTypes()
	{
		return $this->subTypes;
	}
	
	public function isASubType($subType)
	{
		return in_array($subType, $this->subTypes);
	}
	
	public function getSubTypeString()
	{
		return implode(" ", $this->subTypes);
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
	
	public function addUnknownRule($rule)
	{
		array_push($this->unknownRules, $rule);
	}
	
	public function getUnknownRules()
	{
		return $this->unknownRules;
	}
	
	public function hasUnknownRules()
	{
		return count( $this->unknownRules) > 0;
	}

	public function addKeyword($keyword)
	{
		array_push($this->keywords, $keyword);
	}
	
	public function getKeywords()
	{
		return $this->keywords;
	}
	
	public function hasKeyword($keyword)
	{
		return in_array($keyword, $this->keywords);
	}
	
	public function setUnsupported()
	{
		$this->unsupported = true;
	}
	
	public function isSupported()
	{
		return !$this->unsupported;
	}

	private $castingCost = null;
	private $name;
	private $type;
	private $subTypes = array();
	private $abilities = array();
	private $power = null;
	private $toughness = null;
	private $loyalty = null;
	private $tapped = false;
	private $unknownRules = array();
	private $keywords = array();
	private $unsupported = false;
}
?>
