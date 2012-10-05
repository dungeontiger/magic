<?php
/**
 * Creates Card objects by card name
 */
 include_once "Card.php";
 include_once "Mana.php";
 include_once "Activation.php";
class CardFactory
{
	public static function createCard(string cardName)
	{
		if (strcasecmp(cardName, "Swamp") == 0)
		{
			return createSwamp();
		}
		else if (strcasecmp(cardName, "Plains") == 0)
		{
			return createPlains();
		}
		else if (strcasecmp(cardName, "Island") == 0)
		{
			return createIsland();
		}
		else if (strcasecmp(cardName, "Forest") == 0)
		{
			return createForest();
		}
		else if (strcasecmp(cardName, "Mountain") == 0)
		{
			return createMountain();
		}
		else
		{
			throw Exception("Unknown or unsupported card name: " . cardName);
		}
		
		private static function createSwamp()
		{
			Card card = new Card();
			return card;
		}
	}
}
?>
