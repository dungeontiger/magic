<?php
include_once "CardSubType.php";
class CardSubTypeTest extends PHPUnit_Framework_TestCase
{
	public function testEmpty()
	{
		$subType = new CardSubType();
		assert($subType->isA("Wizard") == false);
		assert(strcmp($subType->toString(), "") == 0);
	}
	
	public function testGoblin()
	{
		$subType = new CardSubType("Goblin");
		assert($subType->isA("Goblin"));
		assert(strcmp($subType->toString(), "Goblin") == 0);
	}
	
	public function testTwo()
	{
		$subType = new CardSubType();
		$subType->addSubTypes("Human");
		$subType->addSubTypes("Wizard");
		assert($subType->isA("Wizard"));
		assert($subType->isA("Human"));
		assert(strcmp($subType->toString(), "Human Wizard") == 0);
	}
	
	public function testConstructorSingleLine()
	{
		$subType = new CardSubType("Vampire Assassin");
		assert($subType->isA("Vampire"));
		assert($subType->isA("Assassin"));
		assert(strcmp($subType->toString(), "Vampire Assassin") == 0);
	}
	
	public function testThree()
	{
		$subType = new CardSubType("Zombie Human Knight");
		assert($subType->isA("Knight"));
		assert($subType->isA("Zombie"));
		assert($subType->isA("Human"));
		assert(strcmp($subType->toString(), "Zombie Human Knight") == 0);
	}
}
?>
