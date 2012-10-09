<?php
class ManaPool
{
	public function __construct()
	{
		$this->colorless = 0;
		$this->black = 0;
		$this->green = 0;
		$this->red = 0;
		$this->white = 0;
		$this->blue = 0;
	}
	
	public function applyEffect($effect)
	{
		$mana = $effect->getProducedMana();
		$this->colorless += $mana->getManaAsInt(null);
		$this->black += $mana->getManaAsInt("B");
		$this->green += $mana->getManaAsInt("G");
		$this->blue += $mana->getManaAsInt("U");
		$this->red += $mana->getManaAsInt("R");
		$this->white += $mana->getManaAsInt("W");
	}
	
	public function applyEffects($effects)
	{
		foreach($effects as $effect)
		{
			if (is_a($effect, "ProduceManaEffect") == true)
			{
				$this->applyEffect($effect);
			}
		}
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
	
	public function getRed()
	{
		return $this->red;
	}
	
	public function getWhite()
	{
		return $this->white;
	}
	
	public function getNumberOfColors()
	{
		$count = 0;
		
		if ($this->black > 0)
		{
			$count++;
		}
		
		if ($this->blue > 0)
		{
			$count++;
		}
		
		if ($this->green > 0)
		{
			$count++;
		}
		
		if ($this->red > 0)
		{
			$count++;
		}
		
		if ($this->white > 0)
		{
			$count++;
		}
		
		return $count;
	}
	
	public function getTotalMana()
	{
		$total = $this->colorless + $this->black + $this->blue + $this->green
			+ $this->red + $this->white;
		return $total;
	}
	
	public function betterThan($testPool)
	{
		// return true if this is better than testPool
		// one is better than another if it has more colors
		// TODO: look for even distribution of colors
		// one is better than another if it has more total mana
		if ($this->getNumberOfColors() > $testPool->getNumberOfColors())
		{
			return true;
		}
		
		if ($this->getTotalMana() > $testPool->getTotalMana())
		{
			return true;
		}
		
		return false;
	}
	
	private $colorless;
	private $black;
	private $green;
	private $blue;
	private $red;
	private $white;
}
?>
