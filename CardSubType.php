<?php
class CardSubType
{
	public function __construct($subType = null)
	{
		$this->subTypes = array();
		$this->addSubTypes($subType);
	}

	public function addSubTypes($subType)
	{
		if ($subType != null)
		{
			$split = explode(" ", $subType);
			foreach($split as $value)
			{
				array_push($this->subTypes, $value);
			}
		}
	}

	public function isA($subType)
	{
		return in_array($subType, $this->subTypes);
	}

	public function toString()
	{
		return implode(" ", $this->subTypes);
	}

	private $subTypes;
}
?>
