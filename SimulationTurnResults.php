<?php
/**
 * Records the results from one simulation turn
 */
class SimulationTurnResults
{
	public function incrementDiscarded()
	{
		$this->discarded++;
	}
	
	public function getDiscarded()
	{
		return $this->discarded;
	}
	
	public function incrementPlayed()
	{
		$this->played++;
	}
	
	public function getPlayed()
	{
		return $this->played;
	}
	
	public function setAvailableMana($mana)
	{
		$this->mana = $mana;
	}
	
	public function getAvailableMana()
	{
		return $this->mana;
	}
	
	private $discarded = 0;
	private $mana;
	private $played = 0;
}
?>
