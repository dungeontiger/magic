<?php
include_once "Mana.php";
class ManaTest extends PHPUnit_Framework_TestCase
{
	public function testBlack()
	{
		$mana = new Mana("B");
		assert(strcmp($mana->getMana(), "B") == 0);
		assert($mana->getConvertedTotal() == 1);
	}

	public function testBlue()
	{
		$mana = new Mana("U");
		assert(strcmp($mana->getMana(), "U") == 0);
		assert($mana->getConvertedTotal() == 1);
	}	
	
	public function testGreen()
	{
		$mana = new Mana("G");
		assert(strcmp($mana->getMana(), "G") == 0);
		assert($mana->getConvertedTotal() == 1);
	}
	
	public function testRed()
	{
		$mana = new Mana("R");
		assert(strcmp($mana->getMana(), "R") == 0);
		assert($mana->getConvertedTotal() == 1);
	}
	
	public function testWhite()
	{
		$mana = new Mana("W");
		assert(strcmp($mana->getMana(), "W") == 0);
		assert($mana->getConvertedTotal() == 1);
	}
	
	public function testBad()
	{
		$caught = false;
		try
		{
			$mana = new Mana("A");
		}
		catch (Exception $e)
		{
			$caught = true;
		}
		assert($caught);
	}
	
	public function testBad2()
	{
		$caught = false;
		try
		{
			$mana = new Mana("3BB3");
		}
		catch (Exception $e)
		{
			$caught = true;
		}
		assert($caught);
	}
	
	public function testNumber()
	{
		$mana = new Mana("3");
		assert(strcmp($mana->getMana(), "3") == 0);
		assert($mana->getConvertedTotal() == 3);
	}

	public function testTen()
	{
		$mana = new Mana("10");
		assert(strcmp($mana->getMana(), "10") == 0);
		assert($mana->getConvertedTotal() == 10);
	}

	public function testComplex()
	{
		$mana = new Mana("3WB");
		assert(strcmp($mana->getMana(), "3WB") == 0);
		assert($mana->getConvertedTotal() == 5);
	}

	public function testLarge()
	{
		$mana = new Mana("13UR");
		assert(strcmp($mana->getMana(), "13UR") == 0);
		assert($mana->getConvertedTotal() == 15);
	}
}
?>
