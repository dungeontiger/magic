<?php
/**
 * Map that contains mana
 */
include_once "Color.php";
class ManaVector
{
	public function __construct()
	{
		$this->mana[Color::BLACK] = null;
		$this->mana[Color::BLUE] = null;
		$this->mana[Color::GREEN] = null;
		$this->mana[Color::RED] = null;
		$this->mana[Color::WHITE] = null;
		$this->mana[Color::COLORLESS] = null;
	}
	
	public function getArray()
	{
		return $this->mana;
	}
	
	public function get($color)
	{
		return $this->mana[$color];
	}
	
	public function add($color, $value)
	{
		if ($this->mana[$color] != null)
		{
			$this->mana[$color] += $value;
		}
		else
		{
			$this->mana[$color] = $value;
		}
	}

	private $mana = array();
}
?>
