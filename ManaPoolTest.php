<?php
include_once "ManaPool.php";
include_once "ProduceManaEffect.php";
class ManaPoolTest extends PHPUnit_Framework_TestCase
{
	public function testManaEffect()
	{
		$pool = new ManaPool();
		$mana = new Mana("3GW");
		$effect = new ProduceManaEffect($mana);
		$pool->applyEffect($effect);
		assert($pool->getGreen() == 1);
		assert($pool->getWhite() == 1);
		assert($pool->getColorless() == 3);
	}
	
	public function testTotalMana()
	{
		$pool = new ManaPool();
		$effect = new ProduceManaEffect(new Mana("3WW"));
		$pool->applyEffect($effect);
		assert($pool->getTotalMana() == 5);
	}
	
	public function testManaColors()
	{
		$pool = new ManaPool();
		$effect = new ProduceManaEffect(new Mana("3WW"));
		$pool->applyEffect($effect);
		assert($pool->getNumberOfColors() == 1);
	}
	
	public function testManaColors2()
	{
		$pool = new ManaPool();
		$effect = new ProduceManaEffect(new Mana("3WWB"));
		$pool->applyEffect($effect);
		assert($pool->getNumberOfColors() == 2);
	}
	
	public function testComparePools()
	{
		$pool1 = new ManaPool();
		$pool1->applyEffect(new ProduceManaEffect(new Mana("GW")));

		$pool2 = new ManaPool();
		$pool2->applyEffect(new ProduceManaEffect(new Mana("3WW")));
		
		assert($pool1->betterThan($pool2));
	}
}
?>
