<?php
class SacrificeUnless
{
	public function __construct($when, $life, $mana)
	{
		$this->when = $when;
		$this->life = $life;
		$this->mana = $mana;
	}
	
	public function getWhen()
	{
		return $this->when;
	}
	
	public function getLife()
	{
		return $this->life;
	}
	
	public function getMana()
	{
		return $this->mana;
	}
	
	public function isSupported()
	{
		return true;
	}
	
	const ENTERS_BATTLEFIELD = 0;
	
	private $when;
	private $life;
	private $mana;
}
?>
