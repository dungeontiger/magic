<?php
include_once "Destroy.php";
class DestroyTest extends PHPUnit_Framework_TestCase
{
	public function testAllCreatures()
	{
		// Day Of Judgement
		assert(Destroy::ruleMatches("Destroy all creatures."));
		
		// TODO: create an object with it
	}
	
	public function testTarget()
	{
		// TODO: creatures is bad, should be singular
		assert(Destroy::ruleMatches("Destroy target creatures."));
		assert(Destroy::ruleMatches("Destroy target creature."));
	}
	
	public function testTargetTapped()
	{
		assert(Destroy::ruleMatches("Destroy target tapped creature."));
	}
	
	publiic function testAttackingBlocking()
	{
		// Divine Verdict
		assert(Destroy::ruleMatches("Destroy target attacking or blocking creature."));
	}
}
?>
