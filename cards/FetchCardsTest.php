<?php
include_once "FetchCards.php";
class FetchCardsTest extends PHPUnit_Framework_TestCase
{
	public function testGoblinKing()
	{
		$fetch = new FetchCards();

		// TODO: Cannot yet handle any actual card name that will match
		// to other card names, for example "Swamp" will return multiple 
		// cards with the word swamp in their name

		$fetch->getPageForCard("Goblin King");
		$fetch->getPageForCard("Serra Avatar");
		$fetch->getPageForCard("Fireball");
		$fetch->getPageForCard("Mons's Goblin Raiders");
		$fetch->getPageForCard("Goblin War Wagon");
		$fetch->getPageForCard("Evolving Wilds");
		$fetch->getPageForCard("Ashenmoor Liege");
		$fetch->getPageForCard("Demigod of Revenge");
		$fetch->getPageForCard("Godhead of Awe");
		$fetch->getPageForCard("Hanna, Ship's Navigator");
		$fetch->getPageForCard("Creakwood Liege");
		$fetch->getPageForCard("Petrahydrox");
		$fetch->getPageForCard("Selesnya Guildmage");
		$fetch->getPageForCard("Sorin Markov");
		$fetch->getPageForCard("Act of Aggression");
		$fetch->getPageForCard("Apostle's Blessing");
		$fetch->getPageForCard("Fallen Ferromancer");
		$fetch->getPageForCard("Exclusion Ritual");
		$fetch->getPageForCard("Underground Sea");
	}
}
?>
