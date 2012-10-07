<?php
final class CardType
{
	const BLANK = -1;
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
	
	private function __construct()
	{
		// no instances
		// seems classes cannot be both final and abstract
	}
}
?>
