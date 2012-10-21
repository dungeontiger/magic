<?php
final class CardType
{
	// TODO: Make an array like keywords
	const BASIC_LAND = 0;
	const LAND = 1;
	const CREATURE = 2;
	const INSTANT = 3;
	const SORCERY = 4;
	const ENCHANTMENT = 5;
	const LEGENDARY_CREATURE = 6;
	const LEGENDARY_LAND = 7;
	const LEGENDARY_ENCHANTMENT = 8;
	const LEGENDARY_ARTIFACT = 9;
	const LEGENDARY_ARTIFACT_CREATURE = 10;
	const ARTIFACT = 11;
	const ARTIFACT_CREATURE = 12;
	const PLANESWALKER = 13;
	// tokens?
	// snow lands?
	// artifact land
	// other legendary stuff
	
	// legendary should be a modifier
	
	public function getString($type)
	{
		switch ($type)
		{
			case CardType::BASIC_LAND:
				return "Basic Land";
			case CardType::LAND:
				return "Land";
			case CardType::CREATURE:
				return "Creature";
			case CardType::INSTANT:
				return "Instant";
			case CardType::SORCERY:
				return "Sorcery";
			case CardType::ARTIFACT:
				return "Artifact";
			case CardType::ENCHANTMENT:
				return "Enchantment";
			case CardType::ARTIFACT_CREATURE;
				return "Artifact Creature";
			default:
				return "Unknown";
		}
	}
	
	private function __construct()
	{
		// no instances
		// seems classes cannot be both final and abstract
	}
}
?>
