<?php
/**
 * Records the results from one simulation turn
 */
class SimulationTurnResults
{
	public function setDiscarded($value)
	{
		$this->discarded = $value;
	}
	
	public function incrementDiscarded()
	{
		$this->discarded++;
	}
	
	public function setColorless($value)
	{
		$this->colorless = $value;
	}
	
	public function setBlack($value)
	{
		$this->black = $value;
	}
	
	public function setGreen($value)
	{
		$this->green = $value;
	}
	
	public function setBlue($value)
	{
		$this->blue = $value;
	}
	
	public function setWhite($value)
	{
		$this->white = $value;
	}
	
	public function setRed($value)
	{
		$this->red = $value;
	}
	
	public function getDiscarded()
	{
		return $this->discarded;
	}
	
	public function getColorless()
	{
		return $this->colorless;
	}
	
	public function getBlack()
	{
		return $this->black;
	}
	
	public function getGreen()
	{
		return $this->green;
	}
	
	public function getBlue()
	{
		return $this->blue;
	}
	
	public function getWhite()
	{
		return $this->white;
	}
	
	public function getRed()
	{
		return $this->red;
	}
	
	private $discarded = 0;
	
	private $colorless = 0;
	private $black = 0;
	private $green = 0;
	private $blue = 0;
	private $white = 0;
	private $red = 0;
}
?>
