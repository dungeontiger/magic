<?php
/**
 * Results for one game of a simulation.  Contains many turns
 */
include_once "SimulationTurnResults.php";
class SimulationGameResults
{
	public function addTurnResults($turnResults)
	{
		array_push($this->turnResults, $turnResults);
	}
	
	public function getTurnResults()
	{
		return $this->turnResults;
	}
	
	public function setMulligans($value)
	{
		$this->mulligans = $value;
	}
	
	public function getMulligans()
	{
		return $this->mulligans;
	}
	
	public function getDiscardsByTurn()
	{
		$discards = array();
		foreach($this->turnResults as $turn)
		{
			array_push($discards, $turn->getDiscarded());
		}
		return $discards;
	}
	
	private $turnResults = array();
	
	private $mulligans = 0;
	private $lostDueToEmptyLibrary = false;
}
?>
