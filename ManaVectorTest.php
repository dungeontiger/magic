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
	
	public function testTotal()
	{
		$mana = new ManaVector();
		$mana->add(Color::BLACK, 2);
		assert($mana->getConvertedTotal() == 2);
	}

	public function testTotal2()
	{
		$mana = new ManaVector();
		$mana->add(Color::GREEN, 2);
		$mana->add(Color::WHITE, 2);
		$mana->add(Color::COLORLESS, 3);
		assert($mana->getConvertedTotal() == 7);
	}

	public function testColorCount()
	{
		$mana = new ManaVector();
		$mana->add(Color::GREEN, 2);
		$mana->add(Color::WHITE, 2);
		$mana->add(Color::COLORLESS, 3);
		assert($mana->getColorCount() == 2);
	}
	
	public function testManaString()
	{
		$mana = new ManaVector();
		$mana->add(Color::GREEN, 2);
		$mana->add(Color::WHITE, 2);
		$mana->add(Color::COLORLESS, 3);
		assert(strcmp($mana->getManaString(), "3GGWW") == 0);
	}
	
	public function testManaString2()
	{
		$mana = new ManaVector();
		$mana->add(Color::RED, 1);
		$mana->add(Color::BLACK, 1);
		$mana->add(Color::COLORLESS, 3);
		assert(strcmp($mana->getManaString(), "3BR") == 0);
	}
	
	public function testManaString3()
	{
		$mana = new ManaVector();
		$mana->add(Color::GREEN, 1);
		$mana->add(Color::WHITE, 1);
		assert(strcmp($mana->getManaString(), "GW") == 0);
	}
	
	public function testConstructor()
	{
		$mana = new ManaVector("3B");
		assert($mana->get(Color::BLACK) ==  1);
		assert($mana->get(Color::COLORLESS) == 3);
	}
	
	public function testAddVector()
	{
		$mana = new ManaVector("3B");
		$mana2 = new ManaVector("2GB");
		$mana->addVector($mana2);
		assert(strcmp($mana->getManaString(), "5BBG") == 0);
		assert($mana->getColorCount() == 2);
		assert($mana->getConvertedTotal() == 8);
	}
	
	public function testBadWithOr()
	{
		$found = false;
		try
		{
			$mana = new ManaVector("W or U");
		}
		catch (Exception $e)
		{
			$found = true;
		}
		assert($found);
	}
}
?>
