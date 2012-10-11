<?php
include_once "ProduceManaEffect.php";
class ProduceManaEffectTest extends PHPUnit_Framework_TestCase
{
	public function testProduceBlack()
	{
		$effect = new ProduceManaEffect("B");
		assert(strcmp($effect->getProducedMana()->getManaString(),"B") == 0);
		assert($effect->getProducedMana()->get(Color::BLACK) == 1);
	}

	public function testProduceColoreless()
	{
		$effect = new ProduceManaEffect("3");
		assert(strcmp($effect->getProducedMana()->getManaString(),"3") == 0);
		assert($effect->getProducedMana()->get(Color::COLORLESS) == 3);
	}

	public function testProduceMixedComplex()
	{
		$effect = new ProduceManaEffect("3BU");
		assert(strcmp($effect->getProducedMana()->getManaString(),"3BU") == 0);
		assert($effect->getProducedMana()->get(Color::BLACK) == 1);
		assert($effect->getProducedMana()->get(Color::COLORLESS) == 3);
		assert($effect->getProducedMana()->get(Color::BLUE) == 1);
	}
}
?>
