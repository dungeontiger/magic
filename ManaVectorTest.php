<?php
include_once "ManaVector.php";
class ManaVectorTest extends PHPUnit_Framework_TestCase
{
	public function testCreate()
	{
		$mana = new ManaVector();
	}
	
	public function testBlack()
	{
		$mana = new ManaVector();
		$mana->add(Color::BLACK, 2);
		assert($mana->get(Color::BLACK) == 2);
		assert($mana->get(Color::BLUE) == null);
		assert($mana->get(Color::GREEN) == null);
		assert($mana->get(Color::RED) == null);
		assert($mana->get(Color::WHITE) == null);
		assert($mana->get(Color::COLORLESS) == null);
	}

	public function testBlack2()
	{
		$mana = new ManaVector();
		$mana->add(Color::BLACK, 2);
		$mana->add(Color::BLACK, 3);
		assert($mana->get(Color::BLACK) == 5);
		assert($mana->get(Color::BLUE) == null);
		assert($mana->get(Color::GREEN) == null);
		assert($mana->get(Color::RED) == null);
		assert($mana->get(Color::WHITE) == null);
		assert($mana->get(Color::COLORLESS) == null);
	}

	public function testMultiple()
	{
		$mana = new ManaVector();
		$mana->add(Color::BLACK, 2);
		$mana->add(Color::COLORLESS, 3);
		$mana->add(Color::RED, 1);
		assert($mana->get(Color::BLACK) == 2);
		assert($mana->get(Color::BLUE) == null);
		assert($mana->get(Color::GREEN) == null);
		assert($mana->get(Color::RED) == 1);
		assert($mana->get(Color::WHITE) == null);
		assert($mana->get(Color::COLORLESS) == 3);
	}
}
?>
