<?php
include_once "Ability.php";
class AbilityTest extends PHPUnit_Framework_TestCase
{
	public function testCreate()
	{
		$ability = new Ability(array("Cost1", "Cost2"), array("effect1", "effect2", "effect3"));
		assert(count($ability->getCosts()) == 2);
		assert(count($ability->getEffects()) == 3);
	}
}
?>
