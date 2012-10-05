<?php
include_once "ProduceManaEffect.php";
include_once "Mana.php";
class ProduceManaEffectTest extends PHPUnit_Framework_TestCase
{
	public function testSimple()
	{
		$effect = new ProduceManaEffect();
		assert($effect->getProducedManaString() == "");
	}
	
	public function testProduceBlack()
	{
		$effect = new ProduceManaEffect(new Mana("B"));
		assert(strcmp($effect->getProducedManaString(),"B") == 0);
	}

	public function testProduceColoreless()
	{
		$effect = new ProduceManaEffect(new Mana("3"));
		assert(strcmp($effect->getProducedManaString(),"3") == 0);
	}

	public function testProduceMixedComplex()
	{
		$mana = array();
		array_push($mana, new Mana("3"), new Mana("B"), new Mana("U"));
		$effect = new ProduceManaEffect($mana);
		assert(is_array($effect->getProducedMana()));
		assert(count($effect->getProducedMana()) == 3);
		assert(strcmp($effect->getProducedManaString(),"3BU") == 0);
	}
}
?>
