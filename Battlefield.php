<?php
include_once "CardCollection.php";
include_once "ManaPool.php";
class Battlefield extends CardCollection
{
	/**
	 * This method tells you how much mana you could have
	 * if you drew it all
	 */
	public function getAvailableMana()
	{
		$availableMana = new ManaPool();
		$cards = $this->getCards();
		foreach($cards as $card)
		{
			$candidateAbility = null;
			$abilities = $card->getAbilities();
			foreach($abilities as $ability)
			{
				$effects = $ability->getEffects();
				foreach($effects as $effect)
				{
					if (is_a($effect, "ProduceManaEffect"))
					{
						// produces mana, can it be paided?
						$costs = $ability->getCosts();
						$canBePaid = true;
						foreach ($costs as $cost)
						{
							if (is_a($cost, "TapCost"))
							{
								if ($card->isTapped())
								{
									$canBePaid = false;
									break;
								}
							}
							else
							{
								// other costs
								$canBePaid = false;
								break;
							}
						}
						
						if ($canBePaid)
						{
							$candidateAbility = $ability;
						}
					}
				}
			}
			if ($candidateAbility != null)
			{
				$availableMana->applyEffects($candidateAbility->getEffects());
			}
		}
		return $availableMana;
	}
}
?>
