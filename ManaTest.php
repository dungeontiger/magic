<?php
include_once "Mana.php";
class ManaTest extends PHPUnit_Framework_TestCase
{
	public function testBlack()
	{
		$mana = new Mana("B");
		assert($mana->getMana() == "B");
	}

	public function testBlue()
	{
		$mana = new Mana("U");
		assert($mana->getMana() == "U");
	}	
	
	public function testGreen()
	{
		$mana = new Mana("G");
		assert($mana->getMana() == "G");
	}
	
	public function testRed()
	{
		$mana = new Mana("R");
		assert($mana->getMana() == "R");
	}
	
	public function testWhite()
	{
		$mana = new Mana("W");
		assert($mana->getMana() == "W");
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
			$mana = new Mana("BB");
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
		assert($mana->getMana() == "3");
	}

	public function testTen()
	{
		$mana = new Mana("10");
		assert($mana->getMana() == "10");
	}
}
?>
