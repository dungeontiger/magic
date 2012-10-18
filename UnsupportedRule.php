<?php
// when rules  are unknown or unsupported they go here
class UnsupportedRule
{
	public function __construct($rule, $costs)
	{
		$this->rule = $rule;
		$this->costs = $costs;
	}
	
	public function isSupported()
	{
		return false;
	}
	
	public function getRule()
	{
		return $this->rule;
	}
	
	public function getCosts()
	{
		return $this->costs;
	}
	
	private $rule;
	private $costs;
}
?>
