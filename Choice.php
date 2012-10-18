<?php
class Choice
{
	public function __construct($choices)
	{
		$this->choices = $choices;
	}
	
	public function isSupported()
	{
		return true;
	}
	
	public function getChoices()
	{
		return $this->choices;
	}
	
	private $choices;
}
?>
