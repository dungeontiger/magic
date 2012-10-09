<?php
include_once "Battlefield.php";
include_once "CardFactory.php";
class BattlefieldTest extends PHPUnit_Framework_TestCase
{
	public function testAvailableMana()
	{
		$battlefield = new Battlefield();
		$swamp = CardFactory::createCard("Swamp");
		$swamp2 = CardFactory::createCard("Swamp");
		$mountain = CardFactory::createCard("Mountain");
		$blank = CardFactory::createCard("_blank");
		$battlefield->addCard($swamp);
		$battlefield->addCard($swamp2);
		$battlefield->addCard($mountain);
		$battlefield->addCard($blank);
		$mana = $battlefield->getAvailableMana();
		assert($mana->getBlack() == 2);
		assert($mana->getRed() == 1);
		assert($mana->getBlue() == 0);
		assert($mana->getGreen() == 0);
		assert($mana->getWhite() == 0);
		assert($mana->getColorless() == 0);
	}
}
?>
