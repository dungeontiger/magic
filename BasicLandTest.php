<?php
include_once "BasicLand.php";
class BasicLandTest extends PHPUnit_Framework_TestCase
{
	public function testSwamp()
	{
		$land = new BasicLand("Swamp");
		assert($land->providesMana() == "B");
	}

	public function testIsland()
	{
		$land = new BasicLand("ISLAND");
		assert($land->providesMana() == "U");
	}

	public function testPlains()
	{
		$land = new BasicLand("plains");
		assert($land->providesMana() == "W");
	}

	public function testMountain()
	{
		$land = new BasicLand("Mountain");
		assert($land->providesMana() == "R");
	}

	public function testForest()
	{
		$land = new BasicLand("ForesT");
		assert($land->providesMana() == "G");
	}
}
?>
