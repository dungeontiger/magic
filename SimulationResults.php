<?php
class SimulationResults
{
	public function addGameResults($results)
	{
		array_push($this->gameResults, $results);
	}
	
	public function getGameResults()
	{
		return $this->gameResults;
	}
	
	private $gameResults = array();
}
?>
