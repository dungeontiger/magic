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
15,Swamp
15,Mountain
30,_blank
EOD;
}
?>
