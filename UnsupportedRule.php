<?php
class UnsupportedRule
{
	public function __construct($rule)
	{
		$this->rule = $rule;
	}
	
	public function isSupported()
	{
		return false;
	}
	
	private $rule;
}
?>
