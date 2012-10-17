<?php


// make this destroy creature, not destroy land or artifact

// array of what type of creatures to be destroyed
// these could be:
//	color
//	noncolor
//	attacking
//	blocking
//	blocked
//	nonartifact
//	artifact
//	monocolored
//	subtype
//	nonsubtype

class Destroy
{
	const ALL_CREATURES = 0;
	const TARGET_CREATURE = 1;
	const TARGET_TAPPED_CREATURE = 2;
	const TARGET_ATTACKING_BLOCKING_CREATURE = 3;
	const TARGET_BLOCKED_CREATURE = 4;
//	const TARGET_NONARTIFACT_CREATURE = 4;
//	const TARGET_MONOCOLORED_CREATURE = 5;
	
	public function __construct($rule)
	{
		//TODO: fix it up, its a mess
		$test = strtolower($rule);
		foreach (self::$possibleTargets as $key => $value)
		{
//			if (strcasecmp($value, $test) == 0)
			{
				array_push($this->targets, $key);
			}
		}
	}
	
	public static function ruleMatches($rule)
	{
		$targets = self::calculateRuleMatches($rule);
		return count($targets) > 0;
	}
	
	public static function calculateRuleMatches($rule)
	{
		$targets = array();
		$test = strtolower($rule);
		if (preg_match("/^destroy (.*) (creature|creatures).$/U", $test, $matches))
		{
			$target = $matches[1];
			foreach (self::$possibleTargets as $key => $value)
			{
				if (preg_match($value, $target, $matches))
				{
					array_push($targets, $key);
				}
			}
		}
		return $targets;
	}
	
	public static function initialize()
	{
		self::$possibleTargets[self::ALL_CREATURES] = "/^all$/";
		self::$possibleTargets[self::TARGET_CREATURE] = "/^target$/";
		self::$possibleTargets[self::TARGET_TAPPED_CREATURE] = "/^target tapped$/";
		self::$possibleTargets[self::TARGET_ATTACKING_BLOCKING_CREATURE] = "/^target attacking or blocking$/";
		self::$possibleTargets[self::TARGET_BLOCKED_CREATURE] = "/^target blocked$/";
	}
	
	public function getTargets()
	{
		return $this->targets;
	}
	
	static private $possibleTargets = array();

	private $targets = array();
	// destroy ... creature[s]
	// destroy one or more colored creatures (white or green)
	// destroy noncolored creature (nonblack)
	// destroy target Human creature (subtype????)
	// Destroy target non-Vampire, non-Werewolf, non-Zombie creature.
	//	self::$possibleTargets[self::TARGET_NONARTIFACT_CREATURE] = "/^target nonartifact$/";
	//	self::$possibleTargets[self::TARGET_MONOCOLORED_CREATURE] = "/^target monocolored$/";
	
	// Eaten By Spiders: Destroy target creature with flying and all Equipment attached to that creature.
	// Into The Maw of Hell: Destroy target land. Into the Maw of Hell deals 13 damage to target creature.
	// Scorch the Fields: Destroy target land. Scorch the Fields deals 1 damage to each Human creature.
	// Assassin's Strike: Destroy target creature. Its controller discards a card.
	// Destroy attacking creature without flying
	
	// all or target
	// type or color or noncolor list
	// cannot be regenerated
	//	They can't be regenerated.
	//	It can't be regenerated.
	
	
	// First decide if this is a destroy rule.  It must start with destory
	// The next word will be either all or target
	// then it must be a card type: creature, land, enchantment, artifact, equipment (if all, they will be plural)
	
}

Destroy::initialize();
?>
