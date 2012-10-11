<?php
include_once "ManaVector.php";
class ManaPool
{
	public function __construct()
	{
		$this->mana = new ManaVector();
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

	public function applyEffect($effect)
	{
		$mana = $effect->getProducedMana();
		$this->mana->addVector($mana);
	}
		
	public function getMana($symbol)
	{
		return $this->mana->get($symbol);
	}
	
	public function getNumberOfColors()
	{
		return $this->mana->getColorCount();
	}
	
	public function getTotalMana()
	{
		return $this->mana->getConvertedTotal();
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

	private $mana;
}
?>
