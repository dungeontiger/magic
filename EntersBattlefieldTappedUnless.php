<?php
class EntersBattlefieldTappedUnless
{
	public function __construct($subTypes)
	{
		$this->subTypes = $subTypes;
	}
	
	public function getSubTypes()
	{
		return $this->subTypes;
	}
	
	private $subTypes;
}
?>
