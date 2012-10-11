<?php
include_once "Battlefield.php";
include_once "CardFactory.php";
class BattlefieldTest extends PHPUnit_Framework_TestCase
{
	public function testAvailableMana()
	{
		$factory = new CardFactory();
		$battlefield = new Battlefield();
		$swamp = $factory->createCard("Swamp");
		$swamp2 = $factory->createCard("Swamp");
		$mountain = $factory->createCard("Mountain");
		$blank = $factory->createCard("_blank");
		$battlefield->addCard($swamp);
		$battlefield->addCard($swamp2);
		$battlefield->addCard($mountain);
		$battlefield->addCard($blank);
		$mana = $battlefield->getAvailableMana();
		assert($mana->getMana(Color::BLACK) == 2);
		assert($mana->getMana(Color::RED) == 1);
		assert($mana->getMana(Color::BLUE) == 0);
		assert($mana->getMana(Color::GREEN) == 0);
		assert($mana->getMana(Color::WHITE) == 0);
		assert($mana->getMana(Color::COLORLESS) == 0);
	}
}
?>
