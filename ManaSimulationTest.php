<?php
include_once "ManaSimulation.php";
class ManaSimulationTest extends PHPUnit_Framework_TestCase
{
	public function testManaSimulation()
	{
		$simulation = new ManaSimulation($this->deckBlackRed, 1, 10);
		$simulation->runSimulation();
		print $simulation->getReport();
	}

	private $deckBlackRed = <<<EOD
10,Swamp
10,Mountain
40,_blank
EOD;
}
?>
