<?php
class SearchForCard
{
	public function __construct($collection, $searchFor, $number, $targetLocation, $opponent)
	{
		$this->searchCollection = $collection;
		$this->searchFor = $searchFor;
		$this->opponent = $opponent;
		$this->number = $number;
		$this->targetLocation = $targetLocation;
	}
	
	public function getSearchCollection()
	{
		return $this->searchCollection;
	}
	
	public function getSearchOpponent()
	{
		return $this->searchOpponent;
	}
	
	public function getSearchFor()
	{
		return $this->searchFor;
	}
	
	public function getNumber()
	{
		return $this->number;
	}
	
	public function getTargetLocation()
	{
		return $this->targetLocation;
	}
	
	// where to search or where to go
	const LIBRARY = 0;
	const HAND = 1;
	const GRAVEYARD = 2;
	const BATTLEFIELD = 3;
	const BATTLEFIELD_TAPPED = 4;
	
	// what to search for, should be different class?
	const BASIC_LAND = 0;
	const CARD = 1;
	const PERMANENT = 2;
	const CREATURE = 3;
	
	private $searchCollection;
	private $searchOpponent;
	private $searchFor;
	private $number;
	private $targetLocation;
}
?>
