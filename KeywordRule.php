<?php
class KeywordRule
{
	public function __construct($keyword, $value = null)
	{
		$this->keyword = $keyword;
		$this->value = $value;
	}
	
	public function getKeyword()
	{
		return $this->keyword;
	}
	
	public function isSupported()
	{
		return true;
	}
	
	private $keyword;
	
	// used for things like bloodthirst and rampage
	private $value = null;
}
?>
