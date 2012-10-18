<?php
Class LoseLife
{
	public function __construct($life)
	{
		$this->life = $life;
	}
	
	public function isSupported()
	{
		return true;
	}
	
	public function getLife()
	{
		return $this->life;
	}
	
	private $life;
}
?>
