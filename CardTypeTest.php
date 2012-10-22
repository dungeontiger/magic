<?php
include_once "CardType.php";
class CardTypeTest extends PHPUnit_Framework_TestCase
{
	public function testBasicLand()
	{
		$cardType = new CardType("Basic Land - Swamp");
		assert($cardType->isType(CardType::BASIC_LAND));
		assert($cardType->isType(CardType::LAND));
		assert($cardType->isSubType("Swamp"));
	}
	
	public function testDualLand()
	{
		$cardType = new CardType("Land - Swamp Mountain");
		assert($cardType->isType(CardType::LAND));
		assert($cardType->isSubType("Swamp"));
		assert($cardType->isSubType("Mountain"));
	}
	
	public function testLegendaryLand()
	{
		$cardType = new CardType("Legendary Land");
		assert($cardType->isType(CardType::LAND));
		assert($cardType->isType(CardType::LEGENDARY));
	}
	
	public function testArtifactLand()
	{
		$cardType = new CardType("Artifact Land");
		assert($cardType->isType(CardType::LAND));
		assert($cardType->isType(CardType::ARTIFACT));
	}

	public function testSnowLand()
	{
		$cardType = new CardType("Snow Land");
		assert($cardType->isType(CardType::LAND));
		assert($cardType->isType(CardType::SNOW));
	}

	public function testLandGate()
	{
		$cardType = new CardType("Land - Gate");
		assert($cardType->isType(CardType::LAND));
		assert($cardType->isSubType("Gate"));
	}
	
	public function testLandCreature()
	{
		$cardType = new CardType("Land Creature - Forest Dryad");
		assert($cardType->isType(CardType::LAND));
		assert($cardType->isType(CardType::CREATURE));
		assert($cardType->isSubType("Forest"));
		assert($cardType->isSubType("Dryad"));
	}
	
	public function testTribalSorcery()
	{
		$cardType = new CardType("Tribal Sorcery - Eldrazi");
		assert($cardType->isType(CardType::TRIBAL));
		assert($cardType->isType(CardType::SORCERY));
		assert($cardType->isSubType("Eldrazi"));
	}
	
	public function testArtifactCreature()
	{
		$cardType = new CardType("Artifact Creature - Human Wizard");
		assert($cardType->isType(CardType::ARTIFACT));
		assert($cardType->isType(CardType::CREATURE));
		assert($cardType->isSubType("Human"));
		assert($cardType->isSubType("Wizard"));
	}
	
	public function testInstant()
	{
		$cardType = new CardType("Instant");
		assert($cardType->isType(CardType::INSTANT));
	}
	
	public function testSorcery()
	{
		$cardType = new CardType("Sorcery");
		assert($cardType->isType(CardType::SORCERY));
	}
	
	public function testPlaneswalker()
	{
		$cardType = new CardType("Planeswalker - Garruk");
		assert($cardType->isType(CardType::PLANESWALKER));
		assert($cardType->isSubType("Garruk"));
	}
}
?>
