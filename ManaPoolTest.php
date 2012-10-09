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
}
?>
