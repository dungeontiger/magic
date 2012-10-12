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
	
	public function getNumberOfGames()
	{
		return count($this->gameResults);
	}
	
	// TODO: divide by games
	public function getAvgPlayedByTurn()
	{
		$totalPlays = array();
		foreach($this->gameResults as $gameResult)
		{
			$plays = $gameResult->getPlayedByTurn();
			for ($i = 0; $i < count($plays); $i++)
			{
				if (count($totalPlays) <= $i)
				{
					array_push($totalPlays, $plays[$i]);
				}
				else
				{
					$totalPlays[$i] += $plays[$i];
				}
			}
		}
		return $totalPlays;
	}
	
	// TODO: divide by games
	public function getAvgDiscardsByTurn()
	{
		$totalDiscards = array();
		foreach($this->gameResults as $gameResult)
		{
			$discards = $gameResult->getDiscardsByTurn();
			for ($i = 0; $i < count($discards); $i++)
			{
				if (count($totalDiscards) <= $i)
				{
					array_push($totalDiscards, $discards[$i]);
				}
				else
				{
					$totalDiscards[$i] += $discards[$i];
				}
			}
		}
		return $totalDiscards;
	}
	
	public function getAvgManaByTurn()
	{
		$avgMana = array();
		foreach($this->gameResults as $gameResult)
		{
			$turns = $gameResult->getTurnResults();
			for ($i = 0; $i < count($turns); $i++)
			{
				if (array_key_exists($i, $avgMana) == false)
				{
					$avgMana[$i] = new ManaVector();
				}
				$avgMana[$i]->addVector($turns[$i]->getAvailableMana());
			}
		}

		$games = count($this->gameResults);
		foreach($avgMana as $mana)
		{
			$mana->divideBy($games);
		}
		return $avgMana;
	}
	
	private $gameResults = array();
}
?>
