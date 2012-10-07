<?php
include_once "ProduceManaEffect.php";
include_once "Mana.php";
class ProduceManaEffectTest extends PHPUnit_Framework_TestCase
{
	public function testProduceBlack()
	{
		$effect = new ProduceManaEffect(new Mana("B"));
		assert(strcmp($effect->getProducedMana()->getMana(),"B") == 0);
	}

	public function testProduceColoreless()
	{
		$effect = new ProduceManaEffect(new Mana("3"));
		assert(strcmp($effect->getProducedMana()->getMana(),"3") == 0);
	}

	public function testProduceMixedComplex()
	{
		$effect = new ProduceManaEffect(new Mana("3BU"));
		assert(strcmp($effect->getProducedMana()->getMana(),"3BU") == 0);
	}
}
?>
